---
tags: [documentation]
qmd: "xotbaseresourcetable model audit media batch.story"
issues: []
discussions: []
title: "XotBaseResourceTable: dichiarare $model esplicito e verificare colonne reali"
type: story
module: Media
epic: null
story_id: null
slug: xotbaseresourcetable-model-audit-media-batch
status: done
cold_gate: null
created: '2026-09-11'
updated: '2026-09-11'
repository: "https://github.com/laraxot/module_media_fila5.git"
github_issue: null
github_discussion: null
estimated_effort: "1-2h"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "app/Filament/Resources/HasMediaResource/Tables/HasMediasTable.php (deleted 2026-09-11, see Follow-up)"
  - "app/Filament/Resources/MediaConvertResource/Tables/MediaConvertsTable.php"
  - "app/Filament/Resources/MediaResource/Tables/MediasTable.php (deleted 2026-09-11, see Follow-up)"
  - "app/Filament/Resources/MediaResource/Tables/MediaTable.php"
  - "app/Filament/Resources/TemporaryUploadResource/Tables/TemporaryUploadsTable.php"
  - "tests/Unit/MediaFilamentAndActionsTest.php"
related:
  - "app/Filament/Resources/MediaResource.php"
  - "app/Filament/Resources/MediaConvertResource.php"
  - "app/Filament/Resources/TemporaryUploadResource.php"
  - "app/Filament/Resources/HasMediaResource/RelationManagers/MediaRelationManager.php"
---

# XotBaseResourceTable: dichiarare $model esplicito e verificare colonne reali

## Story

Come sviluppatore che lavora su `XotBaseResourceTable` nel modulo Media,
voglio che ogni classe `*Table` dichiari `protected static string $model`
in modo esplicito e verificato contro la Resource sorella (o l'unica fonte
disponibile), cosi' che il model non vada mai indovinato dal nome del file
e le colonne esposte in tabella corrispondano a colonne reali dello schema.

## Contesto / Baseline

Batch di audit su 5 file `*Table extends XotBaseResourceTable` del modulo
Media. Al momento di iniziare, 4 dei 5 file risultavano gia' modificati nel
working tree (verificato con `git diff`, non committato) con
`protected static string $model` gia' aggiunto da una sessione precedente:
`MediaConvertsTable.php`, `MediaTable.php`, `MediasTable.php`,
`TemporaryUploadsTable.php`. Solo `HasMediasTable.php` era ancora privo del
model. Ho verificato che i 4 model gia' assegnati sono corretti contro la
Resource sorella (vedi tabella sotto) e completato il quinto.

Verifica colonne reale via tinker (sola lettura, nessuna scrittura DB):

```
php artisan tinker --execute="echo (new \Modules\Media\Models\Media)->getTable(); echo implode(',', Schema::getColumnListing(...));"
```

## Acceptance Criteria

