<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name) $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            if (isset($pdo)) {
                $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $errors[] = 'Email already registered.';
                } else {
                    $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
                    $stmt->execute([$name, $email, $hash]);
                    header('Location: signin.php?registered=1'); exit;
                }
            } elseif (isset($conn)) {
                $e = $conn->real_escape_string($email);
                $r = $conn->query("SELECT id FROM users WHERE email = '$e'");
                if ($r && $r->num_rows) { $errors[] = 'Email already registered.'; }
                else {
                    $n = $conn->real_escape_string($name);
                    $h = $conn->real_escape_string($hash);
                    $conn->query("INSERT INTO users (name,email,password) VALUES ('$n','$e','$h')");
                    header('Location: signin.php?registered=1'); exit;
                }
            } else {
                $errors[] = 'No database connection available.';
            }
        } catch (Exception $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
  <div class="w-full max-w-md">
    <!-- Hero Card -->
    <div class="text-center mb-8 animate-fade-in-up">
      <div class="inline-block p-4 rounded-full mb-4" style="background: linear-gradient(135deg, #A8D8EA, #89CFF0); box-shadow: 0 10px 30px rgba(168, 216, 234, 0.4);">
        <i class="fas fa-user-plus text-4xl" style="color: white;"></i>
      </div>
      <h2 class="text-3xl md:text-4xl font-bold hero-title mb-2">
        <?php echo $_SESSION['lang'] === 'fr' ? 'Créer un compte' : 'Create Account'; ?>
      </h2>
      <p class="text-base" style="color: #6C757D;">
        <?php echo $_SESSION['lang'] === 'fr' ? 'Rejoignez notre communauté TakeCare' : 'Join our TakeCare community'; ?>
      </p>
    </div>

    <!-- Form Card -->
    <div class="card p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
      <?php if ($errors): ?>
        <div class="mb-6 p-4 rounded-xl" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1)); border-left: 4px solid #EF4444;">
          <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-xl" style="color: #EF4444;"></i>
            <ul class="space-y-1" style="color: #DC2626;">
              <?php foreach ($errors as $err): ?>
                <li class="text-sm font-medium"><?php echo htmlspecialchars($err); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      <form method="post" class="space-y-5">
        <!-- Name Input -->
        <div class="form-group">
          <label class="block text-sm font-semibold mb-2" style="color: #2C3E50;">
            <i class="fas fa-user mr-2" style="color: #A8D8EA;"></i>
            <?php echo $_SESSION['lang'] === 'fr' ? 'Nom complet' : 'Full Name'; ?>
          </label>
          <input 
            name="name" 
            type="text"
            placeholder="<?php echo $_SESSION['lang'] === 'fr' ? 'Entrez votre nom' : 'Enter your name'; ?>" 
            class="w-full px-4 py-3 rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-offset-2" 
            style="background: rgba(168, 216, 234, 0.05); border: 2px solid rgba(168, 216, 234, 0.2); color: #2C3E50; font-weight: 500;"
            onfocus="this.style.borderColor='#A8D8EA'; this.style.boxShadow='0 0 0 3px rgba(168, 216, 234, 0.1)';"
            onblur="this.style.borderColor='rgba(168, 216, 234, 0.2)'; this.style.boxShadow='none';"
            required>
        </div>

        <!-- Email Input -->
        <div class="form-group">
          <label class="block text-sm font-semibold mb-2" style="color: #2C3E50;">
            <i class="fas fa-envelope mr-2" style="color: #FFB6C1;"></i>
            <?php echo $_SESSION['lang'] === 'fr' ? 'Email' : 'Email'; ?>
          </label>
          <input 
            name="email" 
            type="email"
            placeholder="<?php echo $_SESSION['lang'] === 'fr' ? 'votre@email.com' : 'your@email.com'; ?>" 
            class="w-full px-4 py-3 rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-offset-2" 
            style="background: rgba(255, 182, 193, 0.05); border: 2px solid rgba(255, 182, 193, 0.2); color: #2C3E50; font-weight: 500;"
            onfocus="this.style.borderColor='#FFB6C1'; this.style.boxShadow='0 0 0 3px rgba(255, 182, 193, 0.1)';"
            onblur="this.style.borderColor='rgba(255, 182, 193, 0.2)'; this.style.boxShadow='none';"
            required>
        </div>

        <!-- Password Input -->
        <div class="form-group">
          <label class="block text-sm font-semibold mb-2" style="color: #2C3E50;">
            <i class="fas fa-lock mr-2" style="color: #C7CEEA;"></i>
            <?php echo $_SESSION['lang'] === 'fr' ? 'Mot de passe' : 'Password'; ?>
          </label>
          <input 
            name="password" 
            type="password"
            placeholder="<?php echo $_SESSION['lang'] === 'fr' ? 'Au moins 6 caractères' : 'At least 6 characters'; ?>" 
            class="w-full px-4 py-3 rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-offset-2" 
            style="background: rgba(199, 206, 234, 0.05); border: 2px solid rgba(199, 206, 234, 0.2); color: #2C3E50; font-weight: 500;"
            onfocus="this.style.borderColor='#C7CEEA'; this.style.boxShadow='0 0 0 3px rgba(199, 206, 234, 0.1)';"
            onblur="this.style.borderColor='rgba(199, 206, 234, 0.2)'; this.style.boxShadow='none';"
            required>
          <p class="mt-2 text-xs" style="color: #6C757D;">
            <i class="fas fa-info-circle mr-1"></i>
            <?php echo $_SESSION['lang'] === 'fr' ? 'Utilisez un mot de passe fort avec au moins 6 caractères' : 'Use a strong password with at least 6 characters'; ?>
          </p>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn-primary py-3.5 text-base font-semibold flex items-center justify-center gap-2">
          <i class="fas fa-user-check"></i>
          <?php echo $_SESSION['lang'] === 'fr' ? 'Créer mon compte' : 'Create My Account'; ?>
        </button>

        <!-- Divider -->
        <div class="divider-pastel my-6"></div>

        <!-- Sign In Link -->
        <div class="text-center">
          <p class="text-sm" style="color: #6C757D;">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Vous avez déjà un compte ?' : 'Already have an account?'; ?>
            <a href="signin.php" class="font-semibold ml-2 transition-all hover:underline" style="background: linear-gradient(135deg, #5DADE2, #AF7AC5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
              <?php echo $_SESSION['lang'] === 'fr' ? 'Se connecter' : 'Sign In'; ?> →
            </a>
          </p>
        </div>
      </form>
    </div>

    <!-- Features -->
    <div class="mt-8 grid grid-cols-3 gap-4 animate-fade-in-up" style="animation-delay: 0.4s;">
      <div class="text-center p-3 rounded-xl" style="background: rgba(168, 216, 234, 0.1);">
        <i class="fas fa-shield-alt text-2xl mb-2" style="color: #A8D8EA;"></i>
        <p class="text-xs font-semibold" style="color: #2C3E50;"><?php echo $_SESSION['lang'] === 'fr' ? 'Sécurisé' : 'Secure'; ?></p>
      </div>
      <div class="text-center p-3 rounded-xl" style="background: rgba(255, 182, 193, 0.1);">
        <i class="fas fa-clock text-2xl mb-2" style="color: #FFB6C1;"></i>
        <p class="text-xs font-semibold" style="color: #2C3E50;"><?php echo $_SESSION['lang'] === 'fr' ? 'Rapide' : 'Fast'; ?></p>
      </div>
      <div class="text-center p-3 rounded-xl" style="background: rgba(181, 234, 215, 0.1);">
        <i class="fas fa-check-circle text-2xl mb-2" style="color: #B5EAD7;"></i>
        <p class="text-xs font-semibold" style="color: #2C3E50;"><?php echo $_SESSION['lang'] === 'fr' ? 'Gratuit' : 'Free'; ?></p>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
