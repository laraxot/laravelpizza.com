# Piano Coverage 100% (Pest)

## Obiettivo

Raggiungere 100% su:

1. `pest --coverage`
2. `pest --type-coverage`

## Baseline coordinata (2026-03-06)

- Issue/Discussion GitHub operative per governance coverage.
- Programma in modalita dual-track (allineamento #219 / #229).
- Integrita metrica vincolata a perimetro source runtime completo.

## Policy ufficiale di misurazione

### 1) Source scope (globale)

`laravel/phpunit.xml` deve includere runtime code e basta:

- `./Modules/*/app`
- opzionale: `./app`, `./Themes/*/app` se presenti e runtime.

Esclusioni obbligatorie: `config`, `database`, `lang`, `routes`, `resources`, `tests`, `workbench`, file tool-only.

### 2) Comandi riproducibili

Eseguire da `laravel/`.

- Global coverage baseline:
  - `./vendor/bin/pest --coverage --min=0 --compact`
- Per modulo (esempio User):
  - `./vendor/bin/pest Modules/User/tests --coverage --min=0 --compact`
- Global type coverage baseline:
  - `./vendor/bin/pest --type-coverage --min=0 --compact`
- Gate finale globale:
  - `./vendor/bin/pest --coverage --min=100`
  - `./vendor/bin/pest --type-coverage --min=100`

### 3) Report minimo per aggiornamento modulo

Ogni update su issue modulo deve includere:

- Coverage % corrente
- Gap a 100%
- File/classi toccate
- Prossimo micro-batch
- Blocker

## Strategia operativa

1. **Integrita perimetro**: prima validare source scope, poi leggere le percentuali.
2. **Warning zero**: `./vendor/bin/pest --stop-on-warning`.
3. **Branch uncovered**: test mirati su if/else, eccezioni, fallback, policy/provider/traits.
4. **Type coverage**: mantenere policy in parallelo alla coverage line.
5. **Gate finale**: applicare `--min=100` solo dopo baseline stabile.

## Regole operative

- Nessun nuovo skip nei test attivi.
- Ogni rename `.old` deve essere motivato in issue/comment release.
- Ogni iterazione aggiorna issue + discussion correlate (governance multi-agent).

## Fonti ufficiali

- Pest test coverage: https://pestphp.com/docs/test-coverage
- Pest type coverage: https://pestphp.com/docs/type-coverage
- Laravel Modules tests: https://laravelmodules.com/docs/12/advanced/tests