1. Ogni file della lista ha `protected static string $model = X::class;`
   con `X` verificato contro la Resource sorella (o, quando non esiste una
   Resource, contro l'unica fonte disponibile con evidenza scritta).
2. Ogni chiave diretta (senza punto) di `getTableColumns()` esiste nello
   schema reale della tabella del model dichiarato; le chiavi con punto
   (relazioni) sono saltate.
3. Nessuna colonna esistente rimossa; migliorie UX solo additive e a basso
   rischio.
4. `php -l` pulito su tutti i file toccati; `vendor/bin/phpstan analyse`
   sui file toccati a 0 errori.

## File toccati / Model aggiunto

| File | Model aggiunto | Fonte autorevole |
|---|---|---|
| `HasMediaResource/Tables/HasMediasTable.php` | `Modules\Media\Models\Media` | Nessuna `HasMediaResource` esiste (solo cartella con `Schemas/`, `Tables/`, `Actions/`). `MediaRelationManager` (stessa cartella, relationship `media`) dichiara esplicitamente `protected static string $resource = MediaResource::class;` con un commento che spiega perche' (namespace fuorviante). La relazione `media` restituisce sempre record `Media`, quindi ho usato lo stesso model di `MediaResource` per coerenza, documentando nel file perche' non c'e' una Resource propria. |
| `MediaConvertResource/Tables/MediaConvertsTable.php` | `Modules\Media\Models\MediaConvert` | Gia' presente (sessione precedente). Verificato contro `MediaConvertResource::$model = MediaConvert::class` — corretto. |
| `MediaResource/Tables/MediasTable.php` | `Modules\Media\Models\Media` | Gia' presente (sessione precedente). Verificato contro `MediaResource::$model = Media::class` — corretto. |
| `MediaResource/Tables/MediaTable.php` | `Modules\Media\Models\Media` | Gia' presente (sessione precedente). Verificato contro `MediaResource::$model = Media::class` — corretto. |
| `TemporaryUploadResource/Tables/TemporaryUploadsTable.php` | `Modules\Media\Models\TemporaryUpload` | Gia' presente (sessione precedente). Verificato contro `TemporaryUploadResource::$model = TemporaryUpload::class` — corretto. |

## Verifica colonne (Task 2)

Colonne reali (via `Schema::getColumnListing`, sola lettura):

- `media`: `id,model_type,model_id,uuid,collection_name,name,file_name,mime_type,disk,conversions_disk,size,manipulations,custom_properties,generated_conversions,responsive_images,order_column,created_at,updated_at,created_by,updated_by,user_id,deleted_at,deleted_by`
- `media_converts`: `id,media_id,format,codec_video,codec_audio,preset,bitrate,width,height,threads,speed,percentage,remaining,rate,execution_time,created_at,updated_at,updated_by,created_by,deleted_at,deleted_by`
- `temporary_uploads`: `id,session_id,created_at,created_by,updated_at,updated_by,user_id,file_name,file_size,mime_type,status`

Esito per file:

- `HasMediasTable.php`: chiavi `id`, `name`, `created_at` — tutte presenti in `media`. OK.
- `MediaTable.php`: chiavi `id, name, file_name, mime_type, collection_name, disk, size, order_column, model_type, model_id, created_at, updated_at` — tutte presenti in `media`. OK.
- `MediasTable.php`: chiavi `id, model_type, model_id, collection_name, name, file_name, mime_type, disk, size, created_at` — tutte presenti in `media`. OK.
- `MediaConvertsTable.php`: chiavi dirette tutte presenti in `media_converts`. `media.file_name` e' una relazione (punto), saltata come da istruzioni.
- `TemporaryUploadsTable.php`: chiavi `file_name, mime_type, file_size, status, created_at` — tutte presenti in `temporary_uploads`. OK.

Nessuna colonna sospetta/rimossa trovata. Nessun `git log -S` necessario:
tutte le chiavi dirette hanno riscontro diretto nello schema.

## Dead code segnalato (non toccato, solo evidenza — Task/regola 7)

- **`MediaResource/Tables/MediasTable.php` e' probabile dead code.**
  `XotBaseResource::getTableClass()` deriva la Table da
  `Str::plural(class_basename(getModel()))`. Verificato:
  `Str::plural('Media')` restituisce `'Media'` (invariato, non `'Medias'`),
  quindi per `MediaResource` (model `Media`) la classe risolta e'
  `MediaResource\Tables\MediaTable` (esiste, usata) e MAI
  `MediaResource\Tables\MediasTable`. `grep -rn "MediasTable\b" app`
  restituisce solo la propria dichiarazione di classe — nessun'altra
  Resource/pagina la referenzia con `getTableClass()` o esplicitamente.
  Ho comunque applicato Task 1/2/3 come richiesto, senza cancellare il
  file.
- **`HasMediaResource/Tables/HasMediasTable.php` e' dead code.** La classe
  `HasMediaResource` non esiste affatto (solo le sottocartelle
  `Schemas/Tables/Actions`); nessuna Resource puo' quindi mai risolverla
  via `getTableClass()`. `grep -rn "HasMediasTable" app` non trova alcun
  riferimento fuori dal file stesso. Segnalato, non cancellato.

## Migliorie UX (Task 3, additive, basso rischio)

- `MediasTable.php`: aggiunto `->sortable()` alla colonna `size` (colonna
  numerica reale, gia' sortable nel file gemello `MediaTable.php`; nessuna
  colonna rimossa, solo capacita' di ordinamento aggiunta).
- `MediaConvertsTable.php`: aggiunto `->sortable()` a `format`,
  `codec_video`, `codec_audio`, `preset`, `bitrate`, `width`, `height`,
  `threads`, `speed`, `remaining`, `rate`, `execution_time` — tutte colonne
  scalari dirette della tabella `media_converts`, gia' seguivano il
  pattern di `percentage` (unica gia' sortable prima di questo giro).
  Nessuna label/formattazione cambiata, nessuna colonna rimossa.
- `MediaTable.php`, `TemporaryUploadsTable.php`, `HasMediasTable.php`: gia'
  ben coperte (searchable/sortable/dateTime/badge dove pertinente), nessuna
  modifica UX necessaria.

## Testing

```
php -l <ognuno dei 5 file>                              # tutti: No syntax errors detected
cd laravel && vendor/bin/phpstan analyse <5 file> --no-progress   # [OK] No errors
```

Nessun comando di scrittura database eseguito (solo `Schema::getColumnListing`
in tinker, sola lettura).

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5

### Completion Notes List

- 2026-09-11: audit completato sui 5 file; 4 avevano gia' `$model` da una
  sessione precedente (verificato corretto); aggiunto il quinto
  (`HasMediasTable.php`) con motivazione documentata inline; migliorie UX
  additive su 2 file; 2 file segnalati come probabile dead code senza
  cancellarli.

### File List

- `app/Filament/Resources/HasMediaResource/Tables/HasMediasTable.php` (modificato: $model aggiunto)
- `app/Filament/Resources/MediaConvertResource/Tables/MediaConvertsTable.php` (modificato: sortable() su colonne scalari)
- `app/Filament/Resources/MediaResource/Tables/MediasTable.php` (modificato: sortable() su size)
- `app/Filament/Resources/MediaResource/Tables/MediaTable.php` (nessuna modifica in questo giro, gia' a posto)
- `app/Filament/Resources/TemporaryUploadResource/Tables/TemporaryUploadsTable.php` (nessuna modifica in questo giro, gia' a posto)

## Follow-up (2026-09-11) — cancellazione del dead code segnalato

Riferimento: `docs/stories/xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md`
(root del monorepo, sincronizzato dall'orchestratore — non modificato da qui),
righe Media. Le due classi segnalate sopra come "dead code, non toccato" sono
state riverificate in modo indipendente e cancellate:

### 1. `HasMediaResource/Tables/HasMediasTable.php` — CANCELLATO

Verifiche eseguite (oltre a quelle gia' in questa story):

- `grep -rn "HasMediaResource" laravel` (tutto il monorepo): nessuna classe
  `class HasMediaResource extends ...` esiste da nessuna parte. La cartella
  `HasMediaResource/` contiene solo sottocartelle (`Actions/`, `Pages/`
  vuota, `RelationManagers/`, `Schemas/`, e la `Tables/` ora rimossa) — mai
  una Resource. Nessuna Resource puo' quindi mai chiamare
  `HasMediaResource::getTableClass()`.
- `grep -rn "HasMediasTable\b" laravel`: prima della cancellazione, l'unico
  riferimento fuori dalla propria dichiarazione era
  `tests/Unit/MediaFilamentAndActionsTest.php` (istanziazione diretta in un
  test, non una risoluzione a runtime via convenzione).
- `git log --follow -- app/Filament/Resources/HasMediaResource/Tables/HasMediasTable.php`:
  4 commit, tutti del 2026-09-10/11 (creazione + audit `$model` di questa
  stessa story). Nessun segnale di refactor a meta' in corso.
- La cartella `HasMediaResource/Tables/` e' stata rimossa (era vuota dopo la
  cancellazione del file). La cartella `HasMediaResource/` **non** e' stata
  rimossa: contiene `Actions/AddAttachmentAction.php`,
  `RelationManagers/MediaRelationManager.php`,
  `Schemas/HasMediaForm.php` e `Schemas/HasMediaInfolist.php`, tutti vivi
  (usati o referenziati da test reali) — non nel perimetro di questo task.

Azione: cancellato `HasMediasTable.php`; aggiornato
`tests/Unit/MediaFilamentAndActionsTest.php` rimuovendo l'istanziazione
diretta e l'import (il test residuo copre solo `TemporaryUploadsTable`,
rinominato di conseguenza).

### 2. `MediaResource/Tables/MediasTable.php` — CANCELLATO

Verifiche eseguite:

- `Str::plural('Media')` confermato via tinker: restituisce `'Media'`
  (invariato). `XotBaseResource::getTableClass()` calcola
  `$name = Str::plural(class_basename(getModel()))` e cerca
  `{Resource}\Tables\{$name}Table`, quindi per `MediaResource` (model
  `Media`) risolve sempre a `MediaResource\Tables\MediaTable` (esiste, la
  classe con `$name = 'Media'` + `'Table'`), mai a `MediasTable`.
- `MediaResource.php` verificato: non fa `override` di `table()`, quindi
  usa il default di `XotBaseResource` — nessuna scorciatoia che potrebbe
  far risolvere `MediasTable` per altra via.
- `grep -rn "MediasTable\b" laravel`: solo la propria dichiarazione di
  classe + l'istanziazione diretta nel test (rimossa in questo giro).
- Confronto riga per riga con `MediaTable.php` (la classe viva): `MediaTable`
  espone **piu'** colonne (`order_column`, `updated_at`, assenti in
  `MediasTable`), rende sortable `model_type`/`model_id` (in `MediasTable`
  restano solo searchable), e ha in piu' `getTableBulkActions()` (bulk
  delete) che `MediasTable` non ha affatto. L'azione `download` in
  `MediaTable` e' gia' tipizzata `Media $record` con ritorno
  `BinaryFileResponse`, piu' pulita della versione difensiva
  `mixed $record` + `RuntimeException` di `MediasTable`. L'unica differenza
  a favore di `MediasTable` e' cosmetica: formatta `size` in KB
  (`number_format($state / 1024, 2).' KB'`) invece che in byte grezzi con
  suffisso `' B'`. Non e' logica di business mancante, solo una preferenza
  di formattazione — **non migrata** per restare nel perimetro del task
  (cancellazione dead code) senza toccare la formattazione della classe
  viva senza un mandato esplicito. Annotato qui come possibile follow-up UX
  separato, se qualcuno lo vuole.
- `MediaTable.php` ha gia' copertura test dedicata e superiore in
  `tests/Unit/Filament/MediaTableTest.php` (4 test su colonne, ordine,
  searchable, toggle) — la cancellazione di `MediasTable.php` non riduce la
  copertura reale della classe viva.

Azione: cancellato `MediasTable.php`; stesso aggiornamento del test di cui
sopra.

### Verifica finale

- `cd laravel && vendor/bin/phpstan analyse Modules/Media --no-progress`
- `cd laravel/Modules/Media && bash ../../../tools/phpmd.sh Media` (o script
  equivalente)
- `cd laravel && vendor/bin/pest Modules/Media`
- `docs/coverage.md` aggiornato con numeri reali della run.

Risultati riportati nel commit di questo follow-up.
