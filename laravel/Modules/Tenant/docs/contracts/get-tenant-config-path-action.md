---
title: "GetTenantConfigPathAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\GetTenantConfigPathAction"
qmd: "GetTenantConfigPathAction chiave config dotted tenant prefisso path notazione punto"
---

# GetTenantConfigPathAction

Costruisce la chiave di configurazione Laravel che punta a una voce del tenant corrente. Codice: `app/Actions/Config/GetTenantConfigPathAction.php:10-19`.

## Input

- `string $key`: chiave relativa, ad esempio `app.name`.

## Output

- `string`: `<tenant con '.' al posto di '/'>.<key>` (riga 18). Esempio: tenant `local/ptvx` e chiave `app.name` producono `local.ptvx.app.name`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-CFG-PATH-INV-1` | Ogni `/` del nome tenant diventa `.`. | riga 18 | `tests/Unit/Actions/Config/GetTenantConfigPathActionTest.php` |
| `TENANT-CFG-PATH-INV-2` | `$key` non viene validato né normalizzato. | riga 18 | nessuno |

## Effetti collaterali

Nessuno: legge solo il nome tenant da `GetTenantNameAction`, che a sua volta legge la richiesta corrente.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non verifica che la chiave esista in `config()`.
- Non legge né scrive file.
