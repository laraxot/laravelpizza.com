---
title: "Topologia moduli portfolio: PTVX senza Cms"
type: story
status: done
module: Xot
updated: 2026-11-16
qmd: "module portfolio topology shared cms absent ptvx learn patterns measured taxonomy"
related:
  - ../../../../../../docs/wiki/memories/module-portfolio-taxonomy-ptvx.md
  - ../../../../../../docs/wiki/memories/filament5-layout-contract-shared-modules.md
---

# Topologia moduli: imparare senza importare

## Istruzione

«il modulo cms in questo progetto non ci sta e non ci deve stare, ma te
devi imparare lo stesso, perche' molti moduli son comuni a tutti i progetti
altri moduli son comuni a molti progetti e altri moduli a nessun altro»

## Tassonomia misurata (11 basi `*_fila5`, 2026-11-16)

1. **Universali (11/11)** — Activity, Job, Lang, Media, Notify, Tenant, UI, User, Xot.
   Touch = effetto portfolio.
2. **Comuni a molti** — Cms (10/11, assente solo PTVX), Seo, Geo, Gdpr, AI, Blog, …
   Si studiano nel progetto FO owner; non si importano dove non servono.
3. **Solo PTVX** — Incentivi, IndennitaCondizioniLavoro, IndennitaResponsabilita,
   Pdnd, Performance, Progressioni, Ptv, Sigma.

## Altri motivi (senso, trovati sul campo)

- Dominio HR/panel ≠ FO contenuti.
- Cms tira `laravel/head`, FolioVolt, tema pub → race con Filament.
- Path `cms::*` = falsi SSoT per agenti (incident rsync 2026-11-16).
- Composer/merge sporco di dipendenze FO.
- Confine ECC: mount Folio / document-shell non sono del modulo dominio.
- Stack panel già vivo senza Cms → assenza = scelta, non buco.

## Regola operativa

Imparare invarianti (Filament layout, notifications nudo, Folio owner) dai sibling;
applicare su UI/User/Xot. **Mai** portare il modulo Cms in PTVX.

## Acceptance

- [x] Nessun `Modules/Cms` in checkout PTVX.
- [x] Memoria tassonomia misurata.
- [x] Layout Filament su UI/User; Activity senza `Folio::path`.
