---
title: "Xot redundancy audit 2026-05-21"
type: audit
module: Xot
tags: [redundancy, duplicate-code, autoload, casing]
created: 2026-05-21
related:
  - ../../../docs/chat/INDEX.md
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Xot redundancy audit 2026-05-21

Scope: static audit from repo root over `laravel/Modules` and `laravel/Themes`.

High-risk findings:
- Duplicate FQCN `Modules\Xot\Services\ArrayService` in `app/Services/ArrayService.php` and `Services/ArrayService.php`.
- Duplicate FQCN `Modules\Xot\Filament\Forms\Components\XotBasePlaceholder` in `app/Filament/...` and root `Filament/...`.
- Repeated view mirror: many `app/Resources/views/...` files are byte-identical to `resources/views/...`.
- Case-only locale duplicates under `lang/pt_br/` and `lang/pt_BR/`.
- Historical duplicate roots still referenced in docs: `lang/lang/`, backup examples, and old consolidation paths.

Risk:
- Duplicate FQCN can cause autoload ambiguity and fatal redeclare errors.
- `app/Resources/views` vs `resources/views` makes the view source of truth unclear.
- Case-only paths are unsafe across Linux/Windows/WSL and package sync.

Suggested cleanup order:
1. Decide canonical path for `Xot` classes: module PSR-4 maps `app/`, so runtime classes belong under `app/`.
2. Decide canonical path for views: use the path actually loaded by service providers, then delete or quarantine the mirror in a separate issue.
3. Normalize locale directory to the documented canonical region casing only.
4. Keep this audit as evidence; do not remove files without a dedicated issue, FLVP locks, and PHPStan after each batch.

Evidence commands:
- Duplicate FQCN scan with PHP `RecursiveDirectoryIterator`.
- Byte-identical file scan with `sha256sum`.
- Case-only path scan using lowercase path map.
