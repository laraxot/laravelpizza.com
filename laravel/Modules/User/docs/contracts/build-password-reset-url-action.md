---
title: "BuildPasswordResetUrlAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\BuildPasswordResetUrlAction"
qmd: "BuildPasswordResetUrlAction link reset password email app.url SEC-007 lingua token"
---

# BuildPasswordResetUrlAction

Costruisce l'URL assoluto del link di reset password inserito nell'email (SEC-007). Codice: `app/Actions/Auth/BuildPasswordResetUrlAction.php:16-42`.

## Input

- `string $token`: token di reset (`execute`, riga 21).
- `?string $email`: se non vuoto viene aggiunto come query `?email=` (precompilazione della pagina).

## Output

- `string`: `config('app.url')` senza slash finale, più il percorso `password.reset` relativo, con la lingua della richiesta e l'eventuale `email` (righe 23-40).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PWD-URL-INV-1` | La radice dell'URL viene da `config('app.url')`, mai dall'header `Host` della richiesta. | righe 23, 40 | Test: nessuno. |
| `PWD-URL-INV-2` | Se la lingua della richiesta è tra quelle supportate, il prefisso `/xx` del percorso è sostituito con quella lingua. | righe 25-34 | Test: nessuno. |
| `PWD-URL-INV-3` | `email` viene aggiunta solo se non vuota, con `&` se il percorso ha già una query. | righe 36-38 | Test: nessuno. |
| `PWD-URL-INV-4` | Il locale dell'applicazione è ripristinato dopo la generazione del percorso. | righe 25-27 | Test: nessuno. |

## Effetti collaterali

Nessuno sul database. Modifica temporaneamente il locale dell'applicazione (`setLocale`) e lo ripristina nella stessa chiamata.

## Errori

- Nessuna eccezione propria. Se `app.url` non è una stringa la radice è vuota e il link risulta relativo (riga 40).

## Non fa

- Non genera né salva il token: lo riceve.
- Non invia l'email.
