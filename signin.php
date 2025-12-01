<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (!$password) $errors[] = 'Password required.';

    if (empty($errors)) {
        try {
            if (isset($pdo)) {
                $stmt = $pdo->prepare('SELECT id, password, name, is_admin FROM users WHERE email = ? LIMIT 1');
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['is_admin'] = $user['is_admin'];
                    // Redirect admin to admin panel, regular users to home
                    if ($user['is_admin']) {
                        header('Location: admin/');
                    } else {
                        header('Location: index.php');
                    }
                    exit;
                } else {
                    $errors[] = 'Invalid credentials.';
                }
            } elseif (isset($conn)) {
                $e = $conn->real_escape_string($email);
                $r = $conn->query("SELECT id, password, name, is_admin FROM users WHERE email = '$e' LIMIT 1");
                if ($r && $r->num_rows) {
                    $u = $r->fetch_assoc();
                    if (password_verify($password, $u['password'])) {
                        $_SESSION['user_id'] = $u['id'];
                        $_SESSION['user_name'] = $u['name'];
                        $_SESSION['is_admin'] = $u['is_admin'];
                        // Redirect admin to admin panel, regular users to home
                        if ($u['is_admin']) {
                            header('Location: admin/');
                        } else {
                            header('Location: index.php');
                        }
                        exit;
                    } else {
                        $errors[] = 'Invalid credentials.';
                    }
                } else {
                    $errors[] = 'Invalid credentials.';
                }
            } else {
                $errors[] = 'No database connection available.';
            }
        } catch (Exception $e) { $errors[] = 'Error: ' . $e->getMessage(); }
    }
}
?>

<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
  <div class="w-full max-w-md">
    <!-- Hero Card -->
    <div class="text-center mb-8 animate-fade-in-up">
      <div class="inline-block p-4 rounded-full mb-4" style="background: linear-gradient(135deg, #C7CEEA, #BB8FCE); box-shadow: 0 10px 30px rgba(199, 206, 234, 0.4);">
        <i class="fas fa-sign-in-alt text-4xl" style="color: white;"></i>
      </div>
      <h2 class="text-3xl md:text-4xl font-bold hero-title mb-2">
        <?php echo $_SESSION['lang'] === 'fr' ? 'Bienvenue !' : 'Welcome Back!'; ?>
      </h2>
      <p class="text-base" style="color: #6C757D;">
        <?php echo $_SESSION['lang'] === 'fr' ? 'Connectez-vous à votre compte' : 'Sign in to your account'; ?>
      </p>
    </div>

    <!-- Form Card -->
    <div class="card p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
      <?php if (isset($_GET['registered'])): ?>
        <div class="mb-6 p-4 rounded-xl" style="background: linear-gradient(135deg, rgba(181, 234, 215, 0.15), rgba(125, 206, 160, 0.15)); border-left: 4px solid #B5EAD7;">
          <div class="flex items-start gap-3">
            <i class="fas fa-check-circle text-xl" style="color: #7DCEA0;"></i>
            <div style="color: #27AE60;">
              <p class="text-sm font-semibold"><?php echo $_SESSION['lang'] === 'fr' ? 'Compte créé avec succès !' : 'Account created successfully!'; ?></p>
              <p class="text-xs mt-1"><?php echo $_SESSION['lang'] === 'fr' ? 'Connectez-vous maintenant avec vos identifiants.' : 'Please sign in with your credentials.'; ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($errors): ?>
        <div class="mb-6 p-4 rounded-xl" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1)); border-left: 4px solid #EF4444;">
          <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-xl" style="color: #EF4444;"></i>
            <div class="space-y-1" style="color: #DC2626;">
              <?php foreach ($errors as $err): ?>
                <p class="text-sm font-medium"><?php echo htmlspecialchars($err); ?></p>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <form method="post" class="space-y-5">
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
            placeholder="<?php echo $_SESSION['lang'] === 'fr' ? 'Entrez votre mot de passe' : 'Enter your password'; ?>" 
            class="w-full px-4 py-3 rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-offset-2" 
            style="background: rgba(199, 206, 234, 0.05); border: 2px solid rgba(199, 206, 234, 0.2); color: #2C3E50; font-weight: 500;"
            onfocus="this.style.borderColor='#C7CEEA'; this.style.boxShadow='0 0 0 3px rgba(199, 206, 234, 0.1)';"
            onblur="this.style.borderColor='rgba(199, 206, 234, 0.2)'; this.style.boxShadow='none';"
            required>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" class="w-4 h-4 rounded" style="accent-color: #A8D8EA;">
            <span class="text-sm font-medium" style="color: #6C757D;">
              <?php echo $_SESSION['lang'] === 'fr' ? 'Se souvenir de moi' : 'Remember me'; ?>
            </span>
          </label>
          <a href="#" class="text-sm font-semibold transition-all hover:underline" style="background: linear-gradient(135deg, #5DADE2, #AF7AC5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Mot de passe oublié ?' : 'Forgot password?'; ?>
          </a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn-primary py-3.5 text-base font-semibold flex items-center justify-center gap-2">
          <i class="fas fa-sign-in-alt"></i>
          <?php echo $_SESSION['lang'] === 'fr' ? 'Se connecter' : 'Sign In'; ?>
        </button>

        <!-- Divider -->
        <div class="divider-pastel my-6"></div>

        <!-- Sign Up Link -->
        <div class="text-center">
          <p class="text-sm" style="color: #6C757D;">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Pas encore de compte ?' : "Don't have an account?"; ?>
            <a href="signup.php" class="font-semibold ml-2 transition-all hover:underline" style="background: linear-gradient(135deg, #5DADE2, #AF7AC5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
              <?php echo $_SESSION['lang'] === 'fr' ? 'Créer un compte' : 'Create Account'; ?> →
            </a>
          </p>
        </div>
      </form>
    </div>

    <!-- Trust Badges -->
    <div class="mt-8 text-center animate-fade-in-up" style="animation-delay: 0.4s;">
      <div class="flex items-center justify-center gap-6 flex-wrap">
        <div class="flex items-center gap-2">
          <i class="fas fa-shield-alt" style="color: #A8D8EA;"></i>
          <span class="text-xs font-semibold" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Connexion sécurisée' : 'Secure Login'; ?></span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fas fa-lock" style="color: #C7CEEA;"></i>
          <span class="text-xs font-semibold" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'SSL Crypté' : 'SSL Encrypted'; ?></span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fas fa-user-shield" style="color: #B5EAD7;"></i>
          <span class="text-xs font-semibold" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Données protégées' : 'Data Protected'; ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
