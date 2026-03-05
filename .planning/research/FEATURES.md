# Feature Research: Laravel/Pest Testing Patterns

**Domain:** Code Coverage & Testing Framework Patterns
**Researched:** 2026-03-05
**Confidence:** HIGH

## Feature Landscape

### Table Stakes (Fundamental Testing Patterns)

These are the non-negotiable patterns required for achieving comprehensive test coverage in Laravel. Missing these makes proper coverage impossible.

| Feature | Why Expected | Complexity | Notes |
|---------|--------------|------------|-------|
| **Test file structure (`it()`, `describe()`)** | Pest's core syntax — tests read like natural language | LOW | Use `it('description', closure)` for single tests, `describe('group', closure)` to organize related tests |
| **Expectation API (`expect()->toBe()`)** | Replaces verbose PHPUnit assertions with chainable, readable methods | LOW | `expect($value)->toBe(10)`, `expect($user)->toBeInstanceOf(User::class)` |
| **Database transactions** | Isolates each test without polluting database | LOW | Must use `DatabaseTransactions` per PROJECT.md — NOT `RefreshDatabase` |
| **HTTP feature testing** | Tests complete request-response cycles | MEDIUM | `$this->get()`, `$this->post()`, `$this->put()`, `$this->delete()` with assertions |
| **Model factories** | Creates test data without boilerplate | LOW | `User::factory()->create()`, `User::factory()->count(5)->create()` |
| **Basic assertions** | Validates test outcomes | LOW | `assertOk()`, `assertSee()`, `assertJson()`, `assertDatabaseHas()`, `assertRedirect()` |
| **Authentication helpers** | Tests protected routes and auth flows | MEDIUM | `$this->actingAs($user)`, token-based auth for APIs |
| **TestCase setup** | Provides Laravel testing base | LOW | Every test file must use `uses(TestCase::class)` |
| **Global test functions** | Pest's functional approach | LOW | No `protected function` in test files — use global `it()`, `test()`, `describe()` |

### Differentiators (Advanced Coverage Patterns)

These patterns differentiate between basic coverage and production-grade, maintainable test suites. They enable 100% coverage goals while keeping tests maintainable.

| Feature | Value Proposition | Complexity | Notes |
|---------|-------------------|------------|-------|
| **Data providers / Datasets** | Test multiple scenarios in single test | LOW | `dataset('name', $data)`, run same test with different inputs |
| **Parallel testing** | 60-80% faster CI through multi-process execution | MEDIUM | `--parallel --processes=4` in phpunit.xml, reduces 45s to ~12s |
| **Type coverage analysis** | Ensures PHP type safety across codebase | MEDIUM | Pest v4 plugin: `--type-coverage --min=90` |
| **Higher-order tests** | Reduces boilerplate via fluent chainable tests | MEDIUM | `$user->expect(fn() => $user->name)->toBe('John')` |
| **Mockery integration** | Mocks external dependencies (HTTP, Redis, external APIs) | MEDIUM | `Mockery::mock()`, `double()` for isolating units |
| **Laravel Fakes (Mail/Queue/Event/Notification)** | Tests async behavior without side effects | MEDIUM | `Mail::fake()`, `Queue::fake()`, `Event::fake()`, `Notification::fake()` |
| **Architecture testing (Arch)** | Enforces layer boundaries in tests | HIGH | "Controllers should not access models directly", validates architectural rules |
| **Browser testing (Pest v4/Playwright)** | E2E tests for JavaScript interactions | HIGH | Full browser automation, not just HTTP — for complex UI flows |
| **Visual regression testing** | Catches unintended UI changes | HIGH | `assertScreenshotsMatch()` for pixel-perfect regression detection |
| **Smoke testing** | Quick health-check for many routes | LOW | `--smoke` flag to visit multiple routes and fail on JS errors |
| **Custom expectations** | Extends Pest with domain-specific assertions | MEDIUM | `expect($email)->toBeValidEmail()`, reusable across tests |
| **Coverage sharding** | Distributes coverage checks across CI jobs | MEDIUM | `--shard=1/4` for parallel coverage analysis |

