Ho verificato il comportamento reale di `php artisan ide-helper:models -W` nel progetto.

Conclusione netta:

il comando non va usato come fonte di verita' dentro un sandbox che non raggiunge le connessioni MySQL locali dei modelli.

Nel primo run sono comparsi molti:

- `SQLSTATE[HY000] [2002]`
- su connessioni `mysql`, `activity`, `gdpr`, `xot`

Questo non dimostra un difetto dei modelli. Dimostra che `ide-helper` stava provando a leggere lo schema reale senza accesso al DB.

Nel run successivo, eseguito con accesso reale al DB locale, `ide-helper:models -W` ha completato la generazione dei phpDoc dei modelli.

Quindi la convenzione corretta e' questa:

1. prima distinguere blocco ambientale vs blocco reale del model;
2. non introdurre fix inventati nei model solo per zittire un sandbox non connesso;
3. documentare il prerequisito ambientale come regola stabile del progetto.

Ho allineato:

- `docs/rules/ide-helper-live-db-rule.md`
- `docs/memory/ide-helper-live-db-memory.md`
- `docs/skills/ide-helper-models-refresh-skill.md`
- `laravel/Modules/Xot/docs/ide-helper-best-practices.md`
- `laravel/Themes/Meetup/docs/agent-ai-workflow-final-summary.md`

Se dopo un run live restano segnalazioni vere su relation, property o phpDoc, quelle si correggono forward-only. Ma il primo filtro deve essere sempre l'ambiente di esecuzione.
