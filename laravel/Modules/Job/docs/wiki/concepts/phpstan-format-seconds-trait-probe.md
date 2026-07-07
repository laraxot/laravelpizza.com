---
title: PHPStan trait probe FormatSeconds
type: concept
module: Job
tags: [phpstan, trait, probe, filament, format-seconds]
created: 2026-07-01
updated: 2026-07-01
related:
  - ../../../Xot/docs/wiki/concepts/phpstan-trait-probes.md
  - ../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md
---

# PHPStan trait probe — FormatSeconds

## Problema

`FormatSeconds` è usato da widget Filament (`JobStatsOverview`, `JobsWaitingOverview`) registrati via discovery. PHPStan segnala `trait.unused` sul file trait isolato.

## Soluzione

Probe host `app/Phpstan/FormatSecondsPhpstanProbe.php` registrato in `xotPhpstanTraitProbeClasses()` (`Modules/Xot/helpers/Helper.php`).

Pattern canonico Laraxot: **probe + registry**, non ignore globale in `phpstan.neon`.

## Chiamanti runtime

- `JobResource/Widgets/JobStatsOverview`
- `JobManagerResource/Widgets/JobStatsOverview`
- `JobsWaitingResource/Widgets/JobsWaitingOverview`
