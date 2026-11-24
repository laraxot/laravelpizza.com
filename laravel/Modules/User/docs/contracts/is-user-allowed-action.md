---
title: "IsUserAllowedAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\IsUserAllowedAction"
qmd: "IsUserAllowedAction allowlist domini login socialite email dominio ammesso"
---

# IsUserAllowedAction

Decide se l'utente SSO può accedere, controllando il dominio della sua email contro `GetDomainAllowListAction`. Codice: `app/Actions/Socialite/IsUserAllowedAction.php`.

## Input

- `SocialiteUserContract $user`.

## Output

- `bool`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-ALLOWED-INV-1` | Allowlist vuota: accesso consentito a tutti. | `execute()`, `count < 1` | `tests/Unit/Actions/IsUserAllowedActionTest.php:29` |
| `SOCIALITE-ALLOWED-INV-2` | Con allowlist, vale il dominio della email (parte dopo l'ultimo `@`, in minuscolo) presente nella lista. | `execute()` | `IsUserAllowedActionTest.php:36` |

## Effetti collaterali

Nessuno.

## Errori

- `AssertionFailedException` se l'email è null.

## Non fa

- La lista non è normalizzata: una voce con maiuscole non combacia mai con il dominio in minuscolo.
- Il confronto `in_array` non è stretto (`false` come terzo argomento).
- Non registra l'evento di rifiuto: lo fa `ProcessCallbackAction` (`UserNotAllowed`).
