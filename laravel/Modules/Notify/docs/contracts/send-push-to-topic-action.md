---
title: "SendPushToTopicAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendPushToTopicAction"
qmd: "SendPushToTopicAction push topic FCM topics simulato APNs webpush piattaforme"
---

# SendPushToTopicAction

Invia una push a un topic: su FCM tramite `/topics/<topic>`, su APNs e Web Push solo simulazione.

## Input

- `string $topic`, `PushNotificationData $notification`, `array $data`.

## Output

- `array<string, array>`: per piattaforma, `success`, `message`, `topic`, `platform` (o `success=false` con `error`).

## Invarianti

- `NOTIFY-PUSHTOPIC-INV-1`: le piattaforme sono `fcm`, `apns`, `webpush` in ordine fisso; errore su una non blocca le altre. Test: `tests/Unit/Actions/Push/SendPushNotificationActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-PUSHTOPIC-INV-2`: FCM invia a `/topics/<topic>` e risponde `success` con HTTP 2xx; altrimenti lancia. Test: nessuno dedicato verificato.
- `NOTIFY-PUSHTOPIC-INV-3`: APNs e Web Push non hanno topic: la consegna e' simulata e loggata, con successo. Test: nessuno.

## Effetti collaterali

- POST HTTP verso FCM. Log `notice` per le piattaforme simulate.
- `Log::error` su eccezioni per piattaforma.

## Errori

- Eccezioni per piattaforma convertite nel risultato. Nessuna eccezione esce.

## Non fa

- Non gestisce le sottoscrizioni topic-token: non esiste tabella.
- Non verifica la risposta FCM oltre allo stato HTTP (a differenza del singolo token, non controlla `failure`).
