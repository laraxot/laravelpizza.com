---
title: "Migrazioni UUID user_id e convenzione filename"
type: story
module: Lang
status: in-progress
created: 2026-11-05
updated: 2026-11-10
tags: [bmad, migrations, uuid, naming, user-id]
qmd: "Lang UUID user_id migration naming timestamp action model plural table ledger"
related:
  - ../../migrations.md
  - ../../wiki/concepts/migration-path-canonical.md
  - ../../../../Xot/docs/wiki/rules/migration-filename-from-model-name.md
  - ../../../../Xot/docs/bmad/decision-log.md
  - ../../../../Xot/docs/bmad/stories/migration-standards-correction.story.md
---
# Migrazioni UUID user_id e convenzione filename

## Scopo

`posts.user_id` e `translations.user_id` devono poter contenere le chiavi UUID
usate dagli utenti. Le colonne legacy erano `bigint`; una conversione diretta
può lasciare valori numerici non validi per il modello User. Le migrazioni
convergono solo quando la colonna è già UUID o non contiene valori legacy.

## Convenzione verificata

Il filename mantiene timestamp, azione, owner tabella al plurale in
`snake_case` e suffisso `_table.php`:

```text
YYYY_MM_DD_HHMMSS_<azione>_<modello_plurale>_table.php
```

Le migrazioni interessate sono `2026_11_05_100000_create_posts_table.php` e
`2026_11_05_100001_create_translations_table.php`. Dichiarano `$model_class`,
perché `XotBaseMigration` deriva il modello automaticamente solo dal formato
`create_*_table`. Timestamp e ordine sono preservati; l'helper idempotente fa
sì che i vecchi filename registrati nel ledger non causino una seconda
conversione distruttiva.

## Decisioni di sicurezza dati

- `XotBaseMigration::convertUserIdToUuidIfLegacyBigint()` non modifica una
  colonna già UUID. Con valori legacy non null, le migrazioni owner usano la
  modalità esplicita di compatibilità: convertono la colonna a `char(36)` e
  conservano i numeri, lasciando il mapping verificabile da completare.
- Ogni migrazione controlla `tableExists()` prima di `tableUpdate()`. In questo
  modo l'API `tableUpdate()` non crea una tabella vuota quando manca il target.
- Non sono state rinominate le sette migrazioni storiche di altri moduli:
  risultano già pubblicate e il filename è parte della chiave del ledger.
- Le due create duplicate di `Post` e `Translation` in Lang restano da
  confrontare con i ledger di tutti gli ambienti prima di qualunque
  consolidamento forward-only.

## Acceptance criteria

- [x] AC1: le migrazioni Lang usano `create_<modello_plurale>_table.php` (una owner per tabella).
- [x] AC2: documentazione owner Lang, standard Xot, Blueprint Filament e second
  brain descrivono la stessa convenzione.
- [x] AC3: audit di `Modules/*/database/migrations/` e
  `Themes/*/database/migrations/`; eccezioni pubblicate inventariate senza
  rinomina retroattiva.
- [x] AC4: lint, Pint, PHPStan Lang, Pest Translation e `migrate --pretend`
  superati.
- [ ] AC5: definire un mapping verificabile per eventuali `user_id` bigint
  non null negli ambienti esistenti (i valori sono ora preservati).
- [ ] AC6: confrontare i ledger degli ambienti per le due coppie di migrazioni
  di creazione duplicate, poi definire una correzione forward-only.

## Incidente 2026-11-10: errore 4078 su MariaDB 11.8

