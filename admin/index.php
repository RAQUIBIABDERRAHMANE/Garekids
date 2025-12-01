<?php require_once 'header.php'; ?>

<div class="mb-6">
  <h2 class="text-3xl font-bold text-gray-800"><?php echo $lang['dashboard'] ?? 'Dashboard'; ?></h2>
  <p class="text-gray-600"><?php echo $_SESSION['lang'] === 'fr' ? 'Bienvenue dans le panneau d\'administration' : 'Welcome to the admin panel'; ?></p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <?php
  $testimonial_count = 0;
  $gallery_count = 0;
  $user_count = 0;
  
  if (isset($pdo)) {
      $testimonial_count = $pdo->query('SELECT COUNT(*) FROM testimonials')->fetchColumn();
      $gallery_count = $pdo->query('SELECT COUNT(*) FROM gallery')->fetchColumn();
      $user_count = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
  } elseif (isset($conn)) {
      $r = $conn->query('SELECT COUNT(*) as c FROM testimonials');
      if ($r) $testimonial_count = $r->fetch_assoc()['c'];
      $r = $conn->query('SELECT COUNT(*) as c FROM gallery');
      if ($r) $gallery_count = $r->fetch_assoc()['c'];
      $r = $conn->query('SELECT COUNT(*) as c FROM users');
      if ($r) $user_count = $r->fetch_assoc()['c'];
  }
  ?>
  
  <div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-500 text-sm"><?php echo $lang['testimonials'] ?? 'Testimonials'; ?></p>
        <p class="text-3xl font-bold text-amber-600"><?php echo $testimonial_count; ?></p>
      </div>
      <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center">
        <i class="fas fa-comments text-3xl text-amber-600"></i>
      </div>
    </div>
    <a href="testimonials.php" class="mt-4 inline-block text-amber-600 hover:underline"><?php echo $_SESSION['lang'] === 'fr' ? 'Gérer →' : 'Manage →'; ?></a>
  </div>

  <div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-500 text-sm"><?php echo $lang['gallery'] ?? 'Gallery'; ?></p>
        <p class="text-3xl font-bold text-amber-600"><?php echo $gallery_count; ?></p>
      </div>
      <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center">
        <i class="fas fa-images text-3xl text-amber-600"></i>
      </div>
    </div>
    <a href="gallery.php" class="mt-4 inline-block text-amber-600 hover:underline"><?php echo $_SESSION['lang'] === 'fr' ? 'Gérer →' : 'Manage →'; ?></a>
  </div>

  <div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-500 text-sm"><?php echo $_SESSION['lang'] === 'fr' ? 'Utilisateurs' : 'Users'; ?></p>
        <p class="text-3xl font-bold text-amber-600"><?php echo $user_count; ?></p>
      </div>
      <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center">
        <i class="fas fa-users text-3xl text-amber-600"></i>
      </div>
    </div>
    <a href="users.php" class="mt-4 inline-block text-amber-600 hover:underline"><?php echo $_SESSION['lang'] === 'fr' ? 'Gérer →' : 'Manage →'; ?></a>
  </div>
</div>

<div class="bg-white rounded-lg shadow-lg p-6">
  <h3 class="text-xl font-bold mb-4"><?php echo $_SESSION['lang'] === 'fr' ? 'Actions rapides' : 'Quick Actions'; ?></h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <a href="testimonials.php?action=add" class="flex items-center gap-3 p-4 border-2 border-amber-200 rounded-lg hover:bg-amber-50 transition-colors">
      <i class="fas fa-plus-circle text-2xl text-amber-600"></i>
      <span class="font-semibold"><?php echo $_SESSION['lang'] === 'fr' ? 'Ajouter un témoignage' : 'Add Testimonial'; ?></span>
    </a>
    <a href="gallery.php?action=add" class="flex items-center gap-3 p-4 border-2 border-amber-200 rounded-lg hover:bg-amber-50 transition-colors">
      <i class="fas fa-plus-circle text-2xl text-amber-600"></i>
      <span class="font-semibold"><?php echo $_SESSION['lang'] === 'fr' ? 'Ajouter une image' : 'Add Image'; ?></span>
    </a>
  </div>
</div>

<?php require_once 'footer.php'; ?>
