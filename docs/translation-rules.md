# Regole per le Traduzioni — Meetup Theme (pub_theme)

## Struttura obbligatoria

Le traduzioni del tema pubblico usano il namespace `pub_theme::` che mappa a `Themes/Meetup/lang/{locale}/`.

**MAI chiavi flat. SEMPRE struttura espansa con sotto-chiavi.**

## Gerarchia dei file

```
Themes/Meetup/lang/{locale}/
├── event.php       # Evento singolo (detail page)
├── events.php      # Lista eventi
├── home.php        # Home page
└── navigation.php  # Navigazione
```

## Struttura standard per `event.php`

```php
return [
    'navigation' => [           // Metadati risorsa Filament
        'label' => '...',
        'plural_label' => '...',
        'group' => 'Meetup',
        'icon' => 'heroicon-o-calendar',
        'sort' => 11,
    ],
    'label' => '...',           // Singolare
    'plural_label' => '...',    // Plurale

    'fields' => [               // Campi form/tabella
        'field_name' => [
            'label'       => '...',
            'placeholder' => '...',
            'tooltip'     => '...',
            'helper_text' => '',
            'description' => '...',
            'icon'        => 'heroicon-o-...',
            'color'       => 'primary',
        ],
    ],

    'actions' => [              // Azioni/bottoni
        'action_name' => [
            'label'       => '...',
            'placeholder' => '',
            'tooltip'     => '...',
            'helper_text' => '',
            'description' => '...',
            'icon'        => 'heroicon-o-...',
            'color'       => 'primary',
        ],
    ],

    'status' => [               // Stati/badge
        'upcoming' => ['label' => '...'],
        'past'     => ['label' => '...'],
    ],

    'not_found' => [            // Errore 404 Filament
        'label' => '...',
    ],
    'not_found_description' => [
        'label' => '...',
    ],

    'messages' => [             // Messaggi UI (non campi, non azioni)
        'message_key' => [
            'label'       => '...',
            'description' => '...',
        ],
    ],
];
```

## Chiavi attualmente implementate (event.php)

### `fields.*`
- `date`, `time`, `location`, `about_this_event`
- `attendees`, `people_joined` (usa `:count` come parametro)
- `topics`, `spots_available`, `free_entry`
- `name`, `email` (modal prenotazione)

### `actions.*`
- `share_event`, `view_map`, `rsvp_now`, `sign_in_to_rsvp`
- `back_to_events`, `confirm_booking`, `cancel`

### `messages.*`
- `spots_filling_fast`, `no_events_found`, `check_back_later`, `location_tba`

## Utilizzo nei Blade

```blade
{{-- ✅ CORRETTO: struttura fields --}}
{{ __('pub_theme::event.fields.date.label') }}
{{ __('pub_theme::event.fields.people_joined.label', ['count' => $count]) }}

{{-- ✅ CORRETTO: struttura actions --}}
{{ __('pub_theme::event.actions.back_to_events.label') }}
{{ __('pub_theme::event.actions.share_event.label') }}

{{-- ✅ CORRETTO: struttura messages --}}
{{ __('pub_theme::event.messages.spots_filling_fast.label') }}
{{ __('pub_theme::event.messages.no_events_found.label') }}

{{-- ✅ CORRETTO: struttura status --}}
{{ __('pub_theme::event.status.upcoming.label') }}

{{-- ❌ ERRATO: chiave flat (rimossa) --}}
{{ __('pub_theme::event.date.label') }}
{{ __('pub_theme::event.share_event.label') }}
```

## Regole anti-flat

Le chiavi "piatte" (ex: `pub_theme::event.date.label`) sono **vietate** perché:
1. Duplicano `fields.date.label` — violano DRY
2. Non portano `tooltip`, `placeholder`, `description` — non estendibili
3. Il blade non le usa più — sono dead code

Se serve accedere a un campo nelle view, si usa sempre `fields.{name}.label`.

## Lingue supportate

`it` (primaria) · `en` · `es` · `de` · `fr` · `ru` · `hi` · `zh`

## Riferimenti

- Filosofia Laraxot: `Modules/Xot/docs/best-practices/translations-best-practices.md`
- Localizzazione URL: `Modules/Lang/docs/laravel-localization-mcamara.md`
