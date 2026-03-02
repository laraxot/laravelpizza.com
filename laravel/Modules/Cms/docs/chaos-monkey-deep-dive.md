# Chaos Monkey - Deep Dive Tecnico

Analisi approfondita della catena di rendering per debugging sistematico.

## 1. Risoluzione Tenant e Path

### GetTenantNameAction

- **Input**: `$_SERVER['SERVER_NAME']` o `config('app.url')`
- **Output**: es. `local/laravelpizza` (config_path deve esistere)
- **Fallback**: `localhost` se nessun config trovato
- **Test**: `isRunningTestBench()` → path diverso (`Config/`)

### GetTenantFilePathAction

- **Path**: `base_path('config/'.$tenantName.'/'.$filename)`
- **Esempio**: `database/content/pages` → `config/local/laravelpizza/database/content/pages`
- **SushiToJsons**: `filePath('database/content/pages')` = directory, poi `File::glob($path.'/*.json')`

### Config xra.php

- **Path**: `config/local/laravelpizza/xra.php`
- **Chiavi critiche**: `pub_theme`, `register_pub_theme`, `primary_lang`
- **Se mancante**: XotData::make() può fallire

## 2. SushiToJsons - Caricamento JSON

### Flusso Page

1. `Page::getRows()` → `getSushiRows()`
2. `$path = TenantService::filePath('database/content/pages')`
3. `$files = File::glob($path.'/*.json')`
4. Per ogni file: estrae campi dallo `schema` del model
5. **Slug**: letto da `$json['slug']` nel file, NON dal nome file
6. **Naming**: `events_view.json` → slug nel JSON = `events.view`

### Schema Page

```php
'id', 'title', 'slug', 'middleware', 'content', 'description',
'content_blocks', 'sidebar_blocks', 'footer_blocks', 'created_at', ...
```

## 3. Propagazione container0/slug0

### Catena

1. `[container0]/[slug0]/index.blade.php` → Volt con `$container0`, `$slug0` da Folio
2. `$data = ['container0' => ..., 'slug0' => ...]`
3. `<x-page :data="$data" />` → Page component
4. Page::render() passa `view_params`: `container0`, `slug0`, `blocks`, `data`, ...
5. `page.blade.php` riceve `$container0`, `$slug0` (scope)
6. `@include($block->view, $block->data)` → le view incluse **ereditano** lo scope parent
7. **events/detail.blade.php** ha accesso a `$container0`, `$slug0` dallo scope

### Critico

Se `page.blade.php` non riceve `container0`/`slug0` (es. da `[slug].blade.php`), le view incluse non le hanno. Per `[slug].blade.php` il Page è chiamato senza `:data` → `$data = []` → `container0` e `slug0` vuoti.

## 4. BlockData e ResolveBlockQueryAction

### BlockData constructor

1. Merge `data.query` → `ResolveBlockQueryAction::execute()` → merge risultato in `$data`
2. `$data['view']` obbligatorio
3. Se view non esiste → `throw new \Exception('view not found: '.$view)`
4. **wrap_in**: default `items`; events.json usa `events` → merge `['events' => [...]]`

### ResolveBlockQueryAction

- **model** inesistente → ritorna `[]`
- **scope** inesistente → `BadMethodCallException` catchata, skip
- **toBlockArray()**: se model ce l'ha, usa quello; altrimenti `toArray()`

## 5. events/list - Doppia sorgente dati

### Path A: BlockData (preferito)

- `data.query` in JSON → ResolveBlockQueryAction in BlockData
- Merge `['events' => $transformedItems]` (wrap_in: events)
- View riceve `$data['events']` popolato

### Path B: Fallback nella view

- Se `$data['events']` vuoto E `$data['query']` presente
- List esegue query manualmente (duplicazione logica)
- **Rischio**: divergenza tra BlockData e fallback (orderBy, scope, limit)

## 6. Event::toBlockArray() - Contratto

### Campi obbligatori per events/list

- `id`, `slug`, `status`, `title`, `description`, `date`, `time`, `location`
- **`url`**: `LaravelLocalization::localizeUrl('/events/'.$this->slug)` - CRITICO
- `attendees_current`, `attendees_max`, `image`

### events/detail - Props

- `$event`, `$item`, `$container0`, `$slug0` (da scope Blade)
- Se `slug0` presente: `Event::where('slug', $this->slug0)->first()`

## 7. Punti di rottura ad alta probabilità

| Rottura | Sintomo | Fix |
|---------|---------|-----|
| Tenant path errato | Page non carica, Sushi vuoto | GetTenantNameAction, APP_URL, config/local |
| pub_theme non registrato | view not found pub_theme:: | CmsServiceProvider, register_pub_theme |
| data.view inesistente | Exception in BlockData | Verificare file Blade nel tema |
| wrap_in sbagliato | events list vuota | wrap_in: "events" in JSON, list cerca $data['events'] |
| toBlockArray senza url | Link senza locale | Aggiungere url in Event::toBlockArray() |
| slug0 non propagato | Detail 404 | Page deve ricevere :data con container0, slug0 |
| events.view mancante | /events/slug 500 | Creare events_view.json con slug events.view |

## 8. File canonici (ordine debug)

1. `config/local/{tenant}/xra.php` - pub_theme, register_pub_theme
2. `GetTenantNameAction`, `GetTenantFilePathAction`
3. `FolioVoltServiceProvider` - path tema, uri locale
4. `CmsServiceProvider` - registerNamespaces pub_theme
5. `ThemeServiceProvider` - loadViewsFrom, loadTranslationsFrom
6. `config/local/{tenant}/database/content/pages/*.json`
7. `Page`, `HasBlocks`, `BlockData`, `ResolveBlockQueryAction`
8. `Event::toBlockArray()`
9. `events/list.blade.php`, `events/detail.blade.php`

## Collegamenti

- [template-theme-cms-reference](template-theme-cms-reference.md)
- [chaos-monkey-recovery-playbook](chaos-monkey-recovery-playbook.md)
- [chaos-monkey-event-rendering-playbook](../../Meetup/docs/chaos-monkey-event-rendering-playbook.md)