### Anti-Features (Patterns to Avoid)

These patterns seem beneficial but create problems for coverage-focused initiatives.

| Feature | Why Requested | Why Problematic | Alternative |
|---------|---------------|-----------------|-------------|
| **Testing Laravel internals** | "We should test everything" | Tests become fragile, break on framework upgrades, don't verify behavior | Test your **behavior**, not Laravel's internals — test what your code does, not how Laravel does it |
| **Using `RefreshDatabase`** | "Clean slate for every test" | Slower than transactions, unnecessary for most tests | Use `DatabaseTransactions` as specified in PROJECT.md — faster, same isolation |
| **Aiming for 100% of everything** | "Complete coverage sounds good" | Diminishing returns, tests become write-only, slows development | Focus on critical paths first (auth, CRUD, business logic), expand outward |
| **End-to-end everything** | "Most realistic testing" | Slow, flaky, expensive to maintain | Use Pyramid: many unit tests (fast), fewer feature tests (medium), minimal E2E (critical flows only) |
| **`protected function` in tests** | "OO organization" | Pest is functional by design, conflicts with Pest conventions | Use global functions: `it()`, `test()`, `describe()` |
| **Testing against real external APIs** | "Production-like" | Tests become non-deterministic, depend on third-party availability, slow | Fake external services, test your **handling** of responses, not the responses themselves |
| **Over-mocking** | "Isolate units completely" | Tests lose connection to real behavior, become unit tests that verify implementation, not outcomes | Mock at integration boundaries (HTTP, queue), not at every dependency |
| **Skipping coverage on complex code** | "Too hard to test" | Creates blind spots, technical debt, becomes excuse for untested legacy | Use datasets for edge cases, extract hard-to-test logic into smaller, testable units |

## Feature Dependencies

```
[Pest Installation & Configuration]
    └──requires──> [Basic Test Structure (it, describe)]
                        └──requires──> [Expectation API]
                                            └──requires──> [Database Transactions]
                                                └──requires──> [Model Factories]

[HTTP Feature Testing]
    └──requires──> [Authentication Helpers]
    └──requires──> [Basic Assertions]

[Parallel Testing]
    └──enhances──> [All Testing Patterns] (faster feedback)

[Type Coverage]
    └──enhances──> [All Testing Patterns] (catches type errors)

[Architecture Testing]
    └──conflicts──> [Testing Laravel Internals] (opposite goals)

[Browser Testing]
    └──requires──> [Basic Test Structure]
    └──requires──> [Visual Regression Testing]
```

### Dependency Notes

- **Pest Installation requires Basic Test Structure:** Cannot write effective tests without `it()`, `describe()`, `expect()` syntax
- **Database Transactions requires Model Factories:** Transactions isolate data, factories create data to be isolated
- **HTTP Feature Testing requires Authentication Helpers:** Most routes need auth context
- **Parallel Testing enhances all patterns:** 60-80% speedup applies to any test suite
- **Type Coverage enhances all patterns:** Catches type mismatches that unit tests miss
- **Browser Testing conflicts with pure unit approach:** Requires full Laravel bootstrap, different execution model
- **Architecture Testing conflicts with Testing Laravel Internals:** Arch tests enforce boundaries, internal tests break them

## MVP Definition

### Launch With (v1 — Initial Coverage)

Minimum patterns to achieve basic code coverage on initial modules.

- [ ] **Test file setup** — Pest.php configuration with TestCase and DatabaseTransactions
- [ ] **Basic test syntax** — `it()`, `describe()`, `expect()` in all test files
- [ ] **Model factory usage** — Create test data for User, Meetup, Tenant modules
- [ ] **HTTP testing** — Test controllers and routes with `$this->get()`, assertions
- [ ] **Database assertions** — `assertDatabaseHas()`, `assertDatabaseMissing()`
- [ ] **Authentication testing** — `$this->actingAs()` for protected routes

