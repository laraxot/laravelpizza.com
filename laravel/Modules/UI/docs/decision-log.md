---
title: "Decision Log: UI"
type: note
status: draft
updated: 2026-10-08
tags: [docs, ui]
qmd: "decision log   ui ui"
---
# Decision Log: UI

A threaded, append-only record of decisions made across BMAD planning workflows.
Every later skill (brief, PRD, architecture, stories) appends here so the reasoning
behind the plan stays visible and consistent.

**How to use:** add a new entry at the top of the log (newest first). Never rewrite
or delete past entries: supersede them with a new entry that references the old one.

### 2026-10-14: Un solo ingresso del docs, README come identita' del modulo
- **Choose**: `00-INDEX.md` e' l'unico indice canonico del `docs/` di UI; `README.md` descrive identita', ownership, codice, quick start e limiti con dati verificati; gli indici di `wiki/` e `bmad/` restano come legacy, dichiarati tali.
- **Over**: Creare un `index.md` alla radice (vietato dal contratto) o riscrivere gli indici di `wiki/` e `bmad/`.
- **Because**: Il vecchio `00-INDEX.md` linkava `schema/`, che non esiste; i quattro indici di `wiki/` si contraddicevano (versione 2.3.0 mai dichiarata dal modulo).
- **Verifica**: conteggi da `find`/`ls` su `laravel/Modules/UI`, PHPStan `Modules/UI` exit 0, Pest 218 passati e 16 falliti (cause non indagate). Story: [2026-10-14-docs-ui-studio-e-ingressi](stories/docs-ui-studio-e-ingressi.story.md).

### 2026-10-08: Ripristino GetUserDataAction regredita dal re-import del 07/10
- **Choose**: Ripristinare `Actions/GetUserDataAction.php` dallo stato del monorepo al 06/10.
- **Over**: Tenere la versione del commit `c83cb5a03` (07/10 13:09, senza genitori, 3102 file).
- **Because**: Re-import da una copia vecchia; nessun commit successivo tocca il file. Criterio: contenuto attuale identico byte per byte a una versione più vecchia già sostituita; per ogni file controllata la storia completa (`--full-history`) per non perdere commit successivi.
- **Verifica**: `php -l`; PHPStan su `Modules` senza errori in UI; test prima/dopo identici.

### YYYY-MM-DD: Initial commit
- **Decision:** Initial BMAD documentation setup for UI module
- **Rationale:** Establish decision trail for module development
- **Made by:** bmad-init
- **Supersedes:** none
