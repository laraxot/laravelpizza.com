---
title: "CreateSocialiteUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\CreateSocialiteUserAction"
qmd: "CreateSocialiteUserAction crea record socialite_users provider provider_id user_id avatar email"
---

# CreateSocialiteUserAction

Crea il record `SocialiteUser` che collega un utente locale a un'identità del provider OAuth. Codice: `app/Actions/Socialite/CreateSocialiteUserAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`, `UserContract $user`.

## Output

- `SocialiteUser`: il record creato da `create()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-CREATE-SU-INV-1` | Il record ha `user_id`, `provider`, `provider_id`, `name`, `email`, `avatar` presi da input e provider. | `execute()`, array attributi | `tests/Unit/Actions/Socialite/SocialiteCoreActionsCoverageTest.php:133` |
| `SOCIALITE-CREATE-SU-INV-2` | Il nickname non è salvato (riga commentata). | `execute()` | nessuno |

## Effetti collaterali

Un INSERT su `socialite_users` via `create()` (eventi Eloquent del modello). Nessuna transazione propria: quando è chiamata da `RegisterOauthUserAction` è dentro la sua transazione. Nessun evento dell'Action.

## Errori

- Nessuna eccezione propria. Una violazione di vincolo di unicità (stesso provider e stesso id) si propagherebbe dal database: non verificato se esiste un indice unico.

## Non fa

- Non controlla se il collegamento esiste già.
- Non salva il token (lo fa `RetrieveSocialiteUserAction`).
