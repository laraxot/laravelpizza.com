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

Risolve un valore di configurazione sovrapponendo la config del tenant a quella di base. Codice: `app/Actions/Config/ResolveTenantConfigValueAction.php:13-63`.

## Input

- `string $key`: chiave con notazione a punti. Il primo segmento è il gruppo (riga 33).
- `string|int|array|null $_default`: valore passato a `config()` se la chiave manca (riga 56).

## Output

- `float|int|string|array|null`: valore risolto (riga 58-60).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-RESOLVE-INV-1` | Chiave vuota o gruppo vuoto lancia `Exception`. | righe 33-36 | `tests/Unit/Actions/Config/ResolveTenantConfigValueActionTest.php` |
| `TENANT-RESOLVE-INV-2` | Il gruppo è fuso con `<tenant>.<gruppo>` e i valori del tenant prevalgono (`array_replace_recursive`). | righe 38-52 | `tests/Unit/Actions/Config/ResolveTenantConfigValueActionTest.php` |
| `TENANT-RESOLVE-INV-3` | Un valore non scalare né array (ad esempio bool o oggetto) lancia `Exception`. | righe 58-62 | nessuno |

## Effetti collaterali

- `Config::set($group, $mergeConf)` (riga 54) modifica la configurazione in memoria dell'intero gruppo per il resto del processo. Non scrive su disco.
- Legge la config di base e quella del tenant, e il nome tenant da `GetTenantNameAction`.

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

## ResolveTenantConfigValueAction - Console Check Debate

_Fonte: `resolve-tenant-config-console-debate.md`_

# ResolveTenantConfigValueAction - Console Check Debate

**Status**: 🔥 FURIOUS INTERNAL DEBATE
**Issue**: `runningInConsole()` check breaks tenant functionality
**Filosofia**: DRY + KISS + SOLID + Multi-Tenant Zen

---

## 🔴 Il Problema Critico

Nel file `ResolveTenantConfigValueAction.php` esisteva questo blocco:

```php
if (app()->runningInConsole()) {
    $default = $_default;
    $res = config($key, $default);
    if (is_numeric($res) || \is_string($res) || \is_array($res) || $res === null) {
        /** @var float|int|string|array<mixed>|null $res */
        return $res;
    }

    throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
}
```

**Conseguenza**: Quando l'app gira in console (artisan, queue workers, scheduler), SALTA il merge delle configurazioni tenant e ritorna solo la config globale.

---

## ⚔️ IL DIBATTITO FURIOSO
