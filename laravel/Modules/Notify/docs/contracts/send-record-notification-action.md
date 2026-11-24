---
title: "SendRecordNotificationAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SendRecordNotificationAction"
qmd: "SendRecordNotificationAction notifica singolo record canali ChannelEnum route RecordNotification"
---

# SendRecordNotificationAction

Invia una `RecordNotification` a un singolo record (es. Client) su una lista di canali `ChannelEnum`.

## Input

- `Model $record`: il record da notificare.
- `string $mailTemplateSlug`: slug del template usato da `RecordNotification`.
- `array $channels`: elementi `ChannelEnum`; gli altri tipi vengono ignorati.

## Output

- `void`.

## Invarianti

- `NOTIFY-RECNOTIF-INV-1`: un elemento che non e' `ChannelEnum` viene saltato senza errore. Test: `tests/Unit/Actions/SendRecordNotificationActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-RECNOTIF-INV-2`: il destinatario per canale e' `ChannelEnum::getRecipient($record)`; se null o stringa vuota il canale viene saltato. Stesso test.
- `NOTIFY-RECNOTIF-INV-3`: la route usa `$channelEnum->value` (es. `mail`, `sms`), non la FQCN del canale custom: la scelta e' motivata nel sorgente (righe 38-45). Test: nessuno dedicato verificato.

## Effetti collaterali

- Per ogni canale valido: `Notification::route($canale, $to)->notify(...)`. Nessuna transazione. Il canale effettivo lo decide `RecordNotification::via()`.

## Errori

- Nessuna gestione interna: le eccezioni di `notify()` propagano al chiamante.
- Incoerenza nel docblock di `SendRecordsNotificationAction`, che dice che gli errori sono gestiti via `report()`: qui non esiste nessun `report()` (vedi Non fa).

## Non fa

- Non registra log quando un canale viene saltato (i commenti parlano di log, il codice no).
- Non restituisce l'esito per canale.
