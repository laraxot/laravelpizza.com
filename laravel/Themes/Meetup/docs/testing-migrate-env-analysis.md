# Theme Meetup - Testing Migrate Analysis (2026-03-06)

## Sintesi aggiornata

Il tema non contiene migration proprie ma dipende dal bootstrap schema dei moduli.
L'analisi reale di `php artisan migrate --env=testing` ha mostrato:

1. errore connessione in sandbox (`HY000 2002`) non conclusivo;
2. fuori sandbox, errore schema reale in modulo Meetup:
   - `Duplicate column name 'user_id'`
   - migration `2025_01_01_000008_create_event_user_table`.

## Impatto sul tema

- I test tema/integration con DB non sono affidabili finché la migration Meetup resta bloccante.
- Il failure non è UI/Blade: è un prerequisito infrastrutturale/schema a monte.

## Regola operativa per test tema

Prima di qualunque suite tema dipendente da DB:

1. eseguire `php artisan migrate --env=testing -vvv`;
2. verificare passaggio completo delle migration Meetup;
3. solo dopo lanciare test del tema.

## Nota architetturale

Il caso dimostra che nei moduli condivisi va evitata ambiguità tra:
- `user_id` di dominio,
- `user_id` di audit introdotta da helper cross-modulo.
