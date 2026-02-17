# Architettura Eventi Dinamici - Modulo Meetup

## Data
2026-02-17

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
                    "query": {
                        "model": "Modules\\Meetup\\Models\\Event",
                        "scope": "upcoming",
                        "orderBy": "start_date",
                        "direction": "asc",
                        "limit": 50
                    }
                }
            }
        ]
    }
}
```

**Parametri query supportati:**
- `model` - Classe del modello Eloquent
- `scope` - Nome dello scope da applicare (upcoming, past, etc.)
- `orderBy` - Colonna per ordinamento (start_date, end_date, title, created_at)
- `direction` - asc o desc
- `limit` - Numero massimo di risultati

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

### 4. Pagina Dettaglio (Themes/Meetup/resources/views/pages/events/[slug].blade.php)

Folio routing con dependency injection:

```php
<?php
name('events.show');

new class extends Component
{
    public Event $event;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }
};
?>

<x-layouts.app>
    <x-blocks.events.detail :event="$event" />
</x-layouts.app>
```

**Routing:**
- URL: `/it/events/{slug}` (es. `/it/events/laravel-meetup-milano-2026`)
- Risoluzione automatica tramite `Event::getRouteKeyName()` → `'slug'`
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
                              Legge events.json
                                          ↓
                              content_blocks.events-list
                                          ↓
                              list.blade.php
                                          ↓
                              query.model = Event
                              query.scope = upcoming
                                          ↓
                              Event::upcoming()
                                  ->orderBy('start_date')
                                  ->limit(50)
                                  ->get()
                                          ↓
                              toBlockArray() per ogni evento
                                          ↓
                              Render HTML con Alpine.js filters
```

### Visualizzazione Dettaglio Evento

```
User → /it/events/laravel-meetup-milano → Folio
                                          ↓
                              events/[slug].blade.php
                                          ↓
                              Route binding: Event where slug = ?
                                          ↓
                              mount(Event $event)
                                          ↓
                              detail.blade.php
                                          ↓
                              toBlockArray() + Schema.org JSON-LD
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

## Fix Critico: HasBlocks.php (2026-02-17)

### Problema
Gli eventi non venivano caricati dal database anche se la query era configurata correttamente nel JSON. Il blocco mostrava "No events found".

### Causa
In `Modules/Cms/app/Models/Traits/HasBlocks.php`, il metodo `getBlocks()` usava `BlockData::collect($blocks)` che non chiama il costruttore personalizzato di `BlockData`. Il costruttore di `BlockData` è responsabile dell'esecuzione della query dinamica tramite `ResolveBlockQueryAction`.

### Soluzione
Modificato il metodo per creare manualmente le istanze di `BlockData` prima di passarle alla collection:

```php
// PRIMA (sbagliato)
return BlockData::collect($blocks);

// DOPO (corretto)
$blockDataInstances = array_map(function (array $block): BlockData {
    $type = $block['type'] ?? 'unknown';
    $data = $block['data'] ?? [];
    $slug = $block['slug'] ?? null;
    return new BlockData($type, $data, $slug);  // Costruttore chiama ResolveBlockQueryAction!
}, $blocks);

return BlockData::collection($blockDataInstances);
```

### File Modificato
- `Modules/Cms/app/Models/Traits/HasBlocks.php` - Metodo `getBlocks()`

### Verifica
Dopo il fix, gli eventi vengono caricati correttamente:
```bash
curl -s http://127.0.0.1:8000/it/events | grep "Laravel 11 Release Pizza Party"
# Output: Laravel 11 Release Pizza Party
```

### Screenshot
Vedi: `screenshots/local_events_full.png` e `screenshots/local_events_mobile.png`

### Fix URL Localizzati (2026-02-17)

### Problema
Gli URL degli eventi generavano `/events/<slug>` invece di `/it/events/<slug>`.

### Causa
In `Modules/Meetup/app/Models/Event.php`, il metodo `toBlockArray()` usava una path senza locale.

### Soluzione
Verificato che `LaravelLocalization::localizeURL()` aggiunge correttamente il locale:
```php
'url' => LaravelLocalization::localizeURL('/events/'.$this->slug)
```
L'URL generato è ora: `http://laravelpizza.local/it/events/laravel-11-release-pizza-party`

### File Modificato
- `Modules/Meetup/app/Models/Event.php` - Metodo `toBlockArray()` - Linea 215

### Verifica
```bash
curl -s http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party | head -20
# Output: HTML pagina dettaglio evento
```

## Riepilogo Implementazione (2026-02-17)

### Cosa Funziona
- ✅ Lista eventi: `/it/events` - Carica eventi dal database con scope, orderBy, limit configurabili
- ✅ Dettaglio evento: `/it/events/{slug}` - URL SEO-friendly basato su slug
- ✅ Query dinamica: `ResolveBlockQueryAction` esegue query configurate nel JSON
- ✅ Localizzazione: URL automatici con locale (`/it/events/`, `/en/events/`)
- ✅ Fallback: Se database vuoto, usa eventi hardcoded dal JSON

### URL SEO-Friendly
Il sistema usa slug invece di ID per migliorare la SEO:
- ❌ Prima: `/it/events/1` (ID numerico)
- ✅ Dopo: `/it/events/laravel-11-release-pizza-party` (slug descrittivo)

### Pagine Verificate
- `/it/events` - 200 OK
- `/it/events/laravel-11-release-pizza-party` - 200 OK
- `/it/events/filament-admin-panel-workshop` - 200 OK
- `/it/events/livewire-3-pizza-meetup` - 200 OK

### Screenshots
Vedi: `docs/screenshots/local_event_detail_full.png`

### Slug duplicati
L'ImportEventsFromJsonAction aggiunge counter automaticamente, ma verificare:
```sql
SELECT slug, COUNT(*) FROM meetup_events GROUP BY slug HAVING COUNT(*) > 1;
```

### Performance
Per liste grandi (>100 eventi), considerare:
```json
{
    "query": {
        "limit": 20,
        "orderBy": "start_date"
    }
}
```

## Riferimenti

- [Folio JSON-only Rule](./folio-pages-json-only-rule.md)
- [Schema.org Event Implementation](./schema-org-event-implementation.md)
- [Model Event](./../../app/Models/Event.php)
- [Import Action](./../../app/Actions/Event/ImportEventsFromJsonAction.php)
- [Folio Page](../../resources/views/pages/events/[slug].blade.php)

---

**Ultimo aggiornamento**: 2026-02-17
**Versione**: 1.0
**Autore**: AI Agent
**Stato**: Implementato e funzionante
