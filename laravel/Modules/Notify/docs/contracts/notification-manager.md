---
title: "NotificationManager — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\NotificationManager"
qmd: "NotificationManager facade notifiche sendMultiple getTemplate SendNotificationAction canali"
---

# NotificationManager

Facade di servizio sopra `SendNotificationAction`: invio singolo, invio multiplo e letture dei template. Classe senza suffisso `Action` nel nome, ma residente in `Actions/`.

## Input

- `send()` / `execute()`: `Model $recipient`, `string $templateCode`, `array $data`, `array $channels`, `array $options`.
- `sendMultiple()`: `array $recipients` (filtrati su `Model`).
- `getTemplate(string $code)`, `getTemplatesByCategory(string $category)`, `getTemplatesByChannel(string $channel)`.

## Output

- `send()` / `execute()`: `?Notification` (il primo record `database` restituito da `SendNotificationAction`), oppure `null`.
- `sendMultiple()`: lista dei soli record non nulli.
- Letture: `?NotificationTemplate` o `Collection` di template con `is_active = true`.

## Invarianti

- `NOTIFY-MANAGER-INV-1`: `execute()` e `send()` delegano a `SendNotificationAction::handle()` con `array_values($channels)`. Test: `tests/Unit/Actions/NotificationManagerTest.php` (dedicato, asserti non verificati).
- `NOTIFY-MANAGER-INV-2`: `sendMultiple()` salta silenziosamente i destinatari che non sono `Model`. Test: nessuno dedicato verificato.
- `NOTIFY-MANAGER-INV-3`: le letture filtrano sempre `is_active = true`. Test: nessuno dedicato verificato.

## Effetti collaterali

- Tramite `SendNotificationAction`: invii mail/SMS e scritture sulla tabella `notifications` per il canale `database`. Nessuna transazione attorno al ciclo multiplo.
- Le letture non scrivono.

## Errori

- Propaga `NotificationTemplateNotFoundException` da `SendNotificationAction`.
- In `sendMultiple()` un errore su un destinatario interrompe il ciclo (non c'e' try/catch).

## Non fa

- Non accoda il lavoro: l'invio e' sincrono salvo quanto fa `GenericNotification` (ShouldQueue).
- `getTemplatesByCategory` e `getTemplate` non filtrano per tenant.
