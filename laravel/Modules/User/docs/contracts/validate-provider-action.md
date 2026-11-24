---
title: "ValidateProviderAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\ValidateProviderAction"
qmd: "ValidateProviderAction valida provider OAuth configurato eccezione ProviderNotConfigured client_id secret redirect"
---

# ValidateProviderAction

Si assicura che il provider OAuth sia configurato, altrimenti lancia `ProviderNotConfigured`. Codice: `app/Actions/Socialite/ValidateProviderAction.php`.

## Input

- `string $provider`.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-VALIDATE-PROVIDER-INV-1` | Con variabili mancanti o segnaposto: `ProviderNotConfigured` con provider e elenco. | `execute()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:93` |
| `SOCIALITE-VALIDATE-PROVIDER-INV-2` | Provider configurato: nessuna eccezione. | `execute()` | `SocialiteUtilityActionsTest.php:88` |

## Effetti collaterali

Nessuno.

## Errori

- `Modules\User\Exceptions\ProviderNotConfigured`.

## Non fa

- Non verifica le credenziali presso il provider: solo la presenza e la forma dei valori.
- Chiamanti in produzione: `ProcessCallbackAction` e `app/Http/Controllers/Socialite/RedirectToProviderController.php`.
