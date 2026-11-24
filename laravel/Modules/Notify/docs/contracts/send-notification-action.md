---
title: "Contratto — SendNotificationAction"
type: contract
action: "Modules\Notify\Actions\SendNotificationAction"
tags: [contract, action, notify, template, multicanale]
created: 2026-11-24
updated: 2026-11-24
---

# SendNotificationAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SendNotificationAction.php`. Descrive il codice **com'è**, difetti compresi.

## Input

- `handle(Model $recipient, string $templateCode, array $data = [], array $channels = [], array $options = [])`.
- Il template `NotificationTemplate` attivo con quel `code`; `channels` vuoto = canali del template.

## Output

- La `Notification` salvata dal canale `database` (la prima), oppure `null` se nessun canale `database`, se tutti i canali falliscono
  o se il template dice di non inviare (`shouldSend($data)` falso).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| NOTIFY-SEND-INV-1 | Template assente o non attivo → `NotificationTemplateNotFoundException` prima di qualunque invio. | — |
| NOTIFY-SEND-INV-2 | Un canale che fallisce viene loggato e non ferma gli altri. | — |
| NOTIFY-SEND-INV-3 | Canali ammessi: `mail`, `database`, `sms`; ogni altro nome è un errore di canale (loggato). | — |
| NOTIFY-SEND-INV-4 | SMS: testo senza HTML, massimo 320 caratteri (troncato a 317 + `...`). | — |

Debito: `tests/Unit/Actions/SendNotificationActionTest.php` prova INV-1 (verde) ma due test si aspettano `false`/`true` mentre il
metodo restituisce `null`/`Notification`: sono rossi e vanno corretti prima di aggiungere i group.

## Effetti collaterali

- `mail` e `sms`: `GenericNotification` inviata con `$recipient->notify()` o `Notification::send()` (sincrona salvo code del canale).
- `database`: una riga `Notification` con `status = sent`, `sent_at`, e in `data` soggetto, corpi, codice e id del template, payload e opzioni.
- `Log::error` per ogni canale fallito.

## Errori

- Solo il template mancante esce come eccezione; gli errori dei canali (destinatario senza email o telefono, canale sconosciuto) restano nel log.

## Non fa

- Non scrive `notification_logs` (`NotificationLog`).
- `notifiable_id` e `user_id` passano da `normalizeModelKey()`: una chiave UUID diventa `null` (difetto noto, da non imitare con utenti UUID).
- Non ritenta e non mette in coda da sé (per la coda: `onQueue()` di QueueableAction).
- Non sceglie il fornitore SMS né il mailer: usa i canali Laravel configurati.
