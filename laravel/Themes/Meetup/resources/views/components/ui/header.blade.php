{{--
    AGID Compliant Header Component
    
    Implementa le linee guida AGID per l'header di un sito PA
    - Accessibilità WCAG 2.1 AA
    - Skip links per navigazione da tastiera
    - Breadcrumb semantico
    - Logo PA conforme
--}}

<header class="it-header-wrapper" role="banner">
    {{-- Skip Links per accessibilità --}}
    <div class="it-header-slim-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="it-header-slim-wrapper-content">
                        <a class="sr-only sr-only-focusable" href="#main-content">
                            {{ __('Vai al contenuto principale') }}
                        </a>
                        <a class="sr-only sr-only-focusable" href="#main-navigation">
                            {{ __('Vai alla navigazione') }}
                        </a>
                        <a class="sr-only sr-only-focusable" href="#footer">
                            {{ __('Vai al piè di pagina') }}
                        </a>
                        
                        <div class="header-slim-right-zone" role="navigation" aria-label="{{ __('Lingua e accesso') }}">
                            {{-- Language Selector --}}
                            <div class="nav-item dropdown">
                                <button 
                                    class="nav-link dropdown-toggle" 
                                    type="button" 
                                    id="languageDropdown"
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false"
                                    aria-label="{{ __('Seleziona lingua') }}"
                                >
                                    <span class="visually-hidden">{{ __('Lingua attuale:') }}</span>
                                    ITA
                                    <svg class="icon d-none d-lg-block"><use href="#it-expand"></use></svg>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                                    <div class="link-list-wrapper">
                                        <ul class="link-list">
                                            <li><a class="dropdown-item list-item" href="#" lang="it">Italiano</a></li>
                                            <li><a class="dropdown-item list-item" href="#" lang="en">English</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Area Personale / Login --}}
                            @auth
                                <a class="btn btn-primary btn-sm" href="{{ route('filament.admin.pages.dashboard') }}" aria-label="{{ __('Area personale') }}">
                                    {{ __('Area personale') }}
                                </a>
                            @else
                                <a class="btn btn-primary btn-sm" href="{{ route('filament.admin.auth.login') }}" aria-label="{{ __('Accedi') }}">
                                    {{ __('Accedi') }}
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Header Center con Logo e Ricerca --}}
    <div class="it-header-center-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="it-header-center-content-wrapper">
                        {{-- Logo --}}
                        <div class="it-brand-wrapper">
                            <a href="{{ url('/') }}" aria-label="{{ config('app.name') }} - {{ __('Torna alla home') }}">
                                <svg class="icon" role="img" aria-labelledby="logo-title">
                                    <title id="logo-title">{{ config('app.name') }}</title>
                                    <use href="#it-pa"></use>
                                </svg>
                                <div class="it-brand-text">
                                    <h2 class="no_toc">{{ config('app.name') }}</h2>
                                    <h3 class="no_toc d-none d-md-block">{{ __('Segnalazioni Cittadine') }}</h3>
                                </div>
                            </a>
                        </div>
                        
                        {{-- Header Right Zone con Ricerca e Social --}}
                        <div class="it-right-zone">
                            {{-- Ricerca --}}
                            <div class="it-search-wrapper">
                                <button 
                                    class="search-link rounded-icon" 
                                    type="button" 
                                    aria-label="{{ __('Cerca') }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#searchModal"
                                >
                                    <svg class="icon">
                                        <use href="#it-search"></use>
                                    </svg>
                                </button>
                            </div>
                            
                            {{-- Social --}}
                            <div class="it-socials d-none d-md-flex">
                                <span class="visually-hidden">{{ __('Seguici su:') }}</span>
                                <ul>
                                    <li>
                                        <a href="#" aria-label="{{ __('Facebook') }}" target="_blank" rel="noopener noreferrer">
                                            <svg class="icon"><use href="#it-facebook"></use></svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" aria-label="{{ __('Twitter') }}" target="_blank" rel="noopener noreferrer">
                                            <svg class="icon"><use href="#it-twitter"></use></svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Navigazione Principale --}}
    <div class="it-nav-wrapper">
        <div class="it-header-navbar-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-lg has-megamenu" id="main-navigation" aria-label="{{ __('Navigazione principale') }}">
                            <button 
                                class="custom-navbar-toggler" 
                                type="button" 
                                aria-controls="nav" 
                                aria-expanded="false" 
                                aria-label="{{ __('Apri menu di navigazione') }}"
                                data-bs-toggle="navbarcollapsible"
                                data-bs-target="#nav"
                            >
                                <svg class="icon"><use href="#it-burger"></use></svg>
                            </button>
                            
                            <div class="navbar-collapsable" id="nav">
                                <div class="overlay"></div>
                                <div class="close-div">
                                    <button 
                                        class="btn close-menu" 
                                        type="button"
                                        aria-label="{{ __('Chiudi menu') }}"
                                    >
                                        <svg class="icon"><use href="#it-close-big"></use></svg>
                                    </button>
                                </div>
                                
                                <div class="menu-wrapper">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('/') }}" aria-current="page">
                                                <span>{{ __('Home') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('tickets.index') }}">
                                                <span>{{ __('Segnalazioni') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('tickets.create') }}">
                                                <span>{{ __('Nuova Segnalazione') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('/info') }}">
                                                <span>{{ __('Informazioni') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('/contatti') }}">
                                                <span>{{ __('Contatti') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Modal Ricerca --}}
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Chiudi ricerca') }}">
                    <svg class="icon"><use href="#it-close"></use></svg>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('search') }}" method="GET" role="search">
                    <div class="form-group">
                        <label for="search-input" class="visually-hidden">{{ __('Cerca nel sito') }}</label>
                        <input 
                            type="search" 
                            class="form-control" 
                            id="search-input"
                            name="q"
                            placeholder="{{ __('Cerca nel sito...') }}"
                            aria-label="{{ __('Campo di ricerca') }}"
                            required
                        >
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">
                        {{ __('Cerca') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
