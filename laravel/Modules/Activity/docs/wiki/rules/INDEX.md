---
title: "Rules Index"
<<<<<<< HEAD
type: index
created: 2026-05-11
updated: 2026-05-11
tags: [rules, index, on-demand]
related:
  - ../rules/00-TRIGGER_MAP.md
  - ../rules/on-demand-pattern.md
---

# Rules Index

Le Rules progettuali vivono qui, nel wiki del Module **Activity**, e vengono caricate **on-demand**.

> Vedi anche → [Trigger Map](../rules/00-TRIGGER_MAP.md)

## Regola

1. individua il trigger del task
2. consulta `../rules/00-TRIGGER_MAP.md`
3. se serve, esegui `qmd search "<topic>"`
4. leggi solo la Rules wiki pertinente

## Pattern di caricamento

| Pattern | Comando |
|---------|---------|
| Carica Rules specifica | `Read ../rules/<name>.md` |
| Ricerca semantica | `qmd search "<topic>"` |
| Via trigger map | Consulta `../rules/00-TRIGGER_MAP.md` |

## Note

- La sorgente di verita' per le Rules e' sempre il wiki locale
- Non embeddare Rules nei prompt di avvio
- Per Rules globali, consulta il [wiki root](../../docs/wiki/rules/INDEX.md)

## Aggiungere una Nuova RULES

1. Crea `../rules/<nome>.md` con contenuto completo
2. Aggiungi la voce in `../rules/00-TRIGGER_MAP.md`
3. Aggiorna questo indice se la Rules e' ricorrente
4. Committa: `docs: add rules <nome>`

=======
type: "index"
tags: [rules, filament, activity, phpstan, pest]
module: "Activity"
created: 2026-06-10
updated: 2026-06-10
qmd: "Activity rules index phpstan pest discipline"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/328"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/329"
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
>>>>>>> 40b96bcd6 (.)
