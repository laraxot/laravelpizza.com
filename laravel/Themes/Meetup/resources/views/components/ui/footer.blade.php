{{--
    AGID Compliant Footer Component
    
    Implementa le linee guida AGID per il footer di un sito PA
    - Struttura semantica
    - Link istituzionali obbligatori
    - Informazioni di contatto
    - Social media
    - Accessibilità completa
--}}

<footer class="it-footer" id="footer" role="contentinfo">
    <div class="it-footer-main">
        <div class="container">
            <div class="row">
                {{-- Logo e descrizione ente --}}
                <div class="col-12 col-md-6 col-lg-4 pb-2">
                    <div class="it-brand-wrapper">
                        <a href="{{ url('/') }}" aria-label="{{ config('app.name') }} - {{ __('Torna alla home') }}">
                            <svg class="icon" role="img" aria-labelledby="footer-logo-title">
                                <title id="footer-logo-title">{{ config('app.name') }}</title>
                                <use href="#it-pa"></use>
                            </svg>
                            <div class="it-brand-text">
                                <h2 class="no_toc">{{ config('app.name') }}</h2>
                            </div>
                        </a>
                    </div>
                    <p class="mt-3">
                        {{ __('Piattaforma per la gestione delle segnalazioni cittadine.') }}
                        {{ __('Miglioriamo insieme la nostra città.') }}
                    </p>
                </div>

                {{-- Link utili --}}
                <div class="col-12 col-md-6 col-lg-4 pb-2">
                    <h3 class="footer-heading-title">{{ __('Link Utili') }}</h3>
                    <nav aria-label="{{ __('Link utili del footer') }}">
                        <ul class="footer-list">
                            <li>
                                <a href="{{ url('/amministrazione-trasparente') }}" title="{{ __('Vai alla sezione Amministrazione Trasparente') }}">
                                    {{ __('Amministrazione Trasparente') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/privacy') }}" title="{{ __('Vai alla Privacy Policy') }}">
                                    {{ __('Privacy Policy') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/note-legali') }}" title="{{ __('Vai alle Note Legali') }}">
                                    {{ __('Note Legali') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/cookie-policy') }}" title="{{ __('Vai alla Cookie Policy') }}">
                                    {{ __('Cookie Policy') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/accessibilita') }}" title="{{ __('Vai alla Dichiarazione di Accessibilità') }}">
                                    {{ __('Dichiarazione di Accessibilità') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/sitemap') }}" title="{{ __('Vai alla Mappa del Sito') }}">
                                    {{ __('Mappa del Sito') }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                {{-- Contatti --}}
                <div class="col-12 col-md-6 col-lg-4 pb-2">
                    <h3 class="footer-heading-title">{{ __('Contatti') }}</h3>
                    <address>
                        <p>
                            <strong>{{ config('app.name') }}</strong><br>
                            Via Example, 123<br>
                            00100 Roma (RM)<br>
                            Italia
                        </p>
                        <p>
                            <strong>{{ __('Email') }}:</strong> 
                            <a href="mailto:info@fixcity.it" class="text-decoration-underline">info@fixcity.it</a><br>
                            <strong>{{ __('PEC') }}:</strong> 
                            <a href="mailto:pec@fixcity.it" class="text-decoration-underline">pec@fixcity.it</a><br>
                            <strong>{{ __('Telefono') }}:</strong> 
                            <a href="tel:+390612345678">+39 06 1234 5678</a>
                        </p>
                        <p>
                            <strong>{{ __('Codice Fiscale') }}:</strong> 12345678901<br>
                            <strong>{{ __('Partita IVA') }}:</strong> 12345678901
                        </p>
                    </address>
                </div>
            </div>

            {{-- Social media --}}
            <div class="row mt-4">
                <div class="col-12">
                    <h3 class="footer-heading-title">{{ __('Seguici su') }}</h3>
                    <ul class="list-inline text-start social" aria-label="{{ __('Link ai social media') }}">
                        <li class="list-inline-item">
                            <a href="https://www.facebook.com/fixcity" target="_blank" rel="noopener noreferrer" 
                               aria-label="{{ __('Facebook - si apre in una nuova finestra') }}" title="Facebook">
                                <svg class="icon icon-sm icon-white align-top">
                                    <use href="#it-facebook"></use>
                                </svg>
                                <span class="visually-hidden">Facebook</span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/fixcity" target="_blank" rel="noopener noreferrer"
                               aria-label="{{ __('Twitter - si apre in una nuova finestra') }}" title="Twitter">
                                <svg class="icon icon-sm icon-white align-top">
                                    <use href="#it-twitter"></use>
                                </svg>
                                <span class="visually-hidden">Twitter</span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.linkedin.com/company/fixcity" target="_blank" rel="noopener noreferrer"
                               aria-label="{{ __('LinkedIn - si apre in una nuova finestra') }}" title="LinkedIn">
                                <svg class="icon icon-sm icon-white align-top">
                                    <use href="#it-linkedin"></use>
                                </svg>
                                <span class="visually-hidden">LinkedIn</span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.instagram.com/fixcity" target="_blank" rel="noopener noreferrer"
                               aria-label="{{ __('Instagram - si apre in una nuova finestra') }}" title="Instagram">
                                <svg class="icon icon-sm icon-white align-top">
                                    <use href="#it-instagram"></use>
                                </svg>
                                <span class="visually-hidden">Instagram</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Small - Informazioni obbligatorie AGID --}}
    <div class="it-footer-small-prints">
        <div class="container">
            <ul class="it-footer-small-prints-list list-inline mb-0 d-flex flex-column flex-md-row" 
                aria-label="{{ __('Link del footer secondario') }}">
                <li class="list-inline-item">
                    <a href="{{ url('/privacy') }}" title="{{ __('Privacy Policy') }}">
                        {{ __('Privacy Policy') }}
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="{{ url('/note-legali') }}" title="{{ __('Note Legali') }}">
                        {{ __('Note Legali') }}
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="{{ url('/accessibilita') }}" title="{{ __('Dichiarazione di Accessibilità') }}">
                        {{ __('Accessibilità') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Back to top button --}}
    <a href="#" 
       aria-hidden="true" 
       data-attribute="back-to-top" 
       class="back-to-top shadow" 
       title="{{ __('Torna su') }}">
        <svg class="icon icon-light">
            <use href="#it-arrow-up"></use>
        </svg>
        <span class="visually-hidden">{{ __('Torna all\'inizio della pagina') }}</span>
    </a>
</footer>

{{-- Cookie consent banner (GDPR compliance) --}}
<div class="cookiebar hide" aria-label="{{ __('Banner cookie') }}" role="region">
    <p>
        {{ __('Questo sito utilizza cookie tecnici, analytics e di terze parti.') }}
        <br>
        {{ __('Proseguendo nella navigazione accetti l\'utilizzo dei cookie.') }}
    </p>
    <div class="cookiebar-buttons">
        <a href="{{ url('/cookie-policy') }}" class="cookiebar-btn" title="{{ __('Vai alla Cookie Policy') }}">
            {{ __('Maggiori informazioni') }}
            <span class="visually-hidden">{{ __('sui cookie') }}</span>
        </a>
        <button data-accept="cookiebar" class="cookiebar-btn cookiebar-confirm" 
                aria-label="{{ __('Accetta i cookie') }}">
            {{ __('Accetta') }}<span class="visually-hidden"> {{ __('i cookie') }}</span>
        </button>
    </div>
</div>

<script>
    // Initialize back-to-top button
    document.addEventListener('DOMContentLoaded', function() {
        const backToTop = document.querySelector('[data-attribute="back-to-top"]');
        if (backToTop) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('back-to-top-show');
                } else {
                    backToTop.classList.remove('back-to-top-show');
                }
            });
            
            backToTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>
