---
title: "Contratto — RevokeUserAccessAction"
type: contract
<<<<<<< HEAD
action: "Modules\User\Actions\Auth\RevokeUserAccessAction"
tags: [contract, action, passport, account, sicurezza]
created: 2026-11-24
updated: 2026-11-24
=======
action: "Modules\\User\\Actions\\Auth\\RevokeUserAccessAction"
owner: User
status: accepted
updated: 2026-11-24
qmd: "RevokeUserAccessAction revoca token Passport refresh token remember token account cancellato SEC-05"
>>>>>>> laraxot/dev
---

# RevokeUserAccessAction

<<<<<<< HEAD
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
| USER-REVOKE-INV-3 | Il remember token si ruota (nuova stringa casuale), mai si azzera; se era vuoto l'utente non si salva. | — |

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
=======
Chiude ogni accesso già concesso a un utente (SEC-05). Codice: `app/Actions/Auth/RevokeUserAccessAction.php:21-57`.

## Input

- `BaseUser $user`: l'utente di cui chiudere gli accessi (`execute`, riga 28).

## Output

- `int`: numero di access token Passport che erano attivi e sono stati revocati (riga 56).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `USER-REVOKE-INV-1` | Sono revocati solo gli access token dell'utente con `revoked = false`; il ritorno è il loro numero. | righe 30-34, 43-47, 56 | `tests/Feature/Auth/DeletedAccountAccessTest.php:99` |
| `USER-REVOKE-INV-2` | Sono revocati i refresh token di tutti i token dell'utente, anche di quelli già revocati. | righe 38-41 | `tests/Feature/Auth/DeletedAccountAccessTest.php:99` |
| `USER-REVOKE-INV-3` | Il remember token è ruotato (stringa casuale di 60 caratteri) solo se non è vuoto; se è vuoto l'utente non è salvato. | righe 51-54 | `tests/Feature/Auth/DeletedAccountAccessTest.php:99,145` |

## Effetti collaterali

Ordine di esecuzione: lettura degli id dei token attivi, update dei refresh token, update degli access token (solo se ce n'è almeno uno), eventuale `save()` dell'utente per il remember token. Nessuna transazione esplicita, nessun evento dispatchato dall'Action (gli eventi Eloquent del `save()` restano quelli del modello), nessuna coda, nessun servizio esterno.

## Errori

- L'Action non lancia eccezioni proprie; gli errori del database si propagano.

## Non fa

- Non valorizza né azzera `deleted_at` e non cancella l'utente (il blocco dell'account è del provider, vedi [build-active-user-provider-action](build-active-user-provider-action.md)).
- Non invalida le sessioni web: cadono alla richiesta successiva perché il provider non trova più l'utente (docblock, righe 16-19).
- Marker `@contract` e `@see` presenti nel docblock della classe.
>>>>>>> laraxot/dev
