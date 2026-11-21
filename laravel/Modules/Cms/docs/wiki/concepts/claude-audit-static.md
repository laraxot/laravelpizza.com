---
title: "claude-audit static — modulo Cms"
type: concept
module: Cms
tags: [cms, quality, claude-audit, i18n]
created: 2026-07-09
updated: 2026-07-09
qmd: "Cms claude-audit static 80 lang split ResolvePageAction FolioVolt"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/704"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/705"
related:
  - ../../../../../../bashscripts/tools/split-cms-lang-for-audit.php
  - ../../../../../../bashscripts/tools/run-claude-audit-module-static.sh
---

# claude-audit static (Cms)

## Comando

```bash
bash bashscripts/tools/run-claude-audit-module-static.sh Cms
```

## Fix applicati (80/0)

- Lang `section.php` / `txt.php` → cartelle `lang/{locale}/{name}/*.php` (+ split `fields/` se >500 LOC)
- `ResolvePageAction` — estratti `findViaEloquentQueries` / `findViaRawTable` (nesting)
- `FolioVoltServiceProvider` — `resolveBaseMiddleware()`
- `livewire/menu/builder.blade.php` → partials

## Report

`Modules/Cms/.claude-audit/audit-report.html`
