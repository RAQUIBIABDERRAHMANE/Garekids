<?php 
// SEO Meta Data for Home Page
$page_title = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr' 
    ? 'Accueil - Service de Garde d\'Enfants Professionnel'
    : 'Home - Professional Childcare Services';
$page_description = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'TakeCare offre des services de garde d\'enfants professionnels et aimants. Babysitting, garde après l\'école, activités éducatives. Environnement sûr et stimulant.'
    : 'TakeCare offers professional and loving childcare services. Babysitting, after-school care, educational activities. Safe and stimulating environment.';
$page_keywords = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'garde enfants, babysitting, nounou professionnelle, crèche, garde scolaire, activités enfants'
    : 'childcare, babysitting, professional nanny, daycare, school care, kids activities';

require_once __DIR__ . '/includes/header.php'; 
require_once __DIR__ . '/config/db.php';

// Fetch testimonials from database
$testimonials = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->query("SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 2");
        $testimonials = $stmt->fetchAll();
    } elseif (isset($conn)) {
        $result = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 2");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $testimonials[] = $row;
            }
        }
    }
} catch (Exception $e) {
    // Fallback to default testimonials if database error
    $testimonials = [];
}

// Default testimonials if none in database
if (empty($testimonials)) {
    $testimonials = [
        [
            'parent_name' => 'Sarah M.',
            'content' => $_SESSION['lang'] === 'fr' 
                ? 'Jane est incroyable avec nos enfants ! Ils l\'adorent et nous aussi. Très professionnel et attentionné.' 
                : 'Jane is amazing with our kids! They love her and so do we. Very professional and caring.'
        ],
        [
            'parent_name' => 'Michael K.',
            'content' => $_SESSION['lang'] === 'fr' 
                ? 'Meilleure décision que nous ayons prise ! Notre fille a tellement appris et s\'est fait de nouveaux amis.' 
                : 'Best decision we ever made! Our daughter has learned so much and made new friends.'
        ]
    ];
}

// Get total number of testimonials for stats
$totalTestimonials = 0;
try {
    if (isset($pdo)) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM testimonials");
        $result = $stmt->fetch();
        $totalTestimonials = $result['count'] ?? 0;
    } elseif (isset($conn)) {
        $result = $conn->query("SELECT COUNT(*) as count FROM testimonials");
        if ($result) {
            $row = $result->fetch_assoc();
            $totalTestimonials = $row['count'] ?? 0;
        }
    }
} catch (Exception $e) {
    $totalTestimonials = 0;
}

