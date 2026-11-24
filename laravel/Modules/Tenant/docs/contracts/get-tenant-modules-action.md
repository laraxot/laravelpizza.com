---
title: "GetTenantModulesAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Modules\\GetTenantModulesAction"
qmd: "GetTenantModulesAction moduli abilitati tenant modules_statuses json cartella Modules"
---

# GetTenantModulesAction

Elenca i moduli abilitati per il tenant corrente. Codice: `app/Actions/Modules/GetTenantModulesAction.php:15-62`.

## Input

- Nessun parametro. Legge `modules_statuses.json` del tenant tramite `GetTenantFilePathAction` (riga 24).

## Output

- `array<int, string>`: nomi dei moduli con valore `true` nel file e con cartella `Modules/<nome>` presente (righe 45-61).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MODULES-INV-1` | Un modulo è incluso solo se il suo valore è vero e la cartella esiste. | righe 49-59 | `tests/Unit/Actions/TenantAdditionalActionsTest.php` (riferimento alla classe) |
| `TENANT-MODULES-INV-2` | Se il JSON non è un array, il risultato è `[]`. | righe 33-35 | nessuno |

## Effetti collaterali

Solo lettura del file e del filesystem. Nessuna scrittura.

## Errori

- File mancante: `File::get` lancia, fuori dal `try`, quindi l'eccezione si propaga.
- JSON non valido: `Exception` con messaggio, percorso del file e riga (righe 27-31).

## Non fa

- Non verifica che il modulo sia registrato in nwidart.
