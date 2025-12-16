/**
 * Navigation Component Manager
 * Gestisce la navigation bar riutilizzabile e il dropdown delle lingue
 */

class NavigationManager {
    constructor() {
        this.currentLanguage = localStorage.getItem('language') || 'en';
        this.languages = {
            en: 'English',
            it: 'Italiano',
            de: 'Deutsch',
            fr: 'Français',
            es: 'Español'
        };
        this.init();
    }

    init() {
        this.loadNavigation();
        this.setupLanguageDropdown();
        this.setupMobileMenu();
        this.highlightActiveLink();
    }

    /**
     * Carica il componente navigation
     */
    async loadNavigation() {
        const navContainer = document.getElementById('navigation-container');
        if (!navContainer) return;

        try {
            const response = await fetch('components/navigation.html');
            if (!response.ok) {
                console.error('Failed to load navigation component');
                return;
            }
            const html = await response.text();
            navContainer.innerHTML = html;
            
            // Piccolo delay per assicurarsi che il DOM sia aggiornato
            setTimeout(() => {
                this.setupLanguageDropdown();
                this.setupMobileMenu();
                this.highlightActiveLink();
            }, 10);
        } catch (error) {
            console.error('Error loading navigation:', error);
        }
    }

    /**
     * Setup del dropdown delle lingue
     */
    setupLanguageDropdown() {
        const languageButton = document.getElementById('language-button');
        const languageMenu = document.getElementById('language-menu');
        const currentLanguageSpan = document.getElementById('current-language');
        const languageOptions = document.querySelectorAll('.language-option');

        if (!languageButton || !languageMenu) return;

        // Imposta la lingua corrente
        if (currentLanguageSpan) {
            currentLanguageSpan.textContent = this.languages[this.currentLanguage];
        }

        // Mostra il checkmark sulla lingua corrente
        languageOptions.forEach(option => {
            const lang = option.dataset.lang;
            const checkmark = option.querySelector('svg');
            if (lang === this.currentLanguage && checkmark) {
                checkmark.classList.remove('hidden');
                option.classList.remove('text-gray-300');
                option.classList.add('text-white');
            }
        });

        // Toggle dropdown
        languageButton.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = languageMenu.classList.contains('hidden');
            languageMenu.classList.toggle('hidden');
        });

        // Chiudi dropdown quando si clicca fuori
        document.addEventListener('click', (e) => {
            if (!languageButton.contains(e.target) && !languageMenu.contains(e.target)) {
                languageMenu.classList.add('hidden');
            }
        });

        // Gestione selezione lingua
        languageOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                const lang = option.dataset.lang;
                this.setLanguage(lang);
                languageMenu.classList.add('hidden');
            });
        });
    }

    /**
     * Imposta la lingua selezionata
     */
    setLanguage(lang) {
        this.currentLanguage = lang;
        localStorage.setItem('language', lang);
        
        const currentLanguageSpan = document.getElementById('current-language');
        if (currentLanguageSpan) {
            currentLanguageSpan.textContent = this.languages[lang];
        }

        // Aggiorna i checkmark
        document.querySelectorAll('.language-option').forEach(option => {
            const optionLang = option.dataset.lang;
            const checkmark = option.querySelector('svg');
            
            if (optionLang === lang) {
                checkmark?.classList.remove('hidden');
                option.classList.remove('text-gray-300');
                option.classList.add('text-white');
            } else {
                checkmark?.classList.add('hidden');
                option.classList.remove('text-white');
                option.classList.add('text-gray-300');
            }
        });

        // Qui puoi aggiungere la logica per cambiare la lingua della pagina
        console.log('Language changed to:', lang);
    }

    /**
     * Setup del mobile menu
     */
    setupMobileMenu() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (!mobileMenuButton || !mobileMenu) return;

        mobileMenuButton.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            mobileMenuButton.setAttribute('aria-expanded', !isHidden);
        });
    }

    /**
     * Evidenzia il link attivo nella navigation
     */
    highlightActiveLink() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('[data-nav-link]');

        navLinks.forEach(link => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            if (currentPath === linkPath || (currentPath.endsWith('/') && linkPath.endsWith('index.html'))) {
                link.classList.remove('text-gray-300');
                link.classList.add('text-white', 'font-medium');
            }
        });
    }
}

// Inizializza quando il DOM è pronto
document.addEventListener('DOMContentLoaded', () => {
    window.navigationManager = new NavigationManager();
});

