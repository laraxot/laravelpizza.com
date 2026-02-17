# Translation Rules - Meetup Theme

## Regola Fondamentale: Struttura Espansa delle Traduzioni

> **ATTENZIONE:** Questa è una copia mirror della documentazione nel modulo.  
> **Source of truth:** `Modules/Meetup/docs/translation-rules.md`

### La Regola d'Oro

**MAI usare chiavi di traduzione "flat". Tutte le traduzioni DEVONO seguire la struttura espansa con sotto-chiavi.**

❌ **ERRATO (Flat Keys):**
```php
'about_this_event' => 'About This Event'
// Genera: meetup::events.about_this_event ❌
```

✅ **CORRETTO (Expanded Structure):**
```php
'about_this_event' => [
    'label' => 'About This Event',
    'color' => 'blue',
    'icon' => 'heroicon-o-information-circle',
]
// Genera: meetup::events.about_this_event.label ✅
//         meetup::events.about_this_event.color ✅
```

## Struttura Standard

```php
return [
    'navigation' => [...],
    'label' => 'Singolare',
    'plural_label' => 'Plurale',
    'fields' => [
        'field_name' => [
            'label' => 'Label',
            'placeholder' => 'Placeholder',
            'help' => 'Help text',
        ],
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Label',
            'modal_heading' => 'Heading',
            'success' => 'Messaggio successo',
        ],
    ],
    'sections' => [
        'section_name' => [
            'label' => 'Label',
            'heading' => 'Heading',
            'color' => 'blue',
            'icon' => 'heroicon-o-icon',
        ],
    ],
];
```

## Esempio per Event Detail Page

```php
// File: Modules/Meetup/lang/it/event_detail.php

'sections' => [
    'about_this_event' => [
        'label' => 'Informazioni sull\'evento',
        'heading' => 'About This Event',
        'color' => 'blue',
        'icon' => 'heroicon-o-information-circle',
    ],
    'event_location' => [
        'label' => 'Luogo dell\'evento',
        'heading' => 'Event Location',
        'color' => 'green',
        'icon' => 'heroicon-o-map-pin',
    ],
    'attendees' => [
        'label' => 'Partecipanti',
        'heading' => 'Attendees',
        'color' => 'purple',
        'icon' => 'heroicon-o-users',
    ],
],

'actions' => [
    'book_spot' => [
        'label' => 'Prenota il tuo posto',
        'tooltip' => 'Clicca per registrarti',
        'modal_heading' => 'Conferma iscrizione',
        'success' => 'Iscrizione completata!',
    ],
],
```

## Utilizzo nei Componenti Blade

```blade
{{-- CORRETTO --}}
<h2>{{ __('meetup::event_detail.sections.about_this_event.heading') }}</h2>

<span class="text-{{ __('meetup::event_detail.sections.about_this_event.color') }}-600">
    {{ __('meetup::event_detail.sections.about_this_event.label') }}
</span>

<x-heroicon-o-information-circle 
    class="w-6 h-6 text-blue-500" 
    aria-label="{{ __('meetup::event_detail.sections.about_this_event.label') }}"
/>
```

## Collegamenti

- **Documentazione Completa:** `Modules/Meetup/docs/translation-rules.md`
- **Modulo Meetup:** `Modules/Meetup/`
- **Tema Meetup:** `Themes/Meetup/`

---
**Data:** Febbraio 2026
