# 📚 Docs Update Changelog – 2025-10-01

## Summary
- Updated module and theme documentation to align with current 2025 roadmap and stack.

## Changes
- CMS module roadmap: `laravel/Modules/Cms/docs/development/roadmap.md`
  - Added metadata header (Versione, Status, Priorità, Allineamento).
  - Updated Timeline from 2024 → 2025 across Q1–Q4.
  - Added footer with Last Updated, Next Review, Status.
  - Fixed markdownlint issues for list style and trailing blanks.

- TwentyOne theme README: `laravel/Themes/TwentyOne/docs/README.md`
  - Updated requirements to PHP 8.3, Laravel 11.x (12-ready), Node 18, NPM 9.
  - Added note about Filament 4.x compatibility (where applicable).
  - Wrapped long lines to satisfy markdownlint MD013.
  - Added references to internal docs and roadmaps.

## Recommended Next Actions
- Normalize module-specific roadmaps using the templates under `project_docs/roadmaps/`.
- Run `scripts/update-roadmaps.sh` to create/sync `ROADMAP_2025.md` across modules/themes and refresh dates.
- Review root-level claims vs module docs (PHPStan levels, Filament v4) and align where needed.

## Metadata
- Executed on: 2025-10-01
- Scope: Documentation only (no code changes)
