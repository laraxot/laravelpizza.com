---
title: "Contratto — PublishTranslationAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\PublishTranslationAction"
qmd: "PublishTranslationAction pubblica traduzione singola voce item value SaveArrayAction file lingua LANG-PUB"
---

# PublishTranslationAction

Imposta una singola voce di un file di traduzione e riscrive il file se il contenuto cambia. Codice: `app/Actions/PublishTranslationAction.php:12-48`.

## Input

- `TranslationData $translationData`: fornisce `getFilename()`, `getData()`, `item` e `value`.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-PUB-INV-1` | Il file viene riscritto solo se l'array dopo `Arr::set` e' diverso da quello letto (riga 39). Se la voce ha gia' quel valore, nessuna scrittura. | Test: nessuno comportamentale. `tests/Unit/Actions/LangActionsCoverageTest.php:15` verifica solo che la classe sia accessibile. |
| `LANG-PUB-INV-2` | La scrittura passa per `Modules\Xot\Actions\Arr\SaveArrayAction` sul percorso dato da `getFilename()`. | Test: nessuno. |

## Effetti collaterali

- Scrittura del file di lingua via `SaveArrayAction`. Nessun backup, nessuna pulizia della cache.
- Righe 21-35: blocco di codice commentato (vecchia lettura del file): non attivo.

## Errori

- Eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non valida `item` ne' `value`.
- Non crea backup (a differenza di `write-translation-file-action`).
- Chiamanti non trovati fuori da test.
