# Pitfalls Research

**Domain:** Laravel Coverage Initiatives (Pest/PHPUnit)
**Researched:** 2026-03-05
**Confidence:** HIGH

## Critical Pitfalls

### Pitfall 1: Coverage Is Not Quality

**What goes wrong:**
Code coverage measures execution, not verification. A line can be "covered" (executed during tests) but never actually assertions-verified. Developers achieve 100% coverage while shipping code with critical bugs that tests never catch.

**Why it happens:**
Coverage provides a simple metric that looks objective and measurable. It's easy to report: "96% of lines executed." This creates a false sense of security — the team celebrates hitting targets while business logic remains untested in meaningful ways.

**How to avoid:**
- Implement mutation testing (Infection) to validate test quality, not just coverage
- Require assertions on return values, not just HTTP status codes
- Track branch coverage alongside line coverage
- Add code review checklist: "What does this test actually verify?"

**Warning signs:**
- Tests only assert `$response->assertStatus(200)` without checking response content
- Test files with 0 assertions (tests that just call code to "exercise" it)
- No test verifies exception/error paths — only happy paths covered

**Phase to address:**
Foundation Phase — establish mutation testing and assertion standards before coverage targets

---

### Pitfall 2: Gaming the Metrics

**What goes wrong:**
When 100% coverage becomes a target, developers write tests that technically cover code without actually testing it. Common tactics: test getters/setters, add assertions that always pass, create tests that call private methods via reflection just to increase coverage numbers.

**Why it happens:**
Goodhart's Law: "When a measure becomes a target, it ceases to be a good measure." Coverage was meant to identify untested code; making it a success metric corrupts its purpose. Agents optimizing for coverage will find the path of least resistance.

**How to avoid:**
- Use mutation testing scores as quality gates (not just coverage %)
- Set coverage floors per module, not global targets
- Track time-to-detect-bugs, not just coverage percentages
- Celebrate "meaningful tests" over "covered lines"

**Warning signs:**
- Tests for simple getters/setters that add no value
- Test files that exist only to raise coverage numbers
- No correlation between coverage increases and bug detection rates

**Phase to address:**
Foundation Phase — establish what "good tests" look like before setting coverage targets

---

### Pitfall 3: Database Test Pollution

**What goes wrong:**
Tests create database records without proper cleanup (missing `DatabaseTransactions` or `RefreshDatabase` trait). Tests pass in isolation but fail when run in parallel or in CI due to data leakage between tests. The project constraint specifies `DatabaseTransactions`, never `RefreshDatabase`.

**Why it happens:**
In Laravel, tests can appear to pass locally while introducing subtle data pollution. Using `RefreshDatabase` for every test is slow, so developers omit it for speed. However, `RefreshDatabase` guarantees isolation — without it, test order matters.

**How to avoid:**
- Every test file MUST include `uses(TestCase::class, DatabaseTransactions::class)` as per project constraints
- Run tests in random order (`--order=random`) to catch pollution early
- Add test that detects tests creating records without cleanup
- Use `$this->assertDatabaseMissing()` to verify cleanup

**Warning signs:**
- Tests pass individually but fail when run as suite
- Flaky tests that pass on retry
- "Database state leaked" errors in CI

**Phase to address:**
Module Testing Phase — each module's test suite must enforce isolation

---

### Pitfall 4: Test Suite Performance Collapse

**What goes wrong:**
As coverage increases, test suite slows dramatically. What started as 2-minute runs become 20+ minutes. Developers stop running tests locally, CI pipelines timeout, and coverage gains stall.

**Why it happens:**
Achieving coverage often means adding more feature tests (HTTP, database) rather than fast unit tests. Each test bootstraps Laravel, hits the database, and makes network calls. The math is brutal: 500 tests × 500ms = 250 seconds.

**How to avoid:**
- Maintain ratio: 70% unit tests, 20% integration, 10% feature tests
- Use Pest's parallel execution (`--parallel`) from start
- Mock external services (HTTP, queue, mail) in unit tests
- Profile slow tests (`--profile`) and optimize aggressively

**Warning signs:**
- Test suite exceeds 10 minutes
- Developers skip tests locally to save time
- No parallel execution configured

**Phase to address:**
Foundation Phase — set up parallel execution and performance budgets before scaling

---

### Pitfall 5: Coverage Target Becomes Refactoring Barrier

