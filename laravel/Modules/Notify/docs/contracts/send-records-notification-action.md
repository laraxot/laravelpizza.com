---
title: "SendRecordsNotificationAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SendRecordsNotificationAction"
qmd: "SendRecordsNotificationAction bulk notifica multipli record successCount errorCount Collection"
---

# SendRecordsNotificationAction

Invio in bulk: applica `SendRecordNotificationAction` a ogni record di una collection e aggrega i conteggi.

## Input

- `Collection $records`: record da notificare.
- `string $templateSlug`: passato invariato.
- `array $channels`: lista di canali (in pratica stringhe `'mail'`, `'sms'`, `'whatsapp'`).

## Output

- `SendNotificationBulkResultData` con `successCount`, `errorCount`, `errors` (record, channel, error), `totalProcessed = records * channels`.

## Invarianti

- `NOTIFY-RECORDS-INV-1`: per ogni record, un'eccezione aggiunge `count(channels)` a `errorCount` e un errore per canale; il ciclo prosegue. Test: `tests/Unit/Actions/SendRecordsNotificationActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-RECORDS-INV-2`: per ogni record senza eccezione, `successCount` cresce di `count(channels)`, anche se alcuni canali sono stati saltati (vedi Non fa).
- `NOTIFY-RECORDS-INV-3`: il nome del record per gli errori e' il primo tra `name`, `company_name`, `title` non vuoto, altrimenti la chiave.

## Effetti collaterali

- Per record: invio tramite `SendRecordNotificationAction` (vedi la sua scheda). Nessuna transazione: i record gia' processati non si annullano.
- Nessuna coda: l'esecuzione e' sincrona (il `onQueue` della documentazione e' possibile via `QueueableAction`).

## Errori

- Le `Exception` per record sono assorbite e riportate in `errors`. Gli errori non `Exception` (Error PHP) non sono catturati.

## Non fa

- Non conta i canali realmente consegnati: `successCount` e' un conteggio ottimistico.
- Bug: `SendRecordNotificationAction` salta i valori che non sono `ChannelEnum` (es. stringa `'mail'`). Con i canali passati come stringhe nessun messaggio parte, ma `successCount` cresce comunque (riga 62).
- Il commento su `report()` nel ciclo e' obsoleto.
