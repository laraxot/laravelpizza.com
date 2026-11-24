---
title: "CreatePasswordClientAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Passport\\CreatePasswordClientAction"
qmd: "CreatePasswordClientAction client OAuth2 password grant delega CreateGenericClientAction"
---

# CreatePasswordClientAction

Crea un client OAuth2 di tipo *password grant* delegando a `CreateGenericClientAction` con `password: true` e `personalAccess: false`. Codice: `app/Actions/Passport/CreatePasswordClientAction.php`.

## Input

- `string $name`, `string $redirect`, `?UserContract $user = null`, `?string $provider = null`.

## Output

- `OauthClient`: il valore restituito da `CreateGenericClientAction::execute()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-PWD-CLIENT-INV-1` | Il client restituito ha `password_client = true` e `personal_access_client = false`. | `execute()`, argomenti fissi | `tests/Unit/Actions/Passport/CreateSpecificClientActionsTest.php:29` |
| `PASSPORT-PWD-CLIENT-INV-2` | Nessun comportamento proprio: tutto il resto è delegato. | `execute()` | stesso file |

## Effetti collaterali

Quelli di `CreateGenericClientAction`: un INSERT su `oauth_clients`. Nessuna transazione o evento propri.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non risolve l'istanza tramite iniezione nel costruttore: usa `app(...)` a ogni chiamata.
