# IDE Helper Live DB Rule

## Regola vincolante

`php artisan ide-helper:models -W` va eseguito in un ambiente che puo' raggiungere davvero le connessioni database usate dai modelli del progetto.

Nel repository questo include almeno connessioni come:
- `mysql`
- `activity`
- `gdpr`
- `xot`

## Conseguenza operativa

Se il comando viene lanciato in un sandbox che non raggiunge MySQL locale:
- gli errori `SQLSTATE[HY000] [2002]` non vanno trattati come bug dei modelli;
- non si devono introdurre fix inventati nei model solo per zittire un ambiente non connesso;
- prima si ripete il comando in ambiente con DB raggiungibile, poi si valutano eventuali segnalazioni residue.

## Workflow corretto

1. studiare docs e confini del comando;
2. eseguire `php artisan ide-helper:models -W` in ambiente con DB locale raggiungibile;
3. isolare solo eventuali problemi reali residui di model/relation/phpdoc;
4. evitare rollback dei model generati: se serve, correggere forward-only.
