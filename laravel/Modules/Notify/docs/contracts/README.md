---
title: "Contratti del modulo Notify"
type: index
module: Notify
status: active
tags: [contracts, actions, interfaces, notify]
created: 2026-11-18
updated: 2026-11-24
qmd: "notify contracts readme azioni invarianti pest group notifiche invio"
---

# Contratti del modulo Notify

Cosa promette la superficie pubblica di Notify: le Action che scrivono dati, chiamano servizi esterni o hanno effetti collaterali,
e le interfacce (`app/Contracts`). Un contratto descrive il comportamento promesso da una Action che invia comunicazioni ai
destinatari (dati personali: email, telefono) o scrive lo stato delle notifiche.
Regola e governance: `Modules/Xot/docs/adr/0012-behavioral-contract-governance.md` e
`Modules/Xot/docs/adr/0011-contract-docblock-reference.md`; standard: `Modules/Xot/docs/contracts/README.md`.

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile; il test Pest corrispondente usa lo stesso ID come group. Le Action usano
`NOTIFY-<OPERAZIONE>-INV-<N>`; il formato breve `NOTIFY-INV-N` resta nella tabella di [INDEX](index.md). La classe
implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

Cosa promettono le Action di Notify che parlano con l'esterno o scrivono dati: i due webhook dei fornitori email (esiti Mailjet,
posta in arrivo) e l'invio multicanale da template. Con un group Pest si lancia
`vendor/bin/pest Modules/Notify/tests --group=<ID>`; un `—` nella colonna Group è debito dichiarato.

Quando leggerli: prima di chiamare, modificare o imitare una di queste Action, e prima di aggiungere un fornitore o un canale.
Le interfacce di `app/Contracts` (SMS, Telegram, WhatsApp, push) non hanno ancora un documento qui.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>` (es. `Modules\Notify\Actions\...`), e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`, quello verificato dai test; la
riga legacy `Contratto di comportamento: docs/contracts/<file>.md` può restare. Chi cambia il comportamento aggiorna il
contratto nello stesso commit.

## Contratti

- [HandleMailjetEventsAction](handle-mailjet-events-action.md) — webhook degli esiti Mailjet → evento `MailDeliveryEventReceived`; 4 invarianti, tutte con group.
- [ProcessInboundMailAction](process-inbound-mail-action.md) — webhook della posta in arrivo → `inbound_emails` + `.eml` su disco; 4 invarianti, 1 con group.
- [SendNotificationAction](send-notification-action.md) — invio da template su `mail`, `database`, `sms`; invarianti `NOTIFY-SEND-INV-1..5` nel contratto, debito dichiarato sui test.
- [ModelWithStatusContract](modelwithstatuscontract.md) — rinvio all'interfaccia di Xot `Modules\Xot\Contracts\ModelWithStatusContract` (gestione degli stati via Spatie Model Status); nota legacy (`type: note`, `status: draft`) che rimanda a `Modules/Xot/app/Contracts/ModelWithStatusContract.php`, non è un contratto di comportamento di Notify e non segue il formato a sei sezioni.

## Indice e template

- [INDEX](index.md) — tabella operativa operazione, contratto, classe, invarianti; copertura e backlog.
- [Template di contratto](template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
