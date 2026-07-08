---
title: "Media redundancy audit 2026-05-21"
type: audit
module: Media
tags: [redundancy, duplicate-code, filament, docs]
created: 2026-05-21
related:
  - docs/wiki/troubleshooting/filament-hasmediaform-redeclare.md
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Media redundancy audit 2026-05-21

Scope: static audit from repo root over module PHP, Blade, and docs.

High-risk findings:
- Runtime file `app/Filament/Resources/HasMediaResource/Schemas/HasMediaForm.php` has canonical namespace `Modules\Media\Filament\...`, but the recent fatal reported `Modules\Media\app\Filament\...`; keep investigating stale autoload/opcache or a second checkout in the same PHP process.
- Docs still contain wrong example namespaces with `Modules\Media\app\...` in `laravel-ffmpeg-patterns-laraxot.md`.
- Duplicate documentation variants exist: `performance/media-optimizations.md`, `performance/media_optimizations.md`, and `performance/media-optimizations-1.md`.
- Historical config copies exist in multiple old/superseded locations, including `docs/archived`, `docs/superseded`, and `docs/wiki/_archive`.
- Case-only docs duplicates exist, for example `FILE_MANAGEMENT_ARCHITECTURE.md` and `file_management_architecture.md`.

Risk:
- Wrong namespace examples get copied into code and recreate fatal autoload bugs.
- Docs archive trees are no longer aligned with the no `docs/archive` policy and make QMD retrieval noisy.
- Duplicate docs with underscore/dash/case variants cause agents to read stale instructions.

Suggested cleanup order:
1. Fix or annotate every docs snippet that uses `Modules\Media\app\...`.
2. Pick one canonical performance doc and redirect the variants.
3. Move historical evidence out of forbidden archive paths only under a dedicated docs cleanup issue.
4. Re-run `php artisan optimize:clear` and Composer autoload checks after any namespace cleanup.
