---
title: "no app/Support — Job QueueableAction"
type: concept
tags: [job, actions, queueable-action, support, artisan, console]
created: 2026-07-12
updated: 2026-07-12
qmd: "Job module no Support AllowedArtisanCommands queue schedule whitelist"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md
---

# Job — `app/Support/` eliminato

| Legacy | Action |
|--------|--------|
| `AllowedArtisanCommands::assertAllowed` | `Actions/Console/AssertAllowedArtisanCommandAction` |
| `AllowedArtisanCommands::queueSubcommands` | `Actions/Console/GetQueueSubcommandsAction` |
| `AllowedArtisanCommands::jobStatusCommands` | `Actions/Console/GetJobStatusCommandsAction` |
| `AllowedArtisanCommands::scheduleStatusCommands` | `Actions/Console/GetScheduleStatusCommandsAction` |

## Perché

Livewire/Filament Job status espone bottoni che chiamano Artisan: la **whitelist** è policy di sicurezza, non helper statico. Actions permettono test unitari e audit uniforme.

Consumer: `Job/Status`, `Schedule/Status`, `Filament/Pages/JobStatus`.

## Collegamenti

- [no-app-support-monorepo-migration](../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md)
