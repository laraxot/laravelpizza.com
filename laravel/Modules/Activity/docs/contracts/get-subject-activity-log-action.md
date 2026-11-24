---
title: "Contratto — GetSubjectActivityLogAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Query\\GetSubjectActivityLogAction"
qmd: "contract GetSubjectActivityLogAction activity log soggetto classe e id array attivita ACT-QSUBJECT"
---

# GetSubjectActivityLogAction

Restituisce il log di un soggetto identificato da classe e id, come array, senza bisogno di un'istanza del modello.

## Input

- `string $modelClass`: FQCN del soggetto, usato così com'è (non verificato come classe esistente).
- `int|string $modelId`: chiave del soggetto.
- `int $limit = 500`: numero massimo di righe; non validato.

## Output

- `array<int, array<string, mixed>>`: per ogni attività, `toArray()` con le sole chiavi stringa, reindicizzato.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-QSUBJECT-INV-1` | Filtro `subject_type = $modelClass` e `subject_id = $modelId`, ordine `created_at` decrescente, massimo `$limit` righe. | `CoverageHundredActionsTest.php`, `QueryAndValidationTest.php`, `AdapterActivityRecorderTest.php` (percorsi, non verificati riga per riga) |
| `ACT-QSUBJECT-INV-2` | Il risultato è un array indicizzato da zero, non una Collection. | Test: nessuno dedicato |

## Effetti collaterali

Sola lettura. Nessuna relazione caricata (nessun `with`).

## Errori

- Nessuno dichiarato; le eccezioni del database si propagano.

## Non fa

- Non valida `$modelClass` né `$limit`.
- Il risultato include tutti gli attributi di `Activity`, `properties` comprese, senza redazione (vedi `redact-model-attributes-action.md`).

