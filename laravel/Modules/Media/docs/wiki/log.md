<<<<<<< HEAD
# Media Wiki Log

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`
=======
---
title: "Media Wiki Activity Log"
module: "Media"
---

# Media - Wiki Activity Log

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

>>>>>>> 40b96bcd6 (.)
