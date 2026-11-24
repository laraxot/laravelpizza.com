---
<<<<<<< HEAD
<<<<<<< .merge_file_xUVqSQ
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_zsWbN0
<<<<<<< HEAD
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.
=======
=======
>>>>>>> laraxot/dev
title: "Contratti del modulo Notify"
type: index
tags: [contracts, actions, interfaces, notify]
created: 2026-11-18
updated: 2026-11-24
<<<<<<< .merge_file_xUVqSQ
=======
>>>>>>> laraxot/dev
title: "Contratti del modulo Notify"
type: index
module: Notify
status: active
<<<<<<< HEAD
tags: [contracts, actions, interfaces, notify]
created: 2026-11-18
updated: 2026-11-24
qmd: "notify contracts readme azioni invarianti pest group notifiche invio"
=======
created: 2026-11-18
updated: 2026-11-24
qmd: "notify contracts readme azioni invarianti pest group notifiche invio"
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_zsWbN0
---

# Contratti del modulo Notify

<<<<<<< .merge_file_xUVqSQ
<<<<<<< HEAD
Cosa promette la superficie pubblica di Notify: le Action che scrivono dati, chiamano servizi esterni o hanno effetti collaterali,
e le interfacce (`app/Contracts`). Un contratto descrive il comportamento promesso da una Action che invia comunicazioni ai
destinatari (dati personali: email, telefono) o scrive lo stato delle notifiche.
Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`; standard: `Modules/Xot/docs/contracts/contract-authoring-standard.md`;
governance: `Modules/Xot/docs/adr/0012-behavioral-contract-governance.md`.

=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_zsWbN0
## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile; il test Pest corrispondente usa lo stesso ID come group. Le Action usano
`NOTIFY-<OPERAZIONE>-INV-<N>`; il formato breve `NOTIFY-INV-N` resta nella tabella di [INDEX](INDEX.md). La classe
implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

Cosa promettono le Action di Notify che parlano con l'esterno o scrivono dati: i due webhook dei fornitori email (esiti Mailjet,
posta in arrivo) e l'invio multicanale da template. Con un group Pest si lancia
`vendor/bin/pest Modules/Notify/tests --group=<ID>`; un `—` nella colonna Group è debito dichiarato.

Quando leggerli: prima di chiamare, modificare o imitare una di queste Action, e prima di aggiungere un fornitore o un canale.
Le interfacce di `app/Contracts` (SMS, Telegram, WhatsApp, push) non hanno ancora un documento qui.
<<<<<<< .merge_file_xUVqSQ
<<<<<<< HEAD
=======
=======
>>>>>>> .merge_file_zsWbN0
Formato e regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_xUVqSQ
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_zsWbN0

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

<<<<<<< HEAD
<<<<<<< .merge_file_xUVqSQ
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_zsWbN0
<<<<<<< HEAD
Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

=======
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_xUVqSQ
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_zsWbN0
Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`, quello verificato dai test; la
riga legacy `Contratto di comportamento: docs/contracts/<file>.md` può restare. Chi cambia il comportamento aggiorna il
contratto nello stesso commit.

## Contratti

- [HandleMailjetEventsAction](handle-mailjet-events-action.md) — webhook degli esiti Mailjet → evento `MailDeliveryEventReceived`; 4 invarianti, tutte con group.
- [ProcessInboundMailAction](process-inbound-mail-action.md) — webhook della posta in arrivo → `inbound_emails` + `.eml` su disco; 4 invarianti, 1 con group.
<<<<<<< .merge_file_xUVqSQ
<<<<<<< HEAD
- [SendNotificationAction](send-notification-action.md) — invio da template su `mail`, `database`, `sms`; invarianti `NOTIFY-SEND-INV-<N>` nel contratto, debito dichiarato sui test.
- [ModelWithStatusContract](modelwithstatuscontract.md) — rinvio all'interfaccia di Xot `Modules\Xot\Contracts\ModelWithStatusContract` (gestione degli stati via Spatie Model Status); nota legacy (`type: note`, `status: draft`), non è un contratto di comportamento di Notify e non segue il formato a sei sezioni.

## Indice e template

- [INDEX](INDEX.md) — tabella operativa operazione, contratto, classe, invarianti; copertura e backlog.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
=======
=======
>>>>>>> .merge_file_zsWbN0
- [SendNotificationAction](send-notification-action.md) — invio da template su `mail`, `database`, `sms`; 4 invarianti, debito (test da correggere).
- [ModelWithStatusContract](modelwithstatuscontract.md) — rinvio all'interfaccia di Xot `Modules\Xot\Contracts\ModelWithStatusContract` (gestione degli stati via Spatie Model Status); non è un contratto di comportamento di Notify.

## Indice e template

- [INDEX](INDEX.md) — tabella operativa operazione, contratto, classe, invarianti; oggi censisce solo `modelwithstatuscontract.md`.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_xUVqSQ
=======
Un contract descrive il comportamento promesso da una Action che invia comunicazioni ai destinatari (dati personali: email, telefono) o scrive lo stato delle notifiche.
Standard: `Modules/Xot/docs/contracts/contract-authoring-standard.md`; governance: `Modules/Xot/docs/adr/0012-behavioral-contract-governance.md`.

## Formato

- Frontmatter con `type: contract` e `action: "Modules\\Notify\\Actions\\..."`.
- Sezioni nell'ordine: `## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`.
- Invarianti con ID `NOTIFY-<AREA>-INV-<N>`, ciascuno con test Pest `->group('<ID>')`.

## File presenti

- [send-notification-action.md](send-notification-action.md) (`NOTIFY-SEND-INV-1..5`)
- [modelwithstatuscontract.md](modelwithstatuscontract.md): nota legacy (`type: note`, `status: draft`) che rimanda a `Modules/Xot/app/Contracts/ModelWithStatusContract.php`; non e' un contract di Action e non segue il formato a sei sezioni.
- `_template.md`: modello per i nuovi contract.

Copertura e backlog: [INDEX.md](INDEX.md).
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_zsWbN0
