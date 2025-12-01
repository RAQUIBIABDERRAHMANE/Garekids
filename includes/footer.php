  </main>

  <footer class="mt-16" style="background: linear-gradient(135deg, rgba(108, 117, 125, 0.95), rgba(90, 98, 104, 0.95)) !important; color: white !important; border-top: 3px solid rgba(168, 216, 234, 0.3);">
    <div class="max-w-7xl mx-auto p-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- About section -->
        <div>
          <h3 class="text-xl font-bold mb-4 flex items-center gap-2" style="color: white !important;">
            <i class="fas fa-heart" style="color: #FFB6C1;"></i>
            TakeCare Childcare
          </h3>
          <p class="text-sm leading-relaxed" style="color: #E8F4F8 !important;">
            <?php echo $lang['footer_about'] ?? 'Providing safe, fun, and loving childcare services for families. Creating a nurturing environment where children can learn, play, and grow.'; ?>
          </p>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-xl font-bold mb-4" style="color: white !important;"><?php echo $lang['quick_links'] ?? 'Quick Links'; ?></h3>
          <ul class="space-y-2">
            <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>about.php" class="flex items-center gap-2 transition-all hover:translate-x-2" style="color: #A8D8EA !important;"><i class="fas fa-chevron-right text-xs"></i><?php echo $lang['about'] ?? 'About'; ?></a></li>
            <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>services.php" class="flex items-center gap-2 transition-all hover:translate-x-2" style="color: #A8D8EA !important;"><i class="fas fa-chevron-right text-xs"></i><?php echo $lang['services'] ?? 'Services'; ?></a></li>
            <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>gallery.php" class="flex items-center gap-2 transition-all hover:translate-x-2" style="color: #A8D8EA !important;"><i class="fas fa-chevron-right text-xs"></i><?php echo $lang['gallery'] ?? 'Gallery'; ?></a></li>
            <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>testimonials.php" class="flex items-center gap-2 transition-all hover:translate-x-2" style="color: #A8D8EA !important;"><i class="fas fa-chevron-right text-xs"></i><?php echo $lang['testimonials'] ?? 'Testimonials'; ?></a></li>
            <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>faq.php" class="flex items-center gap-2 transition-all hover:translate-x-2" style="color: #A8D8EA !important;"><i class="fas fa-chevron-right text-xs"></i><?php echo $lang['faq'] ?? 'FAQ'; ?></a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-xl font-bold mb-4" style="color: white !important;"><?php echo $lang['contact_us'] ?? 'Contact Us'; ?></h3>
          <div class="space-y-3">
            <a href="tel:+1234567890" class="flex items-center gap-3 p-3 rounded-xl transition-all group" style="background: rgba(168, 216, 234, 0.15); color: white !important; border: 1px solid rgba(168, 216, 234, 0.2);" onmouseover="this.style.background='rgba(168, 216, 234, 0.25)'" onmouseout="this.style.background='rgba(168, 216, 234, 0.15)'">
              <i class="fas fa-phone text-2xl group-hover:scale-110 transition-transform" style="color: #A8D8EA;"></i>
              <div>
                <div class="text-xs" style="color: #E8F4F8 !important;"><?php echo $lang['call_us'] ?? 'Call Us'; ?></div>
                <div class="font-semibold" style="color: white !important;">+1 234 567 890</div>
              </div>
            </a>
            <a href="https://wa.me/1234567890" target="_blank" class="flex items-center gap-3 p-3 rounded-xl transition-all group" style="background: rgba(181, 234, 215, 0.15); color: white !important; border: 1px solid rgba(181, 234, 215, 0.2);" onmouseover="this.style.background='rgba(181, 234, 215, 0.25)'" onmouseout="this.style.background='rgba(181, 234, 215, 0.15)'">
              <i class="fab fa-whatsapp text-2xl group-hover:scale-110 transition-transform" style="color: #B5EAD7;"></i>
              <div>
                <div class="text-xs" style="color: #E8F4F8 !important;">WhatsApp</div>
                <div class="font-semibold" style="color: white !important;"><?php echo $lang['chat_now'] ?? 'Chat Now'; ?></div>
              </div>
            </a>
            <a href="mailto:hello@takecare.com" class="flex items-center gap-3 p-3 rounded-xl transition-all group" style="background: rgba(255, 182, 193, 0.15); color: white !important; border: 1px solid rgba(255, 182, 193, 0.2);" onmouseover="this.style.background='rgba(255, 182, 193, 0.25)'" onmouseout="this.style.background='rgba(255, 182, 193, 0.15)'">
              <i class="fas fa-envelope text-2xl group-hover:scale-110 transition-transform" style="color: #FFB6C1;"></i>
              <div>
                <div class="text-xs" style="color: #E8F4F8 !important;"><?php echo $lang['email_us'] ?? 'Email Us'; ?></div>
                <div class="font-semibold text-sm" style="color: white !important;">hello@takecare.com</div>
              </div>
            </a>
          </div>
        </div>
      </div>

      <!-- Social Media & Copyright -->
      <div class="mt-8 pt-6 flex flex-col md:flex-row justify-between items-center gap-4" style="border-top: 2px solid rgba(168, 216, 234, 0.2);">
        <div class="text-sm" style="color: #E8F4F8 !important;">
          &copy; <?php echo date('Y'); ?> TakeCare Childcare. <?php echo $lang['all_rights_reserved'] ?? 'All rights reserved'; ?>.
        </div>
        <div class="flex gap-4">
          <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110" style="background: linear-gradient(135deg, #A8D8EA, #89CFF0); color: white !important; box-shadow: 0 4px 10px rgba(168, 216, 234, 0.3);" onmouseover="this.style.transform='scale(1.15) rotate(10deg)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110" style="background: linear-gradient(135deg, #FFB6C1, #FFC0CB); color: white !important; box-shadow: 0 4px 10px rgba(255, 182, 193, 0.3);" onmouseover="this.style.transform='scale(1.15) rotate(10deg)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110" style="background: linear-gradient(135deg, #B5EAD7, #7DCEA0); color: white !important; box-shadow: 0 4px 10px rgba(181, 234, 215, 0.3);" onmouseover="this.style.transform='scale(1.15) rotate(10deg)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110" style="background: linear-gradient(135deg, #C7CEEA, #BB8FCE); color: white !important; box-shadow: 0 4px 10px rgba(199, 206, 234, 0.3);" onmouseover="this.style.transform='scale(1.15) rotate(10deg)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Chatbot CSS & JS -->
  <link rel="stylesheet" href="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>assets/css/chatbot.css?v=<?php echo time(); ?>">
  <script src="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>assets/js/chatbot.js?v=<?php echo time(); ?>"></script>
  <script src="<?php echo (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>assets/js/main.js"></script>
</body>
</html>
