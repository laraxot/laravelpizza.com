---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-14
qmd: "log"
issues: []
discussions: []
title: "Media Wiki Activity Log"
module: "Media"
status: draft
---

# Media - Wiki Activity Log

## [2026-10-14] docs | Ingressi del modulo verificati sul codice

- `README.md`, `00-INDEX.md`, `INDEX.md`, `architecture.md` riscritti nelle parti false con evidenza: `app/Services` non esiste, `Tenant` non e' usato in `app/`, HLS/DASH e watermark assenti, 4 Model (non 8), 5 migrazioni, 41 file in `app/Filament`, 124 file PHP in `app/`.
- `ARCHITECTURE.md` marcato `stale` (cita `UploadMediaAction`, `ProcessMediaAction`, `DeleteMediaAction`, `MediaItem`, `CollectionResource`, tutte assenti).
- `00-index.md`, `wiki/00-index.md`, `wiki/00-INDEX.md`, `wiki/index.md`: copie per variante di maiuscole marcate `superseded` verso l'indice canonico; `index.md` (bridge) con i link a file inesistenti ridotti a testo.
- `vendor/bin/phpstan analyse Modules/Media` da `laravel/`: exit 0. Pest non eseguito.
- Story: [2026-10-14 Ingressi docs Media](../stories/docs-ingressi-media.story.md).

## [2026-05-27] lint | phpstan zero

- `./vendor/bin/phpstan analyse Modules/Media` → 0 errori (135 file).
- Commento provtv/module_media_fila5#3; inventario mono corretto (ex 33 errori stale).

## [2026-05-21] governance | owner html2pdf canonico

- Documentazione Html2Pdf completa solo in `docs/html2pdf/` (+ `README.md`).
- Altri moduli: stub DRY verso Media. Campagna: `bashscripts/tools/dedup_module_docs.py`.
- How-to: [module-docs-deduplication](../../../../../docs/wiki/how-to/module-docs-deduplication.md).

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

## [2026-09-25] phpstan | Pest helper invocations

- I test Media invocano i metodi di `Tests\TestCase` come helper globali; usare `$this->` per gli helper d'istanza e `TestCase::` per quelli statici.
- Le firme PHPDoc dei builder payload preservano `array<string, mixed>` e l'inferenza dei dati passati a Eloquent `create()`.
- Verifica eseguita: `php -l` sui due file di test aggiornati. Analisi PHPStan e test non eseguiti in questa correzione.
