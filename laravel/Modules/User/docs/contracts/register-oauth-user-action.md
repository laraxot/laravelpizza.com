---
title: "RegisterOauthUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\RegisterOauthUserAction"
qmd: "RegisterOauthUserAction registrazione nuovo utente OAuth transazione CreateUserAction CreateSocialiteUserAction evento Registered"
---

# RegisterOauthUserAction

Crea in una sola transazione l'utente locale e il collegamento SSO per un'identità OAuth sconosciuta, poi dispatcha l'evento `Registered`. Codice: `app/Actions/Socialite/RegisterOauthUserAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`.

## Output

- `SocialiteUser`: il collegamento creato.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-REGISTER-OAUTH-INV-1` | Utente e collegamento vengono creati nella stessa transazione: se uno fallisce, nessuno dei due resta. | `execute()`, `DatabaseManager::transaction` | `tests/Unit/Actions/RegisterOauthUserActionTest.php:29,50` (istanziazione e chiamata) |
| `SOCIALITE-REGISTER-OAUTH-INV-2` | `Registered` è dispatchato dopo la transazione, con il `SocialiteUser`. | `execute()` | nessuno |

## Effetti collaterali

Transazione con INSERT utente (+ ruoli) e INSERT `socialite_users`. Poi dispatch di `Modules\User\Events\Registered`. Non effettua il login.

## Errori

- Errori di database: la transazione è annullata e l'eccezione si propaga.

## Non fa

- Non verifica se l'email esiste già: il chiamante sceglie questo percorso solo quando non trova l'utente.
- Il login è commentato nel codice: lo fa il chiamante.
