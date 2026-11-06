---
id: dcp-41
title: "Da URL a JSON: strumento di verifica e regola contro i JSON inventati"
type: story
epic: dc-parity-v2
status: done
priority: P1
owner: module:Cms
module: Cms
created: 2026-10-13
updated: 2026-10-13
tags: [cms, json, slug, governance]
qmd: "dcp-41 Da URL a JSON: strumento di verifica e regola contro i JSON inventati"
related: [Modules/Fixcity/docs/stories/dcp-35-tickets-create-privacy-dati-coordinamento.story.md, Modules/Fixcity/docs/stories/dcp-44-audit-docs-tickets-create.story.md]
---

# DCP-41: da URL a JSON

## Richiesta (2026-10-13)
`/it/tickets/create` non ha e non deve avere `tests.tickets-create.json`: usa `laravel/config/local/fixcity/database/content/pages/tickets.create.json`. Capire il perche', dove si e' sbagliato e impedire che si ripeta.

## Analisi
- Slug = segmenti dell'URL. Pagina generica `[container0]/[slug0]`: `<container0>.<slug0>` (`tickets.create`). Pagina `pages/tests/[slug].blade.php`: `tests.<slug>`, `/it/tests` = `tests.index`.
- Il "tests" in `pub_theme::components.blocks.tests.ticket-crea` e' una cartella di view dei blocchi, non uno slug.
- L'errore: un doc/story (dcp-22, `fil-tickets-create-filament-wizard-parity`) ha citato un JSON `tests.tickets-create`; i risultati QMD piu' in alto descrivevano la sandbox `/it/tests/segnalazione-crea` (JSON oggi cancellato in 260f3bcc5) e view inesistenti. Un secondo JSON duplicherebbe il contenuto e non proverebbe nulla (vedi memoria `tests-pages-are-data-not-code`).

## Modifiche
- `bashscripts/tools/cms/page-json-for-url.sh <url>`: legge `data-slug` dalla risposta reale e cerca `<slug>.json` in `laravel/config/*` e `laravel/Modules/*/config`. Exit 0 trovato, 1 nessun `data-slug`, 2 nessun JSON (non crearlo, chiedere). Doc: `bashscripts/docs/tools/page-json-for-url.md`.
- Doc Cms: sezione "Da URL a JSON: come verificare" in `Modules/Cms/docs/wiki/concepts/cms-page-middleware-json-ssot.md`; regola del Volt in `folio-page-shell-pattern.md`.
- Guardia eseguibile: `Modules/Fixcity/tests/Unit/TicketCreatePageJsonGuardTest.php` (nessun `tests.tickets*.json`; `tickets.create.json` presente in `config/local/fixcity`).
- Second brain: memorie `page-json-comes-from-data-slug-never-invent` e `coordinate-agents-via-bmad-stories-parallel-random`; wiki `bashscripts/ai/wiki/memories/tickets-create-volt-root-and-page-json.md`.

## Verifica (output reali)
- `/it/tickets/create` -> `slug: tickets.create`, 3 file; `/it/tests` -> `tests.index`; `/it/tests/segnalazione-01-privacy` -> `tests.segnalazione-01-privacy`; `/it/tickets/inesistente-xyz` -> exit 2.
- `tickets.create.json`: alle 12:50 UTC `config/eu/fixcity/...` differiva dalle altre due; alle 14:10 UTC le tre copie sono identiche (`cmp`, 164 righe, `middleware: ["auth"]`, `layout: design-comuni`): le ha allineate un altro agente. Il confronto riga per riga del revisore AUD-A e il mio `cmp` coincidono.

## Aperto
- Le tre copie di `tickets.create.json` sono ora identiche (vedi sopra): resta da stabilire quale tenant e' autorevole per le modifiche future.
- Lo script legge `data-slug` dalla risposta HTTP: richiede il server attivo. Per una pagina protetta (302 al login, D17) da ospite non c'e' `data-slug`: lo script lo DEDUCE dalla regola documentata e lo dichiara (`DEDOTTO`); lo slug letto richiede una sessione autenticata.

## Nota storica (verificata dal lead, 2026-10-13)
Il commit `260f3bcc5` (2026-06-05, marco76tv, "restructure documentation...") ha cancellato `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-crea.json` (`git log --diff-filter=D`; oggi non esiste in nessun tenant) e ha rinominato in massa `segnalazione-crea` in `ticket-crea` nei doc `_bmad-output`. Per questo i doc parlano di due nomi per la stessa superficie e i primi risultati QMD indicano una sandbox che non esiste piu'.

## Decisioni
- Lo slug si legge dalla risposta reale (`data-slug`), non si ricostruisce: una regola scritta in un doc puo' essere stale.
- Eccezione dichiarata: con un 302 al login lo slug e' dedotto dall'URL (`<container0>.<slug0>`, `tests.<slug>` per `/it/tests/*`) e l'output lo etichetta `DEDOTTO`.
- Exit code: 0 trovato, 1 nessun `data-slug` e nessun redirect al login, 2 nessun JSON per lo slug.

## Output allegati (2026-10-13 14:10 UTC, comandi eseguiti dal lead)
```
$ page-json-for-url.sh http://192.168.1.40:8000/it/tickets/create     (ospite, 302 al login)
slug: tickets.create (DEDOTTO dall'URL: pagina protetta, 302 al login; per averlo letto serve una sessione autenticata)
laravel/config/eu/fixcity/database/content/pages/tickets.create.json
laravel/config/local/fixcity/database/content/pages/tickets.create.json
laravel/Modules/Fixcity/config/database/content/pages/tickets.create.json
exit=0
$ page-json-for-url.sh http://192.168.1.40:8000/it/tests
slug: tests.index (letto dalla risposta)
laravel/config/local/fixcity/database/content/pages/tests.index.json
laravel/Modules/Fixcity/config/database/content/pages/tests.index.json
exit=0
$ page-json-for-url.sh http://192.168.1.40:8000/it/tickets/inesistente-xyz
slug: tickets.inesistente-xyz (letto dalla risposta)
NESSUN JSON per 'tickets.inesistente-xyz': non crearlo senza chiedere
exit=2
$ page-json-for-url.sh http://192.168.1.40:8000/it/pagina-che-non-esiste
nessun data-slug: pagina non CMS o errore HTTP (404 )
exit=1
```
