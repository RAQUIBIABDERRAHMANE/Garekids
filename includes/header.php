<?php
if (session_status() == PHP_SESSION_NONE) session_start();
// Language system
if (!isset($_SESSION['lang'])) $_SESSION['lang'] = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'fr'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
require_once __DIR__ . '/../lang/' . $_SESSION['lang'] . '.php';

// SEO Meta Data
$site_name = 'TakeCare';
$site_url = 'https://gardekids.com.com';
$default_image = $site_url . '/assets/images/logo.svg';

// Default SEO values (can be overridden per page)
if (!isset($page_title)) {
    $page_title = $lang['site_title'] ?? 'Safe, Fun, and Loving Childcare';
}
if (!isset($page_description)) {
    $page_description = $_SESSION['lang'] === 'fr' 
        ? 'TakeCare - Service de garde d\'enfants professionnel. Babysitting, garde après l\'école, activités éducatives et préparation de repas. Environnement sûr et aimant pour vos enfants.'
        : 'TakeCare - Professional childcare services. Babysitting, after-school care, educational activities, and meal preparation. Safe and loving environment for your children.';
}
if (!isset($page_keywords)) {
    $page_keywords = $_SESSION['lang'] === 'fr'
        ? 'garde d\'enfants, babysitting, nounou, crèche, garde après école, activités éducatives, repas enfants, garde professionnelle'
        : 'childcare, babysitting, nanny, daycare, after school care, educational activities, child meals, professional childcare';
}
if (!isset($page_image)) {
    $page_image = $default_image;
}

$base_path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
$current_url = $site_url . $_SERVER['REQUEST_URI'];
?>
<!doctype html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Primary Meta Tags -->
  <title><?php echo htmlspecialchars($page_title); ?> | <?php echo $site_name; ?></title>
  <meta name="title" content="<?php echo htmlspecialchars($page_title); ?> | <?php echo $site_name; ?>">
  <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
  <meta name="author" content="TakeCare Childcare Services">
  <meta name="robots" content="index, follow">
  <meta name="language" content="<?php echo $_SESSION['lang'] === 'fr' ? 'French' : 'English'; ?>">
  <meta name="revisit-after" content="7 days">
  
  <!-- Canonical URL -->
  <link rel="canonical" href="<?php echo htmlspecialchars($current_url); ?>">
  
  <!-- Alternate Languages -->
  <link rel="alternate" hreflang="en" href="<?php echo $site_url . strtok($_SERVER['REQUEST_URI'], '?'); ?>?lang=en">
  <link rel="alternate" hreflang="fr" href="<?php echo $site_url . strtok($_SERVER['REQUEST_URI'], '?'); ?>?lang=fr">
  <link rel="alternate" hreflang="x-default" href="<?php echo $site_url; ?>">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo htmlspecialchars($current_url); ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?> | <?php echo $site_name; ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
  <meta property="og:image" content="<?php echo htmlspecialchars($page_image); ?>">
  <meta property="og:image:alt" content="TakeCare Childcare Services">
  <meta property="og:site_name" content="<?php echo $site_name; ?>">
  <meta property="og:locale" content="<?php echo $_SESSION['lang'] === 'fr' ? 'fr_FR' : 'en_US'; ?>">
  
  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="<?php echo htmlspecialchars($current_url); ?>">
  <meta property="twitter:title" content="<?php echo htmlspecialchars($page_title); ?> | <?php echo $site_name; ?>">
  <meta property="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
  <meta property="twitter:image" content="<?php echo htmlspecialchars($page_image); ?>">
  
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?php echo $base_path; ?>assets/images/logo.svg">
  <link rel="apple-touch-icon" href="<?php echo $base_path; ?>assets/images/logo.svg">
  
  <!-- Theme Color -->
  <meta name="theme-color" content="#A8D8EA">
  <meta name="msapplication-TileColor" content="#A8D8EA">
  
  <!-- Structured Data / Schema.org -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ChildCare",
    "name": "TakeCare",
    "description": "<?php echo addslashes($page_description); ?>",
    "url": "<?php echo $site_url; ?>",
    "logo": "<?php echo $default_image; ?>",
    "image": "<?php echo $page_image; ?>",
    "telephone": "+212 653-788298",
    "email": "fatielbakki@gmail.com",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "US"
    },
    "openingHours": "Mo-Fr 07:00-19:00",
    "priceRange": "$$",
    "sameAs": [],
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Childcare Services",
      "itemListElement": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Babysitting",
            "description": "Professional childcare for children of all ages"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "After-School Care",
            "description": "Safe and engaging supervision after school hours"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Educational Activities",
            "description": "Age-appropriate learning and development programs"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Meal Preparation",
            "description": "Nutritious meals and snacks tailored to children's needs"
          }
        }
      ]
    }
  }
  </script>
  
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
</head>
<body class="text-gray-800 leading-relaxed">

