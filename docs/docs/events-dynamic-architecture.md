# Architettura Eventi Dinamici - Modulo Meetup

## Panoramica

Il sistema eventi del modulo Meetup utilizza un'architettura **dinamica e configurabile via JSON** che permette di:

1. Caricare eventi dal database usando scope, ordinamenti e limit configurabili
2. Visualizzare eventi hardcoded solo quando necessario (fallback)
3. Supportare SEO con URL basati su slug (non ID numerici)
4. Riutilizzare la stessa configurazione JSON in contesti diversi

## Struttura Architetturale

### 1. Modello Event (Modules/Meetup/app/Models/Event.php)

Il modello fornisce:

**Campi principali:**
- `slug` - Identificatore SEO-friendly univoco
- `title`, `description` - Contenuto evento
- `start_date`, `end_date` - Date e orari
- `location` - Luogo dell'evento
- `event_status`, `event_attendance_mode` - Enum Schema.org
- `attendees_count`, `max_attendees` - Capacità

**Scope disponibili:**
```php
// Filtra eventi futuri
Event::upcoming()->get();

// Filtra eventi passati  
Event::past()->get();

// Filtra per stato
Event::filter('upcoming')->get();

// Ordinamenti
Event::orderBy('start_date', 'asc')->get();
Event::orderByTitle()->get();

// Limitazione
Event::limit(10)->get();
```

**Metodi helper:**
```php
// Trasforma in array per blocchi CMS
$event->toBlockArray();

// Genera dati Schema.org
$event->toSchemaOrg();

// Recupera per slug
Event::getBySlug('mio-evento-2026');
```

### 2. Configurazione JSON (config/local/laravelpizza/database/content/pages/events.json)

```json
{
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "events-list",
                "data": {
                    "view": "pub_theme::components.blocks.events.list",
                    "title": "Upcoming Events",
                    "description": "Join us for pizza and Laravel discussions",
                    "query": {
                        "model": "Modules\\Meetup\\Models\\Event",
                        "orderBy": "start_date",
                        "direction": "asc",
                        "limit": 50,
                        "wrap_in": "events"
                    }
                }
            }
        ]
    }
}
```

**Nota:** Non viene specificato `scope` perche' il filtraggio (All/Upcoming/Past) avviene client-side con Alpine.js. Se si specificasse `scope: "upcoming"`, il filtro "Past Events" non mostrerebbe risultati.

**Parametri query supportati:**
- `model` - Classe del modello Eloquent (FQCN con doppio backslash)
- `scope` - (opzionale) Nome dello scope da applicare (upcoming, past, etc.)
- `orderBy` - Colonna per ordinamento (start_date, end_date, title, created_at)
- `direction` - asc o desc
- `limit` - Numero massimo di risultati
- `wrap_in` - (opzionale) Nome della chiave wrapper per i dati passati alla view

### 3. Componente List (Themes/Meetup/resources/views/components/blocks/events/list.blade.php)

Il componente implementa la logica di fallback:

1. **Prima priorità**: Usa eventi passati via `events` prop (hardcoded)
2. **Seconda priorità**: Carica dal database usando `query` config
3. **Filtraggio client-side**: Alpine.js per filtri (all, upcoming, past)

```php
// Logica di caricamento dinamico
if (empty($eventsData) && isset($data['query'])) {
    $queryConfig = $data['query'];
    $modelClass = $queryConfig['model'] ?? null;
    $scope = $queryConfig['scope'] ?? null;
    // ... applica scope, orderBy, limit
    $eventsModels = $model->limit($limit)->get();
    $eventsData = $eventsModels->map(fn ($item) => $item->toBlockArray());
}
```

### 4. Pagina Dettaglio (Themes/Meetup/resources/views/pages/events/[.Modules.Meetup.Models.Event].blade.php)

Folio routing con model binding automatico:

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\name;
name('events.show');
?>

<x-layouts.app>
    <x-blocks.events.detail :event="$event" />
</x-layouts.app>
```

**Routing:**
- URL: `/it/events/{slug}` (es. `/it/events/laravel-meetup-milano-2026`)
- File: `[.Modules.Meetup.Models.Event].blade.php` — Folio model binding con FQCN (dots al posto di backslash)
- Risoluzione automatica tramite `Event::getRouteKeyName()` → `'slug'`
- La variabile `$event` e' iniettata automaticamente da Folio (no Volt mount necessario)
- SEO-friendly, nessun ID numerico esposto

### 5. Importazione Dati (Modules/Meetup/app/Actions/Event/ImportEventsFromJsonAction.php)

Action che importa eventi da JSON a database:

```php
// Esegue importazione
app(ImportEventsFromJsonAction::class)->execute();

