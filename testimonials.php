<?php 
// SEO Meta Data for Testimonials Page
$page_title = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr' 
    ? 'Témoignages - Avis des Parents Satisfaits'
    : 'Testimonials - Reviews from Satisfied Parents';
$page_description = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'Lisez les témoignages de parents satisfaits de nos services de garde d\'enfants. Découvrez pourquoi les familles nous font confiance.'
    : 'Read testimonials from parents satisfied with our childcare services. Discover why families trust us.';
$page_keywords = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'témoignages garde enfants, avis parents, recommandations nounou, évaluations crèche'
    : 'childcare testimonials, parent reviews, nanny recommendations, daycare ratings';

require_once __DIR__ . '/includes/header.php'; 
?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-pastel-blue via-pastel-lavender to-pastel-pink text-white py-20 rounded-2xl mb-12">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h1 class="text-5xl font-bold mb-4"><?php echo $lang['testimonials'] ?? 'Testimonials'; ?></h1>
        <p class="text-xl mb-8">
            <?php echo $_SESSION['lang'] === 'fr' ? 
                'Découvrez ce que nos parents disent de nous' : 
                'See what our parents say about us'; ?>
        </p>
        <?php if (isset($_SESSION['user_id'])): ?>
        <a href="submit_testimonial.php" class="inline-flex items-center gap-2 bg-white text-pastel-blue font-semibold px-8 py-4 rounded-full hover:shadow-lg transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-pen"></i>
            <?php echo $_SESSION['lang'] === 'fr' ? 'Laisser un témoignage' : 'Leave a Testimonial'; ?>
        </a>
        <?php else: ?>
        <a href="signin.php" class="inline-flex items-center gap-2 bg-white text-pastel-blue font-semibold px-8 py-4 rounded-full hover:shadow-lg transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-sign-in-alt"></i>
            <?php echo $_SESSION['lang'] === 'fr' ? 'Connectez-vous pour témoigner' : 'Sign in to leave a testimonial'; ?>
        </a>
        <?php endif; ?>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 pb-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
        $rows = [];
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT parent_name, content, created_at FROM testimonials WHERE status = 'approved' ORDER BY created_at DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (isset($conn)) {
            $res = $conn->query("SELECT parent_name, content, created_at FROM testimonials WHERE status = 'approved' ORDER BY created_at DESC");
            if ($res) while ($r = $res->fetch_assoc()) $rows[] = $r;
        }

        if (empty($rows)) {
            echo '<div class="col-span-2 text-center py-12">';
            echo '<i class="fas fa-comments text-6xl text-gray-300 mb-4"></i>';
            echo '<p class="text-gray-500 text-lg">' . ($_SESSION['lang'] === 'fr' ? 
                'Aucun témoignage pour le moment. Soyez le premier à partager votre expérience !' : 
                'No testimonials yet. Be the first to share your experience!') . '</p>';
            echo '</div>';
        } else {
            foreach ($rows as $i => $t) {
                $colors = ['pastel-blue', 'pastel-pink', 'pastel-mint', 'pastel-lavender'];
                $color = $colors[$i % 4];
                echo '<div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300 border-l-4 border-' . $color . '">';
                echo '<div class="flex items-center mb-4">';
                echo '<div class="w-12 h-12 rounded-full bg-gradient-to-br from-' . $color . ' to-pastel-mint flex items-center justify-center text-white font-bold text-xl">';
                echo strtoupper(substr($t['parent_name'], 0, 1));
                echo '</div>';
                echo '<div class="ml-4">';
                echo '<p class="font-bold text-gray-800">' . htmlspecialchars($t['parent_name']) . '</p>';
                echo '<p class="text-sm text-gray-500">' . date('F j, Y', strtotime($t['created_at'])) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="flex mb-2">';
                for ($s = 0; $s < 5; $s++) {
                    echo '<i class="fas fa-star text-yellow-400"></i>';
                }
                echo '</div>';
                echo '<p class="text-gray-700 italic leading-relaxed">"' . htmlspecialchars($t['content']) . '"</p>';
                echo '</div>';
            }
        }
        ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
