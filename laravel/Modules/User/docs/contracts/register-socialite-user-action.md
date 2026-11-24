---
title: "RegisterSocialiteUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\RegisterSocialiteUserAction"
qmd: "RegisterSocialiteUserAction collega utente esistente SSO socialite_users ruoli default evento SocialiteUserConnected"
---

# RegisterSocialiteUserAction

Collega un utente locale già esistente a un'identità OAuth, assegna i ruoli di default se applicabili e dispatcha `SocialiteUserConnected`. Codice: `app/Actions/Socialite/RegisterSocialiteUserAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`, `UserContract $user` (già esistente).

## Output

- `SocialiteUser`: il collegamento creato.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REGISTER-SU-INV-1` | Crea sempre un nuovo `SocialiteUser` per l'utente fornito. | `execute()` | nessuno |
| `SOCIALITE-REGISTER-SU-INV-2` | Ruoli default: delegati a `SetDefaultRolesBySocialiteUserAction`, che non fa nulla se l'utente ha già ruoli. | `execute()` | nessuno |
| `SOCIALITE-REGISTER-SU-INV-3` | Dispatch di `SocialiteUserConnected` con il collegamento creato. | `execute()` | `tests/Unit/Actions/AdditionalActionsTest.php:17-20` (solo istanziazione) |

## Effetti collaterali

Ordine: INSERT `socialite_users`, eventuale assegnazione ruoli, dispatch `SocialiteUserConnected`. Nessuna transazione: un fallimento dopo il primo INSERT lascia il collegamento senza ruoli. Nessun login.

## Errori

- Errori di database propagati.

## Non fa

- Non è atomico.
- Il chiamante `ProcessCallbackAction` su questo percorso fa seguire anche `LoginUserAction`, che dispatcha di nuovo `SocialiteUserConnected`.
