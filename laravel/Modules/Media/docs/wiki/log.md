---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "log"
issues: []
discussions: []
title: "Media Wiki Activity Log"
module: "Media"
---

# Media - Wiki Activity Log

## [2026-11-16] phpstan | intervention image v4

- Gate Media: 27 errori (soprattutto `class.notFound` su `Intervention\Image\*`) → 0.
- Causa: mismatch layout vendor v2 vs autoload v4.4.1; azioni Image allineate ad API v4.
- Story: [intervention-image-phpstan.md](../stories/intervention-image-phpstan.md).

## [2026-05-27] lint | phpstan zero

- `./vendor/bin/phpstan analyse Modules/Media` → 0 errori (135 file).
- Commento provtv/module_media_fila5#3; inventario mono corretto (ex 33 errori stale).

## [2026-05-21] governance | owner html2pdf canonico

- Documentazione Html2Pdf completa solo in `docs/html2pdf/` (+ `README.md`).
- Altri moduli: stub DRY verso Media. Campagna: `bashscripts/tools/dedup_module_docs.py`.
- How-to: [module-docs-deduplication](../../../../../docs/wiki/how-to/module-docs-deduplication.md).

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created index.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

## [2026-09-25] phpstan | Pest helper invocations

- I test Media invocano i metodi di `Tests\TestCase` come helper globali; usare `$this->` per gli helper d'istanza e `TestCase::` per quelli statici.
- Le firme PHPDoc dei builder payload preservano `array<string, mixed>` e l'inferenza dei dati passati a Eloquent `create()`.
- Verifica eseguita: `php -l` sui due file di test aggiornati. Analisi PHPStan e test non eseguiti in questa correzione.
