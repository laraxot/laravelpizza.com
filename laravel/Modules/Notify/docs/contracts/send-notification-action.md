---
<<<<<<< .merge_file_Njp6qV
<<<<<<< .merge_file_PEgnxv
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_pYHm0d
=======
>>>>>>> .merge_file_VEF9Ki
title: "Contratto — SendNotificationAction"
type: contract
action: "Modules\Notify\Actions\SendNotificationAction"
tags: [contract, action, notify, template, multicanale]
created: 2026-11-24
updated: 2026-11-24
<<<<<<< .merge_file_Njp6qV
<<<<<<< .merge_file_PEgnxv
=======
>>>>>>> laraxot/dev
title: "SendNotificationAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SendNotificationAction"
qmd: "contract SendNotificationAction notify invio notifica template canali mail sms database NOTIFY-SEND-INV"
<<<<<<< HEAD
tags: [contract, action, notify, template, multicanale]
created: 2026-11-24
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_pYHm0d
=======
>>>>>>> .merge_file_VEF9Ki
---

# SendNotificationAction

<<<<<<< .merge_file_Njp6qV
<<<<<<< .merge_file_PEgnxv
<<<<<<< HEAD
=======
>>>>>>> .merge_file_pYHm0d
=======
>>>>>>> .merge_file_VEF9Ki
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
<<<<<<< .merge_file_Njp6qV
<<<<<<< .merge_file_PEgnxv
=======
Invia una notifica a un destinatario partendo da un `NotificationTemplate` attivo, su uno o piu' canali (`mail`, `database`, `sms`).
Raggiunta da `app/Actions/NotificationManager.php`. Decisione di fondo sul ruolo di Notify: [ADR notify-owns-delivery-contract](../adr/notify-owns-delivery-contract.md) (stato `proposed`).

> Il metodo pubblico si chiama `handle()`, non `execute()`: differisce dalla convenzione delle Queueable Action del progetto (dichiarato qui, non corretto).

## Input

- `Model $recipient`: destinatario (usa `routeNotificationForMail()` / `routeNotificationForSms()` se presenti, `getKey()`, `getAttribute('user_id')`).
- `string $templateCode`: `code` di un `NotificationTemplate` con `is_active = true`.
- `array<string,mixed> $data`: variabili del template.
- `array<int,string> $channels`: canali; se vuoto si usano `$template->channels`.
- `array<string,mixed> $options`: opzioni passate alla notifica.

## Output

- `?NotificationModel`: il primo record creato dal canale `database`; `null` se il template decide di non inviare o se nessun canale `database` e' stato usato (mail e sms non restituiscono record).

## Invarianti

- **NOTIFY-SEND-INV-1** — Se non esiste un template attivo con quel `code` viene lanciata `NotificationTemplateNotFoundException::forCode($templateCode)` prima di qualsiasi invio.
  Verifica non marcata: `Modules/Notify/tests/Unit/Actions/SendNotificationActionTest.php:85` («throws when template is missing»); nessun `->group('NOTIFY-SEND-INV-1')`.
- **NOTIFY-SEND-INV-2** — Se `$template->shouldSend($data)` e' falso l'Action ritorna `null` senza inviare nulla ne' scrivere record.
  Verifica non marcata: `SendNotificationActionTest.php:94`, ma il test asserisce `Assert::assertFalse($result)` mentre il codice ritorna `null` (`SendNotificationAction.php`, `return null`): divergenza tra test e codice, vale il codice; test non eseguito in questa sessione.
- **NOTIFY-SEND-INV-3** — Un canale che fallisce (destinatario senza email o telefono, canale non supportato) non blocca gli altri: l'eccezione e' catturata e registrata con `Log::error`, l'Action non la rilancia.
  Non coperto (nessun test dedicato trovato).
- **NOTIFY-SEND-INV-4** — Il canale `database` salva sempre un `Notification` con `status = sent`, `sent_at = now()`, `channels = ['database']` e il payload (`subject`, corpo, `template_code`, `payload`, `options`).
  Stessa verifica parziale: `SendNotificationActionTest.php:115` («dispatches database notification from template channels»).
- **NOTIFY-SEND-INV-5** — Il testo SMS e' troncato a 320 caratteri (317 piu' `...`), riga 194-195.
  Non coperto.

## Effetti collaterali

- Ordine: lettura template -> `shouldSend` -> `compile($data)` -> per ogni canale: invio (`notify()` / `Notification::send` con `GenericNotification`, che implementa `ShouldQueue`) o `INSERT` su `notifications` per il canale `database`.
- Scrive log di errore per canale fallito.
- Nessuna transazione: i canali gia' inviati non si annullano se uno successivo fallisce.

## Errori

- `NotificationTemplateNotFoundException` (INV-1), unico errore che esce dall'Action.
- Le `Exception` dei canali sono assorbite (INV-3): il chiamante non sa se un canale e' fallito se almeno uno e' riuscito, ne' se tutti sono falliti (ritorna `null`).

## Non fa

- Non ritenta e non traccia lo stato di consegna per mail e sms (nessun record, solo accodamento).
- Non supporta `push`, `whatsapp`, `telegram`: un canale diverso da `mail`, `database`, `sms` fallisce con «Canale ... non supportato» (assorbito).
- Non valida il formato di email o telefono.
- Non controlla il consenso del destinatario.
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_pYHm0d
=======
>>>>>>> .merge_file_VEF9Ki
