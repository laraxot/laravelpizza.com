---
title: "ADR — Gli esiti delle email sono un evento Laravel, non una scrittura nel modulo"
type: decision
status: accepted
module: Notify
tags: [adr, notify, mailjet, eventi, agnostico]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../contracts/handle-mailjet-events-action.md
  - ../email/mailjet.md
---

# ADR: gli esiti delle email sono un evento, non una scrittura nel modulo

## Contesto

- Un esito (consegnata, rimbalzata, spam, disiscrizione) ha senso solo nel dominio del progetto: un cliente con email non valida, una
  prenotazione la cui conferma non è arrivata.
- Notify è condiviso tra progetti e non conosce quei modelli. `X-MJ-CustomID` e `X-MJ-EventPayload`, impostati dal Mailable, tornano
  uguali nel webhook (`docs/email/mailjet.md`).
- Domanda: dove finisce un esito ricevuto dal fornitore?

## Decisione

- `HandleMailjetEventsAction` traduce ogni evento in `Datas\MailDeliveryEventData` (`provider`, `type`, `email`, `at`, `messageId`,
  `customId`, `payload`, `reason`, `permanent`, `raw`) e lancia `Events\MailDeliveryEventReceived`.
- Il modulo non scrive nulla: il progetto ascolta l'evento e decide. Gli esiti definitivi finiscono anche in `Log::warning`.
- Il formato è indipendente dal fornitore (`provider`): un altro fornitore aggiunge un'Action che produce lo stesso Data.

## Alternative scartate

- Tabella degli esiti nel modulo: dati personali conservati senza che il modulo sappia per quanto e perché; e il progetto dovrebbe
  comunque ricollegarli al suo dominio.
- Aggiornare direttamente i modelli del progetto: Notify dipenderebbe dai moduli di dominio.

## Conseguenze

- Pro: modulo agnostico; il progetto usa `customId`/`payload` per ritrovare il suo record.
- Contro: senza un listener gli esiti si perdono (resta solo il log dei definitivi); nessuna deduplica degli eventi ritrasmessi.

## Verifica

`vendor/bin/pest Modules/Notify/tests --group=NOTIFY-MAILJET-INV-2` (`tests/Feature/MailjetEventsWebhookTest.php`, `Event::fake`): fallisce
se gli eventi validi non diventano `MailDeliveryEventReceived` con i campi attesi. Solo revisione: nessun `Model::create`/`save` in
`app/Actions/Mail/Mailjet/HandleMailjetEventsAction.php`.
