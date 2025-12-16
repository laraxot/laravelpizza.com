// Bootstrap Italia + Alpine.js Application
import Alpine from 'alpinejs'
//import '@tailwindplus/elements';

//import "daisyui";

// Make Alpine available globally for debugging
window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    const dropdown = document.querySelector('.nav-item.dropdown');
    
    if (dropdown) {
        // Setup Alpine data
        dropdown.setAttribute('x-data', `{
            open: false,
            currentLang: 'ITA',
            toggle() { this.open = !this.open },
            select(lang) { 
                this.currentLang = lang; 
                this.open = false;
                this.$el.querySelector('.nav-link span:not(.visually-hidden)').textContent = lang;
            }
        }`);

        // Setup eventi
        dropdown.querySelector('.dropdown-toggle').setAttribute('x-on:click', 'toggle()');
        dropdown.querySelector('.dropdown-menu').setAttribute('x-show', 'open');
        
        // Setup click per le lingue
        dropdown.querySelectorAll('.dropdown-item').forEach((item, i) => {
            const lang = i === 0 ? 'ITA' : 'ENG';
            item.setAttribute('x-on:click.prevent', `select('${lang}')`);
        });
        
        // Chiudi quando clicchi fuori
        dropdown.setAttribute('x-on:click.outside', 'open = false');
    }
});

// Initialize Alpine first
Alpine.start()

// Bootstrap Italia Components Integration
document.addEventListener('DOMContentLoaded', function() {
  // Wait for Alpine to be fully ready
  setTimeout(() => {
    // Language dropdown handler
    const languageButton = document.getElementById('language-button');
    const languageMenu = document.getElementById('language-menu');

    if (languageButton && languageMenu) {
      languageButton.addEventListener('click', function() {
        const isExpanded = languageButton.getAttribute('aria-expanded') === 'true';

        if (isExpanded) {
          languageMenu.style.display = 'none';
          languageButton.setAttribute('aria-expanded', 'false');
        } else {
          languageMenu.style.display = 'block';
          languageButton.setAttribute('aria-expanded', 'true');
        }
      });

      // Close dropdown when clicking outside
      document.addEventListener('click', function(event) {
        if (!languageButton.contains(event.target) && !languageMenu.contains(event.target)) {
          languageMenu.style.display = 'none';
          languageButton.setAttribute('aria-expanded', 'false');
        }
      });
    }

    // Hamburger menu handler
    const hamburgerButton = document.querySelector('[data-bs-toggle="navbarcollapsible"]');
    const navCollapsible = document.querySelector('#nav4');
    const closeButton = document.querySelector('.close-menu');
    const overlay = document.querySelector('.overlay');

    if (hamburgerButton && navCollapsible) {
      hamburgerButton.addEventListener('click', function() {
        const isExpanded = hamburgerButton.getAttribute('aria-expanded') === 'true';

        if (isExpanded) {
          navCollapsible.classList.remove('expanded');
          hamburgerButton.setAttribute('aria-expanded', 'false');
          document.body.classList.remove('nav-open');
          if (overlay) overlay.style.display = 'none';
        } else {
          navCollapsible.classList.add('expanded');
          hamburgerButton.setAttribute('aria-expanded', 'true');
          document.body.classList.add('nav-open');
          if (overlay) overlay.style.display = 'block';
        }
      });
    }

    if (closeButton) {
      closeButton.addEventListener('click', function() {
        navCollapsible.classList.remove('expanded');
        hamburgerButton.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
        if (overlay) overlay.style.display = 'none';
      });
    }

    if (overlay) {
      overlay.addEventListener('click', function() {
        navCollapsible.classList.remove('expanded');
        hamburgerButton.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
        overlay.style.display = 'none';
      });
    }
  }, 100);
});