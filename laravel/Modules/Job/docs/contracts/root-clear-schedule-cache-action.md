---
title: "Contratto — ClearScheduleCacheAction (root, superseded)"
type: contract
owner: Job
status: accepted
updated: 2026-11-24
action: "Modules\\Job\\Actions\\ClearScheduleCacheAction"
qmd: "ClearScheduleCacheAction duplicato flat root superseded deprecated Job cache schedule"
---

# ClearScheduleCacheAction (root, superseded)

Duplicato flat, marcato `@deprecated` nel docblock (`app/Actions/ClearScheduleCacheAction.php:11-18`). Il contratto attivo e' [clear-schedule-cache-action](clear-schedule-cache-action.md).

## Input

- Nessun argomento. Stesse config di `job::cache.store` e `job::cache.key` (righe 25-26), asserite `string`.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `JOB-CACHE-ROOT-INV-1` | Stessa logica dell'Action Schedule: `forget` della sola chiave `job::cache.key` nello store `job::cache.store`. | Test: nessuno dedicato. |
| `JOB-CACHE-ROOT-INV-2` | Config non stringa: `InvalidArgumentException` (stesso comportamento di INV-2 del contratto Schedule). | Test: nessuno. |

## Effetti collaterali

- Una sola `Cache::store($store)->forget($key)` (riga 28). Nessun altro effetto.

## Errori

- `Webmozart\Assert\InvalidArgumentException` come sopra.

## Non fa

- Non e' da usare: il docblock indica come chiamante corretto `Modules\Job\Actions\Schedule\ClearScheduleCacheAction`.
- Nei chiamanti di produzione verificati non compare (gli import puntano alla versione Schedule). Il file resta on-disk finche' non c'e' autorizzazione a cancellare i doppioni: non e' stato toccato.
- Riferimento nei test: `tests/Arch/debt.php:18-21` (solo commenti).
