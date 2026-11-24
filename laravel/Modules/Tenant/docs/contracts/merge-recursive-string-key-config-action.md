---
title: "MergeRecursiveStringKeyConfigAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\MergeRecursiveStringKeyConfigAction"
qmd: "MergeRecursiveStringKeyConfigAction fusione ricorsiva configurazioni chiavi stringa array_replace_recursive"
---

# MergeRecursiveStringKeyConfigAction

Fonde più array di configurazione, scartando le chiavi non stringa. Codice: `app/Actions/Config/MergeRecursiveStringKeyConfigAction.php:9-37`.

## Input

- `array<array-key, mixed> ...$configs`: uno o più array; anche con chiavi intere (riga 20).

## Output

- `array<string, mixed>`: fusione ricorsiva; con zero argomenti restituisce `[]`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MERGE-INV-1` | Il risultato ha solo chiavi stringa di primo livello. | righe 29 e 34 | `tests/Unit/TenantCoverageBoostTest.php` (riferimento alla classe) |
| `TENANT-MERGE-INV-2` | Con più array, vince l'ultimo per ogni chiave foglia (`array_replace_recursive`). | righe 27-30 | nessuno dedicato |

## Effetti collaterali

Nessuno: calcolo puro.

## Errori

- Nessuna eccezione propria.

## Non fa

- Il filtro non è ricorsivo: le chiavi intere dentro i sottoarray restano.
