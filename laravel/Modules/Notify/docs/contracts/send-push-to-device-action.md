---
title: "SendPushToDeviceAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendPushToDeviceAction"
qmd: "SendPushToDeviceAction push singolo token fcm apns webpush piattaforme esito per piattaforma"
---

# SendPushToDeviceAction

Invia una push a un singolo token provandole tutte le piattaforme supportate (`fcm`, `apns`, `webpush`).

## Input

- `string $token`, `PushNotificationData $notification`, `array $data`.

## Output

- `array<string, array>`: esito per piattaforma (`SendPushToPlatformAction` oppure `['success' => false, 'error' => ...]`).

## Invarianti

- `NOTIFY-PUSHDEV-INV-1`: le piattaforme sono provate in ordine fisso `fcm`, `apns`, `webpush`. Test: `tests/Unit/Actions/Push/SendPushNotificationActionTest.php` (file dedicato, asserti non verificati).
- `NOTIFY-PUSHDEV-INV-2`: un'eccezione su una piattaforma non interrompe le altre; viene loggata con `Log::error` (incluso il token) e registrata come fallita. Stesso test.

## Effetti collaterali

- Chiamata HTTP verso FCM. APNs e Web Push solo log (vedi [log-simulated-push-delivery-action](log-simulated-push-delivery-action.md)).
- `Log::error` con token in chiaro per le eccezioni.

## Errori

- Nessuna eccezione esce: tutte sono convertite nel risultato per piattaforma.

## Non fa

- Non determina quale piattaforma e' quella giusta per il token: prova tutte e conta come successo quelle simulate.
- Non rimuove token non validi.
