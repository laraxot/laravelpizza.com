# GDPR Compliance - Meetup Theme

## Overview

Questo documento definisce i requisiti GDPR (General Data Protection Regulation - Regolamento UE 2016/679) per il tema Meetup di LaravelPizza.com, implementato secondo D.Lgs. 101/2018 e le best practices AGID per il frontend.

## Frontend GDPR Requirements

### 1. Cookie Banner (Provvedimento 229/2014 Garante Privacy)

#### Requisiti Minimi

Il banner cookie deve essere implementato secondo le seguenti specifiche:

**Posizione e Layout:**
- Posizionato in alto o in basso alla pagina (full width)
- Non deve coprire più del 25% dello schermo su mobile
- Z-index elevato per essere sempre visibile
- Colore di sfondo contrastante (es. #0f2b46)
- Testo bianco con contrasto minimo 4.5:1 (WCAG 2.1 AA)

**Contenuto:**
- Testo breve e chiaro sul tipo di cookie utilizzati
- Link alla cookie policy completa
- Pulsanti chiaramente distinguibili:
  - "Accetta tutto" (Verde/Primary)
  - "Rifiuta tutto" (Rosso/Warning)
  - "Gestisci preferenze" (Secondario)

**Implementazione Blade:**
```blade
{{-- Cookie Banner - GDPR Compliant --}}
@if(!isset($_COOKIE['cookie_consent']))
    <div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-[#0f2b46] text-white p-4 shadow-2xl z-50" role="dialog" aria-labelledby="cookie-title">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex-1">
                <h2 id="cookie-title" class="text-lg font-semibold mb-2">
                    {{ __('pub_theme::gdpr.cookie_banner_title') }}
                </h2>
                <p class="text-sm text-gray-200">
                    {{ __('pub_theme::gdpr.cookie_banner_text') }}
                    <a href="{{ route('cookie-policy') }}" class="text-cyan-400 hover:text-cyan-300 underline" target="_blank" rel="noopener noreferrer">
                        {{ __('pub_theme::gdpr.cookie_policy_link') }}
                    </a>
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <button id="accept-all-cookies" class="px-6 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-white font-medium transition-colors">
                    {{ __('pub_theme::gdpr.accept_all') }}
                </button>
                <button id="reject-all-cookies" class="px-6 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white font-medium transition-colors">
                    {{ __('pub_theme::gdpr.reject_all') }}
                </button>
                <button id="manage-cookies" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg text-white font-medium transition-colors">
                    {{ __('pub_theme::gdpr.manage_preferences') }}
                </button>
            </div>
        </div>
    </div>
@endif

{{-- Cookie Management Modal --}}
<div id="cookie-modal" class="fixed inset-0 bg-black/50 z-50 hidden" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('pub_theme::gdpr.cookie_preferences_title') }}
                    </h2>
                    <button id="close-cookie-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Cookie Technical --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('pub_theme::gdpr.technical_cookies') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('pub_theme::gdpr.technical_cookies_description') }}
                            </p>
                        </div>
                        <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" id="technical-cookies" checked disabled class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-not-allowed">
                            <label for="technical-cookies" class="toggle-label block overflow-hidden h-6 rounded-full bg-green-400 cursor-not-allowed"></label>
                        </div>
                    </div>
                </div>

                {{-- Cookie Analytics --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('pub_theme::gdpr.analytics_cookies') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('pub_theme::gdpr.analytics_cookies_description') }}
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="analytics-cookies" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cyan-300 dark:peer-focus:ring-cyan-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-cyan-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Cookie Marketing --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('pub_theme::gdpr.marketing_cookies') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('pub_theme::gdpr.marketing_cookies_description') }}
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="marketing-cookies" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cyan-300 dark:peer-focus:ring-cyan-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-cyan-600"></div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <button id="save-cookie-preferences" class="px-6 py-2 bg-[#0f2b46] hover:bg-[#1a3f5e] rounded-lg text-white font-medium transition-colors">
                        {{ __('pub_theme::gdpr.save_preferences') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookie-banner');
    const cookieModal = document.getElementById('cookie-modal');
    const acceptAllBtn = document.getElementById('accept-all-cookies');
    const rejectAllBtn = document.getElementById('reject-all-cookies');
    const manageBtn = document.getElementById('manage-cookies');
    const closeBtn = document.getElementById('close-cookie-modal');
    const saveBtn = document.getElementById('save-cookie-preferences');
    const analyticsCheckbox = document.getElementById('analytics-cookies');
    const marketingCheckbox = document.getElementById('marketing-cookies');

    // Check if user has already made a choice
    const cookieConsent = getCookie('cookie_consent');
    if (cookieConsent) {
        if (cookieBanner) cookieBanner.style.display = 'none';
    }

    // Accept all cookies
    if (acceptAllBtn) {
        acceptAllBtn.addEventListener('click', function() {
            setCookie('cookie_consent', 'all', 365);
            setCookie('analytics_consent', 'true', 365);
            setCookie('marketing_consent', 'true', 365);
            if (cookieBanner) cookieBanner.style.display = 'none';
            initAnalytics();
            initMarketing();
        });
    }

    // Reject all cookies
    if (rejectAllBtn) {
        rejectAllBtn.addEventListener('click', function() {
            setCookie('cookie_consent', 'essential', 365);
            setCookie('analytics_consent', 'false', 365);
            setCookie('marketing_consent', 'false', 365);
            if (cookieBanner) cookieBanner.style.display = 'none';
        });
    }

    // Open cookie preferences modal
    if (manageBtn) {
        manageBtn.addEventListener('click', function() {
            if (cookieModal) cookieModal.classList.remove('hidden');
            // Load current preferences
            analyticsCheckbox.checked = getCookie('analytics_consent') === 'true';
            marketingCheckbox.checked = getCookie('marketing_consent') === 'true';
        });
    }

    // Close modal
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            if (cookieModal) cookieModal.classList.add('hidden');
        });
    }

    // Save preferences
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const analytics = analyticsCheckbox.checked ? 'true' : 'false';
            const marketing = marketingCheckbox.checked ? 'true' : 'false';
            
            setCookie('cookie_consent', 'custom', 365);
            setCookie('analytics_consent', analytics, 365);
            setCookie('marketing_consent', marketing, 365);
            
            if (cookieBanner) cookieBanner.style.display = 'none';
            if (cookieModal) cookieModal.classList.add('hidden');
            
            if (analytics === 'true') {
                initAnalytics();
            }
            if (marketing === 'true') {
                initMarketing();
            }
        });
    }

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Strict;Secure";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function initAnalytics() {
        // Initialize Google Analytics only if consent is given
        if (typeof gtag !== 'undefined') {
            gtag('consent', 'update', {
                'analytics_storage': 'granted'
            });
        }
    }

    function initMarketing() {
        // Initialize marketing cookies only if consent is given
        if (typeof gtag !== 'undefined') {
            gtag('consent', 'update', {
                'ad_storage': 'granted',
                'ad_user_data': 'granted',
                'ad_personalization': 'granted'
            });
        }
    }
});
</script>
@endpush
```

#### Requisiti di Accessibilità (WCAG 2.1 AA)

- **Contrasto**: Testo e sfondo devono avere un rapporto di contrasto di almeno 4.5:1
- **Focus**: Tutti gli elementi interattivi devono avere un indicatore di focus chiaro
- **Keyboard**: Tutti gli elementi devono essere accessibili da tastiera
- **ARIA**: Utilizzo corretto di attributi ARIA (role, aria-labelledby, aria-modal)
- **Screen Reader**: Testo alternativo per immagini e icone
- **Colori Non Solo**: Non usare solo i colori per trasmettere informazioni

### 2. Registrazione Utente - GDPR UI

#### Layout del Form

Il form di registrazione deve seguire questi principi UX/GDPR:

**Struttura:**
```blade
<x-layouts.app>
    <x-slot name="title">
        {{ __('Registrazione') }}
    </x-slot>

    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl">
            
            {{-- Registration Form --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                <div class="px-8 py-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('pub_theme::auth.register.title') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        {{ __('pub_theme::auth.register.subtitle') }}
                    </p>

                    @livewire(\Modules\User\Filament\Widgets\Auth\RegisterWidget::class)
                </div>
            </div>

            {{-- Login CTA --}}
            <div class="mt-8 text-center">
                <p class="text-gray-700 dark:text-gray-300 mb-4 font-medium">
                    {{ __('pub_theme::auth.register.already_have_account') }}
                </p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#0f2b46] hover:bg-[#1a3f5e] dark:bg-cyan-600 dark:hover:bg-cyan-700 shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                    {{ __('pub_theme::auth.register.login_button') }}
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"></path>
                    </svg>
                </a>
            </div>

        </div>
    </section>
</x-layouts.app>
```

#### Requisiti UI per Consensi

**Checkbox GDPR:**
- Grandezza minima: 24x24px (cliccabili facilmente)
- Spaziatura: 8px tra checkbox e testo
- Etichette chiare e descrittive
- Separazione visiva tra consensi
- Colori di contrasto per selezione

**Privacy Notice:**
- Posizionato prima dei consensi
- Testo breve con link completo
- Contrasto WCAG 2.1 AA
- Leggibile su tutti i dispositivi

**Esempio:**
```blade
<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
        {{ __('pub_theme::auth.gdpr.notice_title') }}
    </h3>
    <p class="text-sm text-blue-800 dark:text-blue-200">
        {{ __('pub_theme::auth.gdpr.notice_text') }}
        <a href="{{ route('privacy-policy') }}" 
           class="text-cyan-600 hover:text-cyan-700 underline font-medium"
           target="_blank" 
           rel="noopener noreferrer">
            {{ __('pub_theme::auth.gdpr.privacy_policy_link') }}
        </a>
        {{ __('pub_theme::auth.gdpr.notice_and') }}
        <a href="{{ route('terms-conditions') }}" 
           class="text-cyan-600 hover:text-cyan-700 underline font-medium"
           target="_blank" 
           rel="noopener noreferrer">
            {{ __('pub_theme::auth.gdpr.terms_link') }}
        </a>
    </p>
</div>
```

### 3. Privacy Policy Page

#### Layout della Privacy Policy

```blade
<x-layouts.app>
    <x-slot name="title">
        {{ __('Privacy Policy') }}
    </x-slot>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('pub_theme::privacy.title') }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                {{ __('pub_theme::privacy.last_updated') }}: {{ $last_updated ?? '2024-01-15' }}
            </p>

            {{-- Toc (Table of Contents) --}}
            <nav class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8" aria-label="Table of Contents">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('pub_theme::privacy.toc_title') }}
                </h2>
                <ul class="space-y-2">
                    <li><a href="#data-controller" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_controller') }}</a></li>
                    <li><a href="#data-processing" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_processing') }}</a></li>
                    <li><a href="#legal-basis" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_legal_basis') }}</a></li>
                    <li><a href="#data-categories" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_categories') }}</a></li>
                    <li><a href="#recipients" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_recipients') }}</a></li>
                    <li><a href="#retention" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_retention') }}</a></li>
                    <li><a href="#rights" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_rights') }}</a></li>
                    <li><a href="#complaint" class="text-cyan-600 hover:text-cyan-700">{{ __('pub_theme::privacy.toc_complaint') }}</a></li>
                </ul>
            </nav>

            {{-- Content Sections --}}
            @section('privacy_content')
                {{-- Content loaded from JSON --}}
            @show

            {{-- Contact Info --}}
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('pub_theme::privacy.contact_title') }}
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('pub_theme::privacy.privacy_title') }}
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Email: <a href="mailto:privacy@laravelpizza.com" class="text-cyan-600 hover:text-cyan-700">privacy@laravelpizza.com</a>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('pub_theme::privacy.dpo_title') }}
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Email: <a href="mailto:dpo@laravelpizza.com" class="text-cyan-600 hover:text-cyan-700">dpo@laravelpizza.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
```

### 4. Cookie Policy Page

#### Layout della Cookie Policy

```blade
<x-layouts.app>
    <x-slot name="title">
        {{ __('Cookie Policy') }}
    </x-slot>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('pub_theme::cookies.title') }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                {{ __('pub_theme::cookies.last_updated') }}: {{ $last_updated ?? '2024-01-15' }}
            </p>

            {{-- What are cookies --}}
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('pub_theme::cookies.what_are_title') }}
                </h2>
                <p class="text-gray-700 dark:text-gray-300">
                    {{ __('pub_theme::cookies.what_are_text') }}
                </p>
            </section>

            {{-- Cookie Types --}}
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('pub_theme::cookies.types_title') }}
                </h2>
                
                {{-- Technical Cookies --}}
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('pub_theme::cookies.technical_title') }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        {{ __('pub_theme::cookies.technical_text') }}
                    </p>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                <th class="text-left py-2 text-gray-900 dark:text-white">{{ __('pub_theme::cookies.name') }}</th>
                                <th class="text-left py-2 text-gray-900 dark:text-white">{{ __('pub_theme::cookies.purpose') }}</th>
                                <th class="text-left py-2 text-gray-900 dark:text-white">{{ __('pub_theme::cookies.duration') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                <td class="py-2 text-gray-700 dark:text-gray-300">laravel_session</td>
                                <td class="py-2 text-gray-700 dark:text-gray-300">{{ __('pub_theme::cookies.session_purpose') }}</td>
                                <td class="py-2 text-gray-700 dark:text-gray-300">2 hours</td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                <td class="py-2 text-gray-700 dark:text-gray-300">XSRF-TOKEN</td>
                                <td class="py-2 text-gray-700 dark:text-gray-300">{{ __('pub_theme::cookies.csrf_purpose') }}</td>
                                <td class="py-2 text-gray-700 dark:text-gray-300">Session</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Analytics Cookies --}}
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('pub_theme::cookies.analytics_title') }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        {{ __('pub_theme::cookies.analytics_text') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('pub_theme::cookies.analytics_consent_required') }}
                    </p>
                </div>

                {{-- Marketing Cookies --}}
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('pub_theme::cookies.marketing_title') }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        {{ __('pub_theme::cookies.marketing_text') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('pub_theme::cookies.marketing_consent_required') }}
                    </p>
                </div>
            </section>

            {{-- Managing Cookies --}}
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('pub_theme::cookies.manage_title') }}
                </h2>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    {{ __('pub_theme::cookies.manage_text') }}
                </p>
                <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
                    <li>{{ __('pub_theme::cookies.manage_browser') }}</li>
                    <li>{{ __('pub_theme::cookies.manage_banner') }}</li>
                    <li>{{ __('pub_theme::cookies.manage_withdrawal') }}</li>
                </ul>
            </section>

            {{-- Links --}}
            <section class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('pub_theme::cookies.links_title') }}
                </h2>
                <div class="space-y-2">
                    <a href="{{ route('privacy-policy') }}" class="text-cyan-600 hover:text-cyan-700 block">
                        {{ __('pub_theme::cookies.privacy_link') }}
                    </a>
                    <a href="{{ route('terms-conditions') }}" class="text-cyan-600 hover:text-cyan-700 block">
                        {{ __('pub_theme::cookies.terms_link') }}
                    </a>
                </div>
            </section>
        </div>
    </main>
</x-layouts.app>
```

### 5. Dashboard Privacy

Per permettere agli utenti di esercitare i diritti GDPR (Articoli 15-22), implementare una dashboard privacy:

```blade
<x-layouts.app>
    <x-slot name="title">
        {{ __('Privacy Dashboard') }}
    </x-slot>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                {{ __('pub_theme::privacy_dashboard.title') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                {{ __('pub_theme::privacy_dashboard.subtitle') }}
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Your Data --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white ml-3">
                        {{ __('pub_theme::privacy_dashboard.your_data') }}
                    </h2>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('pub_theme::privacy_dashboard.your_data_description') }}
                </p>
                <a href="{{ route('privacy.data-access') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    {{ __('pub_theme::privacy_dashboard.access_data') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            {{-- Consents --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white ml-3">
                        {{ __('pub_theme::privacy_dashboard.consents') }}
                    </h2>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('pub_theme::privacy_dashboard.consents_description') }}
                </p>
                <a href="{{ route('privacy.consents') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    {{ __('pub_theme::privacy_dashboard.manage_consents') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </a>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border-2 border-red-200 dark:border-red-800">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white ml-3">
                        {{ __('pub_theme::privacy_dashboard.delete_account') }}
                    </h2>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('pub_theme::privacy_dashboard.delete_account_description') }}
                </p>
                <a href="{{ route('privacy.delete-account') }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    {{ __('pub_theme::privacy_dashboard.delete_account_button') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </a>
            </div>
        </div>
    </main>
</x-layouts.app>
```

### 6. WCAG 2.1 AA Compliance

#### Contrasto dei Colori

Il tema Meetup deve rispettare i seguenti rapporti di contrasto:

| Elemento | Colore Sfondo | Colore Testo | Rapporto | WCAG 2.1 AA |
|----------|---------------|--------------|----------|-------------|
| Header | #0f2b46 | #ffffff | 15.3:1 | ✅ Passa |
| Footer | #0f2b46 | #f0f9ff | 12.8:1 | ✅ Passa |
| Links | - | #06b6d4 | - | ⚠️ 2.8:1 su bianco, 9.1:1 su scuro |
| Success | #22c55e | #ffffff | 4.5:1 | ✅ Passa |
| Warning | #eab308 | #ffffff | 2.5:1 | ❌ Non passa |
| Error | #ef4444 | #ffffff | 3.9:1 | ⚠️ 3:1 per testo grande |
| Info | #3b82f6 | #ffffff | 4.6:1 | ✅ Passa |

**Correzioni Necessarie:**
- Links su sfondo chiaro: usare #0891b2 (7.5:1)
- Warning: usare #ca8a04 su bianco (4.6:1)

#### Focus Indicators

Tutti gli elementi interattivi devono avere un indicatore di focus chiaro:

```css
/* WCAG 2.1 AA Focus Indicators */
*:focus-visible {
    outline: 3px solid #06b6d4;
    outline-offset: 2px;
    border-radius: 4px;
}

/* Per i link */
a:focus-visible {
    text-decoration: underline;
    text-decoration-thickness: 3px;
    text-underline-offset: 4px;
}

/* Per i bottoni */
button:focus-visible,
input:focus-visible,
textarea:focus-visible,
select:focus-visible {
    outline: 3px solid #06b6d4;
    outline-offset: 2px;
    box-shadow: 0 0 0 6px rgba(6, 182, 212, 0.3);
}
```

#### Keyboard Navigation

```javascript
// Keyboard navigation for cookie banner
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('cookie-modal');
        if (modal && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
            document.getElementById('manage-cookies').focus();
        }
    }
    
    // Tab navigation order
    if (e.key === 'Tab') {
        // Ensure proper tab order
        const focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
        const focusableContent = document.querySelectorAll(focusableElements);
        // Focus trap implementation for modal
    }
});
```

### 7. Privacy by Design

Il tema Meetup deve implementare Privacy by Design:

```blade
{{-- Pseudonimization in frontend --}}
<script>
// Pseudonimize IP address before sending to analytics
function pseudonymizeIP(ip) {
    if (!ip) return '';
    const parts = ip.split('.');
    if (parts.length === 4) {
        parts[3] = '0';
        return parts.join('.');
    }
    return ip;
}

// Send pseudonymized data to analytics
function trackPageView() {
    const analyticsData = {
        page: window.location.pathname,
        ip: pseudonymizeIP(getUserIP()),
        userAgent: window.navigator.userAgent,
        timestamp: Date.now()
    };
    // Send to analytics
}

// Get user IP (for pseudonymization)
async function getUserIP() {
    try {
        const response = await fetch('https://api.ipify.org?format=json');
        const data = await response.json();
        return data.ip;
    } catch (error) {
        return '';
    }
}
</script>
```

---

**Document Version**: 1.0.0  
**Responsible**: Meetup Theme Team  
**Approved by**: GDPR Compliance Team