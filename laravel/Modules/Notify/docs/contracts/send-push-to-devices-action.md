---
title: "SendPushToDevicesAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendPushToDevicesAction"
qmd: "SendPushToDevicesAction push batch token raggruppati piattaforma apns fcm webpush sent failed"
---

# SendPushToDevicesAction

Invia una push a piu' token raggruppandoli per piattaforma rilevata dal formato del token.

## Input

- `list<string> $tokens`, `PushNotificationData $notification`, `array $data`.

## Output

- `array<string, array>`: per piattaforma `success`, `sent`, `failed`, `total`, `results` (o `success=false` con `error` se il batch lancia).

## Invarianti

- `NOTIFY-PUSHDEVS-INV-1`: la piattaforma e' dedotta: 64 caratteri esadecimali = `apns`; piu' di 100 caratteri con `:` = `fcm`; altrimenti `webpush`. Test: `tests/Unit/Actions/Push/SendPushNotificationActionTest.php` (file dedicato, asserti non verificati).
- `NOTIFY-PUSHDEVS-INV-2`: `success` del batch e' `true` solo se nessun token fallisce. Stesso test.
- `NOTIFY-PUSHDEVS-INV-3`: un token che lancia viene contato come fallito e il batch prosegue. Stesso test.

## Effetti collaterali

- Una chiamata per token tramite `SendPushToPlatformAction` (HTTP per FCM).
- `Log::error` su batch fallito.

## Errori

- Eccezioni di `Assert` su tipi non stringa escono (non catturate nel ciclo di raggruppamento).

## Non fa

- Non deduplica i token e non rimuove quelli rifiutati.
- Il rilevamento della piattaforma e' un'euristica: un token FCM corto o webpush lungo puo' essere classificato male.
