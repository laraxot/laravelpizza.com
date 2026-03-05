# Phase 1: Foundation - Context

**Gathered:** 2026-03-05
**Status:** Ready for planning

<domain>
## Phase Boundary

Establish test infrastructure, coverage tools, and quality gates before writing module tests. This phase configures the testing foundation (PCOV, PHPStan, test conventions) that all subsequent module testing phases depend on.

</domain>

<decisions>
## Implementation Decisions

### Coverage Driver
- PCOV selected (2-5x faster than Xdebug, minimal memory usage)
- Install via `pecl install pcov` or ensure extension enabled
- Configuration: PCOV.enabled=1 in php.ini for coverage collection

### Test Structure
- Test files for modules live in `Modules/*/tests/` directories
- Follow existing pattern: Feature/, Unit/, Traits/, Integration/ subdirectories
- Each module should have its own TestCase if needed

### Claude's Discretion
- Exact PHPStan level configuration (Level 10 target)
- Type coverage threshold configuration (100% target)
- CI pipeline integration approach

</decisions>

<specifics>
## Specific Ideas

- "Every test file must use `uses(TestCase::class, DatabaseTransactions::class)` at the top" — from coverage initiative requirements
- "Use DatabaseTransactions, never RefreshDatabase" — performance and isolation
- "No `protected function` in test files" — Pest functional approach
- "All test files must declare `declare(strict_types=1)`" — type safety

</specifics>

<code_context>
## Existing Code Insights

### Reusable Assets
- `laravel/tests/TestCase.php` - Base test case
- `laravel/tests/Pest.php` - Configures Pest with test discovery for Modules/*/tests/Feature, Units
- `Modules/Job/tests/TestCase.php` - Module-specific TestCase
- Existing test patterns in Modules/Xot/tests/Unit/ and Modules/Job/tests/Feature/

### Established Patterns
- Tests use `uses(TestCase::class, DatabaseTransactions::class)` pattern (from Job tests)
- Feature tests use `$this->get()`, `$this->post()` for HTTP testing
- Unit tests use `app(Action::class)->execute()` pattern for Actions

### Integration Points
- phpunit.xml already configured with Modules/*/tests/ discovery
- Database connection overrides in phpunit.xml for testing (DB_DATABASE=laravelpizza_data_test)
- Test bootstrap in vendor/autoload.php

</code_context>

<deferred>
## Deferred Ideas

None — discussion stayed within phase scope (infrastructure setup)

</deferred>

---

*Phase: 01-foundation*
*Context gathered: 2026-03-05*
