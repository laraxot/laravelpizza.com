<?php

declare(strict_types=1);

?>
{{--
/**
 * Language Switcher Widget
 * 
 * Widget per il cambio di lingua dell'interfaccia.
 * Fornisce un dropdown con le lingue disponibili e le relative bandiere.
 * 
 * @var string $current_locale Lingua corrente
 * @var \Illuminate\Support\Collection $available_locales Lingue disponibili
 * @var string $widget_id ID univoco del widget
 */
--}}
<div>
<li class="language-switcher-container">
    <details class="dropdown">
        <summary 
            class="btn btn-ghost btn-sm m-1 hover:bg-emerald-50 hover:bg-opacity-20 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-opacity-50"
            aria-label="@lang('lang::widgets.language_switcher.select_language')"
        >
            @php
                $currentLanguage = $available_locales->firstWhere('code', $current_locale);
            @endphp
            
            {{-- Mostra bandiera e codice della lingua corrente --}}
            <span class="flex items-center space-x-2">
                @if($currentLanguage && $currentLanguage['flag'])
                    <span class="text-lg" role="img" aria-hidden="true">
                        {{ $currentLanguage['flag'] }}
                    </span>
                @endif
                <span class="text-sm font-medium uppercase">
                    {{ $current_locale }}
                </span>
                <x-heroicon-o-chevron-down class="w-4 h-4" aria-hidden="true" />
            </span>
        </summary>
        
        {{-- Menu dropdown delle lingue --}}
        <ul class="dropdown-content z-[1] menu p-2 shadow-lg bg-white dark:bg-gray-800 rounded-lg w-52 mt-2 border border-gray-200 dark:border-gray-700">
            @foreach($available_locales as $locale)
                <li>
                    <a 
                        href="{{ $this->getLanguageUrl($locale['code']) }}"
                        class="flex items-center space-x-3 px-3 py-2 text-sm hover:bg-emerald-50 dark:hover:bg-emerald-900 rounded-md transition-colors duration-200 {{ $locale['code'] === $current_locale ? 'bg-emerald-100 dark:bg-emerald-800 font-medium' : '' }}"
                        @if($locale['code'] === $current_locale) aria-current="page" @endif
                        wire:click="changeLanguage('{{ $locale['code'] }}')"
                    >
                        {{-- Bandiera --}}
                        @if($locale['flag'])
                            <span class="text-lg flex-shrink-0" role="img" aria-hidden="true">
                                {{ $locale['flag'] }}
                            </span>
                        @endif
                        
                        {{-- Nome della lingua --}}
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                {{ $locale['native_name'] }}
                            </span>
                            @if($locale['native_name'] !== $locale['name'])
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $locale['name'] }}
                                </span>
                            @endif
                        </div>
                        
                        {{-- Indicatore lingua corrente --}}
                        @if($locale['code'] === $current_locale)
                            <x-heroicon-o-check class="w-4 h-4 text-emerald-600 dark:text-emerald-400 ml-auto" aria-hidden="true" />
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </details>
</li>

<script>
/**
 * Gestione del cambio lingua tramite AJAX
 */
document.addEventListener('DOMContentLoaded', function() {
    const languageSwitcher = document.querySelector('.language-switcher-container');
    
    if (languageSwitcher) {
        // Gestisce il click sui link delle lingue
        languageSwitcher.addEventListener('click', function(e) {
            const link = e.target.closest('a[wire\\:click]');
            if (link) {
                e.preventDefault();
                
                // Estrae il codice lingua dal wire:click
                const wireClick = link.getAttribute('wire:click');
                const match = wireClick.match(/changeLanguage\('([^']+)'\)/);
                
                if (match) {
                    const langCode = match[1];
                    changeLanguage(langCode, link.href);
                }
            }
        });
    }
});

/**
 * Cambia la lingua dell'interfaccia
 * @param {string} langCode Codice della lingua
 * @param {string} url URL con la nuova lingua
 */
function changeLanguage(langCode, url) {
    // Salva la preferenza nel localStorage
    localStorage.setItem('preferred_language', langCode);
    
    // Mostra un indicatore di caricamento (opzionale)
    const switcher = document.querySelector('.language-switcher-container summary');
    if (switcher) {
        switcher.style.opacity = '0.6';
        switcher.style.pointerEvents = 'none';
    }
    
    // Reindirizza alla nuova URL con la lingua
    window.location.href = url;
}

/**
 * Inizializza la lingua preferita al caricamento della pagina
 */
document.addEventListener('DOMContentLoaded', function() {
    const preferredLang = localStorage.getItem('preferred_language');
    const currentLang = '{{ $current_locale }}';
    
    // Se c'è una preferenza diversa dalla lingua corrente, aggiorna
    if (preferredLang && preferredLang !== currentLang) {
        const langLink = document.querySelector(`a[wire\\:click*="changeLanguage('${preferredLang}')"]`);
        if (langLink) {
            // Opzionale: cambia automaticamente alla lingua preferita
            // window.location.href = langLink.href;
        }
    }
});
</script>

<style>
/* Stili specifici per il language switcher */
.language-switcher-container .dropdown-content {
    min-width: 200px;
    max-height: 300px;
    overflow-y: auto;
}

.language-switcher-container summary {
    list-style: none;
    cursor: pointer;
    user-select: none;
}

.language-switcher-container summary::-webkit-details-marker {
    display: none;
}

/* Animazioni per il dropdown */
.language-switcher-container details[open] .dropdown-content {
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effects */
.language-switcher-container summary:hover {
    transform: scale(1.02);
}

/* Focus styles per accessibilità */
.language-switcher-container summary:focus {
    outline: 2px solid #10b981;
    outline-offset: 2px;
}

/* Stili per il tema scuro */
@media (prefers-color-scheme: dark) {
    .language-switcher-container .dropdown-content {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
    }
}
</style>

@php
/**
 * Helper method per generare URL con lingua
 * Questo dovrebbe essere implementato nel widget PHP
 */
if (!function_exists('getLanguageUrl')) {
    function getLanguageUrl($locale) {
        $currentUrl = request()->url();
        $currentLocale = app()->getLocale();
        
        // Sostituisce la lingua nell'URL se presente
        if (strpos($currentUrl, '/' . $currentLocale . '/') !== false) {
            return str_replace('/' . $currentLocale . '/', '/' . $locale . '/', $currentUrl);
        } elseif (strpos($currentUrl, '/' . $currentLocale) !== false) {
            return str_replace('/' . $currentLocale, '/' . $locale, $currentUrl);
        } else {
            // Aggiunge la lingua all'URL
            return url($locale . request()->getPathInfo());
        }
    }
}
@endphp
</div>
