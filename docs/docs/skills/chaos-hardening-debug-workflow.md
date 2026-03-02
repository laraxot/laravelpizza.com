# Skill: Chaos Hardening Debug Workflow

## Goal
Rapidly isolate and fix breakages introduced by chaos monkey changes in modular Laravel + Filament projects.

## Steps
1. Run PHPStan per affected module (`--debug --no-progress`) to avoid parallel worker/socket issues.
2. Classify errors into:
   - bootstrap/runtime wiring
   - missing optional dependency
   - real type/logic regression
3. Apply guard-based fixes for optional dependencies and strict type fixes for real regressions.
4. Re-run PHPStan on touched modules.
5. Run PHPInsights with explicit composer lock path:
   - `./vendor/bin/phpinsights analyse <paths> --no-interaction --composer=composer.lock`
6. Update module/theme roadmap docs with chaos-readiness notes.

## Filament 5 Comparative Insight
From sibling Filament 5 bases in `/var/www/_bases/`:
- shared pattern: strict modular rules + action-driven architecture
- recurring risk: optional provider packages referenced statically in app code
- mitigation: dependency-safe runtime guards + module-local composer governance