**What goes wrong:**
100% coverage makes code brittle. Teams avoid refactoring because it risks coverage loss. Code that "works" but has design issues becomes permanent technical debt — untouchable because breaking tests is unacceptable.

**Why it happens:**
Coverage becomes a cage. If refactoring requires changing 50 tests, the effort becomes a project. Instead of improving code, teams add workarounds to avoid touching tested code. The "protection" becomes a prison.

**How to avoid:**
- Accept that coverage targets may dip during legitimate refactoring
- Track refactoring separately from feature coverage
- Use coverage as "safety net" not "absolute requirement"
- Prioritize testing contracts/interfaces, not implementation details

**Warning signs:**
- "We can't refactor this — we'd lose too much coverage"
- Test files with 1000+ lines and complex setup
- No recent refactoring despite obvious code smells

**Phase to address:**
Foundation Phase — document that coverage is a tool, not a mandate

---

### Pitfall 6: Ignoring Type Coverage (PHPStan)

**What goes wrong:**
Achieving 100% code coverage while PHPStan reports hundreds of errors. Coverage doesn't catch type mismatches, missing return types, or invalid property accesses. Code is "tested" but not type-safe.

**Why it happens:**
Coverage and type safety are orthogonal concerns. Tests can pass with `mixed` types and runtime checks that mask problems. The project constraint specifies "no `mixed` type declarations allowed" — but this isn't enforced by coverage alone.

**How to avoid:**
- Run PHPStan alongside coverage in CI
- Set PHPStan baseline and reduce errors incrementally
- Use strict types (`declare(strict_types=1)`) in all files
- Add "type coverage" to project success criteria

**Warning signs:**
- PHPStan errors increase while coverage increases
- Code using `mixed` or `/** @var */` comments extensively
- Runtime type errors caught only in production

**Phase to address:**
Foundation Phase — establish type safety alongside code coverage

---

### Pitfall 7: Anti-Patterns in Coverage-Seeking Tests

**What goes wrong:**
Tests written specifically to achieve coverage rather than verify behavior. Common patterns: testing private methods via reflection, asserting on internal state, testing implementation details instead of contracts.

**Why it happens:**
When coverage is the goal, developers do whatever gets lines covered. Private methods get tested directly (brittle). Getters get tested (pointless). Complex test setup tests one line of code (inefficient).

**How to avoid:**
- Test public contracts, not implementation details
- No tests for simple getters/setters unless they contain logic
- Use Pest's expectation syntax that focuses on behavior
- Review tests for "coverage-driven" vs "behavior-driven" patterns

**Warning signs:**
- Tests using `ReflectionClass` to access private methods
- Test files with excessive setup for simple assertions
- Tests that fail on any internal code change

**Phase to address:**
Module Testing Phase — review each module's test patterns

---

### Pitfall 8: Missing Test Documentation

**What goes wrong:**
Tests lack descriptions, making them incomprehensible to future developers. Coverage achieved but knowledge not transferred. New team members can't understand what tests verify, making maintenance impossible.

**Why it happens:**
Tests are written fast to hit coverage targets. The "describe what it does" step gets skipped. Tests become a black box: coverage achieved but understanding zero.

**How to avoid:**
- Require descriptions on all Pest tests using `test('description', ...)`
- Document test strategy per module: what's tested, what's mocked, what's not
- Use descriptive test names that explain expected behavior
- Create test index explaining test organization

**Warning signs:**
- Test names like `test_can_do_something` with no description
- No documentation on what each test file covers
- New developers can't modify tests without breaking them

**Phase to address:**
Foundation Phase — establish documentation standards before coverage work begins

---

## Technical Debt Patterns

| Shortcut | Immediate Benefit | Long-term Cost | When Acceptable |
|----------|-------------------|----------------|------------------|
| Test private methods | Coverage increase | Brittle tests, breaks refactoring | Never — test the contract, not implementation |
| Skip mutation testing | Faster initial coverage | False confidence in test quality | Only if team lacks expertise, then prioritize learning |
| Use `RefreshDatabase` instead of `Transactions` | Simpler setup | Slower test suite | Only for first-time setup, then migrate to Transactions |
| Skip flaky tests | CI passes | Hidden bugs, test distrust | Never — fix the cause, not the symptom |
| Mock everything | Fast unit tests | Integration gaps, missing edge cases | For pure logic; use integration tests for data layers |

