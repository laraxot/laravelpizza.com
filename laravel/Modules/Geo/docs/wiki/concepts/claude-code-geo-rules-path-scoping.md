# Claude Code Geo Rules Path Scoping

## Decisione

Le regole Claude Code relative a mappe, Leaflet, marker SVG, Lit e controlli Geo devono essere path-scoped verso il modulo Geo.

`./.claude` punta a `bashscripts/ai/.claude`, ma la source of truth per il comportamento Geo resta `laravel/Modules/Geo/docs/`.

## Perche'

La documentazione ufficiale Claude Code distingue:

- Skills in `.claude/skills/`: metadata discoverable, istruzioni caricate quando la skill viene attivata, risorse aggiuntive solo quando servono.
- Rules in `.claude/rules/`: se non hanno frontmatter `paths`, vengono caricate ad ogni sessione; con `paths` entrano nel contesto solo quando Claude lavora su file compatibili.

Le regole Geo sono specialistiche e non devono pesare su task non Geo.

## Regola Operativa

Per nuove regole Claude Code che riguardano Geo:

1. documentare prima il contratto in `laravel/Modules/Geo/docs/wiki/`;
2. creare o aggiornare la rule in `.claude/rules/` solo come promemoria operativo;
3. aggiungere sempre `paths` verso `laravel/Modules/Geo/**`;
4. evitare duplicazioni lunghe nella rule: linkare il documento Geo owner.

## Pattern Consigliato

```md
---
paths:
  - "laravel/Modules/Geo/resources/js/**/*.js"
  - "laravel/Modules/Geo/resources/svg/**/*.svg"
  - "laravel/Modules/Geo/docs/**/*.md"
---

# Nome Regola

Sintesi breve.

Owner docs:
- `laravel/Modules/Geo/docs/wiki/concepts/...`
```

## Rule Geo gia' path-scoped

- `leaflet-wizard-invalidate-size.md`
- `lit-icons-filament-way.md`
- `map-interaction-transparency-rule.md`
- `map-marker-custom-asset.md`
