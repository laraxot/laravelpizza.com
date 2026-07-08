# Modules/Themes Docs Audit (2026-03-10)

## Scope

- `laravel/Modules/*/docs`
- `laravel/Themes/*/docs`

## Goal

Reduce documentation entropy caused by duplicate filenames and mixed naming styles.

## Detection Method

Used normalization on basename:

1. lowercase
2. remove `_` and `-`
3. drop extension

Then grouped by normalized key and flagged keys with count > 1.

## High-Signal Findings

1. `schedule1` appears in multiple variants:
   - `schedule-1.md`
   - `schedule_1.md`
   - `schedule_1.txt`
2. `xotbaseclassesconvention` has both underscore and kebab variants.
3. `doctor_emails` / `doctor-emails` duplicated across active + archive.
4. `namespace-conventions` duplicated in multiple module roots and archives.
5. `custom-404-page` appears in many modules (expected cross-module reuse, but often duplicated in active trees).

## Immediate Governance Actions

1. For each duplicate key, select one canonical active filename (`kebab-case`).
2. Move non-canonical active duplicates under explicit `archive/` folders.
3. Keep one index (`README.md` or `00-index.md`) per docs directory.
4. During PR review, reject new duplicate-topic filenames unless justified.

## Related Rules

- [model-and-docs-naming-governance.md](./model-and-docs-naming-governance.md)
