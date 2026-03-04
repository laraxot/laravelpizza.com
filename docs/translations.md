# Traduzioni nel Tema Meetup

## Filosofia Laraxot per le Traduzioni

Le traduzioni nel tema Meetup seguono la **filosofia Laraxot**:
- **Struttura espansa**: Ogni chiave ha `label`, `placeholder`, `help`
- **Nessuna stringa hardcoded**: Tutte le stringhe UI vengono dai file di traduzione
- **Namespace `pub_theme::`**: Tutte le traduzioni usano il namespace del tema

## Struttura dei File

```
Themes/Meetup/lang/
├── it/
│   ├── event.php      # Traduzioni evento
│   ├── events.php     # Traduzioni lista eventi
│   ├── home.php       # Traduzioni homepage
│   └── navigation.php # Traduzioni navigazione
├── en/
│   └── ...
├── es/
│   └── ...
└── fr/
    └── ...
```

## Doppia Struttura: Nidificata + Piatta

I file di traduzione hanno una **doppia struttura** per massima flessibilità:

### 1. Struttura Nidificata (per Filament/Forms)

```php
'fields' => [
    'date' => [
        'label' => 'Data',
        'placeholder' => 'Seleziona la data',
        'tooltip' => 'Data dell\'evento',
        'helper_text' => '',
        'description' => 'La data in cui si terrà l\'evento',
        'icon' => 'heroicon-o-calendar',
        'color' => 'primary',
    ],
],
'actions' => [
    'share_event' => [
        'label' => 'Condividi evento',
        'tooltip' => 'Condividi sui social',
        'icon' => 'heroicon-o-share',
    ],
],
```

Uso: `__('pub_theme::event.fields.date.label')`

### 2. Struttura Piatta (per Template Blade)

```php
'date' => [
    'label' => 'Data',
    'help' => 'Data in cui si terrà l\'evento',
],
'time' => [
    'label' => 'Orario',
    'help' => 'Ora di inizio dell\'evento',
],
'share_event' => [
    'label' => 'Condividi evento',
    'help' => 'Condividi questo evento',
],
```

Uso: `__('pub_theme::event.date.label')`

## Chiavi Obbligatorie per Ogni Traduzione

Ogni traduzione deve avere almeno:

```php
'key_name' => [
    'label' => 'Testo visibile',     // Obbligatorio
    'help' => 'Testo di aiuto',      // Opzionale ma consigliato
],
```

Per i campi form (Filament):

```php
'field_name' => [
    'label' => 'Etichetta',          // Obbligatorio
    'placeholder' => 'Placeholder',  // Obbligatorio
    'tooltip' => 'Tooltip',           // Consigliato
    'helper_text' => 'Aiuto',         // Opzionale
    'description' => 'Descrizione',  // Opzionale
    'icon' => 'heroicon-o-icon',      // Opzionale
    'color' => 'primary',             // Opzionale
],
```

## Namespace pub_theme::

Tutte le traduzioni del tema usano il namespace `pub_theme::`:

```blade
{{-- CORRETTO --}}
{{ __('pub_theme::event.date.label') }}
{{ __('pub_theme::event.share_event.label') }}

{{-- ERRATO --}}
{{ __('event.date.label') }}
{{ __('date.label') }}
```

## Esempio Completo: event.php

```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Evento',
        'plural_label' => 'Eventi',
        'group' => 'Meetup',
        'icon' => 'heroicon-o-calendar',
        'sort' => 11,
    ],
    
    // Struttura nidificata per Filament
    'fields' => [
        'date' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona la data',
            'tooltip' => 'Data dell\'evento',
            'helper_text' => '',
            'description' => 'La data in cui si terrà l\'evento',
            'icon' => 'heroicon-o-calendar',
            'color' => 'primary',
        ],
    ],
    
    'actions' => [
        'share_event' => [
            'label' => 'Condividi evento',
            'tooltip' => 'Condividi sui social',
            'icon' => 'heroicon-o-share',
        ],
    ],
    
    // Struttura piatta per template
    'date' => [
        'label' => 'Data',
        'help' => 'Data dell\'evento',
    ],
    
    'share_event' => [
        'label' => 'Condividi evento',
        'help' => 'Condividi con i tuoi contatti',
    ],
];
```

## Anti-pattern da Evitare

### ❌ NO: Stringhe hardcoded
```blade
{{-- SBAGLIATO --}}
<p>Data dell'evento</p>
<button>Condividi</button>
```

### ✅ SI: Traduzioni sempre
```blade
{{-- CORRETTO --}}
<p>{{ __('pub_theme::event.date.label') }}</p>
<button>{{ __('pub_theme::event.share_event.label') }}</button>
```

### ❌ NO: Struttura flat senza label/help
```php
// SBAGLIATO
date' => 'Data',
'share_event' => 'Condividi',
```

### ✅ SI: Struttura espansa
```php
// CORRETTO
date' => [
    'label' => 'Data',
    'help' => 'Data dell\'evento',
],
```

## Aggiungere Nuove Traduzioni

1. **Identificare il file corretto**:
   - Eventi: `lang/{locale}/event.php`
   - Homepage: `lang/{locale}/home.php`
   - Navigazione: `lang/{locale}/navigation.php`

2. **Aggiungere a tutte le lingue**:
   - `it/` - Italiano (primario)
   - `en/` - Inglese
   - `es/` - Spagnolo
   - `fr/` - Francese

3. **Struttura corretta**:
   ```php
   'new_key' => [
       'label' => 'Testo visibile',
       'help' => 'Descrizione aiuto',
   ],
   ```

## Collegamenti

- [Volt Component Pattern](./volt-component-pattern.md)
- [Helper Class Pattern](./helper-class-pattern.md)
- [Agnostic Routing](./agnostic-routing.md)

---

*
