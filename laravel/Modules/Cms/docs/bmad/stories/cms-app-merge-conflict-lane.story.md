---
title: "Cms app merge conflict lane"
status: done
module: Cms
updated: 2026-11-24
qmd: "cms app folio volt head schema merge conflict lane"
related:
  - ../../../Xot/docs/bmad/stories/phpstan-modules-zero-swarm-standing.story.md
  - ../../adr/folio-volt-sole-owner.md
  - ../filament-layout-styles-scripts.md
---

# Story: lane-cms — conflitti `app/**` + `config/config.php`

## Perché

Marker di merge in Cms rompono bootstrap PHPStan e la pipeline Folio+Volt+head/Schema.org.

## Decisioni

- Base: `laraxot/dev` quando HEAD era vuoto/docs-only.
- `FolioVoltServiceProvider`: DEV + `RedirectUnlocalizedPath` (FR-15); **no** `empty.php`.
- Head / `BuildHeadSchemaAction` / `ResolvePageMetaAction`: pipeline Schema.org DEV (`business`, fallback `name`/`content`).
- `BuildPageSchemaAction` Event: riferimento `@id` (HEAD) — evita Event incompleto per Google.
- `config.php`: allowlist `auth`, `guest`, `throttle`.

## Esito

18 file in scope risolti e staged; `php -l` ok; marker residui in `app/` = 0.

## Gate facts (creazione)

1. **Supersedes / duplicates**: non sostituisce `docs/stories/cms-merge-conflict-resolution.story.md` (docs-sweep storica, ancora con marker fuori scope); non duplica le story Folio locale auth. È il verbale operativo di **lane-cms** sul standing Xot.
2. **Linked from**: riga `lane-cms` in `Modules/Xot/docs/bmad/stories/phpstan-modules-zero-swarm-standing.story.md`.
3. **Why new**: standing Xot ha solo la riga Coordinamento; serve un verbale Cms kebab sotto `docs/bmad/stories/` già esistente.
4. **User instruction**: «Short update to Modules/Cms/docs/bmad/stories/ or Xot standing story Coordinamento lane-cms.»
