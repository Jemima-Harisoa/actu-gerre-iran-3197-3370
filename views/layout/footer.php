<hr class="div" style="margin-top:40px;">

<!-- FOOTER -->
<footer>
  <div class="footer-main">
    <div class="footer-logo">Chronique de Guerre Iran</div>
    <div class="fcol">
      <h4>Chronique de Guerre Iran</h4>
      <a href="<?php echo BASE_URL !== '' ? BASE_URL : '/'; ?>"><svg data-feather="home"></svg>À la une</a>
      <a href="#"><svg data-feather="archive"></svg>Archives</a>
      <a href="#"><svg data-feather="mail"></svg>Newsletters</a>
      <a href="#"><svg data-feather="mic"></svg>Podcasts</a>
      <a href="#"><svg data-feather="file-text"></svg>Chronique de Guerre Iran en PDF</a>
    </div>
    <div class="fcol">
      <h4>International</h4>
      <a href="<?= BASE_URL ?>/categorie/international">Actualités Internationales</a>
      <a href="#">Amériques</a>
      <a href="#">Asie</a>
      <a href="#">Europe</a>
      <a href="#">Moyen-Orient</a>
    </div>
    <div class="fcol">
      <h4>Rubriques</h4>
      <a href="#">Politique</a>
      <a href="#">Économie</a>
      <a href="#">Société</a>
      <a href="#">Culture</a>
      <a href="#">Idées</a>
    </div>
    <div class="fcol">
      <h4>Services</h4>
      <a href="#"><svg data-feather="credit-card"></svg>Abonnements</a>
      <a href="#"><svg data-feather="gift"></svg>Offrir un abonnement</a>
      <a href="#"><svg data-feather="calendar"></svg>Événements</a>
      <a href="#"><svg data-feather="book-open"></svg>Formations</a>
      <a href="#"><svg data-feather="briefcase"></svg>Emploi</a>
    </div>
  </div>
  <div class="footer-bottom">          
    <span style="color:#2e2e2e;">© Chronique de Guerre Iran 2025</span>
    <div class="footer-bottom-links">
      <a href="#">Mentions légales</a>
      <a href="#">Confidentialité</a>
      <a href="#">CGU</a>
      <a href="#">Cookies</a>
      <a href="#">Contact</a>
    </div>
    <div class="footer-social">
      <a href="#" aria-label="Facebook"><svg data-feather="facebook"></svg></a>
      <a href="#" aria-label="Twitter"><svg data-feather="twitter"></svg></a>
      <a href="#" aria-label="Instagram"><svg data-feather="instagram"></svg></a>
    </div>
  </div>
</footer>

<script>
  function initFeatherIcons(triesLeft) {
    if (typeof feather !== 'undefined' && feather.replace) {
      feather.replace();
      return;
    }

    if (triesLeft <= 0) {
      var fallbackScript = document.createElement('script');
      fallbackScript.src = 'https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js';
      fallbackScript.onload = function () {
        if (typeof feather !== 'undefined' && feather.replace) {
          feather.replace();
        }
      };
      fallbackScript.onerror = function () {
        console.error('Feather icons library failed to load (local and CDN).');
      };
      document.head.appendChild(fallbackScript);
      return;
    }

    setTimeout(function () {
      initFeatherIcons(triesLeft - 1);
    }, 80);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      initFeatherIcons(10);
    });
  } else {
    initFeatherIcons(10);
  }
</script>
</body>
</html>
