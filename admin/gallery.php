<?php 
require_once 'header.php';

$msg = '';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Create uploads directory if it doesn't exist
$upload_dir = __DIR__ . '/../uploads/gallery/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $caption = trim($_POST['caption'] ?? '');
            
            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $filename = $_FILES['image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $new_filename = uniqid() . '.' . $ext;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $image_path = '/uploads/gallery/' . $new_filename;
                        
                        try {
                            if (isset($pdo)) {
                                $stmt = $pdo->prepare('INSERT INTO gallery (image_path, caption) VALUES (?, ?)');
                                $stmt->execute([$image_path, $caption]);
                                $msg = 'Image uploaded successfully!';
                            } elseif (isset($conn)) {
                                $ip = $conn->real_escape_string($image_path);
                                $c = $conn->real_escape_string($caption);
                                $conn->query("INSERT INTO gallery (image_path, caption) VALUES ('$ip', '$c')");
                                $msg = 'Image uploaded successfully!';
                            }
                            $action = 'list';
                        } catch (Exception $e) {
                            $msg = 'Error: ' . $e->getMessage();
                        }
                    } else {
                        $msg = 'Failed to upload file.';
                    }
                } else {
                    $msg = 'Invalid file type. Allowed: jpg, jpeg, png, gif, webp';
                }
            } else {
                $msg = 'Please select an image to upload.';
            }
        } elseif ($_POST['action'] === 'edit' && $id) {
            $caption = trim($_POST['caption'] ?? '');
            
            try {
                if (isset($pdo)) {
                    $stmt = $pdo->prepare('UPDATE gallery SET caption = ? WHERE id = ?');
                    $stmt->execute([$caption, $id]);
                    $msg = 'Caption updated successfully!';
                } elseif (isset($conn)) {
                    $c = $conn->real_escape_string($caption);
                    $conn->query("UPDATE gallery SET caption='$c' WHERE id=" . (int)$id);
                    $msg = 'Caption updated successfully!';
                }
                $action = 'list';
            } catch (Exception $e) {
                $msg = 'Error: ' . $e->getMessage();
            }
        } elseif ($_POST['action'] === 'delete' && $id) {
            try {
                // Get image path before deleting
                $image_path = '';
                if (isset($pdo)) {
                    $stmt = $pdo->prepare('SELECT image_path FROM gallery WHERE id = ?');
                    $stmt->execute([$id]);
                    $row = $stmt->fetch();
                    if ($row) $image_path = $row['image_path'];
                } elseif (isset($conn)) {
                    $r = $conn->query('SELECT image_path FROM gallery WHERE id = ' . (int)$id);
                    if ($r) {
                        $row = $r->fetch_assoc();
                        if ($row) $image_path = $row['image_path'];
                    }
                }
                
                // Delete from database
                if (isset($pdo)) {
                    $stmt = $pdo->prepare('DELETE FROM gallery WHERE id = ?');
                    $stmt->execute([$id]);
                } elseif (isset($conn)) {
                    $conn->query('DELETE FROM gallery WHERE id = ' . (int)$id);
                }
                
                // Delete physical file
                if ($image_path) {
                    $file_path = __DIR__ . '/..' . $image_path;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                
                $msg = 'Image deleted successfully!';
                $action = 'list';
            } catch (Exception $e) {
                $msg = 'Error: ' . $e->getMessage();
            }
        }
    }
}

// Get gallery item for edit
$gallery_item = null;
if ($action === 'edit' && $id) {
    if (isset($pdo)) {
        $stmt = $pdo->prepare('SELECT * FROM gallery WHERE id = ?');
        $stmt->execute([$id]);
        $gallery_item = $stmt->fetch();
    } elseif (isset($conn)) {
        $r = $conn->query('SELECT * FROM gallery WHERE id = ' . (int)$id);
        if ($r) $gallery_item = $r->fetch_assoc();
    }
}
?>

<div class="mb-6 flex items-center justify-between">
  <div>
    <h2 class="text-3xl font-bold text-gray-800"><?php echo $lang['manage_gallery'] ?? 'Manage Gallery'; ?></h2>
  </div>
  <?php if ($action === 'list'): ?>
  <a href="?action=add" class="btn-primary inline-flex items-center gap-2">
    <i class="fas fa-plus"></i>
    <?php echo $lang['upload_image'] ?? 'Upload Image'; ?>
  </a>
  <?php else: ?>
  <a href="gallery.php" class="btn-secondary inline-flex items-center gap-2">
    <i class="fas fa-arrow-left"></i>
    <?php echo $_SESSION['lang'] === 'fr' ? 'Retour' : 'Back'; ?>
  </a>
  <?php endif; ?>
