---
title: "README moduli: contratto di ingresso"
type: memory
status: active
owner: module:Xot
confidence: high
created: 2026-09-28
updated: 2026-09-28
verified_at: 2026-09-28
evidence:
  - "bashscripts/tools/normalize-module-readmes.py"
  - "laravel/Modules/Xot/docs/bmad/stories/module-readmes-normalization.story.md"
related:
  - "../../README.md"
  - "../../../../../../bashscripts/ai/wiki/concepts/second-brain-canonical-operating-model.md"
tags: [docs, xot, wiki]
qmd: "readme moduli: contratto di ingresso xot"
---

# README moduli: contratto di ingresso

Ogni modulo Laraxot con `module.json` deve avere un README root in italiano, con
frontmatter `module-readme`, responsabilità/confini, link a `docs/` e `docs/bmad/`,
inventario statico datato e comandi di verifica. L'inventario è un segnale tecnico,
non una garanzia: i gate reali restano PHPStan e Pest.
