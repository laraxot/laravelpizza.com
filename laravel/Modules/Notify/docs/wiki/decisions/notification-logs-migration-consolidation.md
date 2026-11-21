---
title: "Consolidamento migrazioni notification_logs (2 file duplicati → 1 XotBaseMigration)"
type: decision
tags: [notify, migration, notification_logs, xotbasemigration, schema]
created: 2026-07-22
updated: 2026-07-22
qmd: "NotificationLog notification_logs migration consolidation XotBaseMigration duplicate"
issues: []
discussions: []
related:
  - ../migrations/notifications_table.md
---

# Consolidamento migrazioni `notification_logs`

## Problema

Esistevano **due migrazioni distinte** che creavano la stessa tabella `notification_logs`,
entrambe ancora su `Illuminate\Database\Migrations\Migration` (violazione dello standard
`XotBaseMigration` del modulo) e con **schemi tra loro incompatibili**:

1. `2025_03_31_000001_create_notification_logs_table.php` — schema "vecchio":
   `title`, `content`, `channels` (json), `data` (json nullable), `sent_at`, `status`, `error`.
2. `2025_07_01_000000_create_notification_logs_table.php` — schema "intermedio":
   `type`, `channel`, `recipient`, `subject`, `message`, `status`, `sent_at`, `read_at`,
   `error_message`, `metadata` (json). Guardava con `if (! Schema::hasTable(...))`, quindi se
   la migrazione #1 girava per prima, le colonne di questo file **non venivano mai create**
   (bug silenzioso, non solo un problema di stile).

Nessuna delle due corrispondeva al `$fillable`/cast reale del model
`Modules\Notify\Models\NotificationLog`.

## Schema vincente e perché

Ho verificato le tre fonti indipendenti nel modulo che usano davvero le colonne:

- **Model** `NotificationLog` (`$table = 'notification_logs'`, `$fillable`): `template_id`,
  `notifiable_type`, `notifiable_id`, `channel`, `status`, `status_message`, `data`,
  `metadata`, `sent_at`, `delivered_at`, `failed_at`, `opened_at`, `clicked_at`, `tenant_id`.
- **`NotificationLogStatusEnum`**: `pending|sent|delivered|failed|opened|clicked` — coerente
  coi metodi `markAsOpened()`/`markAsClicked()` e le costanti `STATUS_*` del model.
- **`app/Traits/HasTenantNotifications.php`**: usa `tenant_id` e la relazione `template()`.
- **`app/Actions/NotificationManager.php`** (ex `app/Services/NotificationManager.php`):
  riferimenti a `STATUS_SENT/DELIVERED/FAILED/OPENED/CLICKED` — schema nuovo.

Contro-evidenza nota: `database/factories/NotificationLogFactory.php` usa ancora lo schema
**vecchio** (`title`, `content`, `channels`, `error`) — è l'unico file del modulo rimasto
disallineato. Non è stato modificato in questo intervento (fuori scope: qui si consolidano
le migrazioni, non si riscrivono le factory), ma è una **discrepanza nota da correggere** in
un prossimo intervento, altrimenti `NotificationLogFactory::new()->create()` fallirebbe
contro lo schema reale.

**Verdetto:** lo schema del model vince (3 fonti indipendenti coerenti contro 1 file, la
factory, chiaramente non aggiornata dopo l'ultima evoluzione del model).

## Cosa è stato fatto

- `2025_07_01_000000_create_notification_logs_table.php` → **eliminato** (nessun riferimento
  di codice al nome file/classe, solo menzioni in doc storiche `docs/*.md`, non toccate).
- `2025_03_31_000001_create_notification_logs_table.php` → riscritto per estendere
  `XotBaseMigration`, `tableCreate()` con lo schema del model, `tableUpdate()` +
  `updateTimestamps($table, false)` per gli audit column (`created_at/updated_at/created_by/
  updated_by`; niente soft delete, il model non usa `SoftDeletes`).
- Nessun cambio di nome file: `create_notification_logs_table` è già coerente con
  `getTable() === 'notification_logs'` e con la convenzione di derivazione automatica del
  model (`XotBaseMigration::getModelClass()`).

## Verifica

- `php -l` sul file consolidato: OK.
- `./vendor/bin/phpstan clear-result-cache && ./vendor/bin/phpstan analyse Modules/Notify`:
  **0 errori**.
- `tools/phpmd.sh Modules/Notify/database/migrations/2025_03_31_000001_create_notification_logs_table.php`:
  nessuna violazione (exit 0).

## Follow-up consigliato (fuori scope)

1. Allineare `NotificationLogFactory::definition()` al `$fillable` reale del model.
2. Verificare se `NotificationLogSeeder`/eventuali test usano la factory con lo schema vecchio.
