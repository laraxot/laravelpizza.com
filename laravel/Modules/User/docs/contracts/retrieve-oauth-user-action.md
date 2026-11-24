---
title: "RetrieveOauthUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\RetrieveOauthUserAction"
qmd: "RetrieveOauthUserAction scambio codice OAuth socialite driver user InvalidStateException evento InvalidState"
---

# RetrieveOauthUserAction

Completa lo scambio OAuth con il provider e restituisce l'utente. Su `InvalidStateException` dispatcha `InvalidState` e ritorna `null`. Codice: `app/Actions/Socialite/RetrieveOauthUserAction.php`.

## Input

- `string $provider`.

## Output

- `?SocialiteUserContract`: utente del provider, oppure `null` in caso di stato OAuth non valido.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-RETRIEVE-OAUTH-INV-1` | `InvalidStateException` produce evento `InvalidState` e `null`. | `execute()`, `handleInvalidStateException()` | `tests/Unit/Actions/Socialite/SocialiteCoreActionsCoverageTest.php:86,115` |
| `SOCIALITE-RETRIEVE-OAUTH-INV-2` | Ogni altra eccezione si propaga. | `execute()` | nessuno |

## Effetti collaterali

Chiamata di rete verso il provider (`Socialite::driver()->user()`). Evento `InvalidState` solo nel ramo di errore di stato.

## Errori

- `InvalidStateException` assorbita come sopra. Altri errori (rete, provider) propagati.

## Non fa

- Il docblock in fondo al file contiene un dump di esempio di un utente Auth0 (righe di commento): rumore, da rimuovere in un'attività separata.
