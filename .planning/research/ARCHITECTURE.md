# Architecture Research: Test Organization in Modular Laravel

**Domain:** Laravel Modular Testing Architecture
**Researched:** 2026-03-05
**Confidence:** HIGH

## Standard Architecture

### System Overview

```
┌─────────────────────────────────────────────────────────────┐
│                    TEST ORCHESTRATION LAYER                  │
├─────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────┐    │
│  │                    phpunit.xml                       │    │
│  │  - TestSuite "Modules" (wildcard: Modules/*/Tests)  │    │
│  │  - TestSuite "Unit" (tests/Unit)                    │    │
│  │  - TestSuite "Feature" (tests/Feature)              │    │
│  └─────────────────────────────────────────────────────┘    │
├─────────────────────────────────────────────────────────────┤
│                    MODULE TEST LAYER                        │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐    │
│  │   User   │  │  Meetup  │  │  Tenant  │  │   Xot    │    │
│  │  Tests   │  │  Tests   │  │  Tests   │  │  Tests   │    │
│  │ 8,565    │  │ 1,200    │  │   600    │  │ 10,209   │    │
│  │   LOC    │  │   LOC    │  │   LOC    │  │   LOC    │    │
│  └────┬─────┘  └────┬─────┘  └────┬─────┘  └────┬─────┘    │
│       │             │             │             │          │
├───────┴─────────────┴─────────────┴─────────────┴──────────┤
│                    SHARED INFRASTRUCTURE                     │
├─────────────────────────────────────────────────────────────┤
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐          │
│  │ Pest.php    │  │ TestCase    │  │  Factories  │          │
│  │ (per-mod)  │  │ (base)      │  │ (per-mod)   │          │
│  └─────────────┘  └─────────────┘  └─────────────┘          │
├─────────────────────────────────────────────────────────────┤
│                    DATABASE LAYER                            │
├─────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────┐    │
│  │  DatabaseTransactions (not RefreshDatabase)        │    │
│  │  SQLite :memory: (configured in phpunit.xml)        │    │
│  └─────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

### Component Responsibilities

| Component | Responsibility | Typical Implementation |
|-----------|----------------|------------------------|
| **Module Tests (per-module)** | Test all code within a single module boundary | `Modules/*/Tests/Feature/` and `Modules/*/Tests/Unit/` |
| **Root Tests** | Shared/global tests (base TestCase, utilities) | `tests/TestCase.php`, `tests/Pest.php` |
| **Module Pest.php** | Module-specific test configuration, custom expectations, helper functions | Per-module `tests/Pest.php` with `pest()->extend()` |
| **Module TestCase** | Module-specific test base class | Per-module `tests/TestCase.php` extending root TestCase |
| **Module Factories** | Test data generation per module | Per-module `database/factories/` (e.g., `UserFactory`) |
| **phpunit.xml** | Test discovery, coverage configuration, test suites | Wildcard includes for modules, separate test suites |

## Recommended Project Structure

```
laravel/
├── tests/                                    # Global/shared test infrastructure
│   ├── Pest.php                             # Root Pest configuration
│   ├── TestCase.php                         # Base test case class
│   ├── Feature/                             # Cross-cutting feature tests
│   └── Unit/                                # Core application unit tests
│
├── Modules/
│   ├── User/
│   │   ├── Tests/
│   │   │   ├── Pest.php                    # Module-specific config
│   │   │   ├── TestCase.php                # Module-specific base
│   │   │   ├── Feature/                    # Module feature tests
│   │   │   │   ├── Auth/
│   │   │   │   │   └── LoginTest.php       # Mirrors app/Http/Controllers/Auth
│   │   │   │   ├── Actions/
│   │   │   │   │   └── CreateUserActionTest.php
│   │   │   │   └── Filament/
│   │   │   │       └── UserResourceTest.php
│   │   │   └── Unit/                       # Unit tests
│   │   │       ├── Actions/
│   │   │       ├── Models/
│   │   │       ├── Enums/
│   │   │       └── Traits/
│   │   ├── app/                            # Module application code (test target)
│   │   └── database/
│   │       └── factories/                  # Module-specific factories
│   │
│   ├── Meetup/
│   │   └── Tests/                          # Same structure
│   │
│   ├── Xot/
│   │   └── Tests/                          # Same structure
│   │
│   └── [Other Modules]
│       └── Tests/
│
└── phpunit.xml                              # Test configuration
```

### Structure Rationale

- **`Modules/*/Tests/Feature/`:** Mirrors module's HTTP layer structure — tests via `$this->get()`, `$this->post()` simulate HTTP requests through routes defined in module
- **`Modules/*/Tests/Unit/`:** Mirrors module's `app/` directory structure — each subfolder (`Actions/`, `Models/`, `Enums/`) has corresponding test folder for isolated unit testing
- **`Modules/*/Tests/Pest.php`:** Module-specific helpers and expectations (e.g., `createUser()`, `toBeUser()`) — keeps test code DRY within module
- **`tests/` (root):** Global infrastructure only — base TestCase, shared utilities; NOT the place for module-specific tests

## Architectural Patterns

### Pattern 1: Module-Isolated Testing

**What:** Each module owns its own test directory with self-contained test infrastructure.

**When to use:** Always in modular Laravel applications using nwidart/laravel-modules.

**Trade-offs:**
- ✅ Clear ownership — each module team tests their own code
- ✅ Independent test execution per module (`vendor/bin/pest --filter='User'`)
- ✅ Module can be tested standalone (useful for package development)
- ❌ Possible code duplication of helper functions across modules
- ❌ Cross-module integration testing requires additional setup

**Example:**
```php
// Modules/User/tests/Feature/Auth/LoginTest.php
<?php

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(Modules\User\Tests\TestCase::class);

test('user can login with valid credentials', function () {
    $user = User::factory()->create(['password' => 'password']);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/home');
    $this->assertAuthenticated();
});
```

### Pattern 2: DatabaseTransactions Over RefreshDatabase

**What:** Use `DatabaseTransactions` trait instead of `RefreshDatabase` for test isolation.

**When to use:** Always — per PROJECT.md constraints (DatabaseTransactions, never RefreshDatabase).

**Trade-offs:**
- ✅ Faster — doesn't run full migration rollback between tests
- ✅ Safer in parallel execution — each test gets transaction scope
- ✅ Works with existing data — tests can see production-like data within transaction
- ❌ Requires careful transaction management
- ❌ Can't test actual migration behavior

**Example:**
```php
// In tests/Pest.php (root or module)
uses(TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class)->in('Feature', 'Unit');
```

### Pattern 3: Module-Specific Pest Configuration

**What:** Each module has its own `Pest.php` with module-specific helpers and expectations.

**When to use:** When modules have domain-specific test utilities that differ across modules.

**Trade-offs:**
- ✅ Expressive — domain-specific matchers like `toBeUser()`, `toBeTeam()`
- ✅ Reusable — `createUser()` helper available to all tests in module
- ❌ Maintenance burden — keep in sync with model changes

**Example:**
```php
// Modules/User/tests/Pest.php
<?php

use Modules\User\Models\User;
use Modules\User\Models\Team;

pest()->extend(Modules\User\Tests\TestCase::class)->in('Feature', 'Unit');

expect()->extend('toBeUser', fn () => $this->toBeInstanceOf(User::class));

function createUser(array $attributes = []): User
{
    return User::factory()->create($attributes);
}
```

### Pattern 4: Wildcard Test Discovery

**What:** phpunit.xml uses wildcard patterns to discover tests across all modules without manual entries.

**When to use:** Standard approach for laravel-modules.

**Trade-offs:**
- ✅ Automatic — new modules automatically discovered
- ✅ Single command runs all module tests
- ❌ Requires correct phpunit.xml configuration
- ❌ Coverage configuration needs explicit module includes

**Example (phpunit.xml):**
```xml
<testsuite name="Modules">
    <directory suffix="Test.php">./Modules/*/Tests/Feature</directory>
    <directory suffix="Test.php">./Modules/*/Tests/Unit</directory>
</testsuite>

<source>
    <include>
        <directory suffix=".php">./Modules/User</directory>
        <directory suffix=".php">./Modules/Xot</directory>
        <!-- ... all modules for coverage -->
    </include>
</source>
```

### Pattern 5: Module Dependency-Aware Testing Order

**What:** Tests execute in dependency order — modules without external dependencies tested first.

**When to use:** For 100% coverage goals with parallel execution optimization.

**Trade-offs:**
- ✅ Independent modules can run in parallel (faster CI)
- ✅ Dependencies tested after their requirements
- ❌ Requires understanding of module dependencies
- ❌ Graph analysis needed for optimal ordering

**Build Order (dependency-aware):**
```
Phase 1: Xot        → Core framework (no dependencies)
Phase 2: Tenant     → Depends on Xot (tenant isolation)
Phase 3: User      → Auth foundation (no external deps)
Phase 4: Geo       → User profile context
Phase 5: Lang      → Multi-language support
Phase 6: Meetup    → User + Tenant context
Phase 7: Notify    → Depends on User, Tenant
Phase 8: Media     → File handling
Phase 9: Cms       → Content management
Phase 10: Job      → Queue jobs
Phase 11: Activity → Logging/events
Phase 12: Gdpr     → Depends on User
Phase 13: Seo      → SEO metadata
Phase 14: UI       → Depends on all
```

## Data Flow

### Test Execution Flow

```
php artisan test [--coverage]
    │
    ├─→ phpunit.xml (loads)
    │       │
    │       ├─→ TestSuite "Unit" → tests/Unit/*.php
    │       ├─→ TestSuite "Feature" → tests/Feature/*.php
    │       └─→ TestSuite "Modules" → Modules/*/Tests/{Feature,Unit}/*.php
    │
    ├─→ Bootstrap: vendor/autoload.php
    │       │
    │       ├─→ Load tests/Pest.php (global config)
    │       │       │
    │       │       └─→ Apply TestCase + DatabaseTransactions to all tests
    │       │
    │       └─→ For each module: load Modules/*/Tests/Pest.php
    │               │
    │               └─→ Apply module-specific TestCase, helpers, expectations
    │
    ├─→ Database Setup (per phpunit.xml env vars)
    │       │
    │       └─→ DB_CONNECTION=sqlite, DB_DATABASE=:memory:
    │
    ├─→ Test Execution (per file)
    │       │
    │       ├─→ For each test: begin transaction
    │       │       │
    │       │       ├─→ Arrange: create test data (factories)
    │       │       ├─→ Act: execute code under test
    │       │       └─→ Assert: verify expectations
    │       │
    │       └─→ Rollback transaction
    │
    └─→ Coverage Collection (if --coverage)
            │
            └─→ Xdebug/PCOV instruments covered files
                    │
                    └─→ Generate coverage report
