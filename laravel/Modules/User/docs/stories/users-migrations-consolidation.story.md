---
title: "Migrazioni users: consolidamento in create_users_table (convenzione 1 modello = 1 migrazione)"
type: story
bmad: true
status: complete
created: 2026-11-12
owner: module:User
module: User
related: [xotbase-migration-religion, one-migration-per-model, production-500-deleted-at]
tags: [migrations, users, convention, production]
---

# Migrazioni users: consolidamento in create_users_table

## Contesto

In produzione `users` è una tabella legacy senza `deleted_at`: l'auth va in 500
(`Unknown column 'users.deleted_at'`). La prima correzione aveva introdotto la migrazione
`2026_11_12_000002_repair_users_deleted_at_column.php`, che **non rispettava le
convenzioni**:

- nome file: dopo la data deve essere `<azione>_<modello_plurale>_table`
  (`create_users_table` / `update_users_table`), non `repair_*_column`;
- **una migrazione per modello**: i cambi colonna si fanno nella migrazione del
  modello, modificandola e cambiandone il timestamp — non in file `repair_*` /
  `add_*_to_*` separati.

Stessa violazione per le due migrazioni sorelle su `users`:
`2026_10_22_000001_repair_users_type_state_columns.php` e
`2026_11_11_000001_add_digital_identity_columns_to_users_table.php`.

## Decisione

Fondere tutti i `tableUpdate` mancanti in
`Modules/User/database/migrations/2026_11_12_120000_create_users_table.php`
(la create canonica del modello User, `model_class = User::class`):

- `type`, `state` — già presenti nel tableUpdate esistente;
- `deleted_at` — `updateTimestamps($table, true)` con guard `hasColumn` (caso produzione);
- `fiscal_code`, `auth_method`, `identity_provider`, `last_login_at` —
  colonne SPID/CIE della migrazione digital-identity.

Poi:

1. Eliminare i tre file non conformi.
2. Rinominare la create con timestamp nuovo
   (`2026_11_12_120000_create_users_table.php`) così viene registrata come
   migrazione nuova e gira in produzione: `tableCreate` è no-op dove la tabella
   esiste, `tableUpdate` è idempotente (`hasColumn`/`hasColumnType`) e aggiunge
   solo le colonne mancanti — incluso `deleted_at`.

Tutto `XotBaseMigration` + `tableUpdate` + guard; la gestione esistente e necessaria
delle chiavi UUID con `Schema` resta invariata; nessun `down()` distruttivo.

## Perché è sicuro

- Ambienti dove le tre migrazioni separate sono già girate: le colonne esistono,
  il tableUpdate fuso non fa nulla.
- Produzione (tabella vecchia): aggiunge tutte le colonne mancanti in un colpo.
- Fresh install: `tableCreate` crea tutto, `tableUpdate` è no-op.

## File toccati

- `Modules/User/database/migrations/2026_11_12_120000_create_users_table.php`
  → owner migration con `tableUpdate` esteso
- eliminati: `2026_10_22_000001_repair_users_type_state_columns.php`,
  `2026_11_11_000001_add_digital_identity_columns_to_users_table.php`,
  `2026_11_12_000002_repair_users_deleted_at_column.php`

## Verifica

- `php -l` sui file toccati
- `php artisan module:migrate User --pretend` (o migrate:status) per confermare
  che la migrazione è vista come pending e genera le colonne attese
