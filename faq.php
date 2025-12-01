<?php 
// SEO Meta Data for FAQ Page
$page_title = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr' 
    ? 'FAQ - Questions Fréquentes sur la Garde d\'Enfants'
    : 'FAQ - Frequently Asked Questions About Childcare';
$page_description = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'Réponses aux questions fréquentes sur nos services de garde : horaires, tarifs, sécurité, repas, activités. Tout savoir sur TakeCare.'
    : 'Answers to frequently asked questions about our care services: hours, rates, safety, meals, activities. Everything about TakeCare.';
$page_keywords = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'faq garde enfants, questions nounou, réponses crèche, informations babysitting'
    : 'childcare faq, nanny questions, daycare answers, babysitting information';

require_once __DIR__ . '/includes/header.php'; 
?>

<section class="card p-8 md:p-12 animate-fade-in-up max-w-4xl mx-auto">
  <h2 class="text-4xl font-bold text-center mb-4 hero-title"><?php echo $lang['faq']; ?></h2>
  <p class="text-center text-gray-600 mb-12"><?php echo $_SESSION['lang'] === 'fr' ? 'Réponses aux questions fréquemment posées' : 'Answers to frequently asked questions'; ?></p>

  <div class="space-y-4">
    <div>
      <div class="faq-item p-6 bg-amber-50 rounded-lg flex items-center justify-between">
        <h4 class="font-bold text-lg flex items-center gap-3">
          <i class="fas fa-question-circle text-amber-600"></i>
          <?php echo $lang['faq_age_q']; ?>
        </h4>
        <i class="fas fa-chevron-down text-amber-600"></i>
      </div>
      <div class="hidden p-6 border-l-4 border-amber-400 bg-white rounded-b-lg ml-4">
        <p class="text-gray-700"><?php echo $lang['faq_age_a']; ?></p>
      </div>
    </div>

    <div>
      <div class="faq-item p-6 bg-amber-50 rounded-lg flex items-center justify-between">
        <h4 class="font-bold text-lg flex items-center gap-3">
          <i class="fas fa-question-circle text-amber-600"></i>
          <?php echo $lang['faq_safety_q']; ?>
        </h4>
        <i class="fas fa-chevron-down text-amber-600"></i>
      </div>
      <div class="hidden p-6 border-l-4 border-amber-400 bg-white rounded-b-lg ml-4">
        <p class="text-gray-700"><?php echo $lang['faq_safety_a']; ?></p>
      </div>
    </div>

    <div>
      <div class="faq-item p-6 bg-amber-50 rounded-lg flex items-center justify-between">
        <h4 class="font-bold text-lg flex items-center gap-3">
          <i class="fas fa-question-circle text-amber-600"></i>
          <?php echo $lang['faq_meals_q']; ?>
        </h4>
        <i class="fas fa-chevron-down text-amber-600"></i>
      </div>
      <div class="hidden p-6 border-l-4 border-amber-400 bg-white rounded-b-lg ml-4">
        <p class="text-gray-700"><?php echo $lang['faq_meals_a']; ?></p>
      </div>
    </div>

    <div>
      <div class="faq-item p-6 bg-amber-50 rounded-lg flex items-center justify-between">
        <h4 class="font-bold text-lg flex items-center gap-3">
          <i class="fas fa-question-circle text-amber-600"></i>
          <?php echo $lang['faq_emergency_q']; ?>
        </h4>
        <i class="fas fa-chevron-down text-amber-600"></i>
      </div>
      <div class="hidden p-6 border-l-4 border-amber-400 bg-white rounded-b-lg ml-4">
        <p class="text-gray-700"><?php echo $lang['faq_emergency_a']; ?></p>
      </div>
    </div>
  </div>

  <div class="mt-12 p-6 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg text-center">
    <h3 class="text-xl font-bold mb-3"><?php echo $_SESSION['lang'] === 'fr' ? 'Vous avez d\'autres questions ?' : 'Have More Questions?'; ?></h3>
    <p class="text-gray-700 mb-4"><?php echo $_SESSION['lang'] === 'fr' ? 'N\'hésitez pas à nous contacter directement' : 'Feel free to contact us directly'; ?></p>
    <a href="contact.php" class="btn-primary inline-flex items-center gap-2">
      <i class="fas fa-envelope"></i>
      <?php echo $lang['contact']; ?>
    </a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