```

### Module Interaction Testing Flow

```
┌──────────────┐     ┌──────────────┐
│  User Tests  │     │ Meetup Tests │
│              │     │              │
│ ┌──────────┐ │     │ ┌──────────┐ │
│ │ Create   │ │     │ │ Create   │ │
│ │ User     │ │     │ │ Event    │ │
│ └────┬─────┘ │     │ └────┬─────┘ │
│      │       │     │      │       │
│      ↓       │     │      ↓       │
│ ┌──────────┐ │     │ ┌──────────┐ │
│ │ User     │ │     │ │ Attach   │ │
│ │ created  │ │     │ │ User to  │ │
│ └────┬─────┘ │     │ │ Event    │ │
│      │       │     │ └────┬─────┘ │
│      │       │     │      │       │
└──────│───────┘     └──────│───────┘
       │                     │
       └──────────┬──────────┘
                  ↓
       ┌──────────────────────┐
       │  Integration Test   │  ← Uses DatabaseTransactions
       │  (root tests/)       │    to see both modules' data
       └──────────────────────┘
```

### Key Data Flows

1. **Test Data Creation Flow:** Test calls `User::factory()->create()` → Factory builds model attributes → Inserts to SQLite in-memory → Transaction scopes test → Rollback cleans up

2. **Cross-Module Data Flow:** Module A test creates related data from Module B → Both use same in-memory SQLite via DatabaseTransactions → Test sees combined data → Rollback cleans both

3. **Coverage Data Flow:** PCOV/Xdebug instruments PHP files during execution → Tracks line execution → PHPUnit aggregates per file → Report generated from `<source>` includes in phpunit.xml

## Scaling Considerations

| Scale | Architecture Adjustments |
|-------|--------------------------|
| **Current (40K LOC, 4.1% coverage)** | Sequential test runs, wildcard discovery, in-memory SQLite |
| **Mid-term (80K LOC, 80% coverage)** | Parallel test execution (`--parallel`), module-specific phpunit.xml |
| **Long-term (100K+ LOC, 100% coverage)** | Separate CI jobs per module, incremental coverage, coverage caching |

### Scaling Priorities

1. **First bottleneck: Test execution time.** As coverage approaches 100%, test suite grows significantly. Solution: Enable parallel testing (`./vendor/bin/pest --parallel`) and split into module-specific test suites.

2. **Second bottleneck: Coverage collection.** Running with `--coverage --min=100` is slow. Solution: Run coverage only on CI (not local dev), use `XDEBUG=0` for fast tests, enable coverage only on changed modules via git diff.

3. **Third bottleneck: PCOV code coverage failing for modules.** Known issue — PCOV sometimes excludes modules from coverage report. Solution: Use Xdebug instead (`php -d pcov.enabled=0`) or ensure `<source>` includes all module directories.

## Anti-Patterns

### Anti-Pattern 1: Centralized Tests in Root

**What people do:** Put all tests in `tests/Feature/` and `tests/Unit/` without module organization.

**Why it's wrong:** Defeats modular architecture purpose — tests don't align with code ownership, makes parallel execution harder, no clear responsibility.

**Do this instead:** Follow laravel-modules pattern — tests live alongside the code they test within each module's `Tests/` directory.

### Anti-Pattern 2: Using RefreshDatabase

**Why it's wrong:** PROJECT.md explicitly forbids — RefreshDatabase runs full migrations before each test, slower than transactions, breaks parallel execution.

**Do this instead:** Use `DatabaseTransactions` trait — wraps each test in transaction, faster, parallel-safe.

### Anti-Pattern 3: Missing Module Source in Coverage

**What people do:** Configure phpunit.xml `<source>` only with `app/` directory, missing `Modules/*`.

**Why it's wrong:** Coverage report will show 0% for all modules even when tests pass. This is the PCOV bug mentioned earlier.

**Do this instead:** Explicitly include all module directories in `<source>`:
```xml
<source>
    <include>
        <directory suffix=".php">./Modules/User</directory>
        <directory suffix=".php">./Modules/Meetup</directory>
        <directory suffix=".php">./Modules/Xot</directory>
        <!-- ... all modules -->
    </include>
</source>
```

### Anti-Pattern 4: Protected Functions in Tests

**What people do:** Using `protected function setUp()` in test files.

**Why it's wrong:** Per PROJECT.md constraints: "No `protected function` in test files — use global functions."

**Do this instead:** Use Pest's global functions or module-specific helpers defined in Pest.php.

## Integration Points

### External Services

| Service | Integration Pattern | Notes |
|---------|---------------------|-------|
| **SQLite :memory:** | DatabaseTransactions | Configured in phpunit.xml, do NOT use in .env |
| **OAuth Providers** | Mock via `$this->mock()` or factory states | Don't hit real OAuth in tests |
| **External APIs** | Mock via `$this->mock()` or Http::fake() | Never call external services in tests |

### Internal Boundaries

| Boundary | Communication | Notes |
|----------|---------------|-------|
| **User ↔ Tenant** | Direct model relationships | Use DatabaseTransactions to see both in same test |
| **User ↔ Meetup** | Foreign key relationships | Create both via factories, test association |
| **Module ↔ Xot** | Xot provides base classes | Tests for base class behavior belong in module |
| **Cross-module integration** | Shared root tests/Feature | Place cross-cutting integration tests in root `tests/Feature/` |

## Sources

- [Laravel Modules Package — Tests Documentation](https://laravelmodules.com/docs/8/advanced/tests) — Official nwidart/laravel-modules testing guide
- [Pest PHP Documentation](https://pestphp.com/docs/configuring-tests) — Per-folder test configuration
- [Stack Overflow: Laravel Modules Code Coverage](https://stackoverflow.com/questions/79222614/why-does-code-coverage-for-custom-modules-fail-in-laravel) — PCOV + modules issue
- [Dominik Dev: Laravel 12 Testing Guide](https://dominik-dev.pl/en/blog/complete-laravel-testing-guide-from-a-z-with-laravel-12-and-pest-4) — Comprehensive Pest 4 patterns

---

*Architecture research for: Test Organization in Modular Laravel Application*
*Researched: 2026-03-05*
