# events page differences analysis - tema meetup

## data
2025-11-30

## obiettivo
allineare la resa visuale di `/it/events` al design di `https://laravelpizza.com/events`, partendo dalla versione statica:
- `Themes/Meetup/resources/html/events.html`
e mappandola sulla pipeline:
- `Themes/Meetup/resources/views/pages/[slug].blade.php` (folio)
- `config/local/laravelpizza/database/content/pages/events.json` (blocchi)
- `Themes/Meetup/resources/views/components/blocks/events/list.blade.php` (lista eventi).

## stato attuale

### folio page
`Themes/Meetup/resources/views/pages/[slug].blade.php`:
- layout: `<x-layouts.app>`
- contenuto:
  - `@volt('pages.view')`
  - `<x-page side="content" :slug="$slug" />`

quindi `/it/events` risolve slug `events` e carica `events.json`.

### configurazione cms (`events.json`)
attuale configurazione (semplificata):
- blocco `hero` con `pub_theme::components.blocks.hero.main`
- blocco `features` con `pub_theme::components.blocks.features.grid`
- blocco `stats` con `pub_theme::components.blocks.stats.overview`
- blocco `cta` con `pub_theme::components.blocks.cta.banner`

→ la pagina eventi è visivamente quasi identica alla home, non focalizzata sugli eventi.

### componente lista eventi
`Themes/Meetup/resources/views/components/blocks/events/list.blade.php`:
- sezione con:
  - titolo: `{{ $data['title'] ?? 'Upcoming Events' }}`
  - descrizione: `{{ $data['description'] ?? 'Join us at our next meetup' }}`
  - grid `md:grid-cols-3` che itera su `data['events']`
  - card evento con:
    - categoria (`category`)
    - titolo (`title`)
    - data + orario (`date`, `time`)
    - location (`location`)
    - link dettagli (`url`).

**problema**: `events.json` non popola `data.events` e nemmeno usa `events.list` come `view`.

## design target (events.html)

caratteristiche principali della pagina statica:

1. **header**:
   - `Upcoming Events`
   - `Join us for pizza and Laravel discussions`

2. **filter buttons**:
   - `All Events`
   - `Upcoming`
   - `Past`

3. **events grid** (`#events-grid`):
   - 3 card `Upcoming`
   - 3 card `Past`
   - ogni card contiene:
     - titolo evento
     - descrizione breve
     - data
     - orario
     - location
     - badge di stato (`Upcoming` / `Past`).

## differenze visuali principali

1. **layout pagina**
   - attuale `/it/events`: hero + sezioni generiche (features, stats, cta)
   - desiderato: header + filtri + lista eventi (nessun hero grande).

2. **contenuto centrale**
   - attuale: narrativa generica sulla community
   - desiderato: focus sulle schede evento.

3. **interattività**
   - statica: filtri `All / Upcoming / Past` (gestiti via js)
   - attuale: nessun filtro, nessun blocco dedicato agli eventi.

## decisioni di design per il tema

1. **spostare la logica eventi in un blocco dedicato**:
   - usare `pub_theme::components.blocks.events.list` come `view` principale per la pagina
   - configurare `events.json` con:
     - titolo e descrizione presi dall’header statico
     - array `events` mappato dalle card statiche.

2. **header + grid in un unico blocco**
   - per semplicità e coerenza con la home, il blocco `events.list` includerà:
     - titolo + descrizione
     - (opzionale) filtri
     - grid di card evento.

3. **filtri**
   - prima fase: replicare la grid e la struttura visuale
   - fase successiva: aggiungere supporto ai filtri via js (eventualmente usando dati `status` negli eventi).

## passi successivi (implementazione tecnica)

1. aggiornare `events.json`:
   - sostituire i blocchi hero/features/stats/cta con un singolo blocco:
     - `view`: `pub_theme::components.blocks.events.list`
     - `title`: `Upcoming Events`
     - `description`: `Join us for pizza and Laravel discussions`
     - `events`: lista eventi statici (mappati da `events.html`).

2. verificare/coordinare con il modulo meetup:
   - documentazione: `Modules/Meetup/docs/events-page-differences-analysis.md`
   - regole critiche: `Modules/Meetup/docs/critical-rules-consolidated.md`

3. rifinitura visiva:
   - controllare spacing, colori e tipografia rispetto a `events.html`
   - eventualmente estendere `events/list.blade.php` per badge `Upcoming/Past`.

## riferimenti

- `Themes/Meetup/resources/html/events.html`
- `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
- `config/local/laravelpizza/database/content/pages/events.json`
- `Modules/Meetup/docs/events-page-differences-analysis.md`


