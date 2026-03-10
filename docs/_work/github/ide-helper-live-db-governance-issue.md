## Summary

`php artisan ide-helper:models -W` nel progetto non puo' essere valutato correttamente in un ambiente che non raggiunge le connessioni MySQL locali dei modelli.

Primo run nel sandbox:
- errori `SQLSTATE[HY000] [2002]`
- modelli coinvolti su connessioni `mysql`, `activity`, `gdpr`, `xot`

Secondo run fuori sandbox, con DB locale raggiungibile:
- completato
- phpDoc rigenerati
- nessuna segnalazione residua equivalente al blocco iniziale

## Governance decision

Non bisogna correggere model/relation/phpdoc finche' non si e' distinto:

1. errore infrastrutturale di connessione;
2. errore reale del modello.

## Docs updated

- `docs/rules/ide-helper-live-db-rule.md`
- `docs/memory/ide-helper-live-db-memory.md`
- `docs/skills/ide-helper-models-refresh-skill.md`
- `laravel/Modules/Xot/docs/ide-helper-best-practices.md`
- `laravel/Themes/Meetup/docs/agent-ai-workflow-final-summary.md`

## Outcome

La regola operativa adesso e':
- docs-first;
- run `ide-helper:models -W` solo con DB raggiungibile;
- fix forward-only solo se dopo il run live restano segnalazioni reali.
