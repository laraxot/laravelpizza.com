---
id: dcp-152
title: "DCP-152: marker del dettaglio ticket con tipo e stato, pulsanti della mappa opachi nelle pagine DC"
type: story
epic: dc-parity-v2
status: done
priority: P1
owner: module:Geo
created: 2026-10-14
updated: 2026-10-14
qmd: "marker dettaglio ticket nero punto interrogativo coordinate-picker-lit markerCardStylesText ctrl-btn trasparente data-dc reset button usa la mia posizione http"
related: [dcp-148, dcp-127, dcp-146, dcp-93]
---

# DCP-152: marker e pulsanti del picker nelle pagine ospiti

## Segnalazioni dell'utente (2026-10-14)
1. `/it/tickets/66`: il marker e' nero, piccolo, con un punto di domanda a fianco. «In questa situazione sappiamo quale e' il tipo di ticket.»
2. Passo 2 del wizard (`/it/tickets/create?step=form.dati-di-segnalazione::data::wizard-step`): i pulsanti dentro la mappa hanno sfondo trasparente; «usa la posizione corrente» non funziona.

## Fase BMAD
Bugfix: analisi, test rosso, fix, verifica, second brain.

## Cause (riprodotte con Playwright, non ipotizzate)
1. **Tre difetti sovrapposti.**
   - `coordinate-picker-lit` iniettava `mapStylesText` ma non `markerCardStylesText` (lo faceva solo `map-lit`): il cerchio del marker non aveva sfondo e il pin SVG (`currentColor`) usciva nero. Misura: `background-color: rgba(0,0,0,0)`.
   - `createGeoMapLeafletIcon` aggiungeva l'iniziale del tipo (`?` se l'etichetta e' vuota) anche quando disegnava il pin di default: il «punto di domanda a fianco».
   - La sola lettura creava il marker senza tipo ne' colore (`createGeoMapLeafletIcon(L)`), anche se la pagina conosce tipo e stato.
