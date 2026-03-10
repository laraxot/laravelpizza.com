# IDE Helper Models Memory

- `php artisan ide-helper:models -W` e' un tool di documentazione runtime-driven, non solo un formatter.
- Nei moduli Laraxot molti model leggono schema e relazioni da connessioni reali: il comando richiede database accessibile.
- Se il primo run nel sandbox fallisce con errori di connessione, bisogna distinguere il blocker infrastrutturale dal codice rilanciando con accesso locale reale.
- Se il run completo con DB reale finisce senza `Could not analyze class`, le segnalazioni erano ambientali, non bug dei model.
- I PHPDoc generati restano nel file corrente: niente restore da git, solo rigenerazione forward-only.
