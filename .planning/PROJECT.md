# LaravelPizza Coverage Initiative

## What This Is

Systematic effort to achieve 100% Pest code coverage and 100% type coverage across the LaravelPizza modular codebase. This is a quality assurance and technical debt reduction initiative for an existing Laravel 12 application with ~40,000 LOC.

## Core Value

Ship tested, type-safe code with 100% coverage — every line executable and verified, eliminating untested paths as a source of bugs.

## Requirements

### Validated

(None yet — ship to validate)

### Active

- [ ] Achieve 100% code coverage on User module (8,565 LOC)
- [ ] Achieve 100% code coverage on Meetup module (1,200 LOC)
- [ ] Achieve 100% code coverage on Tenant module (600 LOC)
- [ ] Achieve 100% code coverage on Xot module (10,209 LOC)
- [ ] Achieve 100% code coverage on Notify, Geo, Job, Media, Cms, UI, Activity, Lang, Gdpr, Seo modules
- [ ] Achieve 100% type coverage across all modules
- [ ] Establish testing patterns and conventions for future development

### Out of Scope

- Adding new features — coverage only, no feature work
- Refactoring production code to improve coverage — test existing code as-is
- Performance optimization — focus is test coverage, not runtime performance

## Context

- **Current State**: 4.1% code coverage (316 tests, 1,669/40,247 LOC)
- **Existing Coverage**: Xot module at 16.3%, others at 0%
- **Test Framework**: Pest (Laravel's preferred testing framework)
- **Database**: Use DatabaseTransactions, never RefreshDatabase
- **Code Style**: declare(strict_types=1) required in all files

## Constraints

- **Testing**: Use `php artisan test --coverage --min=100` for verification
- **Test Structure**: Every test file must use `uses(TestCase::class, DatabaseTransactions::class)`
- **Type Safety**: No `mixed` type declarations allowed
- **Test Functions**: No `protected function` in test files — use global functions

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Fine-grained phases (8-12) | Each module treated as separate phase for parallel execution | — Pending |
| Parallel execution | Independent modules can be tested simultaneously | — Pending |
| Agent micro-batches | Each agent takes 1 module or 5-15 related files | — Pending |
| User module first | Largest uncovered LOC (8,565), critical auth/OAuth | — Pending |

---

*Last updated: 2026-03-05 after initialization*
