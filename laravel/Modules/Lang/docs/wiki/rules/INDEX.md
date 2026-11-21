---
title: "Rules Index"
type: "index"
tags: [rules, lang, translations, localization]
module: "Lang"
created: 2026-05-12
updated: 2026-06-12
qmd: "Lang rules translation governance factory auto increment id pest sqlite"
issues:
  - "https://github.com/laraxot/base_ptv_fila5/issues/345"
discussions:
  - "https://github.com/laraxot/base_ptv_fila5/discussions/273"
---

# Rules — Lang Module Wiki

> Regole ricorrenti del modulo Lang. Load on-demand.

## Available Rules
- [context-overflow-prevention](../../../../../docs/wiki/rules/context-overflow-prevention.md) — prevenzione 262K token overflow; file vietati; tool output compression

- [translation-key-governance](./translation-key-governance.md) — ownership delle chiavi, struttura semantica e divieto di `->label()`/stringhe inline
- [translation-factory-auto-increment-id](./translation-factory-auto-increment-id.md) — factory Lang: non impostare `id` manuale su colonne auto-increment
- [laravel12-lang-path-rule](../concepts/laravel12-lang-path-rule.md) — il path canonico resta `lang/` e non `resources/lang/`
- [schema-conventions](../../../../../docs/wiki/rules/schema-conventions.md) — convenzioni globali per label e traduzioni gestite da `LangServiceProvider`
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md) — guardrail Filament che impattano anche il modulo Lang

## Usage

```bash
qmd search "Lang module rule translation key" --limit 5
```

---

**Upstream:** [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
