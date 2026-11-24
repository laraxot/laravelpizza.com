---
title: "Contratto — RevokeUserAccessAction"
type: contract
action: "Modules\\User\\Actions\\Auth\\RevokeUserAccessAction"
tags: [contract, action, passport, account, sicurezza]
created: 2026-11-24
updated: 2026-11-24
owner: User
status: accepted
qmd: "RevokeUserAccessAction revoca token Passport refresh token remember token account cancellato SEC-05"
---

# RevokeUserAccessAction

Sorgente: `app/Actions/Auth/RevokeUserAccessAction.php`. Chiamata da `Modules/Gdpr/app/Actions/Account/DeleteAccountAction.php`.
Perché: [ADR](../adr/deleted-account-blocked-in-user-provider.md).

## Input

- `BaseUser $user`: l'utente a cui togliere ogni accesso già concesso.

## Output

- `int`: numero di token di accesso Passport revocati (quelli ancora attivi prima della chiamata).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| USER-REVOKE-INV-1 | Revoca tutti i token di accesso non revocati dell'utente, e solo i suoi. | — |
| USER-REVOKE-INV-2 | Revoca i refresh token di **tutti** i token dell'utente, anche di quelli già revocati. | — |
| USER-REVOKE-INV-3 | Il remember token si ruota (nuova stringa casuale di 60 caratteri), mai si azzera; se era vuoto l'utente non si salva. | — |

Provate da `tests/Feature/Auth/DeletedAccountAccessTest.php` (`revoking access ...`), che richiede un database di test
migrato: il group si aggiunge quando quei casi girano verdi.

## Effetti collaterali

- `UPDATE oauth_refresh_tokens SET revoked = 1`, `UPDATE oauth_access_tokens SET revoked = 1` (connessione dei modelli User).
- Eventuale `save()` dell'utente con il nuovo `remember_token`.

## Errori

- Nessuna gestione: un errore del database si propaga al chiamante (che lavora in transazione).

## Non fa

- Non valorizza `deleted_at` e non blocca il login: lo fa il provider di `BuildActiveUserProviderAction`.
- Non distrugge le sessioni web aperte: cadono alla richiesta successiva perché il provider non trova più l'utente.
- Non cancella righe: i token restano come registro.
