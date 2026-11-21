---
title: "Editor dei file di traduzione nel pannello"
type: guideline
module: Lang
tags: [documentation, filament, translation-file, sushi]
created: 2026-11-19
updated: 2026-11-19
qmd: "TranslationFileForm getFormSchema fieldsFromArray file content traduttore Sushi TranslationFile name key"
issues: []
discussions: []
related:
  - ./filament-table-architecture.md
  - ./stories/7.4.phpstan-canonical-schemas-static-call-fix.story.md
---

# Editor dei file di traduzione nel pannello

`TranslationFile` e' un model Sushi: ogni riga e' un file `lang/<locale>/<nome>.php` di un modulo,
letto da `getRows()`; la colonna `content` (cast `array`) contiene l'array del file.

## Il form (`Schemas/TranslationFileForm`)

`getFormSchema()` restituisce due sezioni, con queste chiavi:

| Chiave | Contenuto |
|---|---|
| `file` | `name` e `key` del file, in sola lettura (`disabled()->dehydrated(false)`) |
| `content` | una casella per ogni testo del file, costruite da `fieldsFromArray($record->content, 'content')` |

`fieldsFromArray()` scende negli array annidati: un sotto-array diventa una `Section` richiudibile,
un testo diventa un `TextInput` (o una `Textarea` sopra gli 80 caratteri). Il nome del campo e' il
percorso con i punti (`content.meta.description`), cosi' lo stato del form ha la stessa forma
dell'array del file.

## Perche' cosi'

Fino a novembre 2026 il form aveva il solo campo `name`: dal pannello non si poteva tradurre nulla.
Un test che cerca ancora `name` al primo livello dello schema misura il form vecchio: la chiave
`name` sta dentro la sezione `file`.

## Guardia

`Modules/Lang/tests/Unit/LangCoverageBoostTest.php` («translation file schemas and pages build
executable structures»): chiavi `file` e `content`, e un campo `content.title` costruito da
`fieldsFromArray()`.
