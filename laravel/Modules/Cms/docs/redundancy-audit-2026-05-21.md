---
title: "Cms redundancy audit 2026-05-21"
type: audit
module: Cms
tags: [redundancy, duplicate-code, docs, views]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Cms redundancy audit 2026-05-21

High-risk findings:
- Duplicate FQCN `Modules\Cms\View\Composers\ThemeComposer` in `app/View/Composers/ThemeComposer.php` and `resources/views/Composers/ThemeComposer.php`.
- Docs/source Blade files are mirrored under `app/docs/source/...` and `docs/source/...`.
- Footer and header components are duplicated between `components/...` and `components/blocks/...`.
- Docs contain case-only duplicates: `INDEX.md`/`index.md`, `PRD.md`/`prd.md`, `METODI_DUPLICATI_ANALISI.md` variants, and more.

Risk:
- A PHP class under `resources/views` is structurally suspicious and can be included by mistake.
- Mirrored docs/source paths make generated docs hard to trust.
- Footer/header duplicated blocks can drift in UI behavior.

Suggested cleanup order:
1. Move PHP classes out of view/resource trees; keep one Composer class under `app/`.
2. Decide whether `docs/source` or `app/docs/source` is canonical.
3. Consolidate component block aliases after checking Blade include names.
