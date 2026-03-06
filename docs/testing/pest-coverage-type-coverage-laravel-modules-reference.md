# Pest Coverage + Type Coverage + Laravel Modules Tests (Reference 2026-03-04)

## Fonti studiate

- Pest Test Coverage: https://pestphp.com/docs/test-coverage
- Pest Type Coverage: https://pestphp.com/docs/type-coverage
- Laravel Modules v12 Tests: https://laravelmodules.com/docs/12/advanced/tests

## Decisioni operative adottate

1. Coverage classica:
   - usare `--coverage` con driver attivo (`XDEBUG_MODE=coverage` oppure PCOV);
   - usare soglie con `--min` o `--exactly`;
   - mantenere `source` in `phpunit.xml` coerente col perimetro reale.

2. Type Coverage:
   - introdurre/abilitare `pest-plugin-type-coverage` dove disponibile;
   - usare `--type-coverage --compact` per backlog incrementale;
   - usare `--type-coverage --min=100` come gate finale per typing completo.

3. Laravel Modules:
   - usare wildcard in `testsuite` (`Modules/*/tests/...`) per non perdere moduli nuovi;
   - includere moduli nel `source` coverage;
   - escludere da coverage cartelle non di codice runtime (`config`, `database`, `resources`, `routes`, `tests`), se si usa include ampio `./Modules`.

## Comandi di riferimento

```bash
# Coverage code
XDEBUG_MODE=coverage ./vendor/bin/pest --coverage --min=100

# Type coverage
./vendor/bin/pest --type-coverage --compact
./vendor/bin/pest --type-coverage --min=100
```

## Nota progetto

Nel progetto LaravelPizza il target resta 100% full-project; i test failing vengono fixati o rinominati `.old` con motivazione documentata.
