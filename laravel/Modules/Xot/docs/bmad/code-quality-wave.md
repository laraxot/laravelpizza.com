---
title: "Code Quality Wave: BMAD + Second Brain + Filament Blueprint"
status: active
module: Xot
scope: cross-module (Modules/)
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, code-quality, second-brain, blueprint, swarm]
qmd: "code quality wave bmad second brain blueprint filament xotbase pint phpstan"
related:
  - ./filament-blueprint.md
  - ./services-to-queueable-actions-filament-blueprint.md
  - ./brainstorming-services-to-actions-wave.md
  - ../conventions/docs-organization.md
  - ../conventions/code-quality-checklist.md
type: note
---

<!--
GateGuard facts:
1. Supersedes doc-only wave status: now records authorized PHP Filament XotBase migrations + gates.
2. Linked from filament-blueprint, code-quality-checklist, Hindsight initiative Qualità codice.
3. Edit existing code-quality-wave.md: not a new file.
4. User verbatim: "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint"
-->

# Obiettivo

Alzare la qualità con tre leve: **BMAD** (wave/checklist), **Second brain**
(Hindsight), **Filament blueprint** (`XotBase*`, Actions, no label hardcoded).

# Regole (non negoziabili)

1. Solo `laravel/phpstan.neon` (umano); mai altri `.neon` / ignore.
2. Docs incrementali ([docs-organization](../conventions/docs-organization.md)).
3. Zero `Modules/*/app/Services` ([services wave](./brainstorming-services-to-actions-wave.md)).
4. Estendere Filament solo via `XotBase*` ([filament-blueprint](./filament-blueprint.md)).

# Stato vivo (2026-10-20)

| Gate | Esito |
|------|--------|
| PHPStan Modules (`--memory-limit=2G`) | OK |
| `app/Services` dirs/PHP | 0/0 |
| Filament direct extends (produzione) | 0; residuo mock TestRelationManager |
| `FILAMENT_DIRECT_EXTENDS_BASELINE` | **1** |
| Pint `--dirty` lotto | passed |
| Haversine DRY | `BuildHaversineSqlAction` → `GenerateHaversineSqlAction` |

## Wave Filament XotBase (lotto)

Notify `HtmlLayoutPathSelect`/`MailTemplateSelect` → `XotBaseSelect`;
`ContactColumn` → `XotBaseViewColumn`; UI `OpeningHours`/`SortableId`/`Timestamp`
→ `XotBaseTextColumn`; Geo Address* → `XotBaseField`; ratchet map + Select/Field/TextInput.

# Checklist

[code-quality-checklist.md](../conventions/code-quality-checklist.md)

# Next (story ready-for-dev)

Hub: [tomorrow-handoff.story.md](../stories/tomorrow-handoff.story.md)

- [code-quality-pint-xot-cms-user](../stories/code-quality-pint-xot-cms-user.story.md)
- [code-quality-strict-types-cms-media](../stories/code-quality-strict-types-cms-media.story.md)
- [code-quality-filament-label-audit](../stories/code-quality-filament-label-audit.story.md)
- Livewire W1: [job](../stories/livewire-widgets-w1-job.story.md) · [user-auth](../stories/livewire-widgets-w1-user-auth.story.md)
- Fleet: [livewire-to-filament-widgets-fleet](./stories/livewire-to-filament-widgets-fleet.story.md)