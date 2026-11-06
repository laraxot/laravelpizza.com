---
id: psr-4-naming-and-dead-code
title: Fix PSR-4 namespace, duplicate fixture and dead test enum in UI
module: UI
type: bugfix
status: done
parent: Modules/Xot/docs/bmad/stories/5.301-psr-4-autoload-compliance-fleet.story.md
tags: [ui, psr-4, namespace, fixtures, tests, dead-code]
---

# Fix PSR-4 namespace, duplicate fixture and dead test enum in UI

## Context

`composer dump-autoload` (run from `laravel/`) flagged three UI items. Parent plan: [Story 5.301, PSR-4 autoload compliance fleet](../../../Xot/docs/bmad/stories/5.301-psr-4-autoload-compliance-fleet.story.md).

## Decisions

### B. Enum namespace (`Modules\UI\App\Enums` to `Modules\UI\Enums`)

- File: `app/Enums/UiGroupColumnTypeEnum.php`.
- PSR-4 maps `Modules\UI\` to `app/`, so the namespace must be `Modules\UI\Enums`. `App\` also collides with Laravel's root namespace.
- Grep of `laravel/` for `Modules\UI\App` found no code consumer of this enum. Other hits were in docs (`Modules/Xot/CHANGELOG.md`, `Modules/Xot/docs/core/naming-conventions.md`, `Modules/UI/docs/ottimizzazioni-super-dry-kiss.md`). They are historical or illustrative and were left untouched.
- Cases and `getLabel()` are unchanged.
- Note: `Modules/UI/docs/bmad/stories/group-column-type-enum-getlabel-fix.story.md` says the real enum "remains unchanged". The namespace correction is an explicit exception requested for this PSR-4 fix. That story is not edited.

### C. Duplicate fixture (`UiPhpstanTraitProbes.php`)

- `diff` confirmed `tests/Fixtures/UiPhpstanTraitProbes.php` is identical to `tests/Fixtures/EnsuresUiDatabaseSchemaProbe.php`, the correctly named file.
- Repo grep for `UiPhpstanTraitProbes`: code had no references. Only docs referenced it: `Modules/Xot/docs/bmad/stories/5.301-psr-4-autoload-compliance-fleet.story.md`, `Modules/UI/docs/bmad/stories/cluster3-phpstan-swarm.story.md`, `Modules/UI/docs/stories/19.UI-merge-conflict-resolution.story.md`, `Modules/UI/docs/stories/phpstan-test-wave-ui.story.md`. These are historical and were left untouched.
- Decision: delete the duplicate. `EnsuresUiDatabaseSchemaProbe.php` remains.

### D. Dead `TestWorkerType` enum in `tests/Feature/GroupColumnTest.php`

- Grep of `Modules/UI` for `TestWorkerType`: the only code hit was the declaration. Other hits were in `Modules/UI/docs/wiki/index.md` (a title line).
- The test body never uses it. The fixture `Modules\UI\Tests\Fixtures\UiGroupColumnTypeEnum` already provides a BackedEnum with `HasLabel`.
- Decision: remove the declaration and its "Local test enum" comment (15 lines). The rest of the test is unchanged.

## Files changed

- `laravel/Modules/UI/app/Enums/UiGroupColumnTypeEnum.php`: namespace line.
- `laravel/Modules/UI/tests/Fixtures/UiPhpstanTraitProbes.php`: deleted (tracked file).
- `laravel/Modules/UI/tests/Feature/GroupColumnTest.php`: dead enum removed.

## Verification

```
php -l app/Enums/UiGroupColumnTypeEnum.php            -> No syntax errors detected
php -l tests/Feature/GroupColumnTest.php              -> No syntax errors detected

composer dump-autoload
(no warning mentions UiGroupColumnTypeEnum, UiPhpstanTraitProbes or GroupColumnTest;
 the remaining PSR-4 warnings are in Modules/IndennitaResponsabilita only)

./vendor/bin/pest Modules/UI/tests/Feature/GroupColumnTest.php --colors=never
Tests: 3 failed, 15 passed (26 assertions)
Failed:
- GroupColumn view rendering > it renders IconColumn boolean via toEmbeddedHtml instead of raw 1
- GroupColumn view rendering > it applies TextColumn formatState ...
- GroupColumn view rendering > it renders SelectColumn via toEmbedded...
Errors: BindingResolutionException "Target [Illuminate\Contracts\View\Factory] is not instantiable"
        and "Target class [translator] does not exist."
```

The three failures are in tests that call `view()` and `__()` without the application container. `tests/Feature/GroupColumnTest.php` does not declare `uses(\Modules\UI\Tests\TestCase::class)`, which `Modules/UI/tests/Pest.php` requires. The removed enum is not referenced by these tests, so this change does not cause them. This is a pre-existing gap that is out of scope for this story. Fixing it would be a follow-up story. No database error occurred, so the DB guard did not block the run.

## Related

- Sibling story for the Sigma module: `Modules/Sigma/docs/stories/psr-4-web-service-import-table-test.story.md`.
