<?php 
// SEO Meta Data for Gallery Page
$page_title = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr' 
    ? 'Galerie Photos - Nos Activités en Images'
    : 'Photo Gallery - Our Activities in Pictures';
$page_description = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'Découvrez notre galerie photos : activités éducatives, jeux, moments de joie. Voyez l\'environnement chaleureux de TakeCare.'
    : 'Discover our photo gallery: educational activities, games, joyful moments. See the warm environment at TakeCare.';
$page_keywords = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'photos garde enfants, galerie crèche, images activités, environnement garderie'
    : 'childcare photos, daycare gallery, activity images, nursery environment';

require_once __DIR__ . '/includes/header.php'; 
?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<section class="bg-white rounded p-6 shadow">
  <h2 class="text-2xl font-bold">Gallery</h2>
  <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php
    $rows = [];
    if (isset($pdo)) {
        $stmt = $pdo->query('SELECT image_path, caption FROM gallery ORDER BY id DESC LIMIT 24');
        $rows = $stmt->fetchAll();
    } elseif (isset($conn)) {
        $res = $conn->query('SELECT image_path, caption FROM gallery ORDER BY id DESC LIMIT 24');
        if ($res) while ($r = $res->fetch_assoc()) $rows[] = $r;
    }

    if (empty($rows)) {
        echo '<div class="p-6 text-sm text-gray-600">No images yet. Upload via admin.</div>';
    } else {
        foreach ($rows as $img) {
            $src = htmlspecialchars($img['image_path']);
            // echo '<pre class="col-span-full p-2 bg-gray-100 text-xs overflow-auto">' . htmlspecialchars(print_r($img['image_path'], true), ENT_QUOTES, 'UTF-8') . '</pre>';
            $cap = htmlspecialchars($img['caption']);
            echo "<div class='rounded overflow-hidden shadow'><img src='./$src' alt='$cap' class='w-full h-40 object-cover'><div class='p-2 text-sm'>$cap</div></div>";
        }
    }
    ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
