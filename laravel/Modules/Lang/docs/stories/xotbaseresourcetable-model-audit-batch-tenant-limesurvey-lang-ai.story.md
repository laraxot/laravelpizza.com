---
tags: [documentation]
updated: 2026-09-26
qmd: "xotbaseresourcetable model audit batch tenant limesurvey lang ai.story"
issues: []
discussions: []
title: "XotBaseResourceTable model audit - Lang/TranslationFilesTable"
status: done
type: story
created: 2026-09-11
---

# XotBaseResourceTable model audit - Lang/TranslationFilesTable

**Scope**: `app/Filament/Resources/TranslationFileResource/Tables/TranslationFilesTable.php` (batch cross-modulo Tenant/Limesurvey/Lang/AI, audit `protected static string $model` + colonne).

**Trovato**: il file aveva gia' `protected static string $model = TranslationFile::class;` con `use` corretto, coerente con `protected static ?string $model = TranslationFile::class;` nella Resource sorella `app/Filament/Resources/TranslationFileResource.php` — nessuna correzione necessaria.

`TranslationFile` e' un model Sushi (righe generate a runtime da `GetAllTranslationAction` + logica di `loadTranslationDataWithErrorHandling()`), docblock `@property` dichiara `key, path, id, name, content`. Le 3 chiavi di `getTableColumns()` (`name`, `key`, `path`) sono tutte presenti — nessuna colonna sospetta, nessuna relazione.

**Fatto**: aggiunto `->sortable()` alla colonna `path` (era gia' `->searchable()->wrap()->toggleable(isToggledHiddenByDefault: true)` ma priva di ordinamento pur essendo un campo di testo ovviamente ordinabile, stesso trattamento gia' riservato a `name` e `key`). Nessun'altra modifica.

**Verifica**: `php -l Modules/Lang/app/Filament/Resources/TranslationFileResource/Tables/TranslationFilesTable.php` → nessun errore di sintassi. `vendor/bin/phpstan analyse Modules/Lang/app/Filament/Resources/TranslationFileResource/Tables/TranslationFilesTable.php --no-progress` (insieme agli altri 3 file del batch) → 0 errori.

**Resta da fare**: niente per questo file.
