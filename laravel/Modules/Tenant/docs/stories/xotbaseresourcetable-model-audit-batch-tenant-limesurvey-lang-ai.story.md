---
tags: [documentation]
updated: 2026-09-26
qmd: "xotbaseresourcetable model audit batch tenant limesurvey lang ai.story"
issues: []
discussions: []
title: "XotBaseResourceTable model audit - Tenant/DomainsTable"
status: done
type: story
created: 2026-09-11
---

# XotBaseResourceTable model audit - Tenant/DomainsTable

**Scope**: `app/Filament/Resources/DomainResource/Tables/DomainsTable.php` (batch cross-modulo Tenant/Limesurvey/Lang/AI, audit `protected static string $model` + colonne).

**Trovato**: il file aveva gia' `protected static string $model = Domain::class;` (con `use Modules\Tenant\Models\Domain;` corretto), coerente con `protected static ?string $model = Domain::class;` dichiarato nella Resource sorella `app/Filament/Resources/DomainResource.php` — nessuna correzione necessaria (probabile esito di un batch parallelo precedente sullo stesso audit).

`Domain` e' un model Sushi (`use Sushi\Sushi;`, righe generate a runtime da `GetDomainsArrayAction::execute()`, non una tabella reale) — verificato che l'action produce solo le chiavi `id` e `name` (array `['id' => ..., 'name' => ...]`), entrambe usate in `getTableColumns()`. Nessuna colonna sospetta: le due chiavi di `getTableColumns()` (`name`, `id`) coincidono esattamente con lo schema virtuale del model.

**Fatto**: nessuna modifica al codice. `name` era gia' `->searchable()->sortable()->wrap()`, `id` gia' `->toggleable(isToggledHiddenByDefault: true)` — con solo 2 colonne virtuali non c'era margine per migliorie UX a basso rischio additive.

**Verifica**: `php -l` non necessario (file non toccato). `vendor/bin/phpstan analyse Modules/Tenant/app/Filament/Resources/DomainResource/Tables/DomainsTable.php --no-progress` → 0 errori (eseguito insieme agli altri 3 file del batch).

**Resta da fare**: niente per questo file.