// Get total number of users (families)
$totalFamilies = 0;
try {
    if (isset($pdo)) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE is_admin = 0");
        $result = $stmt->fetch();
        $totalFamilies = $result['count'] ?? 0;
    } elseif (isset($conn)) {
        $result = $conn->query("SELECT COUNT(*) as count FROM users WHERE is_admin = 0");
        if ($result) {
            $row = $result->fetch_assoc();
            $totalFamilies = $row['count'] ?? 0;
        }
    }
} catch (Exception $e) {
    $totalFamilies = 0;
}
?>

  <!-- Hero Section -->
  <section class="hero-overlay grid grid-cols-1 lg:grid-cols-2 gap-8 items-center p-8 md:p-12 rounded-2xl mb-12 animate-fade-in-up">
    <div>
      <div class="inline-block mb-4">
        <span class="badge-pastel">✨ Certified & Trusted Childcare</span>
      </div>
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold hero-title mb-6 leading-tight">
        <?php echo $lang['hero_title']; ?>
      </h2>
      <p class="text-lg md:text-xl mb-8 leading-relaxed" style="color: #6C757D;">
        <?php echo $lang['hero_subtitle']; ?>
      </p>
      <div class="flex flex-wrap gap-4">
        <a href="tel:+1234567890" class="btn-primary inline-flex items-center gap-2">
          <i class="fas fa-phone-alt"></i>
          <?php echo $lang['call_now']; ?>
        </a>
        <a href="https://wa.me/1234567890" target="_blank" class="btn-secondary inline-flex items-center gap-2">
          <i class="fab fa-whatsapp"></i>
          <?php echo $lang['chat_whatsapp']; ?>
        </a>
      </div>
    </div>
    <div class="relative">
      <div class="absolute inset-0 rounded-2xl transform rotate-3 opacity-20" style="background: linear-gradient(135deg, #FFB6C1, #FFC0CB);"></div>
      <div class="absolute -inset-4 rounded-2xl transform -rotate-2 opacity-10" style="background: linear-gradient(135deg, #A8D8EA, #89CFF0);"></div>
      <img src="https://scdailygazette.com/wp-content/uploads/2024/02/ChildcareGetty-2048x1365-1-1536x1024.jpg" alt="kids playing" class="relative w-full rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500" style="box-shadow: 0 25px 50px rgba(168, 216, 234, 0.3);" onerror="this.src='/assets/images/logo.svg'; this.classList.add('p-12', 'bg-white');">
    </div>
  </section>

  <!-- Stats Section -->
  <section class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
    <div class="card p-6 text-center transform hover:scale-105 transition-all">
      <div class="text-4xl font-bold stat-number mb-2">8+</div>
      <div class="text-sm font-medium" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Années d\'expérience' : 'Years Experience'; ?></div>
    </div>
    <div class="card p-6 text-center transform hover:scale-105 transition-all">
      <div class="text-4xl font-bold stat-number mb-2"><?php echo $totalFamilies > 0 ? $totalFamilies . '+' : '50+'; ?></div>
      <div class="text-sm font-medium" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Familles heureuses' : 'Happy Families'; ?></div>
    </div>
    <div class="card p-6 text-center transform hover:scale-105 transition-all">
      <div class="text-4xl font-bold stat-number mb-2">100%</div>
      <div class="text-sm font-medium" style="color: #6C757D;"><?php echo $_SESSION['lang'] === 'fr' ? 'Certifié et assuré' : 'Certified & Insured'; ?></div>
    </div>
    <div class="card p-6 text-center transform hover:scale-105 transition-all">
      <div class="text-4xl font-bold stat-number mb-2"><?php echo $totalTestimonials > 0 ? $totalTestimonials . '+' : '24/7'; ?></div>
      <div class="text-sm font-medium" style="color: #6C757D;"><?php echo $totalTestimonials > 0 ? ($_SESSION['lang'] === 'fr' ? 'Témoignages' : 'Testimonials') : ($_SESSION['lang'] === 'fr' ? 'Support disponible' : 'Support Available'); ?></div>
    </div>
  </section>

  <!-- Featured Services -->
  <section class="mb-12">
    <h3 class="text-3xl font-bold text-center mb-8 hero-title"><?php echo $lang['featured_services']; ?></h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="card p-6 text-center group">
        <div class="service-icon mx-auto group-hover:scale-110 transition-transform">
          <i class="fas fa-baby"></i>
        </div>
        <h4 class="font-bold text-lg mb-2" style="color: #2C3E50;"><?php echo $lang['babysitting']; ?></h4>
        <p class="text-sm" style="color: #6C757D;"><?php echo $lang['babysitting_desc']; ?></p>
      </div>
      <div class="card p-6 text-center group">
        <div class="service-icon mx-auto group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #C7CEEA, #BB8FCE);">
          <i class="fas fa-school"></i>
        </div>
        <h4 class="font-bold text-lg mb-2" style="color: #2C3E50;"><?php echo $lang['after_school']; ?></h4>
        <p class="text-sm" style="color: #6C757D;"><?php echo $lang['after_school_desc']; ?></p>
      </div>
      <div class="card p-6 text-center group">
        <div class="service-icon mx-auto group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #B5EAD7, #7DCEA0);">
          <i class="fas fa-puzzle-piece"></i>
        </div>
        <h4 class="font-bold text-lg mb-2" style="color: #2C3E50;"><?php echo $lang['educational']; ?></h4>
        <p class="text-sm" style="color: #6C757D;"><?php echo $lang['educational_desc']; ?></p>
      </div>
      <div class="card p-6 text-center group">
        <div class="service-icon mx-auto group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #FFD4B2, #FAD7A0);">
          <i class="fas fa-utensils"></i>
        </div>
        <h4 class="font-bold text-lg mb-2" style="color: #2C3E50;"><?php echo $lang['meals']; ?></h4>
        <p class="text-sm" style="color: #6C757D;"><?php echo $lang['meals_desc']; ?></p>
      </div>
    </div>
  </section>

  <!-- Testimonials Preview -->
  <section class="card p-8 mb-12">
    <h3 class="text-3xl font-bold text-center mb-2 hero-title"><?php echo $lang['what_parents_say']; ?></h3>
    <p class="text-center mb-8" style="color: #6C757D;"><?php echo $lang['see_more_testimonials']; ?></p>
    
    <?php if (!empty($testimonials)): ?>
      <div class="grid grid-cols-1 md:grid-cols-<?php echo count($testimonials); ?> gap-6">
        <?php foreach ($testimonials as $testimonial): ?>
          <div class="testimonial-card p-6 rounded-xl animate-fade-in-up">
            <p class="italic mb-4" style="color: #374151;">
              "<?php echo htmlspecialchars($testimonial['content']); ?>"
            </p>
            <div class="font-semibold" style="background: linear-gradient(135deg, #5DADE2, #AF7AC5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
              — <?php echo htmlspecialchars($testimonial['parent_name']); ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center p-8 rounded-xl" style="background: linear-gradient(135deg, rgba(168, 216, 234, 0.1), rgba(181, 234, 215, 0.1));">
        <i class="fas fa-comments text-4xl mb-4" style="color: #A8D8EA;"></i>
        <p class="text-lg font-semibold" style="color: #2C3E50;">
          <?php echo $_SESSION['lang'] === 'fr' ? 'Soyez le premier à laisser un témoignage !' : 'Be the first to leave a testimonial!'; ?>
        </p>
      </div>
    <?php endif; ?>
    
    <div class="text-center mt-6">
      <a href="testimonials.php" class="btn-secondary inline-flex items-center gap-2">
        <?php echo $_SESSION['lang'] === 'fr' ? 'Voir tous les témoignages' : 'View All Testimonials'; ?>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="hero-overlay p-8 md:p-12 rounded-2xl text-center">
    <div class="inline-block mb-4">
      <span class="badge-pastel">💌 Let's Connect</span>
    </div>
    <h3 class="text-3xl md:text-4xl font-bold hero-title mb-4">
      <?php echo $_SESSION['lang'] === 'fr' ? 'Prêt à nous rejoindre ?' : 'Ready to Join Us?'; ?>
    </h3>
    <p class="text-lg mb-6 max-w-2xl mx-auto" style="color: #6C757D;">
      <?php echo $_SESSION['lang'] === 'fr' ? 'Contactez-nous dès aujourd\'hui pour en savoir plus sur nos services et planifier une visite.' : 'Contact us today to learn more about our services and schedule a visit.'; ?>
    </p>
    <a href="contact.php" class="btn-primary inline-flex items-center gap-2">
      <i class="fas fa-envelope"></i>
      <?php echo $lang['contact']; ?>
    </a>
  </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
