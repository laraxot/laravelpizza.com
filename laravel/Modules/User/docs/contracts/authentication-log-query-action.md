---
title: "AuthenticationLogQueryAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Activity\\AuthenticationLogQueryAction"
qmd: "AuthenticationLogQueryAction query builder authentication_logs authenticatable morph class key attività"
---

# AuthenticationLogQueryAction

Costruisce la query dei log di autenticazione di un modello autenticabile. Codice: `app/Actions/Activity/AuthenticationLogQueryAction.php:15-25`.

## Input

- `Model $authenticatable`: il modello di cui si cercano i log (`execute`, riga 20).

## Output

- `Builder<AuthenticationLog>` non eseguito: filtra `authenticatable_type` = `getMorphClass()` e `authenticatable_id` = `getKey()` (righe 22-24).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `AUTH-LOG-QUERY-INV-1` | Il filtro usa solo morph class e chiave del modello passato; nessun altro vincolo. | righe 22-24 | Test: nessuno (nessun riferimento alla classe in `tests/`). |
| `AUTH-LOG-QUERY-INV-2` | Il builder non viene eseguito: la query parte solo al consumo del chiamante. | riga 22 (nessun `get`/`count`) | Test: nessuno. |

## Effetti collaterali

Nessuno. Nessuna lettura né scrittura: l'Action restituisce solo il builder.

## Errori

- Nessun errore proprio. Un modello senza `getMorphClass()` o chiave produce un errore del framework.

## Non fa

- Non applica ordinamento, paginazione o `whereNotNull` sul timestamp: li aggiunge il chiamante.
- Duplica il corpo di [get-authentication-log-query-action](get-authentication-log-query-action.md) e di [get-authentication-log-query-for-authenticatable-action](get-authentication-log-query-for-authenticatable-action.md): tre copie identiche (vedi report di modulo).
