---
title: "GetUserModelAttributesFromSocialiteAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\GetUserModelAttributesFromSocialiteAction"
qmd: "GetUserModelAttributesFromSocialiteAction attributi utente da identità socialite nome cognome email validazione"
---

# GetUserModelAttributesFromSocialiteAction

Traduce l'identità OAuth in un DTO di attributi per il modello utente, con validazioni esplicite. Codice: `app/Actions/Socialite/GetUserModelAttributesFromSocialiteAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`.

## Output

- `SocialiteUserAttributesData`: `name`, `firstName`, `lastName`, `email`, `provider`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-USER-ATTR-INV-1` | `provider` vuoto: `InvalidArgumentException`. | `execute()` | `tests/Unit/Actions/Socialite/SocialiteCoreActionsCoverageTest.php:44` |
| `SOCIALITE-USER-ATTR-INV-2` | Nome o cognome non stringa: `RuntimeException`. | `execute()` | `SocialiteCoreActionsCoverageTest.php:58` |
| `SOCIALITE-USER-ATTR-INV-3` | Email non stringa o vuota: `RuntimeException`. | `execute()` | `SocialiteCoreActionsCoverageTest.php:58` |
| `SOCIALITE-USER-ATTR-INV-4` | `firstName` coincide con `name` (nome completo), non con il primo nome. | `execute()` | `SocialiteCoreActionsCoverageTest.php:28` (riferimento) |

## Effetti collaterali

Nessuno.

## Errori

- `InvalidArgumentException` e `RuntimeException` come indicato sopra.

## Non fa

- Il controllo `if ($nameFieldsResolver === null)` non può essere vero: `app()` non restituisce null. È codice morto.
- Risolve i nomi con `Utils/UserNameFieldsResolver`, che duplica la logica di `ResolveUserNameFieldsFromSocialiteAction`.
