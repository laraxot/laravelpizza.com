---
title: "SchedulePushNotificationAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SchedulePushNotificationAction"
qmd: "SchedulePushNotificationAction programma push futuro cache scheduled_push job delay ActionJob"
---

# SchedulePushNotificationAction

Programma l'invio di una push a un orario futuro: salva i dati in cache e accoda il job di invio con ritardo.

## Input

- `list<string> $tokens`: token destinatari.
- `PushNotificationData $notification`.
- `array $data`: dati extra.
- `DateTime $scheduleTime`: orario di invio.

## Output

- `string`: il `jobId` (`push_` + uniqid).

## Invarianti

- `NOTIFY-PUSHSCHED-INV-1`: la cache `scheduled_push:<jobId>` contiene token, notifica, dati e timestamp, con scadenza `$scheduleTime`. Test: `tests/Unit/NotifyRemainingCoverageTest.php` (menzione, asserti non verificati).
- `NOTIFY-PUSHSCHED-INV-2`: viene accodato un `ActionJob` su `SendScheduledPushNotificationAction` con `[$jobId]`, ritardato a `$scheduleTime`. Test: nessuno dedicato verificato.

## Effetti collaterali

- Scrittura cache (token inclusi in chiaro nella cache).
- Dispatch di un job in coda con delay.

## Errori

- Nessuna gestione interna: errori di cache o coda propagano.

## Non fa

- Non verifica che `$scheduleTime` sia nel futuro: un orario passato invia subito.
- Non valida i token.
- Non permette di annullare un job: nessuna action di cancellazione.
