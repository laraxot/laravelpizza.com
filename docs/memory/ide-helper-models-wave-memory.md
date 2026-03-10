# Memory: IDE Helper Models Wave

- `php artisan ide-helper:models -W` va eseguito in una wave tracciata (issue + discussion), non come comando isolato.
- Errori su relazioni/modelli si correggono nel codice corrente con patch forward-only, senza rollback git.
- Ogni wave chiude con quality gate PHP (`phpstan`, `phpmd`, `phpinsights`) e Pest se il comportamento e' testabile.
- Per Passport/OAuth nel modulo `User`, il source-of-truth Eloquent dei token resta `OauthToken`/`Laravel\Passport\Token`; evitare workaround sintetici nelle relazioni se il problema reale e' nel wrapper o nei PHPDoc generati.
