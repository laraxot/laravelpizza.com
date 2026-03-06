# Fix: Activity TestCase - Transaction and Connection Setup

## Problema

Nei test Activity c'era duplicazione dell'infrastruttura transazionale:
- `DatabaseTransactions` dichiarato nel TestCase modulo;
- connessioni multiple hardcoded nel modulo senza regola condivisa.

Questo rende difficile mantenere allineati Activity, User e Xot.

## Pattern corretto (aggiornato)

1. Il trait `DatabaseTransactions` vive nel base comune `Modules/Xot/tests/XotBaseTestCase.php`.
2. Il modulo Activity dichiara solo le connessioni aggiuntive necessarie quando serve (`activity`, `user`).
3. Le migration non si eseguono nei test:
   - `php artisan migrate --env=testing`
   - comando esterno, una volta, prima della suite.

## Perché

- DRY: meno duplicazione nei TestCase modulo.
- Coerenza multi-modulo: stessa logica tra Activity/User/Xot.
- Stabilità: nessun `migrate` in `setUp()`, rollback affidato alle transazioni.

## Checklist operativa

- `.env.testing` coerente con database `_test`.
- `php artisan migrate --env=testing` eseguito prima dei test.
- `connectionsToTransact` include tutte le connessioni effettivamente usate dai model sotto test.

## Collegamenti

- [Xot TestCase Setup Rules](../../Xot/docs/testcase-setup-critical-rules.md)
- [Global Testing Standards](../../../../docs/rules/testing-standards.md)