// Supporta formati:
// 1. database/json/events.json {"events": [...]}
// 2. database/json/events/*.json (file individuali)
```

Genera automaticamente slug univoci:
```php
private function generateSlug(string $title): string
{
    $slug = Str::slug($title);
    // Ensure unique con counter
    return $slug; // es. "laravel-meetup-milano-2026-1"
}
```

## Flusso Dati

### Visualizzazione Lista Eventi

```
User → /it/events → Folio → [slug].blade.php → Page component
                                          ↓
                              Legge events.json (SushiToJsons)
                                          ↓
                              content_blocks.events-list
                                          ↓
                              list.blade.php
                                          ↓
                              query.model = Event
                              (no scope = tutti gli eventi)
                                          ↓
                              Event::query()
                                  ->orderBy('start_date', 'asc')
                                  ->limit(50)
                                  ->get()
                                          ↓
                              toBlockArray() per ogni evento
                              (include slug, url localizzato, status)
                                          ↓
                              Js::from() → Alpine.js x-for + filtri client-side
```

### Visualizzazione Dettaglio Evento

```
User → /it/events/laravel-meetup-milano → Folio
                                          ↓
                              events/[.Modules.Meetup.Models.Event].blade.php
                                          ↓
                              Folio model binding: Event where slug = ?
                              (getRouteKeyName() = 'slug')
                                          ↓
                              $event iniettato automaticamente
                                          ↓
                              detail.blade.php
                                          ↓
                              Render completo + Schema.org JSON-LD
```

## Vantaggi dell'Architettura

1. **Configurabile**: Cambiare scope/ordine/limit senza toccare codice
2. **Riutilizzabile**: Stesso JSON per homepage, pagina eventi, sidebar
3. **SEO-first**: URL con slug leggibili e significativi
4. **Performance**: Query con scope e limit ottimizzati
5. **Type-safe**: PHPStan Level 10 compliant
6. **Fallback**: Supporto eventi hardcoded se database vuoto

## Convenzioni

### Namespace
- Model: `Modules\Meetup\Models\Event` (senza segmento App)
- Action: `Modules\Meetup\Actions\Event\*`
- Componenti: `pub_theme::components.blocks.events.*`

### Naming Files
- Pagina Folio: `[slug].blade.php` (lowercase, kebab-case per multi-parola)
- Componenti: `list.blade.php`, `detail.blade.php` (nomi descrittivi)
- JSON: `{slug}.json` in `config/local/laravelpizza/database/content/pages/`

## Troubleshooting

### Eventi non appaiono
1. Verificare importazione: `php artisan meetup:import-events`
2. Controllare scope in JSON: `upcoming` richiede date future
3. Verificare limit: troppo basso potrebbe nascondere eventi

## Fix Noti

### HasBlocks.php - BlockData::collect non eseguiva query
`BlockData::collect($blocks)` non chiamava il costruttore personalizzato. Risolto creando manualmente le istanze prima della collection.

### URL Localizzati - toBlockArray()
URL eventi ora generati con `LaravelLocalization::localizeUrl('/events/'.$this->slug)` — aggiunge automaticamente il prefisso locale (`/it/`, `/en/`).

### Null Safety - start_date
`toBlockArray()` e `toSchemaOrg()` ora usano `$this->start_date ?? Carbon::now()` per gestire eventi con date nulle.

### Scope "upcoming" rimosso da events.json
Lo scope filtrava solo eventi futuri server-side, rendendo inutile il filtro "Past Events" client-side di Alpine.js. Rimosso per caricare tutti gli eventi.

## Stato Funzionante

- `/it/events` - Lista eventi dal database con filtri Alpine.js (All/Upcoming/Past)
- `/it/events/{slug}` - Dettaglio evento con Folio model binding
- URL SEO-friendly con slug (non ID numerici)
- Localizzazione automatica URL
- Schema.org JSON-LD per SEO

## Riferimenti

- [Folio JSON-only Rule](./folio-pages-json-only-rule.md)
- [Schema.org Event Implementation](./schema-org-event-implementation.md)
- [Model Event](./../../app/Models/Event.php)
- [Import Action](./../../app/Actions/Event/ImportEventsFromJsonAction.php)
- [Folio Page](../../resources/views/pages/events/[.Modules.Meetup.Models.Event].blade.php)
