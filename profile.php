<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<?php
if (empty($_SESSION['user_id'])) {
    header('Location: signin.php'); exit;
}

$user = null;
if (isset($pdo)) {
    $stmt = $pdo->prepare('SELECT id, name, email, created_at FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
} elseif (isset($conn)) {
    $id = (int)$_SESSION['user_id'];
    $r = $conn->query("SELECT id, name, email, created_at FROM users WHERE id = $id LIMIT 1");
    if ($r) $user = $r->fetch_assoc();
}

?>

<div class="min-h-[70vh] py-12 px-4">
  <div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="text-center mb-8 animate-fade-in-up">
      <div class="inline-block p-4 rounded-full mb-4" style="background: linear-gradient(135deg, #A8D8EA, #89CFF0); box-shadow: 0 10px 30px rgba(168, 216, 234, 0.4);">
        <i class="fas fa-user-circle text-4xl" style="color: white;"></i>
      </div>
      <h2 class="text-3xl md:text-4xl font-bold hero-title mb-2">
        <?php echo $_SESSION['lang'] === 'fr' ? 'Mon Profil' : 'My Profile'; ?>
      </h2>
      <p class="text-base" style="color: #6C757D;">
        <?php echo $_SESSION['lang'] === 'fr' ? 'Gérez vos informations personnelles' : 'Manage your personal information'; ?>
      </p>
    </div>

    <?php if ($user): ?>
      <!-- Profile Card -->
      <div class="card p-8 mb-6 animate-fade-in-up" style="animation-delay: 0.2s;">
        <div class="grid md:grid-cols-2 gap-6">
          <!-- User Info -->
          <div>
            <h3 class="text-xl font-bold mb-4 flex items-center gap-2" style="background: linear-gradient(135deg, #5DADE2, #AF7AC5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
              <i class="fas fa-info-circle" style="color: #A8D8EA;"></i>
              <?php echo $_SESSION['lang'] === 'fr' ? 'Informations' : 'Information'; ?>
            </h3>
            
            <div class="space-y-4">
              <div class="p-4 rounded-xl" style="background: linear-gradient(135deg, rgba(168, 216, 234, 0.1), rgba(181, 234, 215, 0.1)); border-left: 4px solid #A8D8EA;">
                <label class="text-xs font-semibold" style="color: #6C757D;">
                  <i class="fas fa-user mr-1"></i>
                  <?php echo $_SESSION['lang'] === 'fr' ? 'Nom' : 'Name'; ?>
                </label>
                <p class="text-lg font-semibold mt-1" style="color: #2C3E50;"><?=htmlspecialchars($user['name'])?></p>
              </div>

              <div class="p-4 rounded-xl" style="background: linear-gradient(135deg, rgba(255, 182, 193, 0.1), rgba(255, 192, 203, 0.1)); border-left: 4px solid #FFB6C1;">
                <label class="text-xs font-semibold" style="color: #6C757D;">
                  <i class="fas fa-envelope mr-1"></i>
                  <?php echo $_SESSION['lang'] === 'fr' ? 'Email' : 'Email'; ?>
                </label>
                <p class="text-lg font-semibold mt-1" style="color: #2C3E50;"><?=htmlspecialchars($user['email'])?></p>
              </div>

              <div class="p-4 rounded-xl" style="background: linear-gradient(135deg, rgba(199, 206, 234, 0.1), rgba(187, 143, 206, 0.1)); border-left: 4px solid #C7CEEA;">
                <label class="text-xs font-semibold" style="color: #6C757D;">
                  <i class="fas fa-calendar mr-1"></i>
                  <?php echo $_SESSION['lang'] === 'fr' ? 'Membre depuis' : 'Member since'; ?>
                </label>
                <p class="text-lg font-semibold mt-1" style="color: #2C3E50;">
                  <?php 
                    $date = new DateTime($user['created_at']);
                    echo $date->format('F j, Y');
                  ?>
                </p>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div>
            <h3 class="text-xl font-bold mb-4 flex items-center gap-2" style="background: linear-gradient(135deg, #5DADE2, #AF7AC5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
              <i class="fas fa-bolt" style="color: #FFB6C1;"></i>
              <?php echo $_SESSION['lang'] === 'fr' ? 'Actions rapides' : 'Quick Actions'; ?>
            </h3>

            <div class="space-y-3">
              <a href="services.php" class="block p-4 rounded-xl transition-all hover:translate-x-2" style="background: rgba(168, 216, 234, 0.1); border: 2px solid rgba(168, 216, 234, 0.2);">
                <div class="flex items-center gap-3">
                  <i class="fas fa-baby-carriage text-2xl" style="color: #A8D8EA;"></i>
                  <div>
                    <p class="font-semibold" style="color: #2C3E50;"><?php echo $_SESSION['lang'] === 'fr' ? 'Nos Services' : 'Our Services'; ?></p>
                    <p class="text-xs" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Découvrir' : 'Explore'; ?></p>
                  </div>
                </div>
              </a>

              <a href="gallery.php" class="block p-4 rounded-xl transition-all hover:translate-x-2" style="background: rgba(255, 182, 193, 0.1); border: 2px solid rgba(255, 182, 193, 0.2);">
                <div class="flex items-center gap-3">
                  <i class="fas fa-images text-2xl" style="color: #FFB6C1;"></i>
                  <div>
                    <p class="font-semibold" style="color: #2C3E50;"><?php echo $_SESSION['lang'] === 'fr' ? 'Galerie' : 'Gallery'; ?></p>
                    <p class="text-xs" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Voir les photos' : 'View photos'; ?></p>
                  </div>
                </div>
              </a>

              <a href="contact.php" class="block p-4 rounded-xl transition-all hover:translate-x-2" style="background: rgba(181, 234, 215, 0.1); border: 2px solid rgba(181, 234, 215, 0.2);">
                <div class="flex items-center gap-3">
                  <i class="fas fa-envelope text-2xl" style="color: #B5EAD7;"></i>
                  <div>
                    <p class="font-semibold" style="color: #2C3E50;"><?php echo $_SESSION['lang'] === 'fr' ? 'Nous contacter' : 'Contact Us'; ?></p>
                    <p class="text-xs" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Poser une question' : 'Ask a question'; ?></p>
                  </div>
                </div>
              </a>

              <?php if (!empty($_SESSION['is_admin'])): ?>
              <a href="admin/" class="block p-4 rounded-xl transition-all hover:translate-x-2" style="background: rgba(175, 122, 197, 0.1); border: 2px solid rgba(175, 122, 197, 0.2);">
                <div class="flex items-center gap-3">
                  <i class="fas fa-cog text-2xl" style="color: #AF7AC5;"></i>
                  <div>
                    <p class="font-semibold" style="color: #2C3E50;"><?php echo $_SESSION['lang'] === 'fr' ? 'Administration' : 'Admin Panel'; ?></p>
                    <p class="text-xs" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Gérer le site' : 'Manage site'; ?></p>
                  </div>
                </div>
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Logout Button -->
        <div class="divider-pastel my-6"></div>
        <form method="post" action="logout.php" class="text-center">
          <button type="submit" class="btn-secondary px-6 py-3 inline-flex items-center gap-2">
            <i class="fas fa-sign-out-alt"></i>
            <?php echo $_SESSION['lang'] === 'fr' ? 'Se déconnecter' : 'Sign Out'; ?>
          </button>
        </form>
      </div>

      <!-- Welcome Message -->
      <div class="text-center p-6 rounded-xl animate-fade-in-up" style="background: linear-gradient(135deg, rgba(168, 216, 234, 0.1), rgba(255, 182, 193, 0.1)); animation-delay: 0.4s;">
        <i class="fas fa-heart text-3xl mb-3" style="color: #FFB6C1;"></i>
        <p class="text-lg font-semibold" style="color: #2C3E50;">
          <?php echo $_SESSION['lang'] === 'fr' ? 'Merci de faire partie de la famille TakeCare !' : 'Thank you for being part of the TakeCare family!'; ?>
        </p>
      </div>

    <?php else: ?>
      <div class="card p-8 text-center">
        <i class="fas fa-exclamation-triangle text-4xl mb-4" style="color: #EF4444;"></i>
        <p class="text-lg font-semibold" style="color: #2C3E50;">
          <?php echo $_SESSION['lang'] === 'fr' ? 'Utilisateur non trouvé.' : 'User not found.'; ?>
        </p>
        <a href="signin.php" class="btn-primary inline-flex items-center gap-2 mt-4">
          <?php echo $_SESSION['lang'] === 'fr' ? 'Se reconnecter' : 'Sign In Again'; ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
