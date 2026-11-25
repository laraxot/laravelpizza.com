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
Scrive una riga in `authentication_logs` sulla connessione `user` per ogni tentativo di accesso. Codice: `app/Actions/Auth/RecordAuthenticationLogAction.php:25-58`.

## Input

- `UserContract&HasAuthentications $user`: l'utente (`execute`, riga 30).
- `array $attributes`: `ip_address`, `user_agent`, `login_at`, `login_successful`, `location` (riga 28).

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
| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RECORD-AUTH-INV-1` | Se la connessione user non ha database configurato la scrittura è saltata, con warning, senza eccezione. | righe 36-44 | `tests/Unit/Actions/Auth/RecordAuthenticationLogActionTest.php` (riferimento alla classe) |
| `RECORD-AUTH-INV-2` | Se la tabella `authentication_logs` non esiste sulla connessione la scrittura è saltata, con warning, senza eccezione. | righe 46-55 | come sopra |
| `RECORD-AUTH-INV-3` | Altrimenti la riga è creata tramite la relazione `authentications()` dell'utente. | riga 57 | come sopra |

## Effetti collaterali

Al massimo un INSERT in `authentication_logs` (connessione user). Log di warning in due casi di skip. Nessuna transazione, nessun evento esplicito.

## Errori

- Le eccezioni di `create()` (per esempio attributi non fillable o errori DB) non sono catturate e si propagano.

## Non fa

- Non valida `$attributes`: la forma è dichiarata solo nel docblock.
- Non legge né modifica l'utente.
