# Skill Operativa: Coverage 100% Full-Project

## Trigger

Usare questa skill quando il target esplicito e `pest --coverage --min=100` sul monolite modulare.

## Workflow obbligatorio

1. Eseguire baseline:
   - `./vendor/bin/pest --coverage`
   - `./vendor/bin/pest --type-coverage` (se plugin installato)
2. Stabilizzare suite:
   - `./vendor/bin/pest --stop-on-warning`
   - fix warning/risky in sequenza.
3. Gestire test non recuperabili:
   - rinomina file `*.php` -> `*.php.old`.
4. Copertura rami mancanti:
   - aggiungere test mirati branch-by-branch.
5. Verifica finale:
   - `./vendor/bin/pest --coverage --min=100`
   - `./vendor/bin/pest --type-coverage --min=100`

## Regole pratiche

- Evitare test fragili basati su conteggi globali se il DB non e isolato.
- Preferire assertion su comportamento osservabile e invarianti.
- Non lasciare skip nei test attivi: o fix, o `.old`.

## Fonti canoniche

- https://pestphp.com/docs/test-coverage
- https://pestphp.com/docs/type-coverage
- https://laravelmodules.com/docs/12/advanced/tests