2. **Pulsanti.** `body:has(.page-content[data-dc]) button { background: transparent; border: 0; border-radius: 0 }` (specificita' 0,2,2) batte `.ctrl-btn` (0,1,0); le regole del tema per `coordinate-picker-lit .ctrl-btn` sono spente nelle pagine `data-dc` dal plugin PostCSS `isolate-legacy-important` (stessa famiglia di [[leaflet-css-guard-data-dc-static-panes]]).
3. **«Usa la posizione».** Dove il browser consente il GPS funziona (sonda geo-picker-centering-probe, scenario b: centro e marker sul punto, zoom 14). Su `http://192.168.1.40:8000` il browser vieta `navigator.geolocation` (origine non sicura): nessun codice puo' leggerlo. Resta il comportamento deciso in DCP-127/146 (zona di partenza + invito neutro, niente IP di terzi, niente testo HTTPS). Non e' un difetto del pulsante. In piu' il proxy HTTPS di sviluppo (`:8080`) era SPENTO (nessun listener su 8080/8081): l'unica via per il GPS non esisteva. Riavviato il 2026-10-14 (`artisan serve` su 127.0.0.1:8081 + `scripts/dev-https-proxy.mjs`); `https://192.168.1.40:8080/it/tickets/37` risponde 200, `isSecureContext` true, marker corretto; HTTP su :8080 -> 307 a HTTPS.

## Fix (minimo, nel modulo owner)
- `coordinate-picker-lit.js`: inietta `markerCardStylesText`; nuovi attributi `marker-icon-url`, `marker-color`, `marker-label` (tutti opzionali).
- `map/events.js`: `createGeoMapLeafletIcon(L, ctx.markerColor, ctx.markerIconUrl, ctx.markerLabel)`.
- `map/marker-config.js`: l'iniziale compare solo se l'icona del tipo era indicata ma non e' utilizzabile.
- `map/styles.js`: `.map-container .ctrl-btn.ctrl-btn` (0,3,0, senza `!important`) ripristina sfondo, bordo e raggio.
- Tema Sixteen `ticket-detail/design-comuni.blade.php`: passa icona e colore con le due Action che costruiscono gia' il GeoJSON (`ResolveTicketTypeMarkerPropertiesAction`, `ResolveTicketStatusMarkerPropertiesAction`); `BuildPublicTicketDetailAction` e il suo test dell'insieme esatto di chiavi non cambiano.

## Prove
- Pest `Modules/Fixcity/tests/Feature/Pages/TicketPublicDetailPageTest.php`: caso «map marker» (rosso prima: attributi assenti), 17/17 verdi.
- Playwright `Themes/Sixteen/tests/browser/ticket-detail-marker.spec.mjs` (nuovo, 1/1) e caso «i pulsanti dei controlli hanno sfondo opaco...» in `wizard-step2-map-center.spec.mjs` (11/11).
- A pixel: ticket 37 (`parks_and_gardens`, `in_progress`): cerchio #ea580c con glifo del tipo, nessun `?`. Pulsanti del wizard: `rgb(255,255,255)`, bordo 1px, raggio 8px (prima trasparenti e senza bordo). Marker del wizard dopo due clic: cerchio blu DC con pin, nessun `?`.
- Ticket 66 (proprietario, `pending`, non visibile all'ospite): tipo `sewage_and_drainage` -> `sewage-and-drainage.svg` esiste, stato `pending` -> #f59e0b. Non aperto da loggato come proprietario (nessuna sua credenziale): provato con un ticket pubblico equivalente.
- Build: tema (`npx vite build` con lock) e bundle Geo del back office.

## Aperto (decisioni dell'utente)
- Su HTTP LAN il GPS e' impossibile per specifica del browser. Per provarlo davvero: `https://192.168.1.40:8080` (proxy di sviluppo, [[dev-https-proxy]]), accettando il certificato (`/fixcity-dev.crt`) e il permesso di posizione. Il proxy non parte da solo dopo un riavvio della macchina. Il pulsante in wizard sull'origine HTTPS reale non e' stato provato da loggato (nessuna credenziale dell'utente): provato su 127.0.0.1 con GPS simulato (sonda scenario b). Se si vuole un feedback piu' esplicito sul pulsante in HTTP serve rivedere la decisione «nessun messaggio su HTTPS» (D20).
- Marker del dettaglio per ticket con tipo non valido: usa `other.svg` (comportamento delle Action esistenti).

## Swarm 2026-10-14 (regola utente: parallelo, ordine random, swarm + subagent + BMAD + second brain)
Lead: sessione Claude principale. Lo swarm MCP (`swarm_init`, `claims_*`) non e' caricabile in questa sessione: il coordinamento e' questa tabella. Ordine di lancio estratto con `shuf`: P6, P5, P1, P2, P3, P4. Ogni pacchetto ha file DISGIUNTI; i subagent NON modificano questa story: riportano evidenza al lead, che aggiorna la tabella. Regola dei peer: file con mtime degli ultimi 5 minuti non propri = lavoro in corso di un altro agente (e' attiva un'altra sessione Claude dal 05:50 e ci sono codex/opencode): non toccarli, segnalarli.

| Pacchetto | Ambito (solo questi file) | Stato | Evidenza |
|---|---|---|---|
| P6-DOCS-SIXTEEN | `Themes/Sixteen/docs/**` (esclusi `prompts/**`) | chiuso 06:3x, 73 tool | `bmad/stories/00-REGISTRO-COMPLETO.md` (207 story prima irraggiungibili), 127 link riparati in 62 file (lead: 132 link nuovi tutti esistenti), doc `/it/tickets/{id}` corrette; registro DCP-97 completato dal lead (145-152) |
| P5-DOCS-FIXCITY | `Modules/Fixcity/docs/**` | chiuso 06:3x, 34 tool | indice concepts 14 -> 120 su 120 (lead: 0 voci morte), `stories/index.md` +42 story, concept del dettaglio riscritto sul codice |
| P1-VERIFY-UI | sola lettura sul codice; scrive solo nello scratchpad | claim 06:2x | |
| P2-PHPSTAN-GEO | `Modules/Geo/app/**`, `Modules/Geo/tests/**` (solo PHP) | chiuso 06:3x, 5 tool | PHPStan Geo gia' a 0 prima e dopo, nessun file modificato; lead: rilanciato, `errors 0` |
| P3-PHPSTAN-FIXCITY | `Modules/Fixcity/app/**`, `Modules/Fixcity/tests/**` (solo PHP) | chiuso 06:4x, 57 tool, PARZIALE | PHPStan Fixcity 128 -> 108 (lead: rilanciato, 108 = 105 `noEnvCallsOutsideOfConfig` + 3 `class.notFound` orbit). Corretti: `config/morph_map.php` (12 chiavi duplicate), `config/comments.php` (classe inesistente -> `Modules\Comment\...\NotifyApprovedCommentAction`), `config/database.php`, 3 test. DB dev invariato (18 ticket, 11 utenti). Residuo: DECISIONE UTENTE sui 14 file `Modules/Fixcity/config/*.php` copiati da `config/eu/fixcity/` |
| P4-DOCS-GEO | `Modules/Geo/docs/**` (non `stories/2026-10-14-dcp-152*`) | chiuso 06:4x, 85 tool | `docs/DOCS-MIGRATION-MAP.md` (622 righe, stato proposto, nulla spostato), `INDEX.md` unico (00-INDEX/00-index superseded), concepts 148/148 elencati, 340 link riparati (lead: 479 link nuovi tutti esistenti, 265/317 sostituzioni sono solo maiuscole), 8 affermazioni false corrette (lead: `import 'leaflet.heat'` r.18 di `geo-map-lit.js` confermato). AVVISO: `wiki/.gitignore` ignora `concepts/` (147 file tracciati con force-add): `git add -f` per i nuovi |

### Conflitto con un peer (2026-10-14 06:27)
Un altro agente, con gli stessi prompt, ha riscritto `renderButton` in `Modules/Geo/resources/js/components/map/controls/geolocation.js` con uno stile inline verde `#007a52` solo sul pulsante «posizione» (gli altri cinque restano bianchi: incoerente) e un `@focus-visible`, che non e' un evento DOM (codice morto). Il bundle servito non lo conteneva ancora (0 occorrenze di `005c3d`). Poiche' la causa vera (reset `button` delle pagine data-dc, specificita' 0,2,2) e' risolta per tutti i pulsanti da `.map-container .ctrl-btn.ctrl-btn`, il lead ha RIPRISTINATO `renderButton` alla versione a classe `ctrl-btn` (copia della versione del peer: scratchpad `geolocation.peer-version.js`). Lo stesso peer ha modificato `Themes/Sixteen/resources/views/tickets/index.blade.php` togliendo `fill="#007a52"` dal pin: la vista non e' servita da nessuna rotta (0 occorrenze di `ticket-marker-visible` su `/it/tickets`), lasciata com'e', ma senza `fill` il pin sarebbe nero. Le sue note `Themes/Sixteen/docs/bmad/geo-map-tickets-updates.md` (STORY-054/530/XXX) attribuiscono la causa a `APP_URL` e a `bg-transparent`: non verificato dal peer, smentito dalle misure di questa story. Regola: prima di scrivere sul marker o sui pulsanti del picker leggere questa story.
