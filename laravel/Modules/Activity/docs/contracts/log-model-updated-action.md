---
title: "Contratto — LogModelUpdatedAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\LogModelUpdatedAction"
qmd: "contract LogModelUpdatedAction activity evento updated modello old new changes getOriginal getChanges ACT-MUPDATE"
---

# LogModelUpdatedAction

Registra l'evento `updated` di un modello Eloquent con valori precedenti, nuovi e modificati.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'updated'`, `description = '<Basename> updated'`, `properties = ['old' => getOriginal(), 'new' => getAttributes(), 'changes' => getChanges()]`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-MUPDATE-INV-1` | Senza modello lancia `InvalidArgumentException('A model is required')`. | Test: nessuno che asserisca il messaggio |
| `ACT-MUPDATE-INV-2` | Il tipo è `updated`; `properties` ha le chiavi `old`, `new`, `changes`. | Test: nessuno sulle chiavi |
| `ACT-MUPDATE-INV-3` | `changes` è quello che il modello espone al momento della chiamata: l'Action è valida se chiamata dopo il `save()`. | Test: nessuno |

## Effetti collaterali

- Un `INSERT` in `activity_log` tramite `LogActivityAction`. Il modello non viene modificato.

## Errori

- `InvalidArgumentException` (INV-1).

## Non fa

- Non decide quando viene chiamata (chi la invoca, per esempio un observer, non è in questo contract).
- Non redige `old` e `new`: contengono anche password o token se presenti nel modello (vedi `redact-model-attributes-action.md`).

