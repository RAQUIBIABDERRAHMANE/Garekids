<?php 
// SEO Meta Data for About Page
$page_title = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr' 
    ? 'À Propos - Notre Histoire et Mission'
    : 'About Us - Our Story and Mission';
$page_description = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'Découvrez TakeCare - Plus de 8 ans d\'expérience en garde d\'enfants. Éducatrice certifiée, environnement sécurisé, approche bienveillante pour le développement de votre enfant.'
    : 'Discover TakeCare - Over 8 years of childcare experience. Certified educator, safe environment, caring approach for your child\'s development.';
$page_keywords = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'à propos garde enfants, éducatrice certifiée, expérience garde, histoire crèche'
    : 'about childcare, certified educator, care experience, daycare history';

require_once __DIR__ . '/includes/header.php'; 
?>

<section class="card p-8 md:p-12 animate-fade-in-up">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
    <div>
      <h2 class="text-4xl font-bold hero-title mb-6"><?php echo $lang['about_title']; ?></h2>
      <div class="prose prose-lg">
        <p class="text-gray-700 leading-relaxed mb-4">
          <?php echo $lang['about_text']; ?>
        </p>
        <div class="mt-6 space-y-3">
          <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-2xl text-green-500"></i>
            <span><?php echo $_SESSION['lang'] === 'fr' ? 'Certifié RCR et premiers soins' : 'CPR & First Aid Certified'; ?></span>
          </div>
          <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-2xl text-green-500"></i>
            <span><?php echo $_SESSION['lang'] === 'fr' ? '8+ années d\'expérience' : '8+ Years of Experience'; ?></span>
          </div>
          <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-2xl text-green-500"></i>
            <span><?php echo $_SESSION['lang'] === 'fr' ? 'Références disponibles' : 'References Available'; ?></span>
          </div>
          <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-2xl text-green-500"></i>
            <span><?php echo $_SESSION['lang'] === 'fr' ? 'Horaires flexibles' : 'Flexible Hours'; ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="relative">
      <div class="absolute inset-0 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl transform -rotate-3 opacity-20"></div>
      <img src="/assets/images/about.jpg" alt="Caregiver" class="relative w-full rounded-2xl shadow-2xl" onerror="this.src='/assets/images/logo.svg'; this.classList.add('p-12', 'bg-white');">
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
