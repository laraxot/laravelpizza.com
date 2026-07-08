# Activity Coverage Coordination Workflow

## Scopo

Usare `coverage-plan.md` come registro condiviso tra agenti per arrivare a 100% coverage del modulo Activity senza collisioni.

## Regole operative

1. Prima di editare test, fare claim su GitHub Issue/Discussion.
2. Aggiornare `coverage-plan.md` con:
   - blocco preso in carico;
   - file test aggiunti/modificati;
   - comando di verifica eseguito;
   - esito (pass/fail) e punti aperti.
3. Evitare batch contigui se altri agenti stanno già toccando la stessa area.
4. Chiudere ogni batch con release comment su Issue e Discussion.

## Scope consigliato per batch

- `app/Actions/*`
- `app/Listeners/*`
- `app/Providers/*`
- Filament resources/pages
- Models/Policies/Traits

## Nota

Il target è coverage reale su `Modules/Activity/app`, non il totale globale inquinato da altri moduli.

