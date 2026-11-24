---
title: "GetPermissionModelAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Shield\\GetPermissionModelAction"
qmd: "GetPermissionModelAction modello permission Filament Shield config permission.models.permission Spatie"
---

# GetPermissionModelAction

Restituisce il FQCN del modello Permission da usare, letto da `config('permission.models.permission')` con default `Spatie\Permission\Models\Permission`. Codice: `app/Actions/Shield/GetPermissionModelAction.php`. Esiste anche una `GetPermissionModelAction` in `app/Actions/` radice: il nome è duplicato, questo contract copre solo la versione Shield.

## Input

- Nessuno.

## Output

- `string`: FQCN del modello Permission.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-PERM-MODEL-INV-1` | Il valore restituito è sempre una stringa. | `Assert::string()` | nessuno (0 riferimenti per nome classe nei test) |
| `SHIELD-PERM-MODEL-INV-2` | Se la chiave è assente, vale il default Spatie. | `config(..., Permission::class)` | nessuno |

## Effetti collaterali

Nessuno: sola lettura di configurazione.

## Errori

- `InvalidArgumentException` (webmozart) se la configurazione è presente ma non stringa, incluso `null` esplicito (in quel caso il default di `config()` non interviene).

## Non fa

- Non verifica che la classe esista.
- Chiamante in produzione: `app/Filament/Resources/RoleResource/Pages/EditRole.php:34`.
