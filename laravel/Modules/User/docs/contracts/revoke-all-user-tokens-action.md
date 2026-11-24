---
title: "RevokeAllUserTokensAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Passport\\RevokeAllUserTokensAction"
qmd: "RevokeAllUserTokensAction revoca tutti access token Passport utente revoked update logout forzato"
---

# RevokeAllUserTokensAction

Revoca in blocco gli access token Passport ancora attivi di un utente. Codice: `app/Actions/Passport/RevokeAllUserTokensAction.php`.

## Input

- `UserContract|string $user`: istanza o id utente.

## Output

- `int`: numero di righe aggiornate (token che erano `revoked = false`).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REVOKE-ALL-INV-1` | Sono toccati solo i token dell'utente con `revoked = false`. | `execute()`, doppio `where` | `tests/Feature/Actions/RevokeAllUserTokensActionTest.php:58,67`; `tests/Feature/Actions/Passport/RevokeAllUserTokensActionTest.php` |
| `PASSPORT-REVOKE-ALL-INV-2` | Il valore di ritorno è il numero di righe della UPDATE. | `execute()` | stesso file |

## Effetti collaterali

Una singola UPDATE query builder su `oauth_tokens`. Non passa dagli eventi Eloquent del modello. Nessuna transazione, nessun evento, nessuna coda.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non revoca i refresh token (su `oauth_refresh_tokens`): a differenza di `RevokeTokenAction`.
- Non invalida le sessioni web.
