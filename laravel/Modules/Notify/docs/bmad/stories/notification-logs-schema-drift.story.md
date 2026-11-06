---
title: "notification_logs: allineamento schema canonico su DB legacy"
status: done
module: Notify
created: 2026-11-05
updated: 2026-11-05
qmd: "notification_logs schema drift legacy migration canonica model vince"
---

# notification_logs — schema canonico su DB legacy

## Problema

Tre bug di schema-drift rilevati dall'audit (subagent) sulle connessioni di test:

1. **`notification_logs`** (connessione `notify`): la tabella esistente è stata
   creata dalla variante legacy di `2025_03_31_000001` (`title`, `content`,
   `channels` json, `sent_at`/`status` NOT NULL). Il file è stato riscritto in
   place il 2026-07-22 con lo schema canonico, ma `tableCreate()` salta le
   tabelle esistenti → le colonne canoniche (`template_id`, `channel`,
   `status_message`, `metadata`, `tenant_id`, `delivered_at`, `failed_at`,
   `opened_at`, `clicked_at`) non esistevano da nessuna parte. Model e factory
   scrivono colonne assenti → insert fallivano.
2. **`notifications.notifiable_id`** su connessione `xot`: tabella parallela
   legacy con `notifiable_id` bigint mentre la tabella canonica (connessione
   `user`) ha uuid. Richiede decisione di dominio (due modelli `Notification`
   paralleli: `User\Models\Notification` canonico vs `Notify\Models\Notification`
   legacy usato da `NotificationResource`) — **aperto**, vedi "Da decidere".
3. **`temporary_uploads.id`** (Media): verificato e fixato in separata —
   `HasUuids` + `keyType string` sul model (commit `5c9413c86e`).

## Soluzione

Migration additiva `2026_11_05_144500_update_notification_logs_table.php`
(`XotBaseMigration`, solo `up()`, `model_class = NotificationLog`):

- Aggiunge le 9 colonne canoniche mancanti, tutte nullable, con guard
  `hasColumn` per idempotenza.
- Rende nullable `title`, `content`, `channels` (tipi preservati: varchar,
  text, longtext) e `sent_at` → gli insert canonici non le valorizzano.
- `notifiable_id` bigint → `string(36)` solo se il tipo è ancora bigint
  (valori legacy restano stringhe, nessun cast distruttivo).
- `status` con default `pending` come da canonico.
- `ensureIndexes()` per gli indici canonici (channel, status, sent_at,
  morph notifiable).
- Colonne legacy e dati esistenti preservati: niente drop unilaterale
  (dati sacri).

## Verifica

- `php -l` ✅
- `php artisan module:migrate Notify --env=testing` → DONE 189ms
- DESCRIBE post-migrazione: tutte le colonne canoniche presenti,
  legacy nullable, `notifiable_id` varchar(36) ✅
- `phpstan analyse Modules/Notify` → 0 errori ✅

## Da decidere (aperto)

- **Doppio model `notifications`**: canonico = `User\Models\Notification`
  (connessione `user`, contract `notifications-database-contract.md`);
  `Notify\Models\Notification` (connessione `xot`, schema legacy
  `message/channels/status`) è ancora referenziato da
  `NotificationResource`, `NotificationFactory` e test. Opzioni:
  (a) migration additiva `notifiable_id`→uuid sulla tabella `xot`
  (viola il contratto "UNICA migrazione"); (b) migrare resource/factory/test
  al model canonico e rimuovere il duplicato — più pulito, più invasivo.
  **Serve decisione utente/dominio.**
- **Prod (`ptv_lara`)**: verificare se `notification_logs` ha lo schema
  vecchio anche in produzione — se sì, `NotificationManager` e
  `CleanupNotificationLogsCommand` falliscono lì (potenziale P0).

## Fonti

- Contract: `Modules/Notify/docs/wiki/concepts/notifications-database-contract.md`
- Decisione schema: `Modules/Notify/docs/wiki/decisions/notification-logs-migration-consolidation.md`
