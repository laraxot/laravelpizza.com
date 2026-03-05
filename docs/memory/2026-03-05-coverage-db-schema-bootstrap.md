# 2026-03-05 Coverage DB Schema Bootstrap

## Contesto
Durante l'estensione della copertura test, diversi test `Unit` di `Modules/Meetup` e `Modules/User` falliscono in ambienti dove le tabelle multi-connessione (`user`, `meetup`) non sono migrate.

## Decisione operativa
Per stabilizzare i test di copertura in ambiente CI/dev variabile:
- bootstrap schema minimo in test (solo tabelle realmente usate);
- mantenere i test unitari eseguibili senza dipendere da migrazioni globali esterne;
- aggiornare `docs/coverage-plan.md` con i blocchi risolti e quelli ancora aperti.

## Perimetro
- `Meetup` model tests: `events`, `performers`, `profiles`, pivot correlate.
- `User` socialite action tests: `users`, `socialite_users`.
