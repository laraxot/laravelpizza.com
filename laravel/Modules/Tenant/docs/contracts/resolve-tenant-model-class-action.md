---
title: "ResolveTenantModelClassAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Models\\ResolveTenantModelClassAction"
qmd: "ResolveTenantModelClassAction classe modello tenant morph_map singolare snake scansione moduli persistenza"
---

# ResolveTenantModelClassAction

Risolve il FQCN del model da un nome, usando la `morph_map` del tenant e, se manca, la scansione dei moduli abilitati. Codice: `app/Actions/Models/ResolveTenantModelClassAction.php:16-103`.

## Input

- `string $name`: nome del model, al singolare o al plurale. Viene normalizzato con `Str::snake(Str::singular(...))` (riga 22).

## Output

- `class-string` (`string`): FQCN del model.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `RES-MODEL-CLASS-INV-1` | Il nome è normalizzato al singolare snake_case prima della ricerca. | riga 22 | `tests/Unit/Actions/Models/ResolveTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-2` | Se `morph_map.<name>` è in config, viene restituito senza scansionare i moduli. | righe 24-27 | `tests/Unit/Actions/Models/ResolveTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-3` | Se il nome non è in `morph_map`, la scansione dei moduli abilitati trova la classe e la coppia viene persistita nella `morph_map` del tenant. | righe 37-47 | `tests/Unit/Actions/Models/ResolveTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-4` | Un nome sconosciuto lancia `Exception` e non scrive nulla. | righe 40-42 | `tests/Unit/Actions/Models/ResolveTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-5` | Un valore in `morph_map` non stringa lancia `Exception`. | righe 30-32 | nessuno |

## Effetti collaterali

Ordine: lettura config (`ResolveTenantConfigValueAction`), scansione moduli (`Module::allEnabled`, `GetAllModelsByModuleNameAction`), eventuale scrittura di `config/<tenant>/morph_map.php` tramite `SaveTenantConfigAction` (riga 44), poi risposta. Nessuna transazione, evento o coda.

## Errori

- `Exception('model unknown [...]')` per nomi sconosciuti (riga 41).
- `Exception` generica per valori non stringa (riga 31).

## Non fa

- Non istanzia il model: vedi `ResolveTenantModelInstanceAction`.
- Non verifica che la classe estenda `Model`: solo `class_exists`.
- Con più moduli che dichiarano lo stesso nome, vince l'ultimo per `array_merge` (silenzioso).
