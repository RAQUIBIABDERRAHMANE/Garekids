<?php 
// SEO Meta Data for Contact Page
$page_title = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr' 
    ? 'Contact - Nous Joindre'
    : 'Contact Us - Get in Touch';
$page_description = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'Contactez TakeCare pour vos besoins de garde d\'enfants. Téléphone, WhatsApp, email. Réponse rapide garantie. Devis gratuit.'
    : 'Contact TakeCare for your childcare needs. Phone, WhatsApp, email. Quick response guaranteed. Free quote.';
$page_keywords = isset($_SESSION['lang']) && $_SESSION['lang'] === 'fr'
    ? 'contact garde enfants, téléphone nounou, email crèche, devis babysitting'
    : 'contact childcare, nanny phone, daycare email, babysitting quote';

require_once __DIR__ . '/includes/header.php'; 
?>
<!-- $msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
        $to = 'hello@example.com';
        $subject = "Contact from $name";
        $body = "Name: $name\nEmail: $email\n\n$message";
        // mail() may not be configured; check return value.
        if (@mail($to, $subject, $body, "From: $email")) {
            $msg = 'Message sent — thank you!';
        } else {
            $msg = 'Unable to send email on this server. Please call or WhatsApp.';
        }
    } else {
        $msg = 'Please complete all fields with a valid email.';
    }
}
?> -->

<section class="bg-white rounded p-6 shadow">
  <h2 class="text-2xl font-bold">Contact</h2>
  <p class="mt-2">Call or WhatsApp for fastest response.</p>
  <div class="mt-4 flex gap-3">
    <a href="tel:+212653788298" class="px-4 py-2 bg-amber-400 text-white rounded">Call: +212 653-788298</a>
    <a href="https://wa.me/212653788298" target="_blank" class="px-4 py-2 border rounded">WhatsApp</a>
  </div>

  <div class="mt-6">
    <?php if ($msg): ?><div class="p-3 bg-amber-100 rounded"><?=htmlspecialchars($msg)?></div><?php endif; ?>
    <form method="post" class="mt-4 grid gap-3 max-w-xl">
      <input name="name" placeholder="Your name" class="p-2 border rounded" required>
      <input name="email" type="email" placeholder="Your email" class="p-2 border rounded" required>
      <textarea name="message" rows="4" placeholder="Message" class="p-2 border rounded" required></textarea>
      <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded">Send</button>
    </form>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
