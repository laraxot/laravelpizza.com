## Progress update

Eseguito dalla cartella `laravel`:

```bash
./vendor/bin/phpstan analyse Modules
```

Esito iniziale:

- crash runtime su `Failed to listen on tcp://127.0.0.1:0`

Hardening applicato:

- spostato `tmpDir` di PHPStan da `/tmp/phpstan` a `laravel/storage/app/phpstan`
- documentato il workaround canonico con `XDEBUG_MODE=off`

Run reale completato:

```bash
XDEBUG_MODE=off ./vendor/bin/phpstan analyse Modules --memory-limit=-1 --debug --no-progress
```

Esito:

- il comando entra nell'analisi reale dei moduli
- il primo blocco concreto e' nel modulo `User`
- root cause principale: molte migration contengono marker di merge `<<<<<<< HEAD`, `=======`, `>>>>>>> 74e589dbb (.)`
- PHPStan chiude con severe syntax errors e risultato incompleto

Azioni in corso:

- aggiornate le docs di governance e il modulo `User`
- pulizia delle migration del modulo `User`
- rilancio dei quality gate: `phpstan`, `phpmd`, `phpinsights` e Pest sul perimetro toccato

## Aggiornamento risultato

Correzioni applicate:

- rimossi i merge marker da tutte le migration `Modules/User/database/migrations`
- corretta la chiusura dell'anonymous class in `2026_01_01_000000_create_profiles_table.php`
- corrette tre migration OAuth che usavano `$userClass` fuori scope dentro closure statiche
- aggiunto test Pest di guardia su merge marker e syntax validity delle migration `User`

Verifica:

- `./vendor/bin/phpstan analyse Modules`:
  ancora bloccato dal bug runtime `Failed to listen on tcp://127.0.0.1:0`
- `XDEBUG_MODE=off ./vendor/bin/phpstan analyse Modules/User/database/migrations ... --debug --no-progress`:
  `No errors`
- `./vendor/bin/pest Modules/User/tests/Feature/Database/Migrations/UserMigrationSyntaxTest.php`:
  `110 passed (275 assertions)`
- `php -l` su migration e test toccati:
  OK
- `./vendor/bin/phpmd`:
  non presente nel repository
- `./vendor/bin/phpinsights analyse ... --no-interaction`:
  passa sul perimetro, con residui non bloccanti di stile/architettura e rumore storico factory fuori perimetro

## Nuovo stato globale

Eseguito di nuovo:

```bash
cd laravel
./vendor/bin/phpstan analyse Modules
```

Esito aggiornato:

- il run globale ora completa davvero l'analisi e restituisce `106` errori reali
- cluster principali:
  - `Cms`: contratti fuori sync (`ThemeComposer`, `Blocks`, `HeadernavData`, `GuestLayout`, `Page\Show`, `PostFactory`)
  - `Notify`: model canonici mancanti o non nel percorso corretto (`NotificationLog`, `NotificationChannel`)
  - `Tenant`: factory verso `DatabaseConfig` senza modello canonico
  - `User`: wrapper Passport e resource typing ancora da riallineare

Primo fix del nuovo giro:

- `Cms` riallineato sul contratto reale `Blocks(view: ...)`
- `HeadernavData` ora espone anche `view()` per compatibilita'
- `GuestLayout` semplificato su literal `view-string`
- `Page\Show` non assume piu' proprieta' non annotate del modello `Page`