</div>

<?php if ($msg): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
  <?php echo htmlspecialchars($msg); ?>
</div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
<!-- List gallery items -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
  <?php
  $rows = [];
  if (isset($pdo)) {
      $rows = $pdo->query('SELECT * FROM gallery ORDER BY created_at DESC')->fetchAll();
  } elseif (isset($conn)) {
      $r = $conn->query('SELECT * FROM gallery ORDER BY created_at DESC');
      if ($r) while ($row = $r->fetch_assoc()) $rows[] = $row;
  }
  
  if (empty($rows)) {
      echo '<div class="col-span-full text-center text-gray-500 p-8">No images yet.</div>';
  } else {
      foreach ($rows as $row) {
          echo '<div class="bg-white rounded-lg shadow-lg overflow-hidden group relative">';
          echo '<img src="..' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['caption']) . '" class="w-full h-40 object-cover">';
          echo '<div class="p-3">';
          echo '<p class="text-sm text-gray-600 truncate">' . htmlspecialchars($row['caption']) . '</p>';
          echo '<div class="flex gap-2 mt-2">';
          echo '<a href="?action=edit&id=' . $row['id'] . '" class="text-xs text-blue-600 hover:underline"><i class="fas fa-edit"></i> Edit</a>';
          echo '<form method="post" class="inline" onsubmit="return confirm(\'Delete this image?\');"><input type="hidden" name="action" value="delete"><button type="submit" name="id" value="' . $row['id'] . '" class="text-xs text-red-600 hover:underline"><i class="fas fa-trash"></i> Delete</button></form>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
      }
  }
  ?>
</div>

<?php elseif ($action === 'add'): ?>
<!-- Add form -->
<div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl">
  <h3 class="text-2xl font-bold mb-6"><?php echo $lang['upload_image'] ?? 'Upload Image'; ?></h3>
  
  <form method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="hidden" name="action" value="add">
    
    <div>
      <label class="block font-semibold mb-2"><?php echo $lang['image'] ?? 'Image'; ?></label>
      <input type="file" name="image" accept="image/*" class="w-full p-3 border rounded-lg" required>
      <p class="text-sm text-gray-500 mt-1"><?php echo $_SESSION['lang'] === 'fr' ? 'Formats acceptés: JPG, PNG, GIF, WEBP' : 'Accepted formats: JPG, PNG, GIF, WEBP'; ?></p>
    </div>
    
    <div>
      <label class="block font-semibold mb-2"><?php echo $lang['caption'] ?? 'Caption'; ?></label>
      <input type="text" name="caption" class="w-full p-3 border rounded-lg" placeholder="<?php echo $_SESSION['lang'] === 'fr' ? 'Description de l\'image' : 'Image description'; ?>">
    </div>
    
    <div class="flex gap-3">
      <button type="submit" class="btn-primary">
        <i class="fas fa-upload mr-2"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Télécharger' : 'Upload'; ?>
      </button>
      <a href="gallery.php" class="btn-secondary">
        <?php echo $lang['cancel'] ?? 'Cancel'; ?>
      </a>
    </div>
  </form>
</div>

<?php elseif ($action === 'edit' && $gallery_item): ?>
<!-- Edit form -->
<div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl">
  <h3 class="text-2xl font-bold mb-6"><?php echo $lang['edit'] ?? 'Edit'; ?> <?php echo $lang['caption'] ?? 'Caption'; ?></h3>
  
  <div class="mb-4">
    <img src="<?php echo htmlspecialchars($gallery_item['image_path']); ?>" alt="Current image" class="w-full max-w-md rounded-lg shadow">
  </div>
  
  <form method="post" class="space-y-4">
    <input type="hidden" name="action" value="edit">
    
    <div>
      <label class="block font-semibold mb-2"><?php echo $lang['caption'] ?? 'Caption'; ?></label>
      <input type="text" name="caption" value="<?php echo htmlspecialchars($gallery_item['caption']); ?>" class="w-full p-3 border rounded-lg">
    </div>
    
    <div class="flex gap-3">
      <button type="submit" class="btn-primary">
        <i class="fas fa-save mr-2"></i><?php echo $lang['save'] ?? 'Save'; ?>
      </button>
      <a href="gallery.php" class="btn-secondary">
        <?php echo $lang['cancel'] ?? 'Cancel'; ?>
      </a>
    </div>
  </form>
</div>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
