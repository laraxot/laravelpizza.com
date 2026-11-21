---
title: "geo mixed type reduction.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "geo mixed type reduction.story"
issues: []
discussions: []
scope: module:Geo
---

# Story: Reduce mixed type usage in Geo module

## Status
Done (best-effort, partial — "dove possibile", not full coverage)

## Type
Refactor (typing only, no behavior change)

## Summary
- Module carried roughly 363 `mixed` occurrences (native type-hints and docblocks) across 94 files.
  Reduced 6 occurrences across 5 files where the concrete/union type was genuinely evident from the
  surrounding code, per project convention "cerchiamo di non usare mixed, quando lo troviamo cerchiamo
  di sostituirlo con qualcosa di adeguato".
- Files changed: `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php`, `app/Datas/GeoData.php`,
  `app/Filament/Resources/LocationResource.php`, `app/Filament/Resources/Pages/ListLocations.php`,
  `app/Models/Traits/GeoTrait.php`. Full rationale per change and per skip in
  `docs/coverage.md` (2026-09-04 section).
- PHPStan: baseline 1 error (pre-existing, from a concurrent session's uncommitted WIP in
  `app/Models/Address.php`, not caused by this story), 0 errors on the 5 files this story touched.
- Discovered and documented (not fixed, out of scope) a concurrent session actively editing the same
  module's `mixed` types in parallel during this story, introducing a real regression
  (`app/Filament/Forms/Components/XotBaseCoordinateField.php` narrowing without updating call sites,
  60 new `argument.type` errors) in files this story never touched. See `docs/coverage.md` collision
  note for full detail — needed for whoever picks up the remaining `mixed` cleanup in this module next.

## Acceptance criteria
- [x] No native-type-hint or docblock `mixed` was replaced without verifying the real shape from
      surrounding usage (accessor logic, DTO consumers, Filament/Laravel base contracts).
- [x] Left-as-mixed cases are documented with a concrete reason, not silently skipped.
- [x] `./vendor/bin/phpstan analyse Modules/Geo` does not show a higher error count attributable to
      this story's diff (isolated by scoping the analysis to the touched files: 0 errors).
- [x] `./tools/phpmd.sh Modules/Geo text ../docs/phpmd.ruleset.xml` runs to completion; no new finding
      introduced in the touched files.
- [x] `docs/coverage.md` updated with a dated section (before/after, honest pest/phpmd result).
- [x] Only this story's own changes committed; pre-existing/concurrent uncommitted WIP from another
      session left untouched.

## Notes for follow-up
- `Modules/Geo` still has ~88 files with at least one `mixed` occurrence left. Most of the remaining
  ones are legitimately polymorphic (third-party JSON API payloads, Filament schema/closure contracts,
  Eloquent Model::getKey() boundary) — see the "Left as mixed" list in `docs/coverage.md` before
  re-attempting a blanket sweep.
- `app/Filament/Resources/Pages/ListLocations.php::getTableComumns()` has a pre-existing name typo
  (should be `getTableColumns()` to actually override the base hook) — separate bug, not touched here.
- Before resuming further `mixed` cleanup in this module, check `git status --short` first: another
  session may still be mid-edit on `app/Models/Address.php`,
  `app/Filament/Forms/Components/XotBaseCoordinateField.php`,
  `app/Filament/Forms/Components/Support/CoordinatePickerHelpers.php`,
  `app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`.
