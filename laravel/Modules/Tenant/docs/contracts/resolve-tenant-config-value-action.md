---
title: "ResolveTenantConfigValueAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\ResolveTenantConfigValueAction"
qmd: "ResolveTenantConfigValueAction valore config tenant override gruppo Config::set merge default eccezione"
---

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

## Non fa

- Non crea né modifica file.
- Non distingue un valore assente da un valore `null` già presente.
- Il docblock cita `docs/resolve-tenant-config-console-debate.md` (esistente in `Modules/Tenant/docs/`).
