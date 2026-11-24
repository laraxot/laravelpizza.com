---
title: "Contratto — MergeTranslationsAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\MergeTranslationsAction"
qmd: "MergeTranslationsAction fonde file traduzione array_merge override ultimo vince LANG-MERGE"
---

# MergeTranslationsAction

Fonde piu' array di traduzione in uno. Codice: `app/Actions/MergeTranslationsAction.php:13-33`.

## Input

- `array $translationFiles`: lista di array associativi, uno per file.

## Output

- `array<string, mixed>`: risultato di `array_merge` in sequenza.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-MERGE-INV-1` | Per le chiavi stringa vince l'ultimo file della lista. Il docblock dice «LIFO»: il comportamento reale e' «ultimo vince». | Riferimento in `tests/Unit/LangCoverageBoostTest.php` (contenuto non letto). |
| `LANG-MERGE-INV-2` | La fusione e' superficiale: un array annidato del file successivo sostituisce quello precedente intero, non viene fuso in profondita'. | Test: nessuno. |

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno. Un elemento non array fa lanciare `array_merge` (TypeError).

## Non fa

- Non fonde in profondita' (vedi INV-2).
- Chiamanti non trovati fuori da test.
