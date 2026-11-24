---
title: "ResendEmailVerificationAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\ResendEmailVerificationAction"
qmd: "ResendEmailVerificationAction reinvia mail verifica indirizzo email DCP-285 evento Verified"
---

# ResendEmailVerificationAction

Reinvia la mail di verifica dell'indirizzo, senza verificare nulla (DCP-285, D-04). Codice: `app/Actions/Auth/ResendEmailVerificationAction.php:16-33`.

## Input

- `MustVerifyEmail $user` (`execute`, riga 23).

## Output

- `bool`: `true` se la notifica è stata inviata, `false` se l'indirizzo era già verificato (righe 25-31).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `RESEND-VERIFY-INV-1` | Un indirizzo già verificato non riceve alcuna notifica. | righe 25-27 | Test: nessuno. |
| `RESEND-VERIFY-INV-2` | L'Action non emette l'evento `Verified`: lo emettono solo i controller che hanno validato id e hash. | docblock righe 13-14, nessun dispatch nel corpo | Test: nessuno. |

## Effetti collaterali

Invia la notifica di verifica tramite `sendEmailVerificationNotification()` dell'utente. Se la notifica è in coda, l'invio effettivo è asincrono: non verificato per il tipo di notifica usato. Nessuna scrittura diretta.

## Errori

- Nessuna gestione esplicita: errori di invio si propagano.

## Non fa

- Non marca l'indirizzo come verificato.
- Non applica limiti di frequenza: il freno, se c'è, è del chiamante (vedi [consume-auth-submission-slot-action](consume-auth-submission-slot-action.md)).
