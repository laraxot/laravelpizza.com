# Confronto pagina Events: locale vs laravelpizza.com

## Obiettivo

Allineare `http://127.0.0.1:8000/it/events` a `https://laravelpizza.com/events` (stessa struttura, contenuti e comportamento).

## Screenshots

Salvare in questa cartella:

- **reference-events.png** – screenshot di `https://laravelpizza.com/events` (pagina di riferimento)
- **local-events-before.png** – stato di `http://127.0.0.1:8000/it/events` prima delle modifiche (opzionale)
- **local-events-after.png** – stato dopo l’implementazione (verifica parità)

Come generare gli screenshot (es. da terminale con Puppeteer/Playwright o da browser: DevTools → Capture screenshot).

## Differenze documentate (reference vs stato iniziale)

### Struttura pagina (laravelpizza.com/events)

1. **Header**
   - Titolo: "Upcoming Events"
   - Sottotitolo: "Join us for pizza and Laravel discussions"

2. **Filtri**
   - Pulsanti: "All Events" (attivo), "Upcoming", "Past Events"
   - Comportamento: filtro client-side sulla griglia (mostra tutti / solo upcoming / solo past)

3. **Griglia eventi**
   - Layout: `grid` 3 colonne (desktop), 1–2 su tablet/mobile
   - 6 card evento (3 upcoming, 3 past nel reference)

4. **Singola card evento**
   - Link alla pagina dettaglio (`/events/{id}`)
   - Badge stato: "Upcoming" (verde) o "Past"
   - Titolo evento
   - Descrizione breve
   - Data (es. December 15, 2025)
   - Orario (es. 6:00 PM - 9:00 PM)
   - Location (es. Tech Hub Downtown, 123 Main St)
   - Partecipanti (es. "5 / 30 attendees")

### Stato iniziale locale (/it/events)

- La view `pub_theme::components.blocks.events.list` **non esisteva**: il CMS mostrava "View not found".
- `events.json` definiva già il blocco `events` con `data.view` = `pub_theme::components.blocks.events.list` e array `events` con 6 eventi, ma senza campo `attendees` e con alcuni eventi diversi dal reference.

### Differenze di contenuto

- Reference: eventi 1–6 con titoli/date/location/attendees come su laravelpizza.com.
- Locale: stessa struttura ma nomi/date/attendees da allineare al reference; aggiungere `attendees_current` e `attendees_max` (o equivalente) per la riga "X / Y attendees".

## Come far funzionare tutto

### 1. Componente blocco events list

- **Path**: `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
- **Responsabilità**: ricevere `title`, `description`, `events` (e eventuali filtri); renderizzare header, filtri (All/Upcoming/Past) e griglia di card.
- **Dati per ogni evento**: `status` (upcoming|past), `title`, `description`, `date`, `time`, `location`, `attendees_current`, `attendees_max`, `url`.
- **Filtri**: implementazione client-side (es. Alpine.js) che mostra/nasconde le card in base a `data-status` o attributo derivato da `status`.

### 2. Configurazione CMS (events.json)

- **Path**: `config/local/laravelpizza/database/content/pages/events.json`
- Un solo blocco `content_blocks` per locale con:
  - `type`: `events`
  - `data.view`: `pub_theme::components.blocks.events.list`
  - `data.title`: "Upcoming Events"
  - `data.description`: "Join us for pizza and Laravel discussions"
  - `data.events`: array di 6 eventi con campi come sopra (incluso attendees).
- Nessun blocco hero/features/stats/cta sulla pagina events.

### 3. Flusso di rendering

- Route: `/it/events` → Folio `[slug].blade.php` → `<x-page side="content" slug="events" />`
- Page carica da CMS (Sushi/JSON) la pagina con `slug` = `events` e legge `content_blocks.it` (o locale corrente).
- Ogni blocco viene compilato (`HasBlocks::compile()` risolve eventuali `{{ trans() }}`), poi renderizzato con `@include($block->view, $block->data)`.
- La view `pub_theme::components.blocks.events.list` deve accettare le variabili "spacchettate" da `@include` (es. `$title`, `$description`, `$events`), oltre eventualmente a `$data` per compatibilità.

### 4. Dipendenze

- **Alpine.js**: i filtri (All Events, Upcoming, Past) usano `x-data` e `x-show`; Alpine è caricato dal tema (Vite/app.js) insieme all’header. Se i filtri non reagiscono, verificare che lo script del tema sia incluso (es. da `<x-metatags>` / build Vite).

### 5. Verifica

- Aprire `http://127.0.0.1:8000/it/events`: nessun "View not found".
- Controllare: stesso titolo/sottotitolo, stessi 3 pulsanti filtro, 6 card con badge Upcoming/Past, date, orari, location, "X / Y attendees", link al dettaglio.
- Cliccare "Upcoming" / "Past": la griglia si filtra (Alpine).
- Confrontare con screenshot di laravelpizza.com/events (reference-events.png).

## Riferimenti

- [events-page-differences-analysis.md](../events-page-differences-analysis.md) (tema)
- [events-page-differences-analysis.md](../../../modules/meetup/docs/events-page-differences-analysis.md) (modulo Meetup)
- [events-system.md](../../../modules/meetup/docs/events-system.md)
- HTML di riferimento: `Themes/Meetup/resources/html/events.html`
