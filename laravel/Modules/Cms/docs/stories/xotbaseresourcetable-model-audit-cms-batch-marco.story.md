---
tags: [documentation]
qmd: "xotbaseresourcetable model audit cms batch marco.story"
issues: []
discussions: []
title: "Cms: audit $model + colonne + UX su 5 XotBaseResourceTable"
type: story
module: Cms
story_id: xotbaseresourcetable-model-audit-cms-batch-marco
slug: xotbaseresourcetable-model-audit-cms-batch-marco
status: done
created: 2026-09-11
updated: 2026-09-11
github_issue: https://github.com/laraxot/module_cms_fila5/issues/52
owned_scope:
  - app/Filament/Resources/AttachmentResource/Tables/AttachmentsTable.php
  - app/Filament/Resources/MenuResource/Tables/MenusTable.php
  - app/Filament/Resources/PageContentResource/Tables/PageContentsTable.php
  - app/Filament/Resources/PageResource/Tables/PagesTable.php
  - app/Filament/Resources/SectionResource/Tables/SectionsTable.php
---

# Cms — XotBaseResourceTable model audit (batch cms-batch-marco)

## Contesto

Batch di audit cross-modulo su tutte le classi `abstract class X extends
XotBaseResourceTable`: aggiungere `protected static string $model`, verificare
`getTableColumns()` contro lo schema reale, migliorie UX additive a basso rischio.
Questo modulo (Cms) ha 5 file nello scope.

## Task 1 — `protected static string $model`

All'apertura del batch, i 5 file risultavano gia' modificati (non committati) nel working
tree con la property `protected static string $model = X::class;` aggiunta subito dopo
l'apertura della classe, con `use` corretto in testa al file. Verificato che il valore
coincide con quello autorevole dichiarato nella Resource sorella (`protected static
?string $model = X::class;`):

| Table | Model aggiunto | Resource sorella | Match |
|---|---|---|---|
| `AttachmentsTable` | `Modules\Cms\Models\Attachment` | `AttachmentResource.php:22` | OK |
| `MenusTable` | `Modules\Cms\Models\Menu` | `MenuResource.php:12` | OK |
| `PageContentsTable` | `Modules\Cms\Models\PageContent` | `PageContentResource.php:19` | OK |
| `PagesTable` | `Modules\Cms\Models\Page` | `PageResource.php:22` | OK |
| `SectionsTable` | `Modules\Cms\Models\Section` | `SectionResource.php:15` | OK |

Nessuna modifica necessaria per Task 1: gia' corretto.

## Task 2 — verifica colonne reali

Scoperta rilevante: tutti e 5 i model (`Attachment`, `Menu`, `PageContent`, `Page`,
`Section`) usano il trait `Modules\Tenant\Models\Traits\SushiToJsons` (Sushi + file JSON
in `database/content/<table>/*.json`). **Non sono tabelle MySQL vere** — infatti
`Schema::getColumnListing()` sulla connessione di default (`mysql`, db `quaeris_data`)
ritorna vuoto o dati fuorvianti (es. per `menus` esiste per caso una tabella MySQL
legacy con colonne `id,name,created_at,updated_at`, non collegata al model Sushi).

Lo schema autorevole e' la property `protected array $schema` di ciascun model, che
Sushi usa per costruire la tabella SQLite in-memory. Verificato con:

```php
$model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable())
```

Risultato per ognuno (colonne reali):

- `Attachment` (attachments): `id,title,description,slug,disk,attachment,created_at,updated_at,created_by,updated_by`
- `Menu` (menus): `id,title,parent_id,created_at,updated_at,created_by,updated_by`
- `PageContent` (page_contents): `id,name,slug,blocks,created_at,updated_at,created_by,updated_by`
- `Page` (pages): `id,title,slug,middleware,content,description,blocks,content_blocks,sidebar_blocks,footer_blocks,created_at,updated_at,created_by,updated_by`
- `Section` (sections): `id,name,slug,blocks,created_at,updated_at,created_by,updated_by`

Confronto con `getTableColumns()`:

- `AttachmentsTable`: `title`, `description`, `slug`, `disk` — tutte dirette, tutte presenti. OK.
- `MenusTable`: `title` (diretta, presente); `parent_id` => `TextColumn::make('parent.title')` — relazione (punto), saltata come da istruzioni. OK.
- `PageContentsTable`: `name`, `slug` — tutte dirette, tutte presenti. OK.
- `PagesTable`: `title`, `slug`, `description`, `middleware` — tutte dirette, tutte presenti. OK.
- `SectionsTable`: `name`, `slug` — tutte dirette, tutte presenti. OK.

Nessuna colonna sospetta/inesistente trovata in nessuno dei 5 file. Nessuna rimozione
necessaria.

## Task 3 — UX

Migliorie additive, a basso rischio, applicate solo dove c'era un precedente diretto nello
stesso file:

- `AttachmentsTable.php` riga 26: `'description' => TextColumn::make('description')->limit(50)` ->
  aggiunto `->searchable()`. Motivazione: `description` ha lo stesso schema type (`json`,
  campo traducibile) di `title`, che nello stesso file e' gia' `->searchable()` — pattern
  gia' in uso e verificato, quindi a rischio minimo.
- `PagesTable.php` riga 27: stessa modifica (`description` schema type `string`, ancora
  piu' sicura da rendere searchable). Stesso ragionamento di coerenza con `title`
  gia' searchable nello stesso file.

Nessuna colonna data/enum presente in nessuno dei 5 file (nessuno di questi Table mostra
`created_at`/`updated_at`/campi enum in `getTableColumns()`), quindi non applicabile la
formattazione `->dateTime()`/`->badge()`. Nessun campo person-like (`first_name`,
`last_name`, `email`) presente: non serve `PersonColumn`. `MenusTable.php` e
`SectionsTable.php`/`PageContentsTable.php` avevano gia' searchable/sortable su tutte le
colonne dirette rilevanti: nessuna modifica.

Non sono state rimosse colonne esistenti. Non sono state create nuove classi Column
condivise.

## File toccati

- `app/Filament/Resources/AttachmentResource/Tables/AttachmentsTable.php` (Task 1 gia'
  presente, Task 3: `+searchable()` su `description`)
- `app/Filament/Resources/PageResource/Tables/PagesTable.php` (Task 1 gia' presente,
  Task 3: `+searchable()` su `description`)
- `app/Filament/Resources/MenuResource/Tables/MenusTable.php` (Task 1 gia' presente,
  nessuna modifica Task 3)
- `app/Filament/Resources/PageContentResource/Tables/PageContentsTable.php` (Task 1 gia'
  presente, nessuna modifica Task 3)
- `app/Filament/Resources/SectionResource/Tables/SectionsTable.php` (Task 1 gia' presente,
  nessuna modifica Task 3)

## Verifica

- `php -l` su tutti e 5 i file: nessun errore di sintassi.
- `vendor/bin/phpstan analyse <5 file> --no-progress` (da `laravel/`): `[OK] No errors`.
  (Un primo tentativo aveva riportato un bootstrap failure per un errore di sintassi
  transitorio altrove nel monorepo — probabilmente un altro batch/agente in scrittura
  concorrente in quel preciso istante; confermato non correlato ai 5 file di questa
  story con `php artisan route:list --path=admin` riuscito e un secondo run pulito di
  PHPStan.)

## GitHub

Issue: https://github.com/laraxot/module_cms_fila5/issues/52
