---
title: "Niente cartelle Legacy nel codice PHP"
type: rule
module: Xot
tags: [xot, laraxot, bak, ponytail, seeders]
created: 2026-06-30
updated: 2026-06-30
qmd: "Xot rule no Legacy folder Old Deprecated Archive bak same path"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
related:
  - ../../../../../../docs/wiki/concepts/no-legacy-folders-code.md
  - ../log.md
  - ../../../Predict/docs/wiki/concepts/seeder-canonical-orchestrator.md
---

# Niente cartelle Legacy nel codice PHP

Regola cross-modulo: vedi hub progetto [no-legacy-folders-code.md](../../../../../../docs/wiki/concepts/no-legacy-folders-code.md).

**TL;DR:** codice superato → `file.php.bak` nello **stesso** path; orchestrator unico (`*DatabaseSeeder`); niente `Legacy/` sotto `app/`, `database/`, `database/seeders/`.

Correzione anti-pattern 2026-06-30: rimossa idea `database/seeders/Legacy/` su Predict — mai reintrodurre.
