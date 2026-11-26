---
title: "Topic resolve-tenant"
type: digest
status: active
qmd: "digest ceiling 100 resolve-tenant"
---

# Topic resolve-tenant

Sintesi automatica di 4 documenti (chiave `resolve-tenant`).

## ResolveTenantConfigValueAction

_Fonte: `contracts/resolve-tenant-config-value-action.md`_

# ResolveTenantConfigValueAction

Alias di `GetTenantConfigValueAction`: `execute()` delega all'unica implementazione
(`ResolveTenantConfigValueAction` → `GetTenantConfigValueAction`).
Motivo: evitare due corpi identici; il nome `Resolve*` resta per docs/BC.

## Input

- `string $key`: chiave con notazione a punti. Il primo segmento è il gruppo.
- `string|int|array|null $_default`: valore passato a `config()` se la chiave manca.

## Output

- `float|int|string|array|null`: valore risolto (stesse regole di `GetTenantConfigValueAction`).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-RESOLVE-INV-1` | Chiave vuota o gruppo vuoto lancia `Exception`. | `GetTenantConfigValueAction` | `tests/Unit/Actions/Config/GetTenantConfigValueActionTest.php` |
| `TENANT-RESOLVE-INV-2` | Il gruppo è fuso con `<tenant>.<gruppo>` e i valori del tenant prevalgono (`array_replace_recursive`). | `GetTenantConfigValueAction` | `tests/Unit/Actions/Config/GetTenantConfigValueActionTest.php` |
| `TENANT-RESOLVE-INV-3` | Un valore non scalare né array (ad esempio bool o oggetto) lancia `Exception`. | `GetTenantConfigValueAction` | `tests/Unit/TenantStatementCoverageTest.php` |

## Effetti collaterali

- Via `GetTenantConfigValueAction`: `Config::set($group, $mergeConf)` in memoria; legge base + tenant + `GetTenantNameAction`.

## Errori

- `Exception` generica con messaggio `[riga][classe]` in entrambi i casi di errore.

## ResolveTenantModelClassAction

_Fonte: `contracts/resolve-tenant-model-class-action.md`_

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

Ordine: lettura config (`ResolveTenantConfigValueAction`), scansio

## ResolveTenantModelInstanceAction

_Fonte: `contracts/resolve-tenant-model-instance-action.md`_

# ResolveTenantModelInstanceAction

Restituisce una istanza nuova del model risolto per nome. Codice: `app/Actions/Models/ResolveTenantModelInstanceAction.php:11-24`.

## Input

- `string $name`: come per `ResolveTenantModelClassAction`.

## Output

- `Model`: istanza nuova della classe risolta, creata con `app()` (righe 17-22).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `RES-MODEL-INST-INV-1` | La classe è quella di `ResolveTenantModelClassAction`, istanziata dal container. | righe 17-19 | `tests/Unit/Actions/Models/ResolveTenantModelInstanceActionTest.php` |
| `RES-MODEL-INST-INV-2` | Il risultato è un `Model`, altrimenti `Assert` lancia. | riga 20 | `tests/Unit/Actions/Models/ResolveTenantModelInstanceActionTest.php` |

## Effetti collaterali

Quelli di `ResolveTenantModelClassAction` (possibile scrittura di `morph_map`). Nessuna scrittura diretta, nessuna query.

## Errori

- Le eccezioni di `ResolveTenantModelClassAction` si propagano.
- `Assert::isInstanceOf` lancia se la classe non è un `Model`.

## Non fa

## Topic resolve-tenant

_Fonte: `wiki/topics/resolve-tenant.md`_

# Topic resolve-tenant

Sintesi automatica di 4 documenti (chiave `resolve-tenant`).

## ResolveTenantConfigValueAction

_Fonte: `contracts/resolve-tenant-config-value-action.md`_

# ResolveTenantConfigValueAction

Alias di `GetTenantConfigValueAction` (delega `execute()`). Vedi sezione sopra.
