---
title: "notify owns delivery contract"
<<<<<<< .merge_file_ubUC10
<<<<<<< .merge_file_oseXAF
<<<<<<< HEAD
status: proposed
type: decision
=======
<<<<<<< HEAD
type: decision
status: accepted
=======
status: proposed
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
type: decision
status: accepted
>>>>>>> .merge_file_rVt2cX
=======
type: decision
status: accepted
>>>>>>> .merge_file_nr8ocX
date: 2026-11-23
decision-makers: Notify module owner
created: 2026-11-23
updated: 2026-11-23
<<<<<<< HEAD
qmd: "notify owns delivery contract"
=======
>>>>>>> laraxot/dev
---

# Notify centralizza template e consegna delle notifiche

## Contesto

L'invio richiede ricerca del template attivo, compilazione dei dati, selezione dei
canali e gestione degli esiti. `SendNotificationAction` concentra l'orchestrazione
e implementa i canali `mail`, `database` e `sms`; `SendNotificationToRecipientAction`
offre un invio diretto con validazione dell'indirizzo. Il modulo non espone una UI
web nelle proprie route: l'API contiene endpoint tecnici per inbound e provider.

## Driver della decisione

- un solo punto per template, dati, canali ed error handling;
- supporto a più canali senza duplicare l'orchestrazione nei consumer;
- esecuzione in coda tramite `QueueableAction`;
- separazione tra pannello Filament ed endpoint tecnici dei provider.

## Alternative scartate

- Chiamare SDK dei provider direttamente nei moduli di dominio: duplicherrebbe
  template, validazione e gestione degli errori.
- Mettere l'invio nelle view o in controller web generici: legherebbe la consegna
  alla presentazione.
- Modellare ogni canale come flusso autonomo senza Action centrale: impedirebbe di
  riusare selezione del template e dei canali.

## Decisione

Notify **possiede l'orchestrazione della consegna**: le Actions caricano e compilano
il template, scelgono i canali supportati e delegano l'invio al meccanismo appropriato.
`routes/web.php` non aggiunge UI; `routes/api.php` espone solo endpoint tecnici per
eventi inbound e callback dei provider.

## Conseguenze

- Buono, perché i consumer invocano un contratto operativo comune.
- Buono, perché un fallimento di un canale viene registrato senza interrompere
  necessariamente gli altri canali selezionati.
- Cattivo, perché un nuovo canale richiede modifica all'Action e verifica del provider.
- Cattivo, perché gli endpoint inbound devono restare protetti da token e controlli.

## Conferma

- Orchestrazione: [`SendNotificationAction`](../../app/Actions/SendNotificationAction.php).
- Invio a destinatario: [`SendNotificationToRecipientAction`](../../app/Actions/SendNotificationToRecipientAction.php).
- Confine HTTP: [`routes/web.php`](../../routes/web.php) e [`routes/api.php`](../../routes/api.php).
- Riferimento: [`docs/architecture.md`](../architecture.md).
<<<<<<< .merge_file_ubUC10
<<<<<<< .merge_file_oseXAF
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_rVt2cX
=======
>>>>>>> .merge_file_nr8ocX

## Verifica

- `vendor/bin/pest Modules/Notify/tests/Unit/Actions/SendNotificationActionTest.php`, `SendNotificationToRecipientActionTest.php` e
  `SendNotificationFlowTest.php` (`Modules/Notify/tests/Unit/Actions/SendNotificationActionTest.php`,
  `Modules/Notify/tests/Unit/Actions/SendNotificationToRecipientActionTest.php`,
  `Modules/Notify/tests/Unit/Actions/SendNotificationFlowTest.php`): falliscono se l'orchestrazione dei canali cambia.
- Confine HTTP, revisione ripetibile: `rg -n '^Route::' laravel/Modules/Notify/routes/web.php` non deve trovare nulla; in
  `Modules/Notify/routes/api.php` restano solo le due rotte tecniche dei fornitori (`/inbound/{provider}/{token}`,
  `/notify/mailjet/events/{token}`).
<<<<<<< .merge_file_ubUC10
<<<<<<< .merge_file_oseXAF
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_rVt2cX
=======
>>>>>>> .merge_file_nr8ocX
