---
title: "HandleMailjetEventsAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\Mailjet\\HandleMailjetEventsAction"
qmd: "HandleMailjetEventsAction webhook Mailjet eventi bounce click open spam unsub MailDeliveryEventReceived token"
tags: [contract, action, notify, mailjet, webhook]
created: 2026-11-24
---

# HandleMailjetEventsAction

<<<<<<< HEAD
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Mail/Mailjet/HandleMailjetEventsAction.php`. Studio e integrazione: `docs/email/mailjet.md`.
Decisioni: [token nel percorso](../adr/webhooks-authenticate-with-a-token-in-the-path.md),
[esiti come evento](../adr/mail-delivery-outcomes-are-events.md).

## Input

- `POST /api/notify/mailjet/events/{token}` (rotta `notify.mailjet.events`, `routes/api.php`).
- Corpo JSON: un evento Mailjet oppure una lista (raggruppamento attivo nel pannello Mailjet).
- Config: `notify.notify.mailjet_webhook_token` (`MAILJET_WEBHOOK_TOKEN`).

## Output

- `401 {"error":"unauthorized"}` se il token non coincide o non è configurato.
- Altrimenti `200 {"handled": <n>}`, con `n` = eventi validi.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| NOTIFY-MAILJET-INV-1 | Token confrontato con `hash_equals`; token non configurato o vuoto = 401 per tutti, e nessun evento parte. | `NOTIFY-MAILJET-INV-1` |
| NOTIFY-MAILJET-INV-2 | Accetta sia un oggetto sia una lista; gli elementi non oggetto o senza `event`/`email` validi si saltano. | `NOTIFY-MAILJET-INV-2` |
| NOTIFY-MAILJET-INV-3 | `permanent` vale per hard bounce, `blocked`, `spam`, `unsub`; mai per `sent`, `open`, `click`, soft bounce. | `NOTIFY-MAILJET-INV-3` |
| NOTIFY-MAILJET-INV-4 | Tipi sconosciuti non sono un errore: risposta 200 (altrimenti Mailjet riprova ogni 30 s per 24 h e poi sospende l'URL). | `NOTIFY-MAILJET-INV-4` |

Test: `tests/Feature/MailjetEventsWebhookTest.php`.

## Effetti collaterali

- Un `MailDeliveryEventReceived` (con `MailDeliveryEventData`, `provider = 'mailjet'`) per ogni evento valido.
- `Log::warning('notify.mailjet.permanent_failure')` per ogni evento definitivo, con email, motivo e `custom_id`.

## Errori

- Nessuna eccezione per payload strani: si saltano. Un listener sincrono che lancia fa uscire l'eccezione (500): Mailjet riprova.

## Non fa

- Non scrive nel database: cosa fare di un esito (segnare un'email non valida, ritentare) lo decide il progetto ascoltando l'evento.
- Non deduplica: un evento ritrasmesso da Mailjet arriva due volte ai listener.
- Non verifica firme né IP di provenienza: l'unica autenticazione è il token.
- Non manda email (`CreateMailjetTransportAction` è il trasporto in uscita).
=======
Webhook Mailjet: valida il token nel path, normalizza gli eventi e li rilancia come `MailDeliveryEventReceived`.

## Input

- `Request $request`: JSON con uno o piu' eventi.
- `string $token`: dal path, confrontato con `config('notify.notify.mailjet_webhook_token')`.

## Output

- `JsonResponse`: `401 {error: unauthorized}` oppure `200 {handled: n}`.

## Invarianti

- `NOTIFY-MJEVENTS-INV-1`: token mancante in config, vuoto o diverso risponde `401`. Test: nessuno dedicato verificato.
- `NOTIFY-MJEVENTS-INV-2`: sono accettati solo i tipi `sent`, `delivered`, `open`, `click`, `bounce`, `blocked`, `spam`, `unsub`; gli altri e gli item senza `email` vengono saltati. Test: nessuno.
- `NOTIFY-MJEVENTS-INV-3`: `permanent` vale `true` per `blocked`, `spam`, `unsub` e per `bounce` con `hard_bounce = true`. Per `permanent` si logga `notify.mailjet.permanent_failure`. Test: nessuno.
- `NOTIFY-MJEVENTS-INV-4`: `time` numerico (o stringa di sole cifre) diventa la data dell'evento, altrimenti `now()`. Test: nessuno.
- `NOTIFY-MJEVENTS-INV-5`: `handled` conta gli eventi per cui e' stato lanciato `MailDeliveryEventReceived::dispatch`.

## Effetti collaterali

- `Log::warning` per eventi permanenti.
- `MailDeliveryEventReceived::dispatch` per ogni evento valido (i listener decidono le scritture).

## Errori

- Nessuna eccezione propria: payload non valido viene ignorato silenziosamente.

## Non fa

- Non verifica la firma dei webhook Mailjet: solo il token nel path.
- Non scrive direttamente su DB (lo fanno i listener, non letti qui).
>>>>>>> laraxot/dev
