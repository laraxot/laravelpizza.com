# Implementazione del Selettore di Lingua con Bandiere SVG

## Collegamenti correlati
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Best Practices Chiavi di Traduzione](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Implementazione Header](/laravel/Modules/User/docs/HEADER_LANGUAGE_AVATAR_IMPLEMENTATION.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive come migliorare il selettore di lingua nell'header di <nome progetto> utilizzando le bandiere SVG disponibili nel modulo UI, rendendo il componente più visibile e accattivante.

## Utilizzo delle Bandiere SVG

Le bandiere SVG sono disponibili in `Modules/UI/resources/svg/flags` e sono autoregistrate come componenti Blade tramite il sistema di registrazione delle icone di Blade. Questo avviene grazie al metodo `registerBladeIcons()` nel `XotBaseServiceProvider`.

### Come Funziona la Registrazione

Il `XotBaseServiceProvider` registra automaticamente tutti gli SVG nella directory `/svg` di un modulo come componenti Blade con il prefisso del nome del modulo in minuscolo. Per il modulo UI, questo significa che tutte le bandiere sono accessibili con il prefisso `ui-`.

```php
// Nel XotBaseServiceProvider.php
public function registerBladeIcons(): void
{
    // ...
    $svgPath = module_path($this->name, $relativePath.'/../svg');
    // ...
    Config::set('blade-icons.sets.'.$this->nameLower.'.path', $svgPath);
    Config::set('blade-icons.sets.'.$this->nameLower.'.prefix', $this->nameLower);
}
```

## Componente Selettore di Lingua Migliorato

Ecco un'implementazione migliorata del selettore di lingua che utilizza le bandiere SVG:

```php
// /Themes/One/resources/views/components/blocks/language-selector.blade.php
@props(['items' => [], 'currentLocale' => app()->getLocale()])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <button
        @click="open = !open"
        @click.away="open = false"
        class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
        aria-label="{{ __('common.language_selector.toggle_button') }}"
    >
        {{-- Mostra la bandiera della lingua corrente --}}
        <span class="flex items-center">
            <x-dynamic-component
                :component="'ui-flags.' . $currentLocale"
                class="w-6 h-6 rounded-full shadow-sm border border-gray-200"
                aria-hidden="true"
            />
            <span class="ml-2 font-medium text-sm uppercase">{{ $currentLocale }}</span>
            <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    >
        <div class="py-1">
            @foreach($items as $locale => $label)
                <a
                    href="{{ '/' . $locale . request()->getPathInfo() }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $locale ? 'bg-gray-100' : '' }}"
                >
                    <x-dynamic-component
                        :component="'ui-flags.' . $locale"
                        class="w-5 h-5 rounded-full mr-3"
                        aria-hidden="true"
                    />
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
```

### Aggiornamento del File JSON

Aggiornare il blocco del selettore di lingua nel file JSON dell'header:

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector",
        "items": {
            "it": "Italiano",
            "en": "English",
            "fr": "Français",
            "de": "Deutsch",
            "es": "Español"
        }
    }
}
```

## Esempio Visivo

Il selettore di lingua nell'header apparirà così:

1. **Stato Chiuso**: Mostra la bandiera della lingua corrente con il codice lingua
   ```
   [🇮🇹 IT ▼]
   ```

2. **Stato Aperto**: Mostra un menu dropdown con tutte le lingue disponibili
   ```
   [🇮🇹 IT ▼]
   ┌───────────────┐
   │ 🇮🇹 Italiano   │
   │ 🇬🇧 English    │
   │ 🇫🇷 Français   │
   │ 🇩🇪 Deutsch    │
   │ 🇪🇸 Español    │
   └───────────────┘
   ```

## Considerazioni di Accessibilità

1. **Aria Labels**: Aggiunti attributi `aria-label` e `aria-hidden` per migliorare l'accessibilità
2. **Contrasto**: Utilizzato colori con contrasto sufficiente per il testo
3. **Feedback Visivo**: Evidenziazione della lingua corrente e degli elementi al passaggio del mouse
4. **Tastiera**: Il dropdown è navigabile tramite tastiera

## Implementazione Tecnica

1. Creare il componente Blade come descritto sopra
2. Aggiornare il file JSON dell'header per utilizzare il nuovo componente
3. Verificare che le bandiere SVG vengano caricate correttamente
4. Testare il selettore con diverse lingue

## Vantaggi dell'Utilizzo delle Bandiere SVG

1. **Maggiore Visibilità**: Le bandiere rendono il selettore di lingua immediatamente riconoscibile
2. **Migliore UX**: Fornisce un feedback visivo chiaro sulla lingua corrente e sulle opzioni disponibili
3. **Prestazioni**: Gli SVG sono leggeri e si ridimensionano perfettamente su qualsiasi dispositivo
4. **Coerenza**: Utilizza componenti già disponibili nel sistema

## Traduzioni Necessarie

Assicurarsi di aggiungere le seguenti chiavi di traduzione:

```php
// resources/lang/it/common.php
return [
    'language_selector' => [
        'toggle_button' => 'Cambia lingua',
        'current_language' => 'Lingua corrente: :language',
    ],
];

