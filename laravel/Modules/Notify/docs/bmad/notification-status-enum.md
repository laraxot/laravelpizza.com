---
title: "Notification status enum"
module: Notify
type: decision
tags: [notify, enum, notification-log, status]
created: 2026-10-06
updated: 2026-10-06
---

# Notification status

Gli stati finiti del ciclo di vita sono backed enum `string`; i valori preservano le stringhe gia' presenti nel DB
(`pending`, `processing`, `sent`, `delivered`, `failed`, `opened`, `clicked`). Le migration restano con stringhe letterali.

| Enum | Dominio | Usato da |
|------|---------|----------|
| `NotificationLogStatusEnum` (`HasLabel/HasColor/HasIcon` + `EnumTrait`) | riga di `notification_logs` | cast `status` di `NotificationLog`, Form/Infolist/Table Filament, `CleanupNotificationLogsCommand`, factory |
| `NotificationStatusEnum` (senza UI) | riga di `notifications` | `SendNotificationAction` (`->value`; il modello `Notification` non ha cast: i valori storici non sono inventariati) |

Label/colore/icona di `NotificationLogStatusEnum` vengono da `lang/<locale>/notification_log_status_enum.php`
(chiave `values.<valore>.<attributo>`); senza la voce `getLabel()` restituisce `fix:<chiave>`.

Le vecchie costanti `NotificationLog::STATUS_*` sono state rimosse (nessun consumatore fuori da Notify).
Con il cast, `$log->status` e' l'enum: confrontare con `NotificationLogStatusEnum::SENT`, non con `'sent'`.

Aperto: i due enum hanno gli stessi valori; unificarli e' una decisione dell'utente.
Dettagli: [story/dev 2026-10-06](../stories/2026-10-06-phpstan-cleanup-notify.dev.md).
