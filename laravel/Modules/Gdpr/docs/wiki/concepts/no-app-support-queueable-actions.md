---
title: "no app/Support — Gdpr (mai presente)"
type: concept
tags: [gdpr, actions, queueable-action, support]
created: 2026-07-12
updated: 2026-07-12
qmd: "Gdpr module no app Support never had Support Actions only"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md
---

# Gdpr — nessun `app/Support/`

Il modulo Gdpr **non ha mai** avuto cartella `app/Support/`. Business logic GDPR (consensi, export, purge) vive già in `app/Actions/`.

Regola standing: non introdurre `Support/` — seguire [no-app-support-monorepo-migration](../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md).
