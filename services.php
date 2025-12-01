<?php 
// SEO Meta Data for Services Page
$page_title = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr' 
    ? 'Nos Services - Babysitting, Garde Après l\'École, Activités'
    : 'Our Services - Babysitting, After-School Care, Activities';
$page_description = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'Découvrez nos services de garde d\'enfants : babysitting flexible, garde après l\'école, activités éducatives et préparation de repas nutritifs. Tarifs compétitifs.'
    : 'Discover our childcare services: flexible babysitting, after-school care, educational activities and nutritious meal preparation. Competitive rates.';
$page_keywords = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'babysitting, garde après école, activités éducatives, repas enfants, tarifs garde'
    : 'babysitting, after school care, educational activities, kids meals, childcare rates';

require_once __DIR__ . '/includes/header.php'; 
?>

<section class="animate-fade-in-up">
  <h2 class="text-4xl font-bold text-center mb-4 hero-title"><?php echo $lang['services']; ?></h2>
  <p class="text-center text-gray-600 mb-12 text-lg"><?php echo $_SESSION['lang'] === 'fr' ? 'Des services de qualité adaptés à vos besoins' : 'Quality services tailored to your needs'; ?></p>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="card p-8">
      <div class="service-icon">
        <i class="fas fa-baby"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3 text-amber-700"><?php echo $lang['babysitting']; ?></h3>
      <p class="text-gray-700 leading-relaxed">
        <?php echo $lang['babysitting_desc']; ?>
      </p>
      <ul class="mt-4 space-y-2 text-sm text-gray-600">
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Disponible soirs et week-ends' : 'Evening & weekend availability'; ?></li>
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Tarifs horaires flexibles' : 'Flexible hourly rates'; ?></li>
      </ul>
    </div>

    <div class="card p-8">
      <div class="service-icon">
        <i class="fas fa-school"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3 text-amber-700"><?php echo $lang['after_school']; ?></h3>
      <p class="text-gray-700 leading-relaxed">
        <?php echo $lang['after_school_desc']; ?>
      </p>
      <ul class="mt-4 space-y-2 text-sm text-gray-600">
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Prise en charge à l\'école' : 'School pickup service'; ?></li>
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Aide aux devoirs' : 'Homework assistance'; ?></li>
      </ul>
    </div>

    <div class="card p-8">
      <div class="service-icon">
        <i class="fas fa-puzzle-piece"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3 text-amber-700"><?php echo $lang['educational']; ?></h3>
      <p class="text-gray-700 leading-relaxed">
        <?php echo $lang['educational_desc']; ?>
      </p>
      <ul class="mt-4 space-y-2 text-sm text-gray-600">
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Arts et artisanat' : 'Arts & crafts'; ?></li>
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Jeux éducatifs' : 'Educational games'; ?></li>
      </ul>
    </div>

    <div class="card p-8">
      <div class="service-icon">
        <i class="fas fa-utensils"></i>
      </div>
      <h3 class="text-2xl font-bold mb-3 text-amber-700"><?php echo $lang['meals']; ?></h3>
      <p class="text-gray-700 leading-relaxed">
        <?php echo $lang['meals_desc']; ?>
      </p>
      <ul class="mt-4 space-y-2 text-sm text-gray-600">
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Options biologiques' : 'Organic options'; ?></li>
        <li class="flex items-center gap-2"><i class="fas fa-star text-amber-500"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Adaptations pour allergies' : 'Allergy accommodations'; ?></li>
      </ul>
    </div>
  </div>

  <div class="card p-8 mt-8 text-center bg-gradient-to-r from-amber-50 to-orange-50">
    <h3 class="text-2xl font-bold mb-4"><?php echo $_SESSION['lang'] === 'fr' ? 'Intéressé par nos services ?' : 'Interested in Our Services?'; ?></h3>
    <p class="text-gray-700 mb-6"><?php echo $_SESSION['lang'] === 'fr' ? 'Contactez-nous pour discuter de vos besoins spécifiques' : 'Contact us to discuss your specific needs'; ?></p>
    <a href="contact.php" class="btn-primary inline-flex items-center gap-2">
      <i class="fas fa-paper-plane"></i>
      <?php echo $lang['contact']; ?>
    </a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
