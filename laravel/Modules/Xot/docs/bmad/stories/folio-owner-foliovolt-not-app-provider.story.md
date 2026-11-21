---
title: "Folio owner: FolioVolt, non App FolioServiceProvider"
type: story
status: done
module: Xot
updated: 2026-11-16
qmd: "folio owner FolioVoltServiceProvider not App FolioServiceProvider bootstrap"
related:
  - ../../../../../../docs/wiki/memories/folio-owner-foliovolt-only.md
  - ../../../../../../docs/wiki/memories/filament5-layout-contract-shared-modules.md
  - ../../../Activity/docs/bmad/stories/folio-routing-centralization.story.md
---

# Folio owner: solo FolioVolt

> «scomodare laravel/app/Providers/FolioServiceProvider.php quando abbiamo
> FolioVoltServiceProvider e' sbagliato ! ci deve bastare FolioVolt»

## Decisione

| Contesto | Owner Folio::path |
|----------|-------------------|
| Progetto FO con Cms | Solo `Cms/FolioVoltServiceProvider` |
| PTVX (Cms assente) | Nessun mount App; non inventare surrogato; moduli dominio non montano |

## Perché (senso)

FolioVolt già copre tema + moduli + locale + `/api`. App Folio è stub scaffold
incompleto → doppia catch-all e race. ECC: routing FO non vive in `app/Providers`.

## Acceptance criteria

- [x] `bootstrap/providers.php` non registra `App\Providers\FolioServiceProvider`.
- [x] Stub App annotato: non registrare / non surrogato Cms.
- [x] Memoria `folio-owner-foliovolt-only.md`.
- [x] Pest anti-regressione su bootstrap.