`php artisan migrate` falliva su `2026_11_05_100000_create_posts_table` con
`SQLSTATE[HY000] 4078 Cannot cast 'bigint unsigned' as 'uuid'` (SQL:
`alter table posts modify user_id uuid null`). Causa radice: da MariaDB 10.7
`uuid` è un tipo nativo e il server rifiuta `bigint -> uuid` a prescindere dai
dati; il guard dell'helper vedeva correttamente 0 righe con valore, ma
l'`ALTER` diretto veniva respinto lo stesso (colonna reale: `bigint(20)
unsigned NULL`, tabella vuota, MariaDB 11.8.6).

Correzione (owner Xot, un solo punto per tutti i chiamanti): su driver
mysql/mariadb `XotBaseMigration::convertUserIdToUuidIfLegacyBigint()` emette
prima `char(36) NULL` e poi `uuid`; `char(36) -> uuid` è accettato. Il guard
sulle righe valorizzate resta invariato. Nessuna colonna rimossa, nessun dato
riscritto.

Verifica: uno script standalone (Pest non gira qui: `.env.testing` senza
`DB_USERNAME`) esegue gli `ALTER` del Blueprint su una tabella `TEMPORARY` di
sessione, senza toccare tabelle reali. RED: il solo `uuid` fallisce con 4078.
GREEN: `char(36)` poi `uuid` passano e la colonna risulta `uuid NULL`. `php -l`,
Pint e PHPStan (config di progetto) su `XotBaseMigration.php`: puliti.
La migrazione reale non è stata rieseguita dall'agente: va rilanciata
dall'utente con `php artisan migrate`.

La correzione ha consolidato la conversione nelle migrazioni owner
`create_posts_table` e `create_translations_table`, che verificano
`tableExists()` e passano `preserveLegacyValues: true` a
`XotBaseMigration::convertUserIdToUuidIfLegacyBigint()`: i valori numerici
legacy restano in `char(36)` senza inventare mapping o perdere dati. Le gemelle
`update_user_id_uuid_on_*` (conversione diretta non custodita) sono state
rimosse; `update_translations_table` e' stata rinominata
`create_translations_table` con lo stesso timestamp.

## Esito dell'audit filename

L'audit dei percorsi canonici ha trovato 252 migrazioni nei Moduli e nessuna nei
Temi. **245/252** nei Moduli seguono il formato dichiarato. Le sette eccezioni
sono già pubblicate e vengono conservate:

- Activity: `2026_02_13_171410_fix_causer_id_to_uuid.php`.
- Sigma: `2026_09_30_create_import_logs_table.php` e
  `2026_09_30_create_import_trackers_table.php`.
- User: `2026_02_13_172135_add_lang_column.php`,
  `2026_11_04_220000_add_query_supporting_indexes.php`,
  `2026_10_16_000001_fix_profiles_id_autoincrement.php` e
  `2026_10_22_000001_repair_users_type_state_columns.php`.

I remoti `laraxot/dev` di Activity, Sigma e User puntano agli HEAD che
contengono questi nomi. Non è stato verificato il ledger di ogni database; la
pubblicazione basta a rendere rischiosa una rinomina retroattiva. Nel worktree
sono state annullate le rinomine temporanee delle due migrazioni Sigma, che
avrebbero introdotto nuove chiavi senza una modifica di schema necessaria.

In Lang esistono quattro file `create_*_table.php`: due coppie storiche per
`Post` e `Translation` (2026-01-21 e 2026-08-06). La cartella maiuscola
`database/Migrations/` contiene inoltre una variante legacy di `language_lines`;
`XotBaseServiceProvider` carica il path minuscolo standard. Verificare
l'eventuale uso da consumer esterni prima di spostare o rimuovere la variante.

## Verifica eseguita

- `php -l` sulla migrazione Translation: OK.
- Pint `--test` sulla migrazione Translation: passed.
- PHPStan `analyse Modules/Lang`: `[OK] No errors`.
- Pest `Modules/Lang/tests/Unit/Models/TranslationTest.php`: 6 passed,
  14 assertions.
- `php artisan migrate --pretend --path=...create_translations_table.php`:
  solo query di introspezione e nessun `CREATE TABLE`.
- Blueprint Filament Lang: registra che il naming schema appartiene alle
  migrazioni Xot/Lang; nessun componente UI era richiesto.
