<?php 
require_once 'header.php';

$msg = '';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $parent_name = trim($_POST['parent_name'] ?? '');
            $content = trim($_POST['content'] ?? '');
            
            if ($parent_name && $content) {
                try {
                    if (isset($pdo)) {
                        $stmt = $pdo->prepare('INSERT INTO testimonials (parent_name, content, status) VALUES (?, ?, ?)');
                        $stmt->execute([$parent_name, $content, 'approved']);
                        $msg = 'Testimonial added successfully!';
                    } elseif (isset($conn)) {
                        $pn = $conn->real_escape_string($parent_name);
                        $c = $conn->real_escape_string($content);
                        $conn->query("INSERT INTO testimonials (parent_name, content, status) VALUES ('$pn', '$c', 'approved')");
                        $msg = 'Testimonial added successfully!';
                    }
                    $action = 'list';
                } catch (Exception $e) {
                    $msg = 'Error: ' . $e->getMessage();
                }
            } else {
                $msg = 'All fields are required.';
            }
        } elseif ($_POST['action'] === 'edit' && $id) {
            $parent_name = trim($_POST['parent_name'] ?? '');
            $content = trim($_POST['content'] ?? '');
            
            if ($parent_name && $content) {
                try {
                    if (isset($pdo)) {
                        $stmt = $pdo->prepare('UPDATE testimonials SET parent_name = ?, content = ? WHERE id = ?');
                        $stmt->execute([$parent_name, $content, $id]);
                        $msg = 'Testimonial updated successfully!';
                    } elseif (isset($conn)) {
                        $pn = $conn->real_escape_string($parent_name);
                        $c = $conn->real_escape_string($content);
                        $conn->query("UPDATE testimonials SET parent_name='$pn', content='$c' WHERE id=" . (int)$id);
                        $msg = 'Testimonial updated successfully!';
                    }
                    $action = 'list';
                } catch (Exception $e) {
                    $msg = 'Error: ' . $e->getMessage();
                }
            }
        } elseif ($_POST['action'] === 'delete' && $id) {
            try {
                if (isset($pdo)) {
                    $stmt = $pdo->prepare('DELETE FROM testimonials WHERE id = ?');
                    $stmt->execute([$id]);
                } elseif (isset($conn)) {
                    $conn->query('DELETE FROM testimonials WHERE id = ' . (int)$id);
                }
                $msg = 'Testimonial deleted successfully!';
                $action = 'list';
            } catch (Exception $e) {
                $msg = 'Error: ' . $e->getMessage();
            }
        }
    }
}

// Get testimonial for edit
$testimonial = null;
if ($action === 'edit' && $id) {
    if (isset($pdo)) {
        $stmt = $pdo->prepare('SELECT * FROM testimonials WHERE id = ?');
        $stmt->execute([$id]);
        $testimonial = $stmt->fetch();
    } elseif (isset($conn)) {
        $r = $conn->query('SELECT * FROM testimonials WHERE id = ' . (int)$id);
        if ($r) $testimonial = $r->fetch_assoc();
    }
}
?>

