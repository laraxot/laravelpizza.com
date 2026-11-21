---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "docs index audit.story"
issues: []
discussions: []
id: story-docs-index-audit
slug: docs-index-audit
status: done
priority: low
title: Audit indice documentazione modulo Job
created_at: 2026-09-03
updated_at: 2026-09-03
bmad_phase: dev
module: Job
---

# Docs index audit — modulo Job

Audit di `docs/` (517 file `.md`) e ricostruzione di `docs/index.md` come indice
organizzato per argomento, senza cancellare/rinominare/spostare alcun file.
Individuati ~15 cluster di duplicati storici (dump da conflitti git in
`raw/root-import/`, `root-md-files/`, `root-txt-files/`, `_integration/`,
`archived/`, `llm-wiki/`, coppie case/underscore, serie di report PHPStan
datati) raggruppati nella sezione "Storico / da consolidare" del nuovo indice,
in attesa di una story dedicata di consolidamento/dedup.