## Integration Gotchas

| Integration | Common Mistake | Correct Approach |
|-------------|----------------|------------------|
| Laravel HTTP tests | Only asserting status codes | Assert response body, headers, and JSON structure |
| External APIs | Not mocking in unit tests | Use Http::fake() for fast, reliable unit tests |
| Queued jobs | Testing synchronously only | Use `Job::fake()` and test job dispatch + handling |
| Mail | Not using Mail::fake() | Verify mail was sent, to whom, with what content |
| File storage | Not using Storage::fake() | Test upload, retrieval, and deletion paths |

## Performance Traps

| Trap | Symptoms | Prevention | When It Breaks |
|------|----------|------------|----------------|
| Database-per-test | Tests take 5+ minutes | Use `DatabaseTransactions`, avoid `RefreshDatabase` | At 500+ tests |
| No parallelization | 10+ minute test runs | Configure Pest parallel execution | After 200 tests |
| Heavy factories | Test setup dominates runtime | Use factory states, minimal attributes | At 100+ factories |
| Real HTTP calls in tests | Flaky tests, slow runs | Mock external services | Always — production APIs should never be called |

## Security Mistakes

| Mistake | Risk | Prevention |
|---------|------|------------|
| Not testing authorization | Data exposure via API | Add tests that verify 403 for unauthorized users |
| Testing with admin user by default | Authorization bugs hidden | Use lowest-privilege user in most tests |
| Sensitive data in test factories | Data leaks to logs | Never use real PII in tests |
| Missing CSRF tests | Form submission vulnerabilities | Test that tokens are required |

## UX Pitfalls

This domain doesn't directly involve user-facing UX. The "UX" here is developer experience:

| Pitfall | User Impact | Better Approach |
|---------|-------------|-----------------|
| Cryptic test names | Developers can't understand test intent | Use descriptive Pest test names |
| No test organization | Finding relevant tests is hard | Group by feature/module |
| Missing error messages | Test failures are opaque | Add descriptive assertions |

## "Looks Done But Isn't" Checklist

- [ ] **Coverage:** 100% achieved but no assertions on return values — verify tests actually check behavior
- [ ] **Mutations:** Coverage complete but mutation score unchecked — verify test quality
- [ ] **Database:** Tests pass but may leak data — verify `DatabaseTransactions` trait present
- [ ] **Types:** PHPStan not run alongside coverage — verify both metrics tracked
- [ ] **Performance:** Suite passes but takes 15+ minutes — verify parallelization configured

## Recovery Strategies

| Pitfall | Recovery Cost | Recovery Steps |
|---------|---------------|----------------|
| Coverage ≠ Quality | MEDIUM | Add mutation testing, re-evaluate test assertions |
| Test pollution | HIGH | Run with random order, find offending tests, add cleanup |
| Performance collapse | MEDIUM | Profile slow tests, refactor to unit tests, add parallelization |
| Refactoring barrier | HIGH | Accept temporary coverage loss, focus on contract tests |

## Pitfall-to-Phase Mapping

| Pitfall | Prevention Phase | Verification |
|---------|------------------|--------------|
| Coverage ≠ Quality | Foundation | Mutation testing score >80% |
| Gaming the Metrics | Foundation | Code review for coverage-seeking patterns |
| Database Test Pollution | Foundation | Random order tests pass consistently |
| Performance Collapse | Foundation | Test suite <5 minutes |
| Refactoring Barrier | Foundation | Document "coverage is guidance" policy |
| Type Coverage Neglect | Foundation | PHPStan level 10, 0 errors |
| Anti-Patterns | Module Testing | Code review on each module |
| Missing Documentation | Foundation | Test descriptions required |

## Sources

- Dalibor Karlović — "Your code coverage is lying" (2024)
- Thierry de Pauw — "The Fallacy of the 100% Code Coverage" (2022)
- Rogelio Consejo — "Quality Over Coverage" (Feb 2026)
- Mark Seemann — "100% coverage is not that trivial" (2025)
- Laravel News — "Find Feature Tests Creating Database Records without Refreshing the Database" (2025)
- Pest Documentation — Optimizing Tests (2025)
- Steve Grunwell — "The True Meaning of Code Coverage" (2025)

---

*Pitfalls research for: Laravel Coverage Initiatives*
*Researched: 2026-03-05*