<header class="shadow-lg sticky top-0 z-50" style="background: linear-gradient(135deg, rgba(168, 216, 234, 0.95), rgba(181, 234, 215, 0.95)) !important; backdrop-filter: blur(15px);">
  <div class="max-w-7xl mx-auto flex items-center justify-between p-4">
    <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '/'; ?>" class="flex items-center gap-3 group">
      <img src="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>assets/images/logo.svg" alt="logo" class="h-14 w-14 rounded-full bg-white p-2 shadow-lg transition-transform group-hover:scale-110 float-animation" style="box-shadow: 0 8px 20px rgba(168, 216, 234, 0.4);">
      <div>
        <h1 class="text-2xl font-bold drop-shadow-sm" style="background: linear-gradient(135deg, #5DADE2, #AF7AC5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">TakeCare</h1>
        <p class="text-sm font-medium" style="color: #6C757D !important;"><?php echo $lang['tagline'] ?? 'Loving Childcare'; ?></p>
      </div>
    </a>

    <nav class="hidden lg:flex gap-6 items-center">
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '/'; ?>" class="transition-all font-semibold hover:scale-105" style="color: #2C3E50 !important;"><?php echo $lang['home'] ?? 'Home'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>about.php" class="transition-all font-semibold hover:scale-105" style="color: #2C3E50 !important;"><?php echo $lang['about'] ?? 'About'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>services.php" class="transition-all font-semibold hover:scale-105" style="color: #2C3E50 !important;"><?php echo $lang['services'] ?? 'Services'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>gallery.php" class="transition-all font-semibold hover:scale-105" style="color: #2C3E50 !important;"><?php echo $lang['gallery'] ?? 'Gallery'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>testimonials.php" class="transition-all font-semibold hover:scale-105" style="color: #2C3E50 !important;"><?php echo $lang['testimonials'] ?? 'Testimonials'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>faq.php" class="transition-all font-semibold hover:scale-105" style="color: #2C3E50 !important;"><?php echo $lang['faq'] ?? 'FAQ'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>contact.php" class="transition-all font-semibold hover:scale-105" style="color: #2C3E50 !important;"><?php echo $lang['contact'] ?? 'Contact'; ?></a>
      
      <!-- Language switcher -->
      <div class="flex gap-2 ml-4">
        <a href="?lang=en" class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all shadow-md" style="<?php echo $_SESSION['lang'] === 'en' ? 'background: linear-gradient(135deg, #A8D8EA, #89CFF0); color: #2C3E50; box-shadow: 0 4px 15px rgba(168, 216, 234, 0.4);' : 'color: #2C3E50; background: rgba(255,255,255,0.5);'; ?>"><?php echo $_SESSION['lang'] === 'en' ? '🇬🇧 ' : ''; ?>EN</a>
        <a href="?lang=fr" class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all shadow-md" style="<?php echo $_SESSION['lang'] === 'fr' ? 'background: linear-gradient(135deg, #FFB6C1, #FFC0CB); color: #2C3E50; box-shadow: 0 4px 15px rgba(255, 182, 193, 0.4);' : 'color: #2C3E50; background: rgba(255,255,255,0.5);'; ?>"><?php echo $_SESSION['lang'] === 'fr' ? '🇫🇷 ' : ''; ?>FR</a>
      </div>
      
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>submit_testimonial.php" class="text-sm" style="background: linear-gradient(135deg, #B5EAD7, #A8D8EA); color: #2C3E50; padding: 0.6rem 1.5rem; border-radius: 2rem; font-weight: 600; box-shadow: 0 4px 15px rgba(181, 234, 215, 0.35);"><i class="fas fa-pen mr-2"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Témoigner' : 'Testimonial'; ?></a>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>profile.php" class="text-sm" style="background: linear-gradient(135deg, #C7CEEA, #A8D8EA); color: #2C3E50; padding: 0.6rem 1.5rem; border-radius: 2rem; font-weight: 600; box-shadow: 0 4px 15px rgba(199, 206, 234, 0.35);"><i class="fas fa-user mr-2"></i><?php echo $lang['profile'] ?? 'Profile'; ?></a>
        <?php if (!empty($_SESSION['is_admin'])): ?>
          <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? './' : ''; ?>admin/" class="px-4 py-2 rounded-full text-sm font-semibold" style="background: linear-gradient(135deg, #AF7AC5, #BB8FCE); color: white; box-shadow: 0 4px 15px rgba(175, 122, 197, 0.35);"><i class="fas fa-cog mr-2"></i>Admin</a>
        <?php endif; ?>
      <?php else: ?>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>signup.php" class="text-sm" style="background: linear-gradient(135deg, #A8D8EA, #89CFF0); color: #2C3E50; padding: 0.6rem 1.5rem; border-radius: 2rem; font-weight: 600; box-shadow: 0 4px 15px rgba(168, 216, 234, 0.35);"><?php echo $lang['signup'] ?? 'Signup'; ?></a>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>signin.php" class="text-sm" style="border: 2px solid #A8D8EA; color: #5DADE2; background: rgba(255,255,255,0.8); padding: 0.6rem 1.5rem; border-radius: 2rem; font-weight: 600;"><?php echo $lang['signin'] ?? 'Signin'; ?></a>
      <?php endif; ?>
    </nav>

    <div class="lg:hidden">
      <button id="nav-toggle" class="p-3 rounded-xl shadow-lg transition-all" style="background: white; color: #5DADE2;">
        <i class="fas fa-bars text-xl"></i>
      </button>
    </div>
  </div>
  
  
  <!-- Mobile nav -->
  <div id="mobile-nav" class="hidden lg:hidden" style="background: linear-gradient(135deg, rgba(168, 216, 234, 0.98), rgba(181, 234, 215, 0.98)); backdrop-filter: blur(15px);">
    <div class="p-6 flex flex-col gap-3">
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '/'; ?>" class="font-semibold p-3 rounded-xl transition-all hover:bg-white/50" style="color: #2C3E50;"><?php echo $lang['home'] ?? 'Home'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>about.php" class="font-semibold p-3 rounded-xl transition-all hover:bg-white/50" style="color: #2C3E50;"><?php echo $lang['about'] ?? 'About'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>services.php" class="font-semibold p-3 rounded-xl transition-all hover:bg-white/50" style="color: #2C3E50;"><?php echo $lang['services'] ?? 'Services'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>gallery.php" class="font-semibold p-3 rounded-xl transition-all hover:bg-white/50" style="color: #2C3E50;"><?php echo $lang['gallery'] ?? 'Gallery'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>testimonials.php" class="font-semibold p-3 rounded-xl transition-all hover:bg-white/50" style="color: #2C3E50;"><?php echo $lang['testimonials'] ?? 'Testimonials'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>faq.php" class="font-semibold p-3 rounded-xl transition-all hover:bg-white/50" style="color: #2C3E50;"><?php echo $lang['faq'] ?? 'FAQ'; ?></a>
      <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>contact.php" class="font-semibold p-3 rounded-xl transition-all hover:bg-white/50" style="color: #2C3E50;"><?php echo $lang['contact'] ?? 'Contact'; ?></a>
      <div style="border-top: 2px solid rgba(168, 216, 234, 0.3); margin: 0.75rem 0;"></div>
      <div class="flex gap-2">
        <a href="?lang=en" class="flex-1 text-center py-2.5 rounded-full font-semibold shadow-md" style="<?php echo $_SESSION['lang'] === 'en' ? 'background: linear-gradient(135deg, #A8D8EA, #89CFF0); color: #2C3E50;' : 'background: white; color: #5DADE2;'; ?>">🇬🇧 EN</a>
        <a href="?lang=fr" class="flex-1 text-center py-2.5 rounded-full font-semibold shadow-md" style="<?php echo $_SESSION['lang'] === 'fr' ? 'background: linear-gradient(135deg, #FFB6C1, #FFC0CB); color: #2C3E50;' : 'background: white; color: #EC7063;'; ?>">🇫🇷 FR</a>
      </div>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>submit_testimonial.php" class="p-3 rounded-full text-center font-semibold shadow-lg" style="background: linear-gradient(135deg, #B5EAD7, #A8D8EA); color: #2C3E50;"><i class="fas fa-pen mr-2"></i><?php echo $_SESSION['lang'] === 'fr' ? 'Témoigner' : 'Testimonial'; ?></a>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>profile.php" class="p-3 rounded-full text-center font-semibold shadow-lg" style="background: linear-gradient(135deg, #C7CEEA, #A8D8EA); color: #2C3E50;"><?php echo $lang['profile'] ?? 'Profile'; ?></a>
      <?php else: ?>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>signup.php" class="p-3 rounded-full text-center font-semibold shadow-lg" style="background: linear-gradient(135deg, #A8D8EA, #89CFF0); color: #2C3E50;"><?php echo $lang['signup'] ?? 'Signup'; ?></a>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>signin.php" class="p-3 rounded-full text-center font-semibold" style="border: 2px solid #A8D8EA; color: #5DADE2; background: white;"><?php echo $lang['signin'] ?? 'Signin'; ?></a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main class="max-w-7xl mx-auto p-4 min-h-screen" style="color: var(--dark);">

