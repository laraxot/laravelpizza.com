# Skill Operativa: Coverage 100% Full-Project

## Trigger

Usare questa skill quando il target esplicito e `pest --coverage --min=100` sul monolite modulare.

## Workflow obbligatorio

1. Eseguire baseline:
   - `./vendor/bin/pest --coverage`
   - `./vendor/bin/pest --type-coverage` (se plugin installato)
   - verificare driver coverage: `php -i | rg "pcov.directory|xdebug.mode"`.
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
- Non cancellare file in questo workflow: quando serve escludere, rinominare in `.old`.
- Non accettare baseline con `No tests found` o coverage `0.0%` infrastrutturale: prima stabilizzare discovery e driver.
- Se PCOV e attivo, impostare `pcov.directory` alla root del progetto Laravel per coprire `Modules/*`.
- In contesto multi-agent:
  - verificare sempre `git status --short` prima e dopo ogni micro-batch;
  - verificare sempre la Issue/Discussion GitHub condivisa prima di prendere in carico un blocco;
  - considerare SEMPRE possibile che altri agenti abbiano gia' risolto parte dei fail;
  - evitare duplicazioni: se il lavoro risulta gia' completato, cambiare batch immediatamente;
  - scegliere batch non contigui nel piano condiviso per ridurre collisioni;
  - aggiornare `docs/coverage-plan.md` immediatamente dopo il batch completato.
  - se un file target risulta gia' modificato da altri agenti, cambiare subito batch senza forzare merge manuali.
  - pubblicare su GitHub:
    - commento di presa in carico ("claim") con file target;
    - commento di chiusura batch con risultati test e delta del piano.
  - questa regola e' permanente: applicarla ad ogni turno senza eccezioni.

## Fonti canoniche

- https://pestphp.com/docs/test-coverage
- https://pestphp.com/docs/type-coverage
- https://laravelmodules.com/docs/12/advanced/tests
