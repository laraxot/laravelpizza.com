Aggiornamento governance del 2026-03-09:

ho formalizzato la nuova regola operativa richiesta dall'utente per tutti i file PHP modificati.

Nuovo standard:

- dopo ogni edit PHP vanno eseguiti `phpstan`, `phpmd`, `phpinsights`;
- se il comportamento e' testabile, va cercato il test Pest associato;
- se il test manca, va creato o aggiornato;
- non basta piu `php -l` o una verifica solo manuale.

Allineamenti locali eseguiti:

- `docs/rules/php-post-edit-quality-gate-rule.md`
- `docs/memory/php-quality-gate-memory.md`
- `docs/skills/php-quality-gate-skill.md`
- aggiornati anche `pre-edit-docs-first-*`, `testing-standards.md`, `phpstan-workflow.md`
- aggiornati gli indici docs di `Modules/Xot` e `Themes/Meetup`

Questa regola va ora considerata parte del workflow standard di chiusura task.
