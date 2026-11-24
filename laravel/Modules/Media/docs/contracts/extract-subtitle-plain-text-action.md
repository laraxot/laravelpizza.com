---
title: "ExtractSubtitlePlainTextAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Subtitle\\ExtractSubtitlePlainTextAction"
qmd: "ExtractSubtitlePlainTextAction estrae testo semplice sottotitoli XML sentence item"
---

# ExtractSubtitlePlainTextAction

Estrae il testo di un file di sottotitoli XML concatenando gli `item` di ogni `sentence`. Codice: `app/Actions/Subtitle/ExtractSubtitlePlainTextAction.php:16-40`.

## Input

- `string $filePath`: percorso del file XML.

## Output

- `string`: testo degli item in ordine, ognuno seguito da uno spazio (nessun `trim`).

## Invarianti

- **EXTRACT-SUBTITLE-PLAIN-TEXT-INV-1** — Si leggono solo i percorsi `annotation/type/sentence/item`; altre strutture danno stringa vuota.
  Test: `tests/Unit/Actions/Subtitle/SubtitleTextActionsTest.php:21`.

## Effetti collaterali

- Nessuno: lettura del file.

## Errori

- `Safe\realpath` e `Safe\simplexml_load_string` lanciano se il file non esiste o l'XML non è valido.

## Non fa

- Non usa i tempi dei sottotitoli.
- Non rimuove lo spazio finale.
