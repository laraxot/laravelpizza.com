---
title: "CONTRIBUTING"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CONTRIBUTING"
issues: []
discussions: []
---

# Contributing to Xot

Xot is the foundation of Laraxot. Changes here propagate to 47 other modules. Contribution workflow and quality gates.

## Before You Code

1. **Read PHILOSOPHY.md** — understand the non-negotiables.
2. **Read ARCHITECTURE.md** — know the layers and discovery mechanisms.
3. **Check `docs/`** — is there existing documentation? Update it first.
4. **Check `git log`** — have similar changes been done before?

## Development Setup

```bash
cd laravel

# Dev stack: Xot tests, static analysis, asset building
composer dev

# Just Xot
./vendor/bin/pest Modules/Xot/tests

# Static analysis (PHPStan L10, strict)
./vendor/bin/phpstan analyse Modules/Xot --memory-limit=-1

# Code style (Laravel Pint)
./vendor/bin/pint --dirty Modules/Xot

# Insights (PHPInsights)
./tools/phpinsights.sh Modules/Xot
```

## Change Workflow

### 1. Create a Branch

```bash
git checkout -b feature/xot-my-change

# If feature spans multiple modules
git checkout -b feature/laraxot-my-feature
```

### 2. Write Tests First (TDD)

- Unit tests in `Modules/Xot/tests/Unit/` for actions and models.
- Feature tests in `Modules/Xot/tests/Feature/` for Filament workflows.
- Use `XotBaseTestCase` for shared test utilities.

```bash
./vendor/bin/pest Modules/Xot/tests --filter="MyTest"
```

### 3. Implement

Follow the conventions in PHILOSOPHY.md:
- Use Actions for business logic
- Extend base classes
- Never use Services
- Declare strict types

### 4. Verify Quality

```bash
# Tests
./vendor/bin/pest Modules/Xot/tests

# Static analysis (must pass L10, no suppresses)
./vendor/bin/phpstan analyse Modules/Xot --memory-limit=-1

# Code style
./vendor/bin/pint --dirty Modules/Xot

# All modules (regression check)
./vendor/bin/phpstan analyse Modules --memory-limit=-1
./vendor/bin/pest

# Coverage report
coverage.md in Modules/Xot/docs/ (auto-generated)
```

### 5. Commit

```bash
# Within Xot module git (Xot has its own .git)
cd laravel/Modules/Xot
git add -A
git commit -m "feat: add new action for X"
git push origin feature/xot-my-change
git push github feature/xot-my-change  # if multi-remote
```

### 6. Push Root Repository

After Xot is committed, update root:
```bash
cd ../..  # back to root
git add laravel/Modules/Xot/
git commit -m "feat(xot): add new action for X"
git push origin feature/xot-my-change
```

## Key Quality Gates

### PHPStan Level 10

No exceptions. Run before push:
```bash
./vendor/bin/phpstan analyse Modules/Xot --memory-limit=-1
```

Errors must be fixed in code, never suppressed with `@suppress` or `ignoreErrors` in `phpstan.neon`.

### Test Coverage ≥90%

Coverage report auto-generates in `Modules/Xot/docs/coverage.md`. Target >90% for:
- All actions in `app/Actions/`
- All models in `app/Models/`
- All base classes

```bash
./vendor/bin/pest Modules/Xot/tests --coverage --min=90
```

### Filament Compatibility

If changing `XotBaseResource`, `XotBasePage`, `XotBasePanelProvider`, run regression tests:
```bash
./vendor/bin/pest --filter="Filament" Modules/
```

Ensure all 47 modules still work.

### Documentation

Every new feature requires:
- PHPDoc on the class/method
- Entry in `docs/` with examples
- Update to README.md if user-facing

## Patterns and Examples

### Adding a New Action

```php
// Modules/Xot/app/Actions/MyNewAction.php
declare(strict_types=1);

namespace Modules\Xot\Actions;

use Spatie\QueueableAction\QueueableAction;

final class MyNewAction
{
    use QueueableAction;

    public function execute(string $input): string
    {
        // implementation
        return $output;
    }
}
```

Test:
```php
// Modules/Xot/tests/Unit/Actions/MyNewActionTest.php
test('my new action does something', function () {
    $action = app(MyNewAction::class);
    expect($action->execute('input'))->toBe('expected');
});
```

### Adding a Base Class

Rare. Requires:
1. RFC in `docs/`
2. Consensus with other module maintainers
3. Full test coverage
4. Regression tests on all 47 modules

### Updating a Base Class

1. Change the base class in `app/Filament/Resources/`, `app/Models/`, etc.
2. Run full test suite: `./vendor/bin/pest`
3. Run PHPStan on all modules: `./vendor/bin/phpstan analyse Modules`
4. Document the change in CHANGELOG.md
5. Commit to Xot, then root

## Release & Changelog

Maintain CHANGELOG.md with:
- Version number (semantic versioning)
- Date
- Features, fixes, breaking changes

Format:
```markdown
## [1.2.0] — 2026-09-05

### Added
- New `MyNewAction` for X

### Changed
- Updated `XotBaseResource::form()` to support Y

### Fixed
- Fixed N+1 query in `GetAllModelsAction`

### Breaking
- Removed deprecated `OldAction`
```

## Code Review Checklist

Before submitting PR, self-review:
- [ ] Tests written and passing
- [ ] PHPStan L10 passes
- [ ] Pint formatting applied
- [ ] Coverage ≥90%
- [ ] No `Service` classes
- [ ] No direct Filament usage (extends bases)
- [ ] Documentation updated in `docs/`
- [ ] CHANGELOG.md updated
- [ ] Both Xot and root repos committed and pushed

## Questions?

- Check `docs/` for patterns
- Review similar actions/classes in `app/Actions/`, `app/Models/`
- Ask in module discussions before large changes

---

title: "CONTRIBUTING"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CONTRIBUTING"
issues: []
discussions: []
**Remember:** Xot changes affect 47 modules. Code quality and backward compatibility are non-negotiable.
