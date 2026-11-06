---
title: Livewire → Widgets W1: Job Status/Schedule/Crud
type: story
module: Job
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, livewire, filament-widgets, job, w1]
qmd: "livewire filament widgets job status schedule crud broad w1 reuse migrate"
related:
  - ./tomorrow-handoff.story.md
  - ./livewire-widgets-w1-user-auth.story.md
  - ../bmad/stories/livewire-to-filament-widgets-fleet.story.md
  - ../bmad/livewire-widget-parallelization-plan.md
  - ../bmad/livewire-to-filament-widgets-filament-blueprint.md
  - ../bmad/livewire-to-filament-widgets-inventory.md
  - ../../Job/docs/stories/12.1.retire-job-http-livewire.story.md
---

<!--
GateGuard facts:
1. Supersedes nothing: executable slice of fleet W1 Job lane (fleet remains hub).
2. Linked from tomorrow-handoff.story.md and livewire-to-filament-widgets-fleet.story.md.
3. New file in existing Modules/Xot/docs/stories/; owns Modules/Job Livewire paths.
4. User verbatim: "fa tutte le bmad stories per continuare domani"
-->

# Livewire W1: Job

## Perche'

W0 (UI/Lang/User legal) e' DONE. Prossima wave: Job Http/Livewire → REUSE/MIGRATE
verso widget `XotBaseWidget` esistenti.

## Owned scope

- `Modules/Job/app/Http/Livewire/**`
- `Modules/Job/app/Filament/Widgets/**` (solo gemelli esistenti o nuovi motivati)
- Test Job Livewire/Widget correlati
- `Modules/Job/docs/stories/` esito

**Non toccare:** User Auth Livewire, Xot RegisterLivewire, Cms Page.

## Tasks

1. Inventory + fleet: classificare Status/Schedule/Crud/Broad.
2. Caller `rg`; retarget widget; ritiro HTTP a zero caller.
3. Capability `.env`/Artisan: non inventare widget; KEEP/allowlist se serve.
4. Pest + PHPStan Job.
5. Aggiornare fleet AC + handoff.

## Acceptance

- [ ] Ogni Livewire Job W1 ha esito REUSE/MIGRATE/KEEP documentato
- [ ] Nessun ritiro con caller vivi
- [ ] Widget nuovi estendono `XotBase*Widget`
- [ ] PHPStan Modules 0 (remeasure coords)

## Testing strategy

Pest Job esistenti; smoke panel Job se montato.