// resources/lang/en/common.php
return [
    'language_selector' => [
        'toggle_button' => 'Change language',
        'current_language' => 'Current language: :language',
    ],
];
```

## Collegamenti Utili

- [Documentazione Blade Icons](https://github.com/blade-ui-kit/blade-icons)
- [Documentazione Alpine.js](https://alpinejs.dev/) - Per le interazioni dropdown
- [Documentazione Accessibilità WAI-ARIA](https://www.w3.org/WAI/ARIA/apg/patterns/menubutton/)
# Implementazione del Selettore di Lingua con Bandiere SVG

## Collegamenti correlati
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Best Practices Chiavi di Traduzione](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Implementazione Header](/laravel/Modules/User/docs/HEADER_LANGUAGE_AVATAR_IMPLEMENTATION.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive come migliorare il selettore di lingua nell'header di <nome progetto> utilizzando le bandiere SVG disponibili nel modulo UI, rendendo il componente più visibile e accattivante.

## Utilizzo delle Bandiere SVG

Le bandiere SVG sono disponibili in `Modules/UI/resources/svg/flags` e sono autoregistrate come componenti Blade tramite il sistema di registrazione delle icone di Blade. Questo avviene grazie al metodo `registerBladeIcons()` nel `XotBaseServiceProvider`.

### Come Funziona la Registrazione

Il `XotBaseServiceProvider` registra automaticamente tutti gli SVG nella directory `/svg` di un modulo come componenti Blade con il prefisso del nome del modulo in minuscolo. Per il modulo UI, questo significa che tutte le bandiere sono accessibili con il prefisso `ui-`.

```php
// Nel XotBaseServiceProvider.php
public function registerBladeIcons(): void
{
    // ...
    $svgPath = module_path($this->name, $relativePath.'/../svg');
    // ...
    Config::set('blade-icons.sets.'.$this->nameLower.'.path', $svgPath);
    Config::set('blade-icons.sets.'.$this->nameLower.'.prefix', $this->nameLower);
}
```

## Componente Selettore di Lingua Migliorato

Ecco un'implementazione migliorata del selettore di lingua che utilizza le bandiere SVG:

```php
// /Themes/One/resources/views/components/blocks/language-selector.blade.php
@props(['items' => [], 'currentLocale' => app()->getLocale()])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <button
        @click="open = !open"
        @click.away="open = false"
        class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
        aria-label="{{ __('common.language_selector.toggle_button') }}"
    >
        {{-- Mostra la bandiera della lingua corrente --}}
        <span class="flex items-center">
            <x-dynamic-component
                :component="'ui-flags.' . $currentLocale"
                class="w-6 h-6 rounded-full shadow-sm border border-gray-200"
                aria-hidden="true"
            />
            <span class="ml-2 font-medium text-sm uppercase">{{ $currentLocale }}</span>
            <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    >
        <div class="py-1">
            @foreach($items as $locale => $label)
                <a
                    href="{{ '/' . $locale . request()->getPathInfo() }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $locale ? 'bg-gray-100' : '' }}"
                >
                    <x-dynamic-component
                        :component="'ui-flags.' . $locale"
                        class="w-5 h-5 rounded-full mr-3"
                        aria-hidden="true"
                    />
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
```

### Aggiornamento del File JSON

Aggiornare il blocco del selettore di lingua nel file JSON dell'header:

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector",
        "items": {
            "it": "Italiano",
            "en": "English",
            "fr": "Français",
            "de": "Deutsch",
            "es": "Español"
        }
    }
}
```

## Esempio Visivo

Il selettore di lingua nell'header apparirà così:

1. **Stato Chiuso**: Mostra la bandiera della lingua corrente con il codice lingua
   ```
   [🇮🇹 IT ▼]
   ```

2. **Stato Aperto**: Mostra un menu dropdown con tutte le lingue disponibili
   ```
   [🇮🇹 IT ▼]
   ┌───────────────┐
   │ 🇮🇹 Italiano   │
   │ 🇬🇧 English    │
   │ 🇫🇷 Français   │
   │ 🇩🇪 Deutsch    │
   │ 🇪🇸 Español    │
   └───────────────┘
   ```

## Considerazioni di Accessibilità

1. **Aria Labels**: Aggiunti attributi `aria-label` e `aria-hidden` per migliorare l'accessibilità
2. **Contrasto**: Utilizzato colori con contrasto sufficiente per il testo
3. **Feedback Visivo**: Evidenziazione della lingua corrente e degli elementi al passaggio del mouse
4. **Tastiera**: Il dropdown è navigabile tramite tastiera

## Implementazione Tecnica

1. Creare il componente Blade come descritto sopra
2. Aggiornare il file JSON dell'header per utilizzare il nuovo componente
3. Verificare che le bandiere SVG vengano caricate correttamente
4. Testare il selettore con diverse lingue

## Vantaggi dell'Utilizzo delle Bandiere SVG

1. **Maggiore Visibilità**: Le bandiere rendono il selettore di lingua immediatamente riconoscibile
2. **Migliore UX**: Fornisce un feedback visivo chiaro sulla lingua corrente e sulle opzioni disponibili
3. **Prestazioni**: Gli SVG sono leggeri e si ridimensionano perfettamente su qualsiasi dispositivo
4. **Coerenza**: Utilizza componenti già disponibili nel sistema

## Traduzioni Necessarie

Assicurarsi di aggiungere le seguenti chiavi di traduzione:

```php
// resources/lang/it/common.php
return [
    'language_selector' => [
        'toggle_button' => 'Cambia lingua',
        'current_language' => 'Lingua corrente: :language',
    ],
];

// resources/lang/en/common.php
return [
    'language_selector' => [
        'toggle_button' => 'Change language',
        'current_language' => 'Current language: :language',
    ],
];
```

## Collegamenti Utili

- [Documentazione Blade Icons](https://github.com/blade-ui-kit/blade-icons)
- [Documentazione Alpine.js](https://alpinejs.dev/) - Per le interazioni dropdown
- [Documentazione Accessibilità WAI-ARIA](https://www.w3.org/WAI/ARIA/apg/patterns/menubutton/)
