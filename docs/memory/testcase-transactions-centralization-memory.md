# Memory: TestCase Transactions Centralization (2026-03-06)

## Contesto

Durante il riallineamento dei test del modulo Activity è emersa duplicazione tra i `TestCase` modulo e `Modules/Xot/tests/XotBaseTestCase`:
- trait `DatabaseTransactions` ripetuto in più moduli;
- regole migrate non sempre esplicitate nel punto giusto.

## Decisione

1. Centralizzare il trait `DatabaseTransactions` in `XotBaseTestCase`.
2. Mantenere `connectionsToTransact` estendibile nei moduli (multi-connessione).
3. Rendere esplicito che le migration test si eseguono automaticamente una sola volta per suite:
   - `XotBaseTestCase` esegue `artisan migrate --env=testing` in `createApplication()` la prima volta che viene istanziato.
   - Utilizzo di un flag `static` per evitare esecuzioni multiple (performance).
   - Nessun uso di `--force`, `migrate:fresh`, `RefreshDatabase`.
   - Evitare override con firme incompatibili rispetto ai trait Laravel (es. `connectionsToTransact()` con return type) perché causano fatal prima dell'esecuzione test.
   - Questo bilancia la regola "mai nei TestCase di modulo" con la necessità di avere un database pronto per `DatabaseTransactions`.
   - Rimuovere i vari `bootstrap...TestingSchema` dai moduli (User, Meetup) per usare solo le migration standard.

## Motivazione

- DRY: meno duplicazione tra moduli.
- Sicurezza: rollback coerente su suite multi-modulo.
- Stabilità: evita anti-pattern di migrazioni runtime nei test.

## Impatto atteso

- `Modules/Activity/tests/TestCase.php` può delegare il trait al base.
- Altri moduli possono mantenere override connessioni senza regressioni.
