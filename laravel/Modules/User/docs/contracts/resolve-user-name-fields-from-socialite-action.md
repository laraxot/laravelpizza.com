---
title: "ResolveUserNameFieldsFromSocialiteAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\ResolveUserNameFieldsFromSocialiteAction"
qmd: "ResolveUserNameFieldsFromSocialiteAction nome cognome da identità OAuth NameSearchEnum email fallback reflection getRaw"
---

# ResolveUserNameFieldsFromSocialiteAction

Ricava nome e cognome da un'identità OAuth, con tre fonti in ordine: attributo `name`, campo `name` dei dati grezzi, parte locale dell'email. Codice: `app/Actions/Socialite/ResolveUserNameFieldsFromSocialiteAction.php`.

## Input

- `Laravel\Socialite\Contracts\User $oauthUser`.

## Output

- `SocialiteNameFieldsData`: `name`, `firstName` (uguale a `name`), `lastName`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-NAME-FIELDS-INV-1` | Il nome viene dall'attributo `name` se produce un risultato non vuoto. | `determineNameField()` | `tests/Unit/Actions/Socialite/ResolveUserNameFieldsFromSocialiteActionTest.php:24,32,40` |
| `SOCIALITE-NAME-FIELDS-INV-2` | Il campo grezzo `name` è scartato se sembra un'email. | `determineNameField()`, `FILTER_VALIDATE_EMAIL` | stesso file |
| `SOCIALITE-NAME-FIELDS-INV-3` | Senza altre fonti, si usa la parte locale dell'email in formato titolo. | `analyzeEmailForNameSection()` | stesso file |

## Effetti collaterali

Nessuno. Legge i dati grezzi con reflection (`getRaw()` o proprietà `user`).

## Errori

- Nessuna eccezione propria. Gli errori di reflection non sono catturati in questa classe.

## Non fa

- Nessun chiamante in produzione nel perimetro cercato: il flusso reale usa `Utils/UserNameFieldsResolver`, che contiene la stessa logica.
- Due implementazioni della stessa regola: candidata alla rimozione in una story dedicata.
