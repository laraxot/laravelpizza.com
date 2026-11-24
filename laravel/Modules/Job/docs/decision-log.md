# Decision Log — Job

A threaded, append-only record of decisions made across BMAD planning workflows.
Every later skill (brief, PRD, architecture, stories) appends here so the reasoning
behind the plan stays visible and consistent.

**How to use:** add a new entry at the top of the log (newest first). Never rewrite
or delete past entries — supersede them with a new entry that references the old one.

### 2026-10-08: Schedule all'enum Status (ultima versione buona)
- **Choose**: Ripristinare `Models/Schedule.php` dal blob `788ff149`, la versione del commit `97fe8f09` (07/10 06:37) che sostituisce le costanti `STATUS_*` con l'enum `Status`.
- **Over**: La versione del 06/10 (costanti), o quella attuale.
- **Because**: Il commit delle 13:01 del 07/10 (re-import `431b5e66` e successivi) aveva rimesso la versione vecchia; la storia completa mostra che `97fe8f09` era lavoro nuovo da conservare, più recente del 06/10. `Status::activeCases()` esiste.
- **Verifica**: `php -l`; PHPStan su `Modules` senza errori in Job; test prima/dopo identici.

### YYYY-MM-DD — Initial commit
- **Decision:** Initial BMAD documentation setup for Job module
- **Rationale:** Establish decision trail for module development
- **Made by:** bmad-init
- **Supersedes:** none
