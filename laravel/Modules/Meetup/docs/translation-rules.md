# Regole per le Traduzioni nel Modulo Meetup

## Regola Fondamentale: Struttura Espansa (Expanded Structure)

**MAI usare chiavi di traduzione "flat". Tutte le traduzioni DEVONO essere strutturate con sotto-chiavi.**

### ❌ ERRATO (Flat Keys - MAI USARE)
```php
// NON FARE MAI QUESTO
return [
    'about_this_event' => 'About This Event',
    'event_location' => 'Event Location',
    'book_your_spot' => 'Book Your Spot',
];
```

Questo genererebbe chiavi come:
- `meetup::events.about_this_event` ❌ (flat)

### ✅ CORRETTO (Expanded Structure - OBBLIGATORIO)
```php
// SEMPRE USARE QUESTA STRUTTURA
return [
    'about_this_event' => [
        'label' => 'About This Event',
        'color' => 'blue',
        'icon' => 'heroicon-o-information-circle',
    ],
    'event_location' => [
        'label' => 'Event Location',
        'heading' => 'Location',
        'description' => 'Where the event takes place',
        'color' => 'green',
    ],
    'book_your_spot' => [
        'label' => 'Book Your Spot',
        'tooltip' => 'Reserve your place now',
        'color' => 'primary',
    ],
];
```

Questo genera chiavi strutturate:
- `meetup::events.about_this_event.label` ✅
- `meetup::events.about_this_event.color` ✅
- `meetup::events.about_this_event.icon` ✅

## Struttura Standard Obbligatoria

Ogni gruppo di traduzioni deve seguire questa gerarchia:

```php
return [
    // 1. Navigation (per Filament)
    'navigation' => [
        'label' => 'Label Singolare',
        'plural_label' => 'Label Plurale',
        'group' => 'Gruppo Navigazione',
        'icon' => 'heroicon-o-icon',
        'sort' => 10,
    ],
    
    // 2. Label principali
    'label' => 'Label Singolare',
    'plural_label' => 'Label Plurale',
    
    // 3. Fields (per form e tabelle)
    'fields' => [
        'field_name' => [
            'label' => 'Label campo',
            'placeholder' => 'Placeholder',
            'help' => 'Testo di aiuto',
            'tooltip' => 'Tooltip',
            'description' => 'Descrizione lunga',
        ],
    ],
    
    // 4. Actions (per bottoni e azioni)
    'actions' => [
        'action_name' => [
            'label' => 'Label azione',
            'modal_heading' => 'Titolo modale',
            'modal_description' => 'Descrizione modale',
            'success' => 'Messaggio successo',
            'error' => 'Messaggio errore',
            'confirmation' => 'Messaggio conferma',
        ],
    ],
    
    // 5. Sections (per sezioni pagina/blocchi)
    'sections' => [
        'section_name' => [
            'label' => 'Label sezione',
            'heading' => 'Titolo sezione',
            'description' => 'Descrizione',
            'color' => 'blue|green|red|yellow|gray',
            'icon' => 'heroicon-o-icon',
        ],
    ],
    
    // 6. Messages (per messaggi UI)
    'messages' => [
        'message_key' => [
            'title' => 'Titolo messaggio',
            'description' => 'Descrizione messaggio',
        ],
    ],
    
    // 7. Status (per badge/stati)
    'status' => [
        'status_key' => [
            'label' => 'Label stato',
            'color' => 'success|danger|warning|info',
            'badge' => 'Testo badge',
        ],
    ],
    
    // 8. Filters (per filtri tabella)
    'filters' => [
        'filter_name' => [
            'label' => 'Label filtro',
            'options' => [
                'option_1' => 'Label opzione 1',
                'option_2' => 'Label opzione 2',
            ],
        ],
    ],
];
```

## Esempi Pratici per Meetup

