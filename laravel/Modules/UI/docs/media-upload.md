---
title: "Upload file: FileUpload e Spatie Media Library"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui upload FileUpload SpatieMediaLibraryFileUpload SpatieDocumentUpload media library blocks ImageSpatie VideoSpatie prefixIcon buttonLabel"
---

# Upload file

## Scelta: Spatie Media Library per i file di dominio

Il modulo preferisce `SpatieMediaLibraryFileUpload` (conversioni, collection, dischi, ownership via `HasMedia`) al
`FileUpload` di Filament che salva un path in una colonna. Stato osservato nel codice (2026-11-25):

| Blocco / componente | Upload usato |
|---|---|
| `Blocks\ImageSpatie`, `Blocks\VideoSpatie`, `Blocks\ImagesGallery` | `SpatieMediaLibraryFileUpload` |
| `Blocks\Image`, `Blocks\Hero` (`background`), `Blocks\Post` | `FileUpload` standard (non ancora migrati) |
| `Filament\Components\SpatieDocumentUpload` | helper statico sopra Spatie, vedi sotto |

I modelli base di User (`BaseUser`, `BaseProfile`, `BaseTenant`) usano gia' `InteractsWithMedia`: migrare un campo non richiede di toccare il modello, solo di dichiarare la collection.

## SpatieDocumentUpload

`SpatieDocumentUpload::make($name, $collection)` centralizza la configurazione dei documenti: disco `private`
(documenti sempre privati), `preserveFilenames()`, `openable()/downloadable()/previewable()`, `maxSize(10240)` KB,
tipi `jpeg/png/heic/webp/pdf`, `imagePreviewHeight('150')`. Le factory `forIdentityDocument()` (5 MB, conversioni
`thumbnail` e `preview`), `forIseeDocument()`, `forPregnancyDocument()`, `forCertifications()` e `custom()` sono
specializzazioni per collection nominate: i nomi delle collection sono dati di dominio sanitario e vanno ripensati se
l'helper viene riusato altrove (il modulo dovrebbe restare neutro).

## Regole per chi migra un campo

1. dichiarare la collection sul modello (`registerMediaCollections()`), disco privato per dati personali;
2. sostituire `FileUpload::make('x')` con `SpatieMediaLibraryFileUpload::make('x')->collection('...')`;
3. mantenere un accessor di compatibilita' se vecchie view leggono il path;
4. migrare i dati esistenti con una migration idempotente che aggiunge media senza rimuovere colonne (dati sacri);
5. rollback: la colonna originale resta fino alla verifica in produzione.

## Metodi che NON esistono su FileUpload (Filament 5)

Verificato su `vendor/filament/forms` (Filament `^5.0`): `FileUpload`/`BaseFileUpload` non espongono `buttonLabel()`,
`icon()` ne' `prefixIcon()` (quest'ultimo vive in `HasAffixes`, usato da `TextInput`, `Select`, `DateTimePicker`, `TagsInput`, `ColorPicker`). Usarli da'
errore fatale a runtime. Disponibili tra gli altri: `disk()`, `directory()`, `acceptedFileTypes()`, `maxSize()`,
`downloadable()`, `previewable()`, `imagePreviewHeight()`, `panelLayout()`, `uploadButtonPosition()`. Per testi e
icone del pulsante si usano le traduzioni o una view custom. Le vecchie pagine del modulo sul tema erano
contraddittorie (alcune elencavano `icon()`/`buttonLabel()` come validi): fa fede il vendor, non la documentazione.

Non usare `->label()` esplicito sui campi: le etichette arrivano dal `LangServiceProvider` (vedi
[translations.md](translations.md)).
