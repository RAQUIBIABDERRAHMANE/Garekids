<?php
session_start();
if (empty($_SESSION['is_admin'])) {
    header('Location: ../signin.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';
if (!isset($_SESSION['lang'])) $_SESSION['lang'] = 'en';
require_once __DIR__ . '/../lang/' . $_SESSION['lang'] . '.php';
?>
<!doctype html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $lang['admin_panel'] ?? 'Admin Panel'; ?> - TakeCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-amber-600 to-orange-600 text-white p-6">
    <div class="mb-8">
      <h1 class="text-2xl font-bold flex items-center gap-2">
        <i class="fas fa-shield-alt"></i>
        <?php echo $lang['admin_panel'] ?? 'Admin Panel'; ?>
      </h1>
    </div>
    
    <nav class="space-y-2">
      <a href="index.php" class="flex items-center gap-3 p-3 rounded hover:bg-white/20 transition-colors">
        <i class="fas fa-tachometer-alt"></i>
        <span><?php echo $lang['dashboard'] ?? 'Dashboard'; ?></span>
      </a>
      <a href="testimonials.php" class="flex items-center gap-3 p-3 rounded hover:bg-white/20 transition-colors">
        <i class="fas fa-comments"></i>
        <span><?php echo $lang['manage_testimonials'] ?? 'Testimonials'; ?></span>
      </a>
      <a href="gallery.php" class="flex items-center gap-3 p-3 rounded hover:bg-white/20 transition-colors">
        <i class="fas fa-images"></i>
        <span><?php echo $lang['manage_gallery'] ?? 'Gallery'; ?></span>
      </a>
      <a href="users.php" class="flex items-center gap-3 p-3 rounded hover:bg-white/20 transition-colors">
        <i class="fas fa-users"></i>
        <span><?php echo $_SESSION['lang'] === 'fr' ? 'Utilisateurs' : 'Users'; ?></span>
      </a>
      <div class="border-t border-white/30 my-4"></div>
      <a href="../" class="flex items-center gap-3 p-3 rounded hover:bg-white/20 transition-colors">
        <i class="fas fa-home"></i>
        <span><?php echo $_SESSION['lang'] === 'fr' ? 'Retour au site' : 'Back to Site'; ?></span>
      </a>
      <a href="../logout.php" class="flex items-center gap-3 p-3 rounded hover:bg-white/20 transition-colors">
        <i class="fas fa-sign-out-alt"></i>
        <span><?php echo $lang['logout'] ?? 'Logout'; ?></span>
      </a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 overflow-y-auto p-8">
