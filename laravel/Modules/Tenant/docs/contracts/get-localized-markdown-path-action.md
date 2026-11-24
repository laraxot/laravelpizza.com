---
title: "GetLocalizedMarkdownPathAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Markdown\\GetLocalizedMarkdownPathAction"
qmd: "GetLocalizedMarkdownPathAction markdown localizzato percorso lingua tenant fallback cancelletto"
---

# GetLocalizedMarkdownPathAction

Trova il file markdown del tenant nella lingua corrente, con ripiego sulla versione generica. Codice: `app/Actions/Markdown/GetLocalizedMarkdownPathAction.php:11-33`.

## Input

- `string $name`: percorso relativo del markdown (ad esempio `privacy.md`).

## Output

- `string`: percorso assoluto del primo file esistente, nell'ordine `lang/<locale>/<name>` poi `<name>`; `'#'` se nessuno esiste (righe 19-31).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MD-INV-1` | Vince la versione nella lingua corrente, se esiste. | righe 19-25 | `tests/Unit/Actions/Markdown/GetLocalizedMarkdownPathActionTest.php` |
| `TENANT-MD-INV-2` | Se nessun file esiste, il risultato è `'#'`. | righe 27-29 | `tests/Unit/Actions/Markdown/GetLocalizedMarkdownPathActionTest.php` |
| `TENANT-MD-INV-3` | Ogni percorso passa da `GetTenantFilePathAction`, quindi un nome con traversal lancia un'eccezione. | righe 20-21 | nessuno diretto |

## Effetti collaterali

Solo `file_exists`. Nessuna scrittura.

## Errori

- `InvalidArgumentException` da `GetTenantFilePathAction`: propagata.

## Non fa

- Non legge il contenuto.
- Non ripiega sulla lingua di default dell'app: il fallback è solo il file senza prefisso lingua.
