---
title: "IsRegistrationEnabledAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\IsRegistrationEnabledAction"
qmd: "IsRegistrationEnabledAction registrazione abilitata socialite config registration default attiva"
---

# IsRegistrationEnabledAction

Dice se la registrazione di nuovi utenti via SSO è abilitata. Codice: `app/Actions/Socialite/IsRegistrationEnabledAction.php`.

## Input

- Nessuno.

## Output

- `bool`: `true` se `config('socialite.registration')` è null o assente; altrimenti `(bool)` del valore.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REG-ENABLED-INV-1` | Config assente o null: registrazione attiva. | `execute()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:55,63` |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione.

## Non fa

- Il cast `(bool)` di una stringa è `true` anche per `'false'`: se la config arriva da una variabile d'ambiente come stringa, un valore `false` testuale abilita comunque la registrazione. Da verificare in `config/socialite.php`.
- Chiamante in produzione: `ProcessCallbackAction`.
