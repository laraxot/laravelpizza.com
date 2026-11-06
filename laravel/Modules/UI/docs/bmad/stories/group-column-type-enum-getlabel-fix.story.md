---
id: 2.0-group-column-type-enum-getlabel-fix
title: Fix UiGroupColumnTypeEnum fixture for UI tests (add getLabel() method)
module: UI
type: bugfix
priority: high
status: in_progress
created: 2026-10-15
updated: 2026-10-15
owner: kilo
tags: [ui, tests, enum, getLabel, phpstan]
qmd: "story: fix UiGroupColumnTypeEnum fixture for UI tests"
---
## Context

The UI tests for GroupColumn rely on a fixture enum `UiGroupColumnTypeEnum` located in `Modules\UI\Tests\Fixtures`. The fixture was missing a proper `getLabel()` method that returns a human-readable label instead of the raw enum value.

## Errors to Fix

- The fixture `UiGroupColumnTypeEnum` defined a case `Dip = 'Dip'` with `getLabel()` returning `$this->value` ('Dip'), but the test expected the label `'Dipendente'`.
- This mismatch caused the test to fail when verifying that the enum label is correctly rendered in the UI.

## Acceptance Criteria

- [ ] Fixture `UiGroupColumnTypeEnum` exists in `laravel/Modules/UI/tests/Fixtures/UiGroupColumnTypeEnum.php`.
- [ ] The enum has a `getLabel()` method that returns `'Dipendente'` for the `Dip` case.
- [ ] All related UI tests pass, including the test that checks the label rendering.
- [ ] PHPStan analysis on the UI module passes with 0 errors.
- [ ] Documentation is updated in `Modules/UI/docs/` (if applicable).

## Implementation Notes

- Updated the fixture enum to map the `Dip` case to the translated label `'Dipendente'`.
- The real enum in `laravel/Modules/UI/app/Enums/UiGroupColumnTypeEnum.php` already had a correct `getLabel()` method for its cases (TEXT, NUMBER, BOOLEAN, DATE) and remains unchanged.
- No changes were needed in the production enum; only the test fixture was corrected.

## Definition of Done

- [x] Fixture file `UiGroupColumnTypeEnum.php` exists in `laravel/Modules/UI/tests/Fixtures/` with correct `getLabel()` method.
- [x] The test `Modules/UI/tests/Feature/GroupColumnTest.php` passes.
- [x] PHPStan analysis on `Modules/UI` module passes with 0 errors.
- [x] Story file created in `laravel/Modules/UI/docs/bmad/stories/` with proper metadata.
- [x] All verification steps completed.

## Related Items

- Fixture file: `Modules/UI/tests/Fixtures/UiGroupColumnTypeEnum.php`
- Test file: `laravel/Modules/UI/tests/Feature/GroupColumnTest.php`
- Real enum: `laravel/Modules/UI/app/Enums/UiGroupColumnTypeEnum.php`