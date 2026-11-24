---
title: "ADR — Il registro degli accessi sta sulla connessione user e non rompe mai il login"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/Auth/RecordAuthenticationLogAction.php
  - ../../app/Models/BaseModel.php
  - ../contracts/record-authentication-log-action.md
<<<<<<< HEAD
=======
qmd: "authentication log never breaks login registro"
>>>>>>> laraxot/dev
---

# ADR: il registro degli accessi sta sulla connessione `user` e non rompe mai il login

## Contesto

- `authentication_logs` appartiene agli utenti: i modelli del modulo estendono `Modules/User/app/Models/BaseModel.php`,
  che dichiara `protected $connection = 'user'`, e nelle installazioni con database separato la tabella vive accanto a `users`.
- I listener `LoginListener` e `FailedLoginListener` scrivono il log a ogni tentativo. Un deploy con la connessione
  `user` non configurata o senza la tabella trasformava ogni login in un errore 500.
- Domanda: il registro è più importante dell'accesso?

## Decisione

- `RecordAuthenticationLogAction` controlla prima `IsUserDatabaseConfiguredAction` e `Schema::hasTable()` sulla
  connessione del modello; se manca qualcosa scrive un `Log::warning` e ritorna, senza eccezione.
- Il parametro è `UserContract&HasAuthentications`, mai la classe concreta `BaseUser`: i listener controllano le stesse
  interfacce.

## Alternative scartate

- Lasciare propagare l'eccezione: l'audit fermerebbe l'autenticazione, cioè il servizio.
- Scrivere sulla connessione di default: il log finirebbe lontano dalla tabella `users` a cui si riferisce.

## Conseguenze

- Pro: login sempre disponibile; il problema di configurazione resta visibile nei log.
- Contro: con la tabella mancante gli accessi non sono registrati; serve un monitoraggio dei warning.

## Verifica

`Modules/User/tests/Unit/Actions/Auth/RecordAuthenticationLogActionTest.php` (source-level, 5 test verdi; groups
`USER-AUTHLOG-INV-1`, `USER-AUTHLOG-INV-3`).
