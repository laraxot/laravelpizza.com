# Meetup: Analisi Errori `migrate --env=testing` (2026-03-06)

## Contesto verificato

Comando eseguito da `laravel/`:

```bash
php artisan migrate --env=testing -vvv
```

Sequenza osservata nel debugging reale:

1. In sandbox: `SQLSTATE[HY000] [2002]` (falso primario dovuto al contesto di esecuzione).
2. Fuori sandbox: parse blocker transitorio su migration Meetup 2026.
3. Dopo riesecuzione: blocker strutturale persistente su migration Meetup 2025.

## Failure strutturale confermato

Migration:
- `Modules/Meetup/database/migrations/2025_01_01_000008_create_event_user_table.php`

Errore:
- `SQLSTATE[42S21]: Column already exists: 1060 Duplicate column name 'user_id'`

## Root cause tecnico

Nel `tableCreate(...)` di `create_event_user_table`:

- viene definita colonna business `user_id` (utente registrato all'evento);
- viene poi chiamato `$this->timestamps($table)`.

`XotBaseMigration::timestamps()` aggiunge automaticamente anche:
- `user_id` (audit actor),
- `updated_by`,
- `created_by`.

Risultato: doppia definizione di `user_id` nello stesso DDL, collisione deterministica.

## Perché è importante

- blocca bootstrap DB testing dell'intero progetto;
- impedisce run coverage/stabilizzazione che dipendono da `migrate --env=testing`;
- impatta tutti i test integrati che toccano Meetup.

## Decisione tecnica proposta

Per tabelle che hanno una `user_id` di dominio (pivot/event_user):

- non usare `timestamps()` (che include `user_id` audit),
- usare `updateTimestamps()` oppure colonne audit esplicite senza ridefinire `user_id`.

Obiettivo: separare chiaramente `user_id` di business da metadata audit.

## Verifica attesa post-fix

```bash
php artisan migrate --env=testing -vvv
```

Esito atteso:
- superamento migration `2025_01_01_000008_create_event_user_table` senza `42S21`.

## Applicazione linea guida (2026-04-16)

Modifiche applicate alle migration Meetup:

- `2025_01_01_000008_create_event_user_table.php`: mantiene `user_id` come colonna di dominio, usa `tableCreate()` senza guard esterno, aggiunge `created_by`/`updated_by` tramite `foreignIdFor($userClass, ...)` e usa `updateTimestamps()` nel ramo di update.
- `2026_03_05_000001_create_event_user_table.php`: rimossa perché duplicava la creazione della stessa tabella `event_user`. La fonte di verità resta la migration 2025.
- `2026_03_08_102952_CreateMeetupFeedbacksTable.php`: mantiene `user_id` come colonna di dominio, usa audit columns tramite `foreignIdFor($userClass, ...)`, `softDeletes()` e `updateTimestamps(..., hasSoftDeletes: true)` nel ramo di update.

La correzione segue la regola Laraxot: una sola migration di creazione per tabella e separazione esplicita tra `user_id` di dominio e colonne audit.
