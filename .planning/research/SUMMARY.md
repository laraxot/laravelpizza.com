# Project Research Summary

**Project:** LaravelPizza Coverage Initiative
**Domain:** Laravel/PHP Testing and Code Coverage
**Researched:** 2026-03-05
**Confidence:** HIGH

## Executive Summary

This research addresses achieving 100% code and type coverage for the LaravelPizza modular Laravel application (40K LOC, current 4.1% coverage). The initiative targets Pest/PHPUnit testing with PCOV as the coverage driver, implementing modular test organization following nwidart/laravel-modules patterns.

**Recommended approach:** Install PCOV for fast coverage collection, use Pest as the testing framework with DatabaseTransactions for test isolation (NOT RefreshDatabase per PROJECT.md), and run PHPStan alongside coverage to ensure type safety. Tests should live within each module's `Modules/*/Tests/` directory following the modular architecture.

**Key risks:** Coverage metrics can create false confidence — tests may execute code without verifying behavior. Mutation testing (Infection) is essential to validate test quality. Performance collapse is likely as test suite grows — parallel testing must be configured early. The 100% coverage target itself risks becoming a refactoring barrier if tests verify implementation details rather than contracts.

## Key Findings

### Recommended Stack

**Core technologies:**

- **PCOV 2.x** — Lightweight code coverage driver, 2-5x faster than Xdebug with minimal memory (1.36GB vs 3.32GB). Install via `pecl install pcov`.
- **Pest 2.x/3.x** — Laravel's preferred testing framework with elegant syntax (`it()`, `expect()`, `describe()`). Use `--coverage` and `--type-coverage` flags.
- **pest-plugin-type-coverage** — Analyzes type declaration coverage without requiring tests. Complements line coverage.
- **PHPStan 2.x** — Static analysis with `--type-coverage` for strict type enforcement. LaravelPizza requires Level 10 with 0 errors and no `mixed` types.
- **Infection** — Mutation testing to verify test quality beyond coverage metrics. Essential for avoiding false confidence.

**Installation:**
```bash
pecl install pcov
composer require --dev pestphp/pest pestphp/pest-plugin-type-coverage
./vendor/bin/pest --coverage --min=100
./vendor/bin/pest --type-coverage
./vendor/bin/phpstan analyse --memory-limit=1G
```

### Expected Features

**Must have (table stakes):**
- Test file structure using Pest's `it()`, `describe()` syntax — no `protected function` in test files
- Expectation API (`expect()->toBe()`) replacing verbose PHPUnit assertions
- DatabaseTransactions trait for test isolation — NEVER RefreshDatabase per PROJECT.md constraints
- HTTP feature testing with `$this->get()`, `$this->post()` and full assertions
- Model factories for test data creation
- Authentication helpers (`$this->actingAs()`) for protected routes

**Should have (differentiators):**
- Data providers/datasets for testing multiple scenarios in single tests
- Parallel testing (`--parallel --processes=4`) for 60-80% faster CI
- Mockery integration for isolating units from external dependencies
- Laravel Fakes (Mail::fake(), Queue::fake()) for testing async behavior
- Custom expectations extending Pest with domain-specific assertions

**Defer (v2+):**
- Browser testing (Pest v4/Playwright) — for JavaScript-dependent features only
- Visual regression testing — only if UI changes are frequent
- Architecture testing (Arch) — enforce layer boundaries after base modules tested

### Architecture Approach

Tests follow modular organization within each module's `Tests/` directory:

- **Module tests:** `Modules/*/Tests/Feature/` and `Modules/*/Tests/Unit/` — mirrors module's app structure
- **Root tests:** `tests/TestCase.php`, `tests/Pest.php` — global infrastructure only
- **Module Pest.php:** Module-specific helpers (`createUser()`, `toBeUser()`) and expectations
- **Database:** SQLite :memory: with DatabaseTransactions (configured in phpunit.xml)
- **Test discovery:** Wildcard patterns in phpunit.xml for automatic module discovery

**Key architectural patterns:**
1. **Module-isolated testing** — Each module owns its tests, testable standalone
2. **DatabaseTransactions over RefreshDatabase** — Faster, parallel-safe, per PROJECT.md
3. **Wildcard test discovery** — New modules automatically discovered
4. **Dependency-aware test ordering** — Xot → Tenant → User → Geo → Lang → Meetup → Notify → etc.

### Critical Pitfalls

1. **Coverage is not quality** — Lines can execute without assertions verifying behavior. Use mutation testing (Infection) to validate test quality, not just coverage percentage.

2. **Gaming the metrics** — 100% coverage target encourages tests for getters/setters and assertions that always pass. Track mutation scores, not just coverage %.

3. **Database test pollution** — Missing DatabaseTransactions causes flaky tests in CI. Every test file must include the trait. Run tests in random order to catch pollution early.

4. **Performance collapse** — Test suite grows from minutes to 20+ minutes. Maintain 70% unit / 20% integration / 10% feature test ratio. Configure parallel execution from the start.

5. **Coverage target becomes refactoring barrier** — 100% coverage makes code brittle. Accept that coverage may dip during legitimate refactoring. Test contracts/interfaces, not implementation details.

