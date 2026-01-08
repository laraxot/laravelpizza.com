{{--
/**
 * Login Page AGID-Compliant - Tema Sixteen
 * 
 * Pagina di login completamente conforme alle linee guida AGID
 * e agli standard di accessibilità WCAG 2.1 AA.
 * 
 * Caratteristiche:
 * - Layout AGID-compliant nativo
 * - Header istituzionale con branding
 * - Breadcrumb navigation obbligatorio
 * - Skip links per accessibilità
 * - Footer con link PA obbligatori
 * - Font Titillium Web (standard AGID)
 * - Palette colori Bootstrap Italia
 * - Focus management avanzato
 * - Responsive design mobile-first
 * - Componente Livewire integrato
 * 
 * @version 3.0
 * @date 2025-08-01
 * @compliance AGID, WCAG 2.1 AA, Bootstrap Italia
 */
--}}

<x-layouts.guest>
    {{-- Skip Links per Accessibilità WCAG 2.1 AA --}}
    <div class="sr-only">
        <a href="#main-content" class="skip-link focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-blue-600 focus:text-white focus:rounded focus:shadow-lg">
            Salta al contenuto principale
        </a>
        <a href="#login-form" class="skip-link focus:not-sr-only focus:absolute focus:top-4 focus:left-20 focus:z-50 focus:px-4 focus:py-2 focus:bg-blue-600 focus:text-white focus:rounded focus:shadow-lg">
            Vai al modulo di accesso
        </a>
    </div>

    {{-- Header Istituzionale AGID --}}
    <header role="banner" class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <x-pub_theme::ui.logo class="h-10 w-auto text-white flex-shrink-0" />
                    <x-pub_theme::ui.logo class="h-10 w-auto text-white flex-shrink-0" />
                    <div class="flex flex-col">
                        <h1 class="text-lg font-bold leading-tight">
                            {{ config('app.institution_name', 'Ente di appartenenza') }}
                        </h1>
                        <p class="text-sm text-blue-100 leading-tight">
                            {{ config('app.institution_tagline', 'Servizi digitali per i cittadini') }}
                        </p>
                    </div>
                </div>
                @if(config('app.institution_url'))
                    <a href="{{ config('app.institution_url') }}" 
                       class="text-blue-100 hover:text-white text-sm underline focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 rounded"
                       target="_blank" 
                       rel="noopener noreferrer">
                        Sito istituzionale
                    </a>
                @endif
            </div>
        </div>
    </header>

    {{-- Breadcrumb Navigation AGID --}}
    <nav class="bg-gray-50 border-b border-gray-200" aria-label="Percorso di navigazione">
        <div class="container mx-auto px-4 py-3">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" 
                       class="text-blue-600 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 rounded">
                        Home
                    </a>
                </li>
                <li class="text-gray-500" aria-hidden="true">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li class="text-gray-900 font-medium" aria-current="page">
                    Accesso
                </li>
            </ol>
        </div>
    </nav>

    {{-- Main Content Area --}}
    <main id="main-content" role="main" class="flex-1 bg-gray-50 py-8 sm:py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                
                {{-- Login Card AGID-Compliant --}}
                <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                    
                    {{-- Card Header con Colori AGID --}}
                    <div class="bg-blue-600 text-white px-8 py-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold mb-3">
                                Accedi ai servizi
                            </h2>
                            <p class="text-blue-100 text-base leading-relaxed max-w-lg mx-auto">
                                Utilizza le tue credenziali per accedere all'area riservata e gestire i tuoi servizi digitali
                            </p>
                        </div>
                    </div>
                    
                    {{-- Card Body con Form --}}
                    <div id="login-form" class="px-8 py-12">
                        {{-- Session Status --}}
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        
                        {{-- Livewire Login Component (OBBLIGATORIO - NON MODIFICARE) --}}
                        @livewire(\Modules\User\Http\Livewire\Auth\Login::class)
                    </div>
                    
                    {{-- Card Footer con Info Assistenza --}}
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                        <div class="text-center text-sm text-gray-600">
                            <p class="mb-3 font-semibold text-base">
                                Problemi di accesso?
                            </p>
                            <p class="mb-4">
                                Contatta l'assistenza tecnica al numero 
                                <a href="tel:{{ config('app.support_phone', '+390123456789') }}" 
                                   class="text-blue-600 hover:text-blue-800 font-semibold underline focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 rounded text-lg">
                                    {{ config('app.support_phone_display', '01 2345 6789') }}
                                </a>
                            </p>
                            <p class="text-sm text-gray-500">
                                Orari: Lunedì-Venerdì 9:00-17:00
                            </p>
                        </div>
                    </div>
                </div>
                
                {{-- Info Accessibilità AGID --}}
                <div class="mt-6 text-center text-sm text-gray-600 space-y-3">
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <p class="mb-2 font-semibold text-gray-800">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Accessibilità
                            </span>
                        </p>
                        <p class="text-xs text-gray-600 mb-3">
                            Questo servizio è conforme alle linee guida WCAG 2.1 AA e alle normative AGID per l'accessibilità dei servizi digitali della Pubblica Amministrazione.
                        </p>
                        <div class="flex flex-col sm:flex-row sm:justify-center sm:space-x-4 space-y-2 sm:space-y-0">
                            <a href="{{ route('pages.view', ['slug' => 'accessibility']) }}" 
                               class="text-blue-600 hover:text-blue-800 underline focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 rounded">
                                Dichiarazione di accessibilità
                            </a>
                            <a href="{{ route('pages.view', ['slug' => 'help']) }}" 
                               class="text-blue-600 hover:text-blue-800 underline focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 rounded">
                                Guida all'uso
                            </a>
                        </div>
                    </div>
                    
                    {{-- Navigazione da Tastiera --}}
                    <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                        <p class="text-xs text-blue-800 font-medium mb-1">
                            💡 Navigazione da tastiera
                        </p>
                        <p class="text-xs text-blue-700">
                            Usa <kbd class="px-1 py-0.5 bg-blue-200 rounded text-xs">Tab</kbd> per navigare tra i campi, 
                            <kbd class="px-1 py-0.5 bg-blue-200 rounded text-xs">Invio</kbd> per inviare il modulo, 
                            <kbd class="px-1 py-0.5 bg-blue-200 rounded text-xs">Esc</kbd> per chiudere i messaggi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer Istituzionale AGID --}}
    <footer role="contentinfo" class="bg-gray-900 text-white mt-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Colonna 1: Informazioni Ente --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">
                        {{ config('app.institution_name', 'Ente di appartenenza') }}
                    </h3>
                    <div class="space-y-2 text-sm text-gray-300">
                        @if(config('app.institution_address'))
                            <p>{{ config('app.institution_address') }}</p>
                        @endif
                        @if(config('app.institution_city'))
                            <p>{{ config('app.institution_city') }}</p>
                        @endif
                        @if(config('app.institution_email'))
                            <p>
                                Email: 
                                <a href="mailto:{{ config('app.institution_email') }}" 
                                   class="text-blue-300 hover:text-blue-100 underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
                                    {{ config('app.institution_email') }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
                
                {{-- Colonna 2: Link Obbligatori PA --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Servizi</h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="{{ route('pages.view', ['slug' => 'privacy']) }}" 
                               class="text-gray-300 hover:text-white underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pages.view', ['slug' => 'legal-notes']) }}" 
                               class="text-gray-300 hover:text-white underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
                                Note Legali
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pages.view', ['slug' => 'accessibility']) }}" 
                               class="text-gray-300 hover:text-white underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
                                Dichiarazione di Accessibilità
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pages.view', ['slug' => 'contacts']) }}" 
                               class="text-gray-300 hover:text-white underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded">
                                Contatti
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Colonna 3: Link Istituzionali --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Riferimenti</h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="https://www.agid.gov.it/" 
                               class="text-gray-300 hover:text-white underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded"
                               target="_blank" 
                               rel="noopener noreferrer">
                                AGID - Agenzia per l'Italia Digitale
                            </a>
                        </li>
                        <li>
                            <a href="https://designers.italia.it/" 
                               class="text-gray-300 hover:text-white underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded"
                               target="_blank" 
                               rel="noopener noreferrer">
                                Designers Italia
                            </a>
                        </li>
                        <li>
                            <a href="https://www.gov.it/" 
                               class="text-gray-300 hover:text-white underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded"
                               target="_blank" 
                               rel="noopener noreferrer">
                                Governo Italiano
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- Copyright e Info Legali --}}
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                <p class="mb-2">
                    © {{ date('Y') }} {{ config('app.institution_name', 'Ente di appartenenza') }}. 
                    Tutti i diritti riservati.
                </p>
                <p class="text-xs">
                    Sito conforme alle 
                    <a href="https://docs.italia.it/italia/designers-italia/design-linee-guida-docs/" 
                       class="text-blue-300 hover:text-blue-100 underline focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-gray-900 rounded"
                       target="_blank" 
                       rel="noopener noreferrer">
                        Linee Guida di Design per i Servizi Digitali della PA
                    </a>
                </p>
            </div>
        </div>
    </footer>

    {{-- JavaScript per Focus Management e Accessibilità --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Focus management per skip links
            const skipLinks = document.querySelectorAll('.skip-link');
            skipLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.focus();
                        targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Gestione ESC per chiudere messaggi di errore/successo
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const alerts = document.querySelectorAll('[role="alert"], .alert');
                    alerts.forEach(alert => {
                        if (alert.style.display !== 'none') {
                            alert.style.display = 'none';
                        }
                    });
                }
            });

            // Miglioramento focus visivo per elementi interattivi
            const interactiveElements = document.querySelectorAll('a, button, input, select, textarea');
            interactiveElements.forEach(element => {
                element.addEventListener('focus', function() {
                    this.classList.add('focus-visible');
                });
                element.addEventListener('blur', function() {
                    this.classList.remove('focus-visible');
                });
            });
        });
    </script>

    {{-- CSS Aggiuntivo per Accessibilità --}}
    <style>
        /* Skip links migliorati */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #0066cc;
            color: white;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
            transition: top 0.3s;
        }
        
        .skip-link:focus {
            top: 6px;
        }

        /* Focus visivo migliorato */
        .focus-visible {
            outline: 2px solid #0066cc !important;
            outline-offset: 2px !important;
        }

        /* Stili per elementi kbd */
        kbd {
            font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Miglioramento contrasto per accessibilità */
        @media (prefers-contrast: high) {
            .text-gray-600 { color: #374151 !important; }
            .text-gray-500 { color: #4b5563 !important; }
            .text-blue-100 { color: #dbeafe !important; }
        }

        /* Supporto per riduzione movimento */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</x-layouts.guest>
