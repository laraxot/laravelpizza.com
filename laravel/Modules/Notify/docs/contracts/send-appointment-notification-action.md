---
title: "SendAppointmentNotificationAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SendAppointmentNotificationAction"
qmd: "SendAppointmentNotificationAction appuntamento notifica stub non implementato Patient"
---

# SendAppointmentNotificationAction

Entry point per le notifiche di appuntamento. Oggi e' uno stub: non invia nulla.

## Input

- `Model $appointment`: non letto.
- `string $type`: solo per il log.
- `array $additionalData`: solo per il log.

## Output

- `bool`: sempre `false`.

## Invarianti

- `NOTIFY-APPT-INV-1`: nessuna notifica viene inviata; il ritorno e' sempre `false`. Test: `tests/Unit/Actions/SendAppointmentNotificationActionTest.php` (dedicato; verifica il ritorno `false`, non verificato nel dettaglio).
- `NOTIFY-APPT-INV-2`: ogni chiamata scrive un `Log::debug` con `type` e `additional_data`. Test: nessuno dedicato verificato.

## Effetti collaterali

- Solo `Log::debug`. Nessuna scrittura, nessuna coda, nessun servizio esterno.

## Errori

- Il `catch` interno non puo' scattare: il blocco `try` non contiene operazioni che lanciano. Nessuna eccezione esce.

## Non fa

- Non legge `$appointment`, non invia mail/SMS/push.
- La proprieta' `$tries = 3` non ha effetto su questa chiamata sincrona.
- Motivo dichiarato nel log: modelli Patient non ancora disponibili.
