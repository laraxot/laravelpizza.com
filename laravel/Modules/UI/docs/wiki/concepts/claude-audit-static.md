---
title: "claude-audit static — modulo UI"
type: concept
module: UI
tags: [ui, quality, claude-audit, i18n, blade]
created: 2026-07-09
updated: 2026-07-12
qmd: "UI claude-audit static 80 score lang split pricing blade partials SelectStateColumn"
issues:
  - "https://github.com/laraxot/module_ui_fila5/issues/1"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/304"
related:
  - ../../../../../../bashscripts/tools/run-claude-audit-module-static.sh
  - ../../../../../../bashscripts/tools/split-module-lang-monolith-for-audit.php
  - ../../Xot/docs/wiki/concepts/claude-audit-static-all-modules.md
  - ../memories/lang-split-ui-claude-audit.md
---

# claude-audit static (UI)

## Comando

```bash
bash bashscripts/tools/run-claude-audit-module-static.sh UI
```

## Fix quality (70/8 → 80/0)

| Finding | Mitigazione |
|--------|-------------|
| `lang/it/icon_state_group.php`, `opening_hours_field.php` | Split per chiave top-level + `array_merge` loader |
| Blade pricing >500 righe | `@include` partials sotto `pricing/partials/` |
| `SelectStateColumn` nesting | `applyStateTransition()` con early return |
| `TestChartWidget` nesting | Opzioni Chart in `resources/js/test-chart-y-tick-options.js` |

## `.gitignore`

`/Tests/` + negazioni `!tests/**` e `!audit-coverage/**` — rimuovere `audit-coverage/` dalla ignore list (altrimenti 0 test in static → 79/100).

Bridge in `audit-coverage/tests/` (path con substring `/tests/`), non `tests/AuditCoverage/`.

## Verifica

```bash
bash bashscripts/tools/run-claude-audit-module-static.sh UI
cd laravel && php -d memory_limit=2048M vendor/bin/phpstan analyse Modules/UI/app/Filament/Tables/Columns/SelectStateColumn.php
```

Target static: **80/100**, **0 finding**.
