# Coverage 100% Full-Project Rule

## Obiettivo

Portare Pest al 100% in modo verificabile e ripetibile:

- code coverage: `./vendor/bin/pest --coverage --min=100`
- type coverage: `./vendor/bin/pest --type-coverage --min=100`

## Regole non negoziabili

1. Niente metriche artificiali: il perimetro coverage deve restare coerente con il codice runtime reale.
2. I test failing si gestiscono solo in due modi:
   - fix immediato, oppure
   - rinomina file in `.old` quando fuori scope corrente, con motivazione documentata.
3. I test con skip legacy (`markTestSkipped`, `->skip`) sono candidati prioritari a `.old`.
4. Ogni run deve essere tracciabile con comando, esito e delta.
5. Ogni iterazione aggiorna sempre:
   - `docs/testing/coverage-100-plan.md`
   - `docs/memory/coverage-100-full-project-memory.md`
   - `docs/skills/coverage-100-full-project-skill.md`

## Standard ufficiali da applicare

- Pest code coverage richiede Xdebug/PCOV/phpdbg attivi.
- Se si usa PCOV, `pcov.directory` deve includere l'intero progetto Laravel (`laravel/`) e non solo `laravel/app`, altrimenti i moduli `Modules/*` risultano sempre a `0.0%`.
- Soglie: usare `--min` per gate minimo e `--exactly` quando si vuole match esatto.
- Type coverage e separato dalla code coverage e richiede plugin dedicato.
- Con Laravel Modules, la struttura test standard resta `Modules/*/tests/...` (Unit/Feature/Integration/Performance).

## Guardrail operativi aggiuntivi

1. Non rinominare in massa i test `*.php` in `*.old`: genera `No tests found` e produce una coverage non valida.
2. Se si incontrano file vendor rinominati anomali (es. `Test.php.old`), ripristinare immediatamente prima di ogni run coverage.
3. Prima di perseguire il 100%, la baseline deve essere: test discovery corretta + suite green senza errori infrastrutturali.

## Fonti

- https://pestphp.com/docs/test-coverage
- https://pestphp.com/docs/type-coverage
- https://laravelmodules.com/docs/12/advanced/tests