<div class="mb-6 flex items-center justify-between">
  <div>
    <h2 class="text-3xl font-bold text-gray-800"><?php echo $lang['manage_testimonials'] ?? 'Manage Testimonials'; ?></h2>
  </div>
  <?php if ($action === 'list'): ?>
  <a href="?action=add" class="btn-primary inline-flex items-center gap-2">
    <i class="fas fa-plus"></i>
    <?php echo $lang['add_new'] ?? 'Add New'; ?>
  </a>
  <?php else: ?>
  <a href="testimonials.php" class="btn-secondary inline-flex items-center gap-2">
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
<!-- List testimonials -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
  <table class="w-full">
    <thead class="bg-amber-600 text-white">
      <tr>
        <th class="p-4 text-left">ID</th>
        <th class="p-4 text-left"><?php echo $lang['parent_name'] ?? 'Parent Name'; ?></th>
        <th class="p-4 text-left"><?php echo $lang['testimonial_content'] ?? 'Content'; ?></th>
        <th class="p-4 text-left">Status</th>
        <th class="p-4 text-left">AI Analysis</th>
        <th class="p-4 text-left"><?php echo $_SESSION['lang'] === 'fr' ? 'Date' : 'Date'; ?></th>
        <th class="p-4 text-left"><?php echo $lang['actions'] ?? 'Actions'; ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $rows = [];
      if (isset($pdo)) {
          $rows = $pdo->query('SELECT * FROM testimonials ORDER BY created_at DESC')->fetchAll();
      } elseif (isset($conn)) {
          $r = $conn->query('SELECT * FROM testimonials ORDER BY created_at DESC');
          if ($r) while ($row = $r->fetch_assoc()) $rows[] = $row;
      }
      
      if (empty($rows)) {
          echo '<tr><td colspan="7" class="p-4 text-center text-gray-500">No testimonials yet.</td></tr>';
      } else {
          foreach ($rows as $row) {
              // Status badge
              $status_badge = '';
              if ($row['status'] === 'approved') {
                  $status_badge = '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full"><i class="fas fa-check-circle"></i> Approved</span>';
              } elseif ($row['status'] === 'rejected') {
                  $status_badge = '<span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full"><i class="fas fa-times-circle"></i> Rejected</span>';
              } else {
                  $status_badge = '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full"><i class="fas fa-clock"></i> Pending</span>';
              }
              
              // User info
              $user_info = '';
              if ($row['user_id']) {
                  $user_info = '<span class="text-xs text-gray-500"><i class="fas fa-user"></i> User ID: ' . $row['user_id'] . '</span>';
              } else {
                  $user_info = '<span class="text-xs text-gray-500"><i class="fas fa-shield-alt"></i> Admin</span>';
              }
              
              echo '<tr class="border-b hover:bg-amber-50">';
              echo '<td class="p-4">' . $row['id'] . '</td>';
              echo '<td class="p-4"><div class="font-semibold">' . htmlspecialchars($row['parent_name']) . '</div>' . $user_info . '</td>';
              echo '<td class="p-4 max-w-xs truncate">' . htmlspecialchars(substr($row['content'], 0, 80)) . '...</td>';
              echo '<td class="p-4">' . $status_badge . '</td>';
              if ($row['ai_sentiment']) {
                  echo '<td class="p-4"><div class="text-xs">' . ucfirst($row['ai_sentiment']) . '</div><div class="text-xs text-gray-500">' . number_format($row['ai_score'] * 100, 0) . '%</div></td>';
              } else {
                  echo '<td class="p-4 text-gray-400">-</td>';
              }
              echo '<td class="p-4 text-sm text-gray-600">' . date('M d, Y', strtotime($row['created_at'])) . '</td>';
              echo '<td class="p-4"><div class="flex gap-2">';
              echo '<a href="?action=edit&id=' . $row['id'] . '" class="text-blue-600 hover:underline" title="Edit"><i class="fas fa-edit"></i></a>';
              echo '<form method="post" class="inline" onsubmit="return confirm(\'Delete this testimonial?\');"><input type="hidden" name="action" value="delete"><button type="submit" name="id" value="' . $row['id'] . '" class="text-red-600 hover:underline" title="Delete"><i class="fas fa-trash"></i></button></form>';
              echo '</div></td>';
              echo '</tr>';
          }
      }
      ?>
    </tbody>
  </table>
</div>

<?php elseif ($action === 'add' || $action === 'edit'): ?>
<!-- Add/Edit form -->
<div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl">
  <h3 class="text-2xl font-bold mb-6"><?php echo $action === 'add' ? ($lang['add_new'] ?? 'Add New') : ($lang['edit'] ?? 'Edit'); ?> <?php echo $lang['testimonials'] ?? 'Testimonial'; ?></h3>
  
  <form method="post" class="space-y-4">
    <input type="hidden" name="action" value="<?php echo $action; ?>">
    
    <div>
      <label class="block font-semibold mb-2"><?php echo $lang['parent_name'] ?? 'Parent Name'; ?></label>
      <input type="text" name="parent_name" value="<?php echo htmlspecialchars($testimonial['parent_name'] ?? ''); ?>" class="w-full p-3 border rounded-lg" required>
    </div>
    
    <div>
      <label class="block font-semibold mb-2"><?php echo $lang['testimonial_content'] ?? 'Content'; ?></label>
      <textarea name="content" rows="6" class="w-full p-3 border rounded-lg" required><?php echo htmlspecialchars($testimonial['content'] ?? ''); ?></textarea>
    </div>
    
    <div class="flex gap-3">
      <button type="submit" class="btn-primary">
        <i class="fas fa-save mr-2"></i><?php echo $lang['save'] ?? 'Save'; ?>
      </button>
      <a href="testimonials.php" class="btn-secondary">
        <?php echo $lang['cancel'] ?? 'Cancel'; ?>
      </a>
    </div>
  </form>
</div>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
