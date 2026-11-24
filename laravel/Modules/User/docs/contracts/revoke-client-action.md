---
title: "RevokeClientAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Passport\\RevokeClientAction"
qmd: "RevokeClientAction revoca client OAuth2 Passport opzionale token associati revokeTokens"
---

# RevokeClientAction

Marca un client OAuth2 come revocato e, se richiesto, revoca in blocco i suoi access token. Codice: `app/Actions/Passport/RevokeClientAction.php`.

## Input

- `OauthClient|string $client`: istanza o id.
- `bool $revokeTokens`: se `true` revoca anche i token del client.

## Output

- `bool`: `true` se il client è stato trovato e marcato; `false` se non esiste (nessuna eccezione).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REVOKE-CLIENT-INV-1` | Con id inesistente ritorna `false` senza scritture. | `execute()`, controllo `instanceof` | `tests/Unit/Actions/Passport/PassportActionsCoverageBatch2Test.php:282` |
| `PASSPORT-REVOKE-CLIENT-INV-2` | Con `$revokeTokens = true` i token non revocati del client sono revocati prima del client. | `execute()`, primo blocco | nessuno sull'ordine |
| `PASSPORT-REVOKE-CLIENT-INV-3` | Il client finisce con `revoked = true`. | `execute()`, `save()` | stesso file (riferimento) |

## Effetti collaterali

Ordine: (opzionale) UPDATE in blocco su `oauth_tokens` filtrata per `client_id`; poi `save()` del client. Nessuna transazione: se il `save()` fallisce, i token restano già revocati. Nessun evento, nessuna coda.

## Errori

- Nessuna eccezione propria. Errori di database propagati.

## Non fa

- Non revoca i refresh token dei token del client.
- Le istanze `app(OauthClient::class)` e `app(OauthToken::class)` sono risolte nel corpo del metodo, non iniettate.
