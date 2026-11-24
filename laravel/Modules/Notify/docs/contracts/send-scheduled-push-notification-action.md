---
title: "SendScheduledPushNotificationAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendScheduledPushNotificationAction"
qmd: "SendScheduledPushNotificationAction push programmata job cache esecuzione failed fallimento definitivo"
---

# SendScheduledPushNotificationAction

Esegue l'invio di una push programmata da `SchedulePushNotificationAction`, leggendone i dati dalla cache.

## Input

- `string $jobId`: chiave della cache `scheduled_push:<jobId>`.

## Output

- `void`.

## Invarianti

- `NOTIFY-PUSHSCHEDRUN-INV-1`: cache assente o vuota: `Log::warning` e ritorno senza eccezione. Test: `tests/Unit/NotifyCoverage100ExtendedTest.php` (menzione, asserti non verificati).
- `NOTIFY-PUSHSCHEDRUN-INV-2`: token non stringa vengono scartati; `tokens`, `notification`, `data` devono essere array (altrimenti `Assert`). Test: nessuno dedicato verificato.
- `NOTIFY-PUSHSCHEDRUN-INV-3`: a successo la cache viene svuotata. Test: nessuno.
- `NOTIFY-PUSHSCHEDRUN-INV-4`: su eccezione la cache viene svuotata e l'eccezione viene rilanciata; `failed()` logga il fallimento definitivo.

## Effetti collaterali

- Invio tramite `SendPushToDevicesAction`.
- Cancellazione della chiave cache in ogni caso dopo la lettura (successo o errore).
- `Log::debug` con l'esito, `Log::error` su errore.

## Errori

- Eccezioni di `Assert` e di invio: rilanciate. Il job fallisce.

## Non fa

- Non ritenta in modo esplicito: la politica di retry e' quella del job in coda.
- Non cancella il job se la cache e' gia' scaduta: in quel caso il ramo di warning esce senza errore.
