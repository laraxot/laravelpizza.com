# events page differences analysis

## data
[DATE]

## obiettivo
allineare la pagina `/it/events` (folio + volt + blocchi cms) al design di `https://laravelpizza.com/events`, utilizzando:
- `Themes/Meetup/resources/views/pages/[slug].blade.php` per il routing folio
- `config/local/laravelpizza/database/content/pages/events.json` per la definizione dei blocchi
- componenti blade del tema `Meetup` (`pub_theme::components.blocks.*`)

## stato attuale

### routing
- folio usa `Themes/Meetup/resources/views/pages/[slug].blade.php`:
  - `name('pages.view')`
  - `middleware(PageSlugMiddleware::class)`
  - layout: `<x-layouts.app>`
  - contenuto: `<x-page side="content" :slug="$slug" />`
- quindi `/it/events` risolve slug `events` e carica `events.json`.

### configurazione cms (`events.json`)
attualmente `events.json` è configurato correttamente con il blocco eventi:
```json
{
    "type": "events",
    "slug": "events-list",
    "data": {
        "view": "pub_theme::components.blocks.events.list",
        "title": "Upcoming Events",
        "description": "Join us for pizza and Laravel discussions",
        "query": {
            "model": "Modules\\Meetup\\Models\\Event",
            "scope": "upcoming",
            "orderBy": "start_date",
            "direction": "asc",
            "limit": 50
        }
    }
}
```

**Nota**: Gli eventi sono caricati dinamicamente dal database usando il modello `Event`. Gli slug sono generati automaticamente durante l'importazione.

### componente eventi
esiste già il componente:
- `pub_theme::components.blocks.events.list` → `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
  - accetta `@props(['data'])`
  - si aspetta `data['events']` come array di eventi
  - renderizza una grid `md:grid-cols-3` con card evento.

## design target (`laravelpizza.com/events`)

dalla versione statica `Themes/Meetup/resources/html/events.html`:
- **header sezione**:
  - titolo: `Upcoming Events`
  - sottotitolo: `Join us for pizza and Laravel discussions`
- **filter buttons**:
  - `All Events`
  - `Upcoming`
  - `Past`
- **events grid**:
  - 6 card evento (3 upcoming, 3 past)
  - per ogni card:
    - titolo evento
    - descrizione breve
    - data, orario
    - location
    - stato (badge `Upcoming` / `Past`)

## differenze principali

1. **tipo di contenuto**
   - **attuale /events**: hero + features + stats + cta (copiato da home)
   - **desiderato /events**: header semplice + filtri + lista eventi

2. **blocco cms usato**
   - attuale: nessun uso di `pub_theme::components.blocks.events.list`
   - desiderato: blocco dedicato `events.list` con lista eventi.

3. **dati eventi**
   - attuale: nessun array `events` in `events.json`
   - desiderato: array strutturato di eventi (categoria, titolo, descrizione, data, orario, location, url, status).

4. **esperienza utente**
   - attuale: pagina molto simile alla home, non focalizzata sugli eventi
   - desiderato: pagina focalizzata sulla scoperta degli eventi (listing + filtri).

## piano di correzione

1. **aggiornare `events.json`**:
   - rimuovere i blocchi `hero`, `features`, `stats`, `cta` ereditati dalla home
   - definire un unico blocco:
     - `type`: `events`
     - `slug`: `events-list`
     - `data.view`: `pub_theme::components.blocks.events.list`
     - `data.title`: `Upcoming Events`
     - `data.description`: `Join us for pizza and Laravel discussions`
     - `data.events`: array di eventi (mappati dal markup statico).

2. **allineare il componente `events/list.blade.php`**:
   - utilizzare `title`, `description` e `events` passati dal json
   - opzionale: aggiungere supporto a `status` (`upcoming` / `past`) per eventuali badge e filtri js.

3. **verifica architetturale**:
   - confermare che `x-page` → `BlockData` → `page-content` includa correttamente `pub_theme::components.blocks.events.list` con i dati `events`.

4. **documentazione**:
   - questo file (`events-page-differences-analysis.md`) nel modulo meetup
   - file gemello nel tema meetup con focus più visuale.

## checklist

- [x] identificato flusso `/it/events` → `[slug].blade.php` → `events.json`
- [x] confrontato `events.json` con `events.html` statico
- [x] elencate differenze architetturali e di contenuto
- [ ] aggiornare `events.json` con blocco `events.list`
- [ ] adeguare (se necessario) `events/list.blade.php`
- [ ] verificare rendering `/it/events` rispetto a `laravelpizza.com/events`
- [ ] aggiornare eventuali regole in `critical-rules-consolidated.md` se emergono nuovi pattern
