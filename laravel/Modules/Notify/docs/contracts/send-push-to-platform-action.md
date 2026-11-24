---
title: "SendPushToPlatformAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendPushToPlatformAction"
qmd: "SendPushToPlatformAction push piattaforma FCM legacy server key APNs webpush simulati HTTP"
---

# SendPushToPlatformAction

Invia una push a un token su una piattaforma precisa: FCM reale (HTTP legacy), APNs e Web Push simulati.

## Input

- `string $platform`: `fcm`, `apns` o `webpush`; altro valore lancia.
- `string $token`, `PushNotificationData $notification`, `array $data`.
- Config: `notify.fcm.server_key`, `NotifyConfigData::fcm_url`.

## Output

- `array`: `['success' => true, 'message_id', 'response']` per FCM; `['success' => true, 'message', 'platform']` per APNs e Web Push simulati.

## Invarianti

- `NOTIFY-PUSHPLAT-INV-1`: piattaforma sconosciuta lancia `Exception("Unsupported platform")`. Test: `tests/Unit/NotifyHighestMissCoverageTest.php` (menzione, asserti non verificati).
- `NOTIFY-PUSHPLAT-INV-2`: FCM risponde `success` solo con HTTP 2xx e campo `failure` assente o zero; `failure > 0` lancia anche con HTTP 200. Test: nessuno dedicato verificato.
- `NOTIFY-PUSHPLAT-INV-3`: APNs e Web Push restituiscono sempre `success = true` senza invio reale. Test: nessuno.

## Effetti collaterali

- FCM: POST HTTP sincrono con header `Authorization: key=...`.
- APNs e Web Push: solo log.

## Errori

- `Exception` per piattaforma sconosciuta, risposta FCM non valida, HTTP non 2xx o `failure > 0`.

## Non fa

- Non esiste un transport APNs o Web Push: il successo di quelle piattaforme non significa consegna.
- Non ritenta.
