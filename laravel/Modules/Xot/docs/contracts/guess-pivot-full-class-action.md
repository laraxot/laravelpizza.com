---
title: "GuessPivotFullClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModelClass\\GuessPivotFullClassAction"
qmd: "GuessPivotFullClassAction FQCN pivot namespace classe genitore ricorsione Morph class_exists"
---

# GuessPivotFullClassAction

Cerca il FQCN di una classe pivot nel namespace del modello dichiarante, poi in quello del correlato, poi risalendo le classi genitrici. Codice: `app/Actions/ModelClass/GuessPivotFullClassAction.php`.

## Input

- `string $pivot_name`: nome base del pivot.
- `string $related`, `string $class`: FQCN dei modelli.

## Output

- `string`: FQCN candidato. Può non esistere se nessun candidato è trovato.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `MODEL-PIVOT-FQCN-INV-1` | Se esiste una classe nel namespace di `$class`, il risultato è quella. | Test: nessuno |
| `MODEL-PIVOT-FQCN-INV-2` | Altrimenti, se esiste nel namespace di `$related`, il risultato è quella. | Test: nessuno |
| `MODEL-PIVOT-FQCN-INV-3` | Se la classe genitrice non termina con `Morph`, la ricerca continua con il nome derivato dal genitore. | Test: nessuno |

## Effetti collaterali

- `class_exists` può attivare l'autoload.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non verifica che il candidato finale esista né che sia un `Pivot`: il controllo è demandato a `GuessPivotAction` e `GuessMorphPivotAction`.
