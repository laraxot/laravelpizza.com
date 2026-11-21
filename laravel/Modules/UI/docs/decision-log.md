---
title: "Decision Log — UI"
qmd: "ui decision log md"
type: note
tags: [documentation]
---

# Decision Log — UI

A threaded, append-only record of decisions made across BMAD planning workflows.
Every later skill (brief, PRD, architecture, stories) appends here so the reasoning
behind the plan stays visible and consistent.

**How to use:** add a new entry at the top of the log (newest first). Never rewrite
or delete past entries — supersede them with a new entry that references the old one.

### 2026-10-08: Ripristino GetUserDataAction regredita dal re-import del 07/10
- **Choose**: Ripristinare `Actions/GetUserDataAction.php` dallo stato del monorepo al 06/10.
- **Over**: Tenere la versione del commit `c83cb5a03` (07/10 13:09, senza genitori, 3102 file).
- **Because**: Re-import da una copia vecchia; nessun commit successivo tocca il file. Criterio: contenuto attuale identico byte per byte a una versione più vecchia già sostituita; per ogni file controllata la storia completa (`--full-history`) per non perdere commit successivi.
- **Verifica**: `php -l`; PHPStan su `Modules` senza errori in UI; test prima/dopo identici.

### YYYY-MM-DD — Initial commit
- **Decision:** Initial BMAD documentation setup for UI module
- **Rationale:** Establish decision trail for module development
- **Made by:** bmad-init
- **Supersedes:** none
