---
title: "CreateClientAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Passport\\CreateClientAction"
qmd: "CreateClientAction crea client OAuth2 Passport uuid secret provider users revoked redirect"
---

# CreateClientAction

Crea e salva un client OAuth2 Passport (`oauth_clients`). Codice: `app/Actions/Passport/CreateClientAction.php`.

## Input

- `string $name`, `string $redirect`: nome e URI di redirect del client; nessuna validazione nell'Action.
- `?UserContract $user = null`: proprietario; se assente `user_id` non viene valorizzato.
- `bool $personalAccess = false`, `bool $password = false`: flag del tipo di client, passati senza controlli incrociati.
- `?string $provider = null`: se assente vale `'users'`.

## Output

- `OauthClient`: il modello appena salvato, con `id` (UUID v4) e `secret` (40 caratteri casuali) in chiaro.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-CREATE-CLIENT-INV-1` | `id` è un UUID generato a ogni chiamata. | `execute()`, `Str::uuid()` | chiamata in `tests/Unit/Actions/Passport/PassportActionsCoverageBatch2Test.php:36` |
| `PASSPORT-CREATE-CLIENT-INV-2` | Il client nasce non revocato (`revoked = false`). | `execute()` | stesso file |
| `PASSPORT-CREATE-CLIENT-INV-3` | `provider` vale `'users'` quando l'argomento è `null`. | `execute()`, `?? 'users'` | nessuno |

## Effetti collaterali

Ordine: costruzione del modello, assegnazioni, `save()` (un INSERT). Nessuna transazione esplicita, nessun evento dell'Action, nessuna coda, nessun servizio esterno. Gli eventi Eloquent del `save()` restano quelli del modello.

## Errori

- Nessuna eccezione propria. Gli errori del database si propagano.

## Non fa

- Non valida il formato di `redirect` né l'unicità del `name`.
- Non impedisce di impostare insieme `personalAccess` e `password`.
- Il `secret` è salvato così com'è (la classe non lo cifra né lo sottopone a hashing): da verificare se il modello `OauthClient` applica un cast.
- Duplica il corpo di `CreateGenericClientAction` (vedi il relativo contract): nessun codice condiviso.
