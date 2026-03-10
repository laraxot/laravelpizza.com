# IDE Helper Models Wave Rule

## Regola

Quando richiesto un passaggio `php artisan ide-helper:models -W`:

1. prima si aggiorna documentazione operativa (`docs/rules`, `docs/memory`, `docs/skills`) e la doc del modulo/tema toccato;
2. si apre o aggiorna una GitHub Issue dedicata alla wave;
3. si aggiorna almeno una GitHub Discussion con stato e decisioni;
4. solo dopo si esegue il comando e si correggono tutte le segnalazioni.

## Vincoli operativi

- niente rollback git: solo patch forward-only;
- niente fix nascosti: ogni cluster di errori va tracciato in issue/discussion;
- dopo le correzioni PHP: quality gate obbligatorio (`phpstan`, `phpmd`, `phpinsights`) e Pest quando testabile.
