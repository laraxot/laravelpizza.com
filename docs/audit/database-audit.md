# Database audit

> Audit del 2026-11-05. Fonti: migrazioni dei moduli e modelli. Schema verificato eseguendo le migrazioni su MySQL 8.0 locale (vedi [test-coverage.md](test-coverage.md)).

## Rilievi

| ID | Gravità | Problema | Evidenza | Stato |
|---|---|---|---|---|
| D-01 | Alta | **Migrazioni duplicate per la stessa tabella**, in violazione della regola "una tabella, una migrazione" (AD-8). 27 tabelle hanno più `create_*_table`: `mail_templates` ×13 (6 in `_archive_redundant/`), `activity` ×9, `profiles` ×8 (3 in Meetup e 5 in User, **stessa tabella `profiles`**), `users` ×6, `consents` ×5, `events` ×2, `event_user` ×2… | `find Modules -path '*/database/migrations/*'` | ⏳ consolidare modulo per modulo, verificando lo stato `migrations` in ogni ambiente |
| D-02 | Alta | Tabelle orfane: `2026_03_05_000002_create_event_performers_table` e `…000003_create_event_sponsors_table` creano tabelle **plurali** che nessun modello usa (`EventPerformer::$table = 'event_performer'`, `EventSponsor::$table = 'event_sponsor'`) | `Modules/Meetup/database/migrations/` | ⏳ |
| D-03 | Alta | Nessuna foreign key sulle tabelle del dominio (`event_user`, `event_performer`, `event_sponsor`, `events.location_id`, `events.user_id`): eliminare un evento lasciava iscrizioni orfane | migrazioni Meetup | ✔ in parte: `DeleteEventAction` ora rimuove le righe pivot nella stessa transazione. Le FK reali restano da valutare (connessioni separate, `user_id` stringa UUID) |
| D-04 | Alta | Transazioni aperte sulla connessione sbagliata (default invece di `meetup`) | `Modules/Meetup/app/Actions/Event/*` | ✔ |
| D-05 | Media | `attendees_count` è un contatore denormalizzato, modificabile a mano dal form admin e mai riconciliato con `event_user` | `EventResource`, `Event::isFull()` | ✔ campo in sola lettura nel form. ⏳ comando di riconciliazione |
| D-06 | Media | Lo slug è generato da `Str::slug($title)` senza gestire le collisioni: due eventi con lo stesso titolo violano l'indice `unique` e il salvataggio fallisce con un errore SQL | `Event::booted()` | ⏳ suffisso progressivo, o `spatie/laravel-sluggable` già presente in `config/sluggable.php` |
| D-07 | Media | `events.slug` è `unique()->nullable()` nella migrazione 2026 e `unique()` in quella 2025: lo schema finale dipende dall'ordine di esecuzione | due `create_events_table` | ⏳ |
| D-08 | Bassa | Nessun indice composto per le query pubbliche (`status`, `start_date`) | migrazioni | ⏳ utile solo con molti eventi |
| D-10 | **Critica** | Su un database nuovo `profiles.id` era `uuid` (da `User/…/2022_01_01_000000` e `2026_01_01_000000`), mentre `BaseProfile` è incrementale (`HasUuids` commentato) e le migrazioni successive usano `id()`. Ogni richiesta autenticata che crea il profilo andava in 500 (`Field 'id' doesn't have a default value`) | Test `EventVisibilityPageTest`, `EventRegistrationTest` | ✔ le due migrazioni creano `id()` come le successive. Database esistenti non toccati (`tableCreate` agisce solo se la tabella manca). **Da verificare in produzione** lo schema reale di `profiles` |
| D-11 | **Critica** | `php artisan migrate` su MySQL vuoto falliva: (1) `->after('title')` dentro `CREATE TABLE events`; (2) migrazione `Activity/…/2026_02_13_171410_fix_causer_id_to_uuid.php` **vuota (0 byte)**, committata in `c6b3499c5`; (3) `organizer_id ->after('user_id')` prima che `user_id` esista | Run locale delle migrazioni | ✔ tutte e tre corrette; la migrazione Activity è ripristinata dalla copia in `_bak/` |
| D-12 | Alta | Contenuti CMS duplicati: due sezioni con slug `header` (`1.json`, `header.json`) e due `footer` → `Page::sole()` lancia `MultipleRecordsFoundException` e **ogni pagina con il layout app va in 500**. Inoltre 171 sezioni `test-section` e 7 pagine Faker (`1…8.json`) scritte dai test e committate | `config/local/laravelpizza/database/content/` | ✔ rimossi i duplicati vecchi (2025) e i file generati dai test. ⏳ `Cms/tests/Feature/PageManagementBusinessLogicTest.php` scrive ancora nei JSON reali |
| D-13 | Media | 55 file PHP vuoti (0 byte), tra cui `Notify/app/Console/Commands/CleanupNotificationLogsCommand.php`, `Notify/app/Http/Controllers/NotificationTrackingController.php`, factory e seeder in `Cms/database/Factories` e `Seeders` | `find -size 0` | ⏳ verificare caso per caso con la storia Git (probabile troncamento nello stesso sync di D-11) |
| D-09 | Info | Database SQLite committati (`laravel/database/*.sqlite`): contengono solo dati di test (440 utenti `@example.test`) | ispezione in sola lettura | ⏳ igiene del repo |

## Backup, restore, migrazioni reversibili

Nel repository non ci sono procedure di backup o restore né runbook. Le migrazioni Xot usano `tableCreate`/`tableUpdate` idempotenti (`hasTable`/`hasColumn`): ripetibili, ma i `down()` non sono stati verificati.