6. **Ignoring type coverage** — 100% code coverage with PHPStan errors means untested type safety. Run PHPStan alongside coverage. No `mixed` types allowed per PROJECT.md.

7. **Anti-patterns in coverage-seeking tests** — Testing private methods via reflection, asserting on internal state. Test public contracts, not implementation.

8. **Missing test documentation** — Tests lack descriptions making maintenance impossible. Require descriptive test names.

## Implications for Roadmap

Based on research, suggested phase structure:

### Phase 1: Foundation Setup
**Rationale:** Establish testing infrastructure, performance baselines, and quality gates before writing tests. This prevents all the pitfalls documented in PITFALLS.md from taking root.

**Delivers:**
- PCOV installation and phpunit.xml coverage configuration
- Pest setup with DatabaseTransactions in root tests/Pest.php
- Parallel testing configuration (`--parallel`)
- Mutation testing (Infection) setup
- PHPStan Level 10 baseline with 0 errors
- Performance budget: target <5 minute test runs

**Addresses:**
- All table stakes features (test structure, expectations, database isolation)
- Pitfall prevention: performance collapse, type coverage neglect, test pollution

**Avoids:**
- Database test pollution by enforcing DatabaseTransactions from day one
- Performance collapse by configuring parallelization before tests grow
- Coverage ≠ quality pitfall by adding mutation testing immediately

### Phase 2: Core Module Testing
**Rationale:** Test foundational modules (Xot, Tenant, User) first as other modules depend on them. These have the highest LOC (Xot: 10,209, User: 8,565) and provide base classes for others.

**Delivers:**
- Full test coverage for Xot module (core framework)
- Full test coverage for Tenant module (multi-tenancy)
- Full test coverage for User module (auth, OAuth)
- Module-specific Pest.php with domain helpers
- Tests for auth flows, model relationships, CRUD operations

**Addresses:**
- HTTP feature testing, authentication helpers
- Data providers for edge cases
- Module factories for User, Tenant, Xot

**Uses:**
- PCOV for coverage collection
- Parallel test execution for faster feedback

### Phase 3: Feature Module Testing
**Rationale:** Test dependent modules that build on core (Meetup, Geo, Notify, Media, Job, etc.). Each has clear boundaries with testable business logic.

**Delivers:**
- Meetup: CRUD, event management, user associations
- Geo: Location/geographic features
- Notify: Queue fakes, notification testing
- Media: File handling, conversions
- Job: Queue job dispatch and handling

**Addresses:**
- Laravel Fakes for Mail/Queue/Events
- Mockery for external service isolation
- Cross-module integration testing in root tests/Feature

### Phase 4: Compliance & Polish
**Rationale:** Modules requiring specific compliance (Lang, Gdpr, Seo) and UI polish.

**Delivers:**
- Lang: Multi-language edge cases
- Gdpr: Compliance testing, data handling
- Seo: Metadata, sitemap generation
- UI: Component testing, integration

**Addresses:**
- Type coverage target (--type-coverage --min=100)
- Architecture testing for layer boundaries
- Visual regression for UI if needed

### Phase Ordering Rationale

- **Foundation first:** Prevents pitfalls from becoming entrenched. Parallel execution, mutation testing, and PHPStan must be in place before writing tests.
- **Core modules first:** Xot (10K LOC) provides base classes — bugs there cascade. User (8.5K LOC) handles auth — security-critical. Tenant (600 LOC) is multi-tenancy foundation.
- **Dependency order:** Tests build on each other — Meetup tests need User and Tenant working. Running in dependency order catches integration issues early.
- **Parallel execution:** Independent modules (Xot, Tenant, Geo) can run in parallel once configured.

### Research Flags

Phases likely needing deeper research during planning:
- **Phase 3 (Feature Modules):** Cross-module integration testing patterns for Meetup/User/Tenant interactions — may need dedicated research on testing module boundaries.
- **Phase 4 (Compliance):** Gdpr module testing patterns for compliance verification — specific legal requirements may need external validation.

Phases with standard patterns (skip research-phase):
- **Phase 1 (Foundation):** Well-documented Laravel/Pest patterns, multiple authoritative sources.
- **Phase 2 (Core Modules):** Standard modular Laravel testing — follows nwidart/laravel-modules documentation.

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Stack | HIGH | PCOV/Pest/PHPStan are Laravel standard. Verified with official docs and multiple sources. |
| Features | HIGH | Comprehensive feature landscape documented. All patterns have clear implementation paths. |
| Architecture | HIGH | Modular testing architecture follows nwidart/laravel-modules patterns. PCOV+modules known issue documented with solution. |
| Pitfalls | HIGH | Eight critical pitfalls identified with mitigation strategies. Mutation testing importance emphasized. |

**Overall confidence:** HIGH

### Gaps to Address

- **Mutation testing configuration:** Infection setup for modular Laravel needs validation during Phase 1 — may need adjustment for module structure.
- **Cross-module test organization:** Root tests/Feature for integration testing across modules — best practices for modular Laravel less documented.
- **100% type coverage feasibility:** Requires every model and service to have explicit return types — may encounter legacy code needing significant refactoring.

---

*Research completed: 2026-03-05*
*Ready for roadmap: yes*
