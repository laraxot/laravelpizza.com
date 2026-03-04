# Piano Coverage 100% (Pest)

## Obiettivo

Raggiungere 100% su:

1. `pest --coverage`
2. `pest --type-coverage` (plugin)

## Baseline corrente (2026-03-04)

- Suite globale eseguita: `1610 passed`.
- Coverage globale non valida: `Total 0.0%` per perimetro `source` troppo ampio e non filtrato (molti file non target coverage).
- Type coverage non disponibile: plugin non installato (`pest-plugin-type-coverage` assente).
- GitHub issue/discussion non aggiornabili da CLI per token `gh` invalido.

## Strategia in 5 fasi

1. **Perimetro coverage corretto**
- In `phpunit.xml` includere solo codice runtime PHP.
- Escludere file non target coverage (view blade, stubs/template, config di modulo, docs, test fixture non runtime).
- Verificare con `./vendor/bin/pest --coverage --exactly=0` che il perimetro sia sensato solo per debug iniziale.

2. **Warning zero**
- Comando: `./vendor/bin/pest --stop-on-warning`
- Fix one-by-one fino a `0 warning`.

3. **Perimetro test coerente**
- Mantenere testsuite root + moduli con struttura `Modules/*/tests/*` (Unit/Feature/Integration/Performance).
- Test legacy non recuperabili nel ciclo corrente: rename `.old`.

4. **Copertura rami mancanti**
- Eseguire `./vendor/bin/pest --coverage --compact`.
- Scrivere test mirati su branch non coperti (if/else, eccezioni, fallback, policy/provider/traits).

5. **Type coverage**
- Installare plugin dedicato e poi eseguire:
- `./vendor/bin/pest --type-coverage --compact`
- `./vendor/bin/pest --type-coverage --min=100`

6. **Gate finale**
- `./vendor/bin/pest --coverage --min=100`
- `./vendor/bin/pest --coverage --exactly=100`
- `./vendor/bin/pest --type-coverage --min=100`

## Regole operative

- Nessun nuovo skip nei test attivi.
- Ogni rename `.old` va motivato nel commit/changelog.
- Ogni iterazione aggiorna docs/rules/memory/skill coverage.
- Eseguire coverage con driver attivo (Xdebug/PCOV/phpdbg); con Xdebug usare `XDEBUG_MODE=coverage`.

## Fonti ufficiali

- Pest test coverage: https://pestphp.com/docs/test-coverage
- Pest type coverage: https://pestphp.com/docs/type-coverage
- Laravel Modules tests: https://laravelmodules.com/docs/12/advanced/tests
