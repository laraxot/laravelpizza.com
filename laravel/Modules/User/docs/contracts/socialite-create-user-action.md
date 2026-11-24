---
title: "CreateUserAction (Socialite) — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\CreateUserAction"
qmd: "CreateUserAction Socialite crea utente locale da identità OAuth nome cognome email ruoli default"
---

# CreateUserAction (Socialite)

Crea un utente locale a partire dagli attributi dell'identità OAuth, gli assegna i ruoli di default e restituisce l'istanza aggiornata. Codice: `app/Actions/Socialite/CreateUserAction.php`. Il basename `CreateUserAction` esiste anche in `app/Actions/` e in `app/Actions/User/`: questo contract copre solo la versione Socialite.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`.

## Output

- `UserContract`: l'utente ricaricato con `refresh()`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-CREATE-USER-INV-1` | `first_name` riceve il nome completo risolto, non il solo primo nome. | `execute()`, array di `create()` | nessuno sul valore |
| `SOCIALITE-CREATE-USER-INV-2` | Il modello creato deve essere `Model` e `UserContract`, altrimenti asserzione fallita. | `Assert::isInstanceOf` | nessuno |
| `SOCIALITE-CREATE-USER-INV-3` | Ruoli assegnati da `SetDefaultRolesBySocialiteUserAction` prima del `refresh()`. | `execute()` | nessuno |

## Effetti collaterali

Ordine: risoluzione attributi (`GetUserModelAttributesFromSocialiteAction`), INSERT utente, assegnazione ruoli (eventuali INSERT sulla tabella pivot), `refresh()` (SELECT). Nessuna transazione propria: il chiamante `RegisterOauthUserAction` la apre. Nessun evento dell'Action (restano quelli Eloquent).

## Errori

- `AssertionFailedException` (webmozart) se la classe utente non è né `Model` né `UserContract`.
- Errori di database propagati.

## Non fa

- Non cerca utenti esistenti con la stessa email: il controllo è in `ProcessCallbackAction`.
- Il valore di `name`, `last_name` e `email` dipende da `UserNameFieldsResolver` (vedi il suo contract, se presente).
- Test: solo istanziazione in `tests/Unit/Actions/AdditionalActionsTest.php:35-38`.
