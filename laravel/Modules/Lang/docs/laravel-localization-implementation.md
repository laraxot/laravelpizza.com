# Implementazione della Localizzazione 

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni Lang](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Componenti SVG Bandiere](/laravel/Modules/UI/docs/FLAGS_COMPONENTS.md)
- [Implementazione Header](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

 utilizza il pacchetto `mcamara/laravel-localization` per gestire la localizzazione dell'applicazione. Questo documento descrive come implementare correttamente il selettore di lingue e come utilizzare le funzioni del pacchetto.

## Regole Fondamentali

1. **NON creare rotte personalizzate** per la gestione delle lingue (come `language.switch`)
2. **NON creare controller specifici** per la gestione delle lingue
3. Utilizzare **ESCLUSIVAMENTE** le funzioni native del pacchetto `mcamara/laravel-localization`
4. Filament e Folio gestiscono già la localizzazione, non è necessario implementare logiche personalizzate

## Funzioni del Pacchetto `mcamara/laravel-localization`

### Ottenere la Lingua Corrente

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$currentLocale = LaravelLocalization::getCurrentLocale();
```

### Ottenere le Lingue Supportate

```php
$supportedLocales = LaravelLocalization::getSupportedLocales();
```

### Generare URL Localizzati

```php
$url = LaravelLocalization::getLocalizedURL('it'); // URL per la lingua italiana
$url = LaravelLocalization::getLocalizedURL('en'); // URL per la lingua inglese
```

## Implementazione Corretta del Selettore di Lingue

### Componente Blade

```blade
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div x-data="{ open: false }" class="relative">
    <button
        @click="open = !open"
        class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-200"
        aria-label="{{ __('common.language_selector.toggle_button') }}"
    >
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-ui-flags.{{ $flagCode }} class="w-6 h-4" />
        <span class="text-sm font-medium text-white">{{ strtoupper($currentLocale) }}</span>
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @php
                    $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
                @endphp
                <a
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $localeCode ? 'bg-gray-50' : '' }}"
                >
                    <x-ui-flags.{{ $flagCode }} class="w-6 h-4 mr-2" />
                    <span>{{ $properties['native'] }}</span>
                    @if($currentLocale === $localeCode)
                        <svg class="w-4 h-4 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
```

## Errori Comuni da Evitare

### 1. Utilizzo di Rotte Personalizzate

```blade
<!-- ERRATO -->
<a href="{{ route('language.switch', 'it') }}">Italiano</a>

<!-- CORRETTO -->
<a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
```

### 2. Implementazione di Controller per il Cambio Lingua

```php
// ERRATO
Route::get('language/{locale}', 'LanguageController@switch')->name('language.switch');

// CORRETTO
// Non è necessario implementare controller o rotte personalizzate
// Il pacchetto mcamara/laravel-localization gestisce già tutto
```

### 3. Utilizzo di Helper Personalizzati

```php
// ERRATO
function switchLanguage($locale) {
    // Logica personalizzata per il cambio lingua
}

// CORRETTO
// Utilizzare le funzioni native del pacchetto
$url = LaravelLocalization::getLocalizedURL($locale);
```

## Configurazione del Pacchetto

La configurazione del pacchetto `mcamara/laravel-localization` si trova nel file `config/laravellocalization.php`. Le lingue supportate sono definite nell'array `supportedLocales`:

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    // Altre lingue...
],
```

## Middleware

Il pacchetto `mcamara/laravel-localization` fornisce diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRoutes`: Applica il prefisso della lingua alle rotte
2. `LaravelLocalizationRedirectFilter`: Reindirizza alla lingua predefinita se la lingua non è specificata
3. `LaravelLocalizationViewPath`: Imposta il percorso delle viste in base alla lingua

## Conclusione

Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di  di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.
