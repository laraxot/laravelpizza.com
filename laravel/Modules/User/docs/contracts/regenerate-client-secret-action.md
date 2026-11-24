---
title: "RegenerateClientSecretAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Passport\\RegenerateClientSecretAction"
qmd: "RegenerateClientSecretAction rigenera secret client OAuth2 Passport 40 caratteri salvataggio"
---

# RegenerateClientSecretAction

Sostituisce il `secret` di un client OAuth2 con uno nuovo casuale e lo restituisce in chiaro. Codice: `app/Actions/Passport/RegenerateClientSecretAction.php`.

## Input

- `OauthClient|string $client`: istanza, oppure id da cercare con `findOrFail`.

## Output

- `string`: il nuovo secret di 40 caratteri, in chiaro. È l'unico punto in cui il valore è disponibile.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `PASSPORT-REGEN-SECRET-INV-1` | Il secret precedente è sovrascritto: dopo il `save()` non è più valido. | `execute()`, assegnazione e `save()` | riferimento in `tests/Unit/Actions/Passport/PassportActionsCoverageBatch2Test.php:107` (verifica asserzioni non eseguita) |
| `PASSPORT-REGEN-SECRET-INV-2` | Un id inesistente produce `ModelNotFoundException`. | `findOrFail` | nessuno |

## Effetti collaterali

Un `save()` sul client. Nessuna revoca di token esistenti, nessun evento, nessuna coda.

## Errori

- `ModelNotFoundException` se la stringa non corrisponde a nessun client.

## Non fa

- Non revoca i token già emessi con il vecchio secret.
- Non cifra né hasha il secret: viene salvato in chiaro, come in `CreateClientAction`.
