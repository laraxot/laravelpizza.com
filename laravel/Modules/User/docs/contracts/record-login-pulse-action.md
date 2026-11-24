---
title: "RecordLoginPulseAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Login\\RecordLoginPulseAction"
qmd: "RecordLoginPulseAction Laravel Pulse user_login bucket conteggio accesso onlyBuckets"
---

# RecordLoginPulseAction

Registra un accesso nel contatore aggregato di Laravel Pulse. Codice: `app/Actions/Login/RecordLoginPulseAction.php:10-22`.

## Input

- `DateTimeInterface $loginAt`: momento dell'accesso (`execute`, riga 12).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PULSE-LOGIN-INV-1` | Registra il tipo `user_login` con chiave `all`, come conteggio. | righe 14-19 | `tests/Unit/Actions/Auth/RecordAuthenticationLogActionTest.php` (riferimento alla classe, non dedicato) |
| `PULSE-LOGIN-INV-2` | Scrive solo bucket aggregati (`onlyBuckets`), nessuna riga di dettaglio. | riga 20 | come sopra |

## Effetti collaterali

Scrittura nello storage di Pulse (bucket). Nessuna transazione, nessun evento.

## Errori

- Nessuna gestione esplicita.

## Non fa

- Non conta utenti distinti né esiti di login.
- Pulse conserva al massimo 7 giorni (vedi docblock di [get-login-history-action](get-login-history-action.md)): la storia lunga viene da `authentication_logs`.
