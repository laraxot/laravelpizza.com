---
qmd: "index"
issues: []
discussions: []
title: "Rules Index"
type: "index"
created: 2026-05-11
updated: 2026-05-12
tags: [rules, rating, filament, xotbase]
status: draft
---

# Rules: Rating Module Wiki

> Regole ricorrenti del modulo Rating. Load on-demand.

## Available Rules
- [context-overflow-prevention](../../../../../../docs/wiki/rules/context-overflow-prevention.md): prevenzione 262K token overflow; file vietati; tool output compression
- [prefer-contracts-over-abstract-classes](../../../../../../bashscripts/ai/wiki/rules/modules.md): tipizzare contratti, non astratte (`RatingContract` ≠ `BaseRating`)
- [no-trait-name-static-calls](./no-trait-name-static-calls.md): mai `HasRatingsTrait::static()`; usare `RatingData`
- [rating-contract-over-baserating](./rating-contract-over-baserating.md): helper puri tipizzati `RatingContract` (anche closure `reject`/`filter`/`map`); `$ratingClass` required; ecc. OK: `class-string<BaseRating>` / `@var EloquentCollection<int, BaseRating>` per scope Eloquent
- [no-rm-no-archive-use-old-suffix](./no-rm-no-archive-use-old-suffix.md): non `rm`/archive; suffisso `.old`

- [filament-resource-zen-pattern](../concepts/filament-resource-zen-pattern.md): `XotBaseResource` possiede `form()`/`table()`, niente override locali
- [xotbase-table-columns-enforcement](../concepts/xotbase-table-columns-enforcement.md): tabelle tipizzate e complete per le risorse del modulo
- [filament-resource-property](../../../../../../docs/wiki/rules/filament-resource-property.md): `$resource` nelle page resta `protected static string`
- [filament-rules-summary](../../../../../../docs/wiki/rules/filament-rules-summary.md): riepilogo root su `->label()`, XotBase e convenzioni Filament

## Usage

```bash
qmd search "Rating module rule filament xotbase" --limit 5
```

---

**Upstream:** [Root Trigger Map](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)

## Contenuto fuso da `index.md`

# Rules — Rating Module Wiki

## Available Rules
- [context-overflow-prevention](../../../../../docs/wiki/rules/context-overflow-prevention.md) — prevenzione 262K token overflow; file vietati; tool output compression

- [filament-resource-zen-pattern](../concepts/filament-resource-zen-pattern.md) — `XotBaseResource` possiede `form()`/`table()`, niente override locali
- [xotbase-table-columns-enforcement](../concepts/xotbase-table-columns-enforcement.md) — tabelle tipizzate e complete per le risorse del modulo
- [filament-resource-property](../../../../../docs/wiki/rules/filament-resource-property.md) — `$resource` nelle page resta `protected static string`
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md) — riepilogo root su `->label()`, XotBase e convenzioni Filament

**Upstream:** [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