### Event Detail Page
```php
// Modules/Meetup/lang/it/event_detail.php
return [
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
            'description' => 'Dove si terrà l\'evento',
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
            'modal_description' => 'Sei sicuro di volerti iscrivere?',
            'success' => 'Iscrizione completata!',
            'error' => 'Errore durante l\'iscrizione',
        ],
        'share' => [
            'label' => 'Condividi',
            'tooltip' => 'Condividi l\'evento',
        ],
    ],
    
    'status' => [
        'upcoming' => [
            'label' => 'In arrivo',
            'color' => 'success',
            'badge' => 'Upcoming',
        ],
        'past' => [
            'label' => 'Passato',
            'color' => 'gray',
            'badge' => 'Past Event',
        ],
    ],
];
```

### Utilizzo nei Componenti Blade
```blade
{{-- CORRETTO --}}
<h2>{{ __('meetup::event_detail.sections.about_this_event.heading') }}</h2>
<span class="badge badge-{{ __('meetup::event_detail.sections.about_this_event.color') }}">
    {{ __('meetup::event_detail.sections.about_this_event.label') }}
</span>

{{-- Per Filament - il sistema LangServiceProvider gestisce automaticamente --}}
// Non serve specificare ->label(), prende automaticamente da:
// meetup::event.fields.title.label
TextInput::make('title')
```

## Chiavi Disponibili per Sotto-Struttura

Per ogni elemento traducibile, le sotto-chiavi standard sono:

| Chiave | Descrizione | Esempio |
|--------|-------------|---------|
| `label` | Label principale | `'label' => 'Titolo'` |
| `heading` | Titolo sezione/modale | `'heading' => 'About This Event'` |
| `description` | Descrizione/dettagli | `'description' => 'Dettagli evento'` |
| `placeholder` | Placeholder input | `'placeholder' => 'Inserisci...'` |
| `help` | Testo aiuto | `'help' => 'Info aggiuntiva'` |
| `tooltip` | Tooltip | `'tooltip' => 'Clicca qui'` |
| `color` | Colore tema | `'color' => 'blue'` |
| `icon` | Icona Heroicon | `'icon' => 'heroicon-o-user'` |
| `badge` | Testo badge | `'badge' => 'New'` |
| `sort` | Ordinamento | `'sort' => 10` |

## Verifica e Quality Gates

### Comando per verificare struttura
```bash
# Cerca chiavi flat (senza sotto-array)
grep -r "=> '.*',$" Modules/Meetup/lang/ --include="*.php" | grep -v "label\|placeholder\|help\|tooltip\|description\|color\|icon\|badge\|heading\|sort\|options"

# Cerca struttura corretta (dovrebbe trovare molti risultati)
grep -r "=> \[$" Modules/Meetup/lang/ --include="*.php"
```

### PHPStan Check
```bash
cd /var/www/html/ptvx/laravel
./vendor/bin/phpstan analyze Modules/Meetup --level=10
```

## Collegamenti

- [Documentazione Root Translations](../../../../../../../docs/translations-standards.md)
- [Xot Translation Guidelines](../xot/docs/translations.md)
- [Meetup Module](../meetup/readme.md)

## `messages.*` — messaggi UI (non campi, non azioni)

Per testi UI che non sono né campi form né azioni (es. "Nessun evento trovato", "Posti in esaurimento"):

```php
'messages' => [
    'spots_filling_fast' => [
        'label'       => 'Posti in esaurimento!',
        'description' => 'Avviso capacità quasi esaurita',
    ],
    'no_events_found' => [
        'label'       => 'Nessun evento trovato',
        'description' => 'Visualizzato quando non ci sono eventi',
    ],
    'check_back_later' => [
        'label'       => 'Torna a trovarci per i prossimi eventi.',
        'description' => 'Invito a tornare',
    ],
    'location_tba' => [
        'label'       => 'Luogo da definire',
        'description' => 'Luogo non ancora annunciato',
    ],
],
```

## Namespace corretto per il tema pubblico

Il tema pubblico usa `pub_theme::` — MAI `meetup::` per le view front-office:

```blade
{{-- ✅ CORRETTO per Themes/Meetup --}}
{{ __('pub_theme::event.fields.date.label') }}
{{ __('pub_theme::event.actions.back_to_events.label') }}
{{ __('pub_theme::event.messages.no_events_found.label') }}

{{-- ✅ CORRETTO per Modules/Meetup (admin Filament) --}}
{{ __('meetup::event.fields.date.label') }}
```
