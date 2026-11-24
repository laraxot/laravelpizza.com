---
title: "GetAuthenticationLogQueryAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\GetAuthenticationLogQueryAction"
qmd: "GetAuthenticationLogQueryAction query builder log autenticazione authenticatable morph"
---

# GetAuthenticationLogQueryAction

Restituisce il query builder dei log di autenticazione di un modello autenticabile. Codice: `app/Actions/Auth/GetAuthenticationLogQueryAction.php:15-27`.

## Input

- `Model $authenticatable` (`execute`, riga 22).

## Output

- `Builder<AuthenticationLog>` non eseguito, filtrato su `authenticatable_type` (morph class) e `authenticatable_id` (riga 24-26).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `GET-AUTH-LOG-INV-1` | Il filtro è esattamente morph class e chiave del modello; nessun altro vincolo. | righe 24-26 | Test: nessuno (nessun riferimento alla classe in `tests/`). |

## Effetti collaterali

Nessuno: solo costruzione del builder.

## Errori

- Nessuna eccezione propria.

## Non fa

- Stesso corpo di [authentication-log-query-action](authentication-log-query-action.md) e di [get-authentication-log-query-for-authenticatable-action](get-authentication-log-query-for-authenticatable-action.md): duplicazione da rimuovere in un intervento dedicato (non fatto qui).
