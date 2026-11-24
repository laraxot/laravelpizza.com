---
title: "User/CreateUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\User\\CreateUserAction"
qmd: "User CreateUserAction creazione utente nome fallback first_name last_name email localpart users name NOT NULL"
---

# User/CreateUserAction

Crea un utente dal form di registrazione, riempiendo il campo `name` quando manca (NOT NULL senza default). Codice: `app/Actions/User/CreateUserAction.php:10-36`.

Nota: esiste anche una `CreateUserAction` nella radice di `Actions/` con altro contratto. Questo file prende il prefisso `user-` per evitare la collisione di nome.

## Input

- `array<string, mixed> $data` (`execute`, riga 19). Chiavi lette per il fallback: `name`, `first_name`, `last_name`, `email`.

## Output

- `User` creato con `User::create` (righe 33-35).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `USER-CREATE-INV-1` | Se `name` manca o è vuoto: nome = `first_name last_name` (trim); se vuoto, la parte prima di `@` dell'email; se anche quella manca, l'email intera. | righe 23-30 | `tests/Unit/Actions/User/CreateUserActionTest.php` (riferimento per nome, non verificato per singolo caso) |
| `USER-CREATE-INV-2` | Un `name` non vuoto fornito è mantenuto invariato. | riga 23 | come sopra |
| `USER-CREATE-INV-3` | L'Action non cifra la password né valida l'email: sono responsabilità del chiamante. | righe 33-35 | Test: nessuno. |

## Effetti collaterali

Un INSERT in `users` tramite `User::create`. Nessuna transazione, nessuna mail, nessun evento esplicito.

## Errori

- Nessuna gestione esplicita: errori di validazione del database si propagano.

## Non fa

- Non hash della password: se il modello non ha un cast o un mutator che la cifra, la password resta in chiaro (non verificato nel modello `User`).
- Se l'email non contiene `@` il nome diventa l'email intera (riga 29).