### Add After Validation (v1.x — Coverage Expansion)

Patterns to add as coverage expands to more modules.

- [ ] **Data providers/datasets** — When testing validation rules, edge cases
- [ ] **Parallel testing setup** — Enable `--parallel` in CI after base tests pass
- [ ] **Mockery integration** — When tests need to isolate from external services
- [ ] **Laravel Fakes** — When testing Mail, Queue, Events, Notifications
- [ ] **Custom expectations** — When domain assertions become repetitive

### Future Consideration (v2+ — Advanced Coverage)

Patterns for achieving 100% coverage with maintainability.

- [ ] **Type coverage analysis** — `--type-coverage --min=100` once basic tests stable
- [ ] **Architecture testing** — Enforce layer boundaries after modules tested
- [ ] **Browser testing (Pest v4)** — For JavaScript-dependent features only
- [ ] **Visual regression testing** — If UI changes are frequent, for early detection

## Feature Prioritization Matrix

| Feature | User Value | Implementation Cost | Priority |
|---------|------------|---------------------|----------|
| Test file structure | HIGH | LOW | P1 |
| Expectation API | HIGH | LOW | P1 |
| Database transactions | HIGH | LOW | P1 |
| Model factories | HIGH | LOW | P1 |
| HTTP feature testing | HIGH | MEDIUM | P1 |
| Basic assertions | HIGH | LOW | P1 |
| Authentication helpers | HIGH | MEDIUM | P1 |
| Data providers | MEDIUM | LOW | P2 |
| Parallel testing | HIGH | MEDIUM | P2 |
| Mockery integration | MEDIUM | MEDIUM | P2 |
| Laravel Fakes | MEDIUM | MEDIUM | P2 |
| Type coverage | MEDIUM | MEDIUM | P2 |
| Architecture testing | MEDIUM | HIGH | P3 |
| Browser testing | LOW | HIGH | P3 |
| Visual regression | LOW | HIGH | P3 |

**Priority key:**
- **P1:** Must have for basic coverage (all v1 items)
- **P2:** Should have for expanded coverage (v1.x items)
- **P3:** Nice to have for 100% coverage (v2+ items)

## Testing Patterns by Module Type

Based on LaravelPizza's module structure, different modules require different testing approaches:

| Module Type | Recommended Patterns | Coverage Target |
|-------------|---------------------|-----------------|
| **User (8,565 LOC)** | Full feature testing, auth flows, OAuth | 100% — critical security |
| **Xot (10,209 LOC)** | Unit tests for services, feature tests for controllers | 100% — core framework |
| **Meetup (1,200 LOC)** | CRUD operations, relationships | 100% — clear boundaries |
| **Tenant (600 LOC)** | Isolation, multi-tenancy patterns | 100% — critical for SaaS |
| **Notify, Geo, Job** | Queue fakes, job dispatching | 100% — background processing |
| **Media** | File handling, conversions | 100% — external integrations |
| **Cms, UI, Activity** | Content management, UI components | 100% — user-facing |
| **Lang, Gdpr, Seo** | Edge cases, compliance | 100% — legal requirements |

## Sources

- Pest PHP official documentation (pestphp.com)
- Laravel 12 testing documentation (laravel.com/docs/master/testing)
- "Complete Laravel Testing Guide — Laravel 12 and Pest 4" — Dominik Dev (2025-09)
- "What's New in Pest v4 for Laravel 12" — Tilly The Coder (2025-08)
- "Laravel Testing Strategy — Pest/PHPUnit" — Greeden (2026-01)
- "PestPHP: 5 Test Patterns That Transform Your Workflow" — Medium (2025-11)
- Laravel Community best practices (dev.to, forem.com)

---

*Feature research for: Laravel/Pest Testing Patterns*
*Researched: 2026-03-05*
