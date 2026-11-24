---
title: "LogoutUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\LogoutUserAction"
qmd: "LogoutUserAction logout revoca access token refresh token Passport device logout_at"
---

# LogoutUserAction

Chiude l'accesso di un utente: revoca il suo access token Passport e i refresh token collegati, e marca il logout sui dispositivi. Codice: `app/Actions/Socialite/LogoutUserAction.php`.

## Input

- `UserContract $user`: deve avere un token attivo (`$user->token()`).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-LOGOUT-INV-1` | Senza token: `AssertionFailedException`. | `Assert::notNull` | nessuno |
| `SOCIALITE-LOGOUT-INV-2` | I refresh token con `access_token_id` del token sono revocati (non cancellati). | `execute()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:152` (chiamata) |
| `SOCIALITE-LOGOUT-INV-3` | I `DeviceUser` dell'utente hanno `logout_at` = ora. | `execute()` | stesso riferimento |

## Effetti collaterali

Ordine: UPDATE su `oauth_refresh_tokens`, `revoke()` sull'access token, UPDATE su `device_users`. Nessuna transazione: un errore dopo la prima scrittura lascia le modifiche parziali. Nessun evento.

## Errori

- `AssertionFailedException` se il token manca.

## Non fa

- Non cancella nulla: la revoca lascia il token per audit.
- Il logout dei dispositivi mobile (`MobileDeviceUser`) è commentato nel codice.
- Non invalida la sessione web.
