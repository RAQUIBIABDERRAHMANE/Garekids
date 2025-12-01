// Enhanced JS for mobile nav, FAQ accordion, and animations
document.addEventListener('DOMContentLoaded', function () {
  // Mobile navigation toggle
  var navToggle = document.getElementById('nav-toggle');
  var mobileNav = document.getElementById('mobile-nav');
  if (navToggle && mobileNav) {
    navToggle.addEventListener('click', function () {
      mobileNav.classList.toggle('hidden');
      const icon = navToggle.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
      }
    });
  }

  // FAQ accordion with animation
  document.querySelectorAll('.faq-item').forEach(function (item) {
    item.addEventListener('click', function () {
      const content = item.nextElementSibling;
      const icon = item.querySelector('.fa-chevron-down');
      
      if (content) {
        // Close all other items
        document.querySelectorAll('.faq-item').forEach(function (otherItem) {
          if (otherItem !== item) {
            const otherContent = otherItem.nextElementSibling;
            const otherIcon = otherItem.querySelector('.fa-chevron-down');
            if (otherContent) {
              otherContent.classList.add('hidden');
            }
            if (otherIcon) {
              otherIcon.style.transform = 'rotate(0deg)';
            }
          }
        });
        
        // Toggle current item
        content.classList.toggle('hidden');
        if (icon) {
          if (content.classList.contains('hidden')) {
            icon.style.transform = 'rotate(0deg)';
          } else {
            icon.style.transform = 'rotate(180deg)';
          }
        }
      }
    });
  });

  // Add fade-in animation to elements as they come into view
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fade-in-up');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observe cards and sections
  document.querySelectorAll('.card, section').forEach(el => {
    if (!el.classList.contains('animate-fade-in-up')) {
      observer.observe(el);
    }
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Form validation enhancement
  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      const inputs = form.querySelectorAll('input[required], textarea[required]');
      let valid = true;
      
      inputs.forEach(input => {
        if (!input.value.trim()) {
          valid = false;
          input.classList.add('border-red-500');
        } else {
          input.classList.remove('border-red-500');
        }
      });
      
      if (!valid) {
        e.preventDefault();
        alert(document.documentElement.lang === 'fr' ? 'Veuillez remplir tous les champs requis.' : 'Please fill in all required fields.');
      }
    });
  });
});
