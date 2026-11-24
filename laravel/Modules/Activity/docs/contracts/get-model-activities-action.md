---
title: "Contratto — GetModelActivitiesAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Query\\GetModelActivitiesAction"
qmd: "contract GetModelActivitiesAction activity query attivita di un modello soggetto subject_type subject_id ACT-QMODEL"
---

# GetModelActivitiesAction

Restituisce le attività recenti il cui soggetto è un dato modello Eloquent.

## Input

- `Model $model`: modello soggetto; la classe è `$model::class`, la chiave `getKey()`.
- `int $limit = 50`: numero massimo di righe.

## Output

- `Collection<int, Activity>`: dalla più recente, con `causer` eager-loaded.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-QMODEL-INV-1` | Filtro esatto su `subject_type = FQCN del modello` e `subject_id = chiave`, ordine `created_at` decrescente, massimo `$limit` righe. | `CoverageHundredActionsTest.php` (percorso positivo, non verificato riga per riga) |

## Effetti collaterali

Sola lettura.

## Errori

- Nessuno proprio; le eccezioni del database si propagano.

## Non fa

- Non valida `$limit`: un valore `<= 0` non è rifiutato, a differenza di `GetRecentActivitiesAction`. Un limite negativo potrebbe non applicare il tetto (da verificare con la versione di Laravel in uso).
- Non normalizza la classe del soggetto: confronta il FQCN esatto.

