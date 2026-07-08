# Project Roadmap

## Goals
- Zero PHPStan errors across all Modules.
- Full upgrade and alignment to Filament v4 patterns.
- Consistent use of Laraxot/Xot base classes (XotBase*) and contracts.
- Robust module documentation and migration notes.

## Milestones
- M1: Fix critical syntax/contract issues in User module (`BaseUser`, `Profile`).
- M2: Clean Filament pages/resources in User and Notify (v4 forms/actions, remove deprecated patterns).
- M3: Achieve PHPStan 0 errors across Modules; add missing types and return annotations.
- M4: Final docs pass with per-module ROADMAPs, changelogs, and migration notes.

## Execution Plan
- Iterate with PHPStan: run, fix, re-run until 0 errors.
- Apply Filament v4 upgrade guide changes as we go.
- Keep changes small and verifiable; add tests where helpful.
