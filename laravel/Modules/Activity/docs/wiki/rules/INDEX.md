---
title: "Rules Index"
type: "index"
tags: [rules, filament, activity, phpstan, pest]
module: "Activity"
created: 2026-06-10
updated: 2026-06-10
qmd: "Activity rules index phpstan pest discipline"
issues:
  - "https://github.com/laraxot/base_ptv_fila5/issues/328"
discussions:
  - "https://github.com/laraxot/base_ptv_fila5/discussions/329"
---

# Rules — Activity Module Wiki

> Regole specifiche modulo Activity. Load on-demand.

## Available Rules
- [best-practices](./best-practices.md) — DRY/KISS, centralized orchestration, clean code principles
- [phpstan-pest-discipline](../concepts/phpstan-pest-discipline.md) — PHPStan dal root Laravel; `phpstan.neon` intoccabile; test Activity sempre Pest
- [context-overflow-prevention](../../../../../docs/wiki/rules/context-overflow-prevention.md) — prevenzione 262K token overflow; file vietati; tool output compression

- [xotbase-resource-zen-pattern](../concepts/xotbase-resource-zen-pattern.md) — NON override form()/table(), auto-discovery Schemas/Tables
- [code-redundancy-deep-dive-2026-05](../../../../../docs/wiki/audits/code-redundancy-deep-dive-2026-05.md) — 2026-05 deep audit of duplication across the monorepo (technical + zen/political/philosophical reflections). Activity module must contribute local findings.
- [filament-resource-property](../../../../../docs/wiki/rules/filament-resource-property.md) — `$resource` è `protected static`
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md) — no `->label()`, XotBase sempre

## Usage

```bash
qmd search "Activity rule" --limit 5
```

---

**Upstream:** [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
