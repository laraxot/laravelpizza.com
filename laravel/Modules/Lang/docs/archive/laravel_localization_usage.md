# Utilizzo di mcamara/laravel-localization 

## Collegamenti correlati
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](./TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive come utilizzare correttamente il pacchetto `mcamara/laravel-localization`  per gestire la localizzazione delle URL e l'interfaccia multilingua.

## Regole Fondamentali

1. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

2. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

3. **Gestione della Localizzazione**
   - Utilizzare SEMPRE il pacchetto mcamara/laravel-localization
   - Seguire la documentazione ufficiale: https://github.com/mcamara/laravel-localization
   - Assicurarsi che tutti gli URL includano il prefisso della lingua

## Configurazione

Il pacchetto `mcamara/laravel-localization` è già configurato . La configurazione si trova in:
- `/var/www/html/<nome progetto>/laravel/config/laravellocalization.php`

Le lingue supportate sono definite nella chiave `supportedLocales` di questo file.

## Utilizzo Corretto in Blade

### 1. Ottenere la Lingua Corrente

```php
// CORRETTO - Utilizzare LaravelLocalization::getCurrentLocale()
$currentLocale = LaravelLocalization::getCurrentLocale();

// ERRATO - Non utilizzare app()->getLocale() direttamente
$currentLocale = app()->getLocale();
```

### 2. Ottenere le Lingue Supportate

```php
// CORRETTO - Utilizzare LaravelLocalization::getSupportedLocales()
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    // $properties contiene 'name', 'script', 'native', 'regional'
    <span>{{ $properties['native'] }}</span>
@endforeach

// ERRATO - Non utilizzare array hardcoded
@foreach(['it' => 'Italiano', 'en' => 'English'] as $locale => $label)
    <span>{{ $label }}</span>
@endforeach
```

### 3. Generare URL Localizzati

```php
// CORRETTO - Utilizzare LaravelLocalization::getLocalizedURL()
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a>

// ERRATO - Non costruire URL manualmente
<a href="{{ '/en' . substr(request()->getPathInfo(), 3) }}">English</a>
```

### 4. Esempio di Selettore Lingua Completo

```php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        <x-dynamic-component 
            :component="'ui-flags.' . ($currentLocale === 'en' ? 'gb' : $currentLocale)" 
        />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>
    
    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component 
                    :component="'ui-flags.' . ($localeCode === 'en' ? 'gb' : $localeCode)" 
                />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

## Utilizzo delle Bandiere SVG

Le bandiere SVG sono disponibili in `/var/www/html/<nome progetto>/laravel/Modules/UI/resources/svg/flags` e sono autoregistrate come componenti Blade con il prefisso `ui-flags`.

### Utilizzo Corretto

```php
// Per la bandiera italiana
<x-ui-flags.it class="w-6 h-6" />

// Per la bandiera inglese (UK)
<x-ui-flags.gb class="w-6 h-6" />

// Utilizzo dinamico
@php
    $flagCode = $locale === 'en' ? 'gb' : $locale;
@endphp
<x-dynamic-component :component="'ui-flags.' . $flagCode" class="w-6 h-6" />
```

## Middleware e Configurazione

Il pacchetto utilizza diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRedirectFilter` - Reindirizza all'URL localizzato
2. `LaravelLocalizationViewPath` - Imposta il percorso della vista localizzata
3. `LaravelLocalizationRoutes` - Gestisce le rotte localizzate

Questi middleware sono già configurati  e non è necessario modificarli.

## Errori Comuni da Evitare

1. **Utilizzo di route() per rotte localizzate**
   ```php
   // ERRATO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
   
   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
   ```

2. **Costruzione manuale degli URL localizzati**
   ```php
   // ERRATO
   <a href="{{ '/' . $locale . '/pages/about' }}">About</a>
   
   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL($locale, route('pages.about')) }}">About</a>
   ```

3. **Utilizzo di app()->setLocale() direttamente**
   ```php
   // ERRATO
   @php app()->setLocale('it') @endphp
   
   // CORRETTO - Lasciare che il middleware gestisca la locale
   // Non modificare manualmente la locale
   ```

## Esempi Pratici

### Esempio 1: Header con Selettore Lingua

```php
// /laravel/Themes/One/resources/views/components/blocks/language-selector.blade.php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-dynamic-component :component="'ui-flags.' . $flagCode" />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>
    
    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @php
                $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
            @endphp
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component :component="'ui-flags.' . $flagCode" />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

### Esempio 2: Configurazione JSON per Header

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector"
    }
}
```

## Componenti Bandiera

### Implementazione Corretta
```blade
{{-- Per icone semplici --}}
<x-filament::icon
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5 text-gray-500 dark:text-gray-400"
    :label="$flagCode"
    aria-hidden="true"
/>

{{-- Per pulsanti con icone --}}
<x-filament::icon-button
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5"
    :label="$flagCode"
    aria-hidden="true"
/>
```

### Vantaggi
1. **Coerenza**: Usa i componenti nativi di Filament
2. **Tema Scuro**: Supporto automatico
3. **Accessibilità**: Componenti ottimizzati
4. **Manutenibilità**: Codice pulito e standardizzato

## Riferimenti

- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Localization](https://laravel.com/docs/10.x/localization)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)
