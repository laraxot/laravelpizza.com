---
title: "Contratto — RecordAuthenticationLogAction"
type: contract
action: "Modules\User\Actions\Auth\RecordAuthenticationLogAction"
tags: [contract, action, audit, login]
created: 2026-11-24
updated: 2026-11-24
---

# RecordAuthenticationLogAction

Sorgente: `app/Actions/Auth/RecordAuthenticationLogAction.php`. Chiamata da `LoginListener` e `FailedLoginListener`.
Perché: [ADR](../adr/authentication-log-never-breaks-login.md).

## Input

- `UserContract&HasAuthentications $user`.
- `$attributes`: `ip_address`, `user_agent`, `login_at`, `login_successful`, `location`.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| USER-AUTHLOG-INV-1 | Connessione `user` non configurata o tabella `authentication_logs` assente: `Log::warning` e ritorno, mai eccezione. | `USER-AUTHLOG-INV-1` |
| USER-AUTHLOG-INV-2 | La riga si scrive sulla connessione del modello `AuthenticationLog` (`user`), non sulla default. | — |
| USER-AUTHLOG-INV-3 | Il parametro è tipizzato sulle interfacce, mai sulla classe concreta `BaseUser`. | `USER-AUTHLOG-INV-3` |

## Effetti collaterali

- Insert in `authentication_logs` tramite `$user->authentications()->create()`.
- In assenza di tabella: una riga di log `warning` con connessione, tabella e id utente.

## Errori

- Con tabella presente, un errore di insert si propaga al listener.

## Non fa

- Non registra la metrica Pulse (`RecordLoginPulseAction`, chiamata dai listener).
- Non geolocalizza l'IP: `location` arriva già pronta.
- Non applica retention né cancella righe vecchie.
