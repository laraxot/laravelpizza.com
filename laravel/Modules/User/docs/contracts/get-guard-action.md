---
title: "GetGuardAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\GetGuardAction"
qmd: "GetGuardAction guard autenticazione filament auth guard config StatefulGuard"
---

# GetGuardAction

Restituisce il guard di autenticazione indicato da `config('filament.auth.guard')`. Codice: `app/Actions/Socialite/GetGuardAction.php`.

## Input

- Nessuno.

## Output

- `StatefulGuard|Guard`: il guard risolto con `auth()->guard()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-GUARD-INV-1` | Il nome del guard deve essere una stringa. | `Assert::string()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:102` |

## Effetti collaterali

Nessuno.

## Errori

- `AssertionFailedException` se la configurazione non è stringa.
- Un nome di guard sconosciuto: comportamento di Laravel, non verificato qui.

## Non fa

- Non è usato in produzione nel perimetro cercato. Il guard di `ResolveShieldAuthenticationConfigurationAction` è invece hardcoded a `'web'`.
