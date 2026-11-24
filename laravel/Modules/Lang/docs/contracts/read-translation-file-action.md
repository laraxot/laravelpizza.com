---
title: "Contratto — ReadTranslationFileAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\ReadTranslationFileAction"
qmd: "ReadTranslationFileAction legge file traduzione require array toPhp rendering PHP LANG-READ"
---

# ReadTranslationFileAction

Legge un file di traduzione PHP e ne rende il contenuto come codice PHP. Codice: `app/Actions/ReadTranslationFileAction.php:11-100`. Due responsabilita' nello stesso file: lettura (`execute`) e rendering (`toPhp`).

## Input

- `execute(string $filePath)`: percorso di un file che restituisce un array.
- `toPhp(array $translations)`: array con chiavi stringa (annidate incluse).

## Output

- `execute`: `array<string, mixed>`, il valore restituito dal file.
- `toPhp`: stringa `<?php\n\nreturn [...];\n`, indentata a 4 spazi.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-READ-INV-1` | File inesistente: `\Exception` «File di traduzione non trovato». | `tests/Unit/Actions/ReadTranslationFileActionTest.php:36`. |
| `LANG-READ-INV-2` | File non leggibile: `\Exception` «non leggibile». | `ReadTranslationFileActionTest.php:42`. |
| `LANG-READ-INV-3` | Il file deve restituire un array con chiavi stringa: altrimenti `\Exception` «non valido» o asserzione Webmozart. | `ReadTranslationFileActionTest.php:56`. |
| `LANG-READ-INV-4` | `toPhp` produce chiavi e valori escapati, array annidati come `[...]`, valori scalari via `SafeStringCastAction`. | `ReadTranslationFileActionTest.php:65-167` (conversione, annidamento, indentazione, array vuoti, numeri, ordine delle chiavi). |

## Effetti collaterali

- `execute` esegue il codice del file con `require`. Il modello di fiducia assume file di lingua del progetto.
- Nessuna scrittura.

## Errori

- `\Exception` per file mancante, non leggibile, non array.
- `Webmozart\Assert\InvalidArgumentException` per chiavi non stringa, anche annidate (riga 84).

## Non fa

- Non verifica la sintassi dell'output di `toPhp`: lo fa `write-translation-file-action` prima di scrivere.
- Non scrive il file.
- Chiamante verificato per `toPhp`: `WriteTranslationFileAction`.
