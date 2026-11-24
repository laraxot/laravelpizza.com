---
title: "Contratto — BuildActiveUserProviderAction"
type: contract
action: "Modules\\User\\Actions\\Auth\\BuildActiveUserProviderAction"
owner: User
status: accepted
updated: 2026-11-24
qmd: "BuildActiveUserProviderAction provider eloquent deleted_at account cancellato login sessione remember token"
---

# BuildActiveUserProviderAction

Costruisce il provider utenti che esclude gli account cancellati dal titolare (SEC-05). Codice: `app/Actions/Auth/BuildActiveUserProviderAction.php`; registrazione: `app/Providers/UserServiceProvider.php:157-175`.

## Input

- `Hasher $hasher`, `string $model`: classe del modello utente (`execute`).

## Output

- Un `EloquentUserProvider` con una query di base che applica il filtro `deleted_at IS NULL`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `USER-PROVIDER-INV-1` | Il filtro `whereNull(deleted_at)` si applica solo se il modello è un `UserContract` e ha la colonna `deleted_at`. | `BuildActiveUserProviderAction.php:36-42` | `tests/Feature/Auth/DeletedAccountAccessTest.php:36,52` |
| `USER-PROVIDER-INV-2` | Il driver `eloquent` dei provider utenti è sostituito da questo provider in `UserServiceProvider`, per ogni tenant. | `UserServiceProvider.php:166-172` | `tests/Feature/Auth/DeletedAccountAccessTest.php:29` |
| `USER-PROVIDER-INV-3` | Un account con `deleted_at` valorizzato non è trovato per id, credenziali o remember token; il login resta possibile per gli account attivi. | docblock `BuildActiveUserProviderAction.php:14-27` | `tests/Feature/Auth/DeletedAccountAccessTest.php:52,69,76` |

## Effetti collaterali

Nessuno a runtime: l'Action costruisce il provider; la query è filtrata a ogni ricerca. Nessuna scrittura, evento o coda.

## Errori

- Nessun errore proprio. Se `ModelHasColumnAction` indica che la colonna manca, il filtro non è applicato (nessuna eccezione).

## Non fa

- Non introduce `SoftDeletes` né uno scope globale: `BaseUser` non li usa, perché purga differita e back office devono vedere gli utenti cancellati (docblock, righe 17-19).
- Non revoca token Passport né cookie "ricordami" (vedi [revoke-user-access-action](revoke-user-access-action.md)).
- Marker `@contract` e `@see` presenti nel docblock della classe.
