# FixCity Testing Guidelines — Phase 3 BMAD Optimization

## Overview

This document provides comprehensive guidelines for the Phase 3 testing and coverage optimization initiative for the FixCity modular Laravel 11 project.

**Phase 3 Goals:**
- Increase test coverage from ~5% to 60%+ overall
- Add 532 new tests across all test types
- Achieve 75% coverage on critical modules (Xot, User, Blog)
- Optimize test execution for parallel runs (4.5x speedup)
- Establish standardized testing patterns and documentation

---

## Table of Contents

1. [Test Types and Scope](#test-types-and-scope)
2. [Test Structure](#test-structure)
3. [Test Naming Conventions](#test-naming-conventions)
4. [Mock and Stub Strategy](#mock-and-stub-strategy)
5. [Database Testing](#database-testing)
6. [Parallel Execution](#parallel-execution)
7. [Coverage Targets](#coverage-targets)
8. [Common Patterns](#common-patterns)
9. [Troubleshooting](#troubleshooting)

---

## Test Types and Scope

### Unit Tests (`tests/Unit/`)

**Purpose:** Test individual components in isolation with minimal external dependencies.

**Scope:**
- Models (relationships, scopes, accessors, mutators)
- Actions (business logic, transformations)
- Services (calculations, data processing)
- Traits (behavior mixins)
- Value Objects / Data Transfer Objects

**Characteristics:**
- Fast execution (<500ms per test)
- Extensive mocking of dependencies
- No real database access
- In-memory/SQLite only
- ~235 tests target across all modules

**Example Structure:**
```php
tests/Unit/Modules/{ModuleName}/{ComponentType}/
├── Models/
│   ├── {Model}Test.php
│   └── {Model}RelationshipsTest.php
├── Actions/
│   ├── Create{Entity}ActionTest.php
│   └── Update{Entity}ActionTest.php
└── Services/
    ├── {Service}Test.php
    └── {Service}EdgeCasesTest.php
```

### Integration Tests (`tests/Integration/`)

**Purpose:** Test interactions between multiple components and modules.

**Scope:**
- Cross-module facade usage
- Event/listener chains
- Service container resolution
- Database migration chains
- Repository pattern implementations
- Multi-step workflows

**Characteristics:**
- Medium execution time (500ms–2s per test)
- Real SQLite test database
- Selective mocking (real DB, mocked external APIs)
- Database transactions for isolation
- ~50 tests target across all modules

**Example Structure:**
```php
tests/Integration/Modules/CrossModule/
├── EventListenerChainTest.php
├── ServiceContainerResolutionTest.php
├── MultiModuleWorkflowTest.php
└── DatabaseMigrationChainTest.php
```

### Feature Tests (`tests/Feature/`)

**Purpose:** Test complete user workflows through the full application stack.

**Scope:**
- HTTP API endpoints
- Authentication and authorization flows
- CRUD operations through controllers
- Permission checks and gating
- Error handling and validation
- Form submissions and redirects

**Characteristics:**
- Slower execution (1–5s per test)
- Real SQLite test database
- Full middleware stack
- Minimal mocking (full stack testing)
- Database rollback after each test
- ~247 tests target across all modules

**Example Structure:**
```php
tests/Feature/Modules/{ModuleName}/
├── Controllers/
│   ├── {Entity}ControllerTest.php
│   └── {Entity}ApiControllerTest.php
├── Api/
│   ├── {Resource}ApiTest.php
│   └── {Resource}AuthorizationTest.php
└── Filament/
    ├── {Resource}ManagementTest.php
    └── {Resource}PermissionsTest.php
```

---

## Test Structure

### Base Test Class

All tests inherit from `Tests\TestCase` which provides common utilities:

```php
<?php

namespace Tests\Unit\Modules\{Module}\Models;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class {EntityTest} extends TestCase
{
    use WithFaker;

    /**
     * Test that model extends base model.
     *
     * This ensures the model has common functionality like timestamps,
     * fillable attributes, and BMAD conformance.
     */
    public function test_extends_base_model(): void
    {
        // Test implementation
    }
}
```

### Test Method Naming

Follow this naming convention for clarity and PHPUnit discovery:

```php
// Pattern: test_{condition}_{expected_result}

// Examples:
test_it_creates_user_with_valid_data()
test_it_returns_null_when_user_not_found()
test_it_throws_exception_on_invalid_email()
test_authenticated_user_can_view_dashboard()
test_unauthorized_user_receives_403_response()
```

Alternatively, use PHPUnit attributes (PHP 8+):

```php
#[Test]
#[Group('models')]
#[DataProvider('validUserData')]
public function creates_user_successfully(array $data): void
{
    // Test implementation
}
```

### Docblock Style

Every test should include a docblock explaining the scenario:

```php
/**
 * Test that user can update their profile.
 *
 * Verifies:
 * - User authentication is required
 * - Email uniqueness is enforced
 * - Profile photo is stored correctly
 * - Updated_at timestamp is refreshed
 *
 * @test
 */
public function test_authenticated_user_can_update_profile(): void
{
    // ...
}
```

---

## Test Naming Conventions

### Unit Tests

```
test_{subject}_{condition}_{expected_behavior}

Examples:
- test_user_model_has_correct_fillable_attributes
- test_create_user_action_returns_user_instance
- test_module_service_throws_exception_when_module_not_found
```

### Feature Tests

```
test_{user_role}_{can|cannot}_{action}_{on_resource}

Examples:
- test_authenticated_user_can_view_blog_posts
- test_unauthorized_user_cannot_delete_article
- test_admin_can_manage_all_permissions
```

### Integration Tests

```
test_{first_module}_{interacts_with}_{second_module}_{scenario}

Examples:
- test_user_module_creates_tenant_in_tenant_module
- test_activity_module_logs_events_from_blog_module
- test_notification_triggers_from_comment_creation
```

---

## Mock and Stub Strategy

### Unit Tests: Extensive Mocking

Mock external dependencies to isolate unit logic:

```php
use Mockery;

public function test_create_user_action_with_email_service(): void
{
    // Mock the email service
    $emailService = Mockery::mock(EmailService::class);
    $emailService->shouldReceive('sendVerification')
        ->once()
        ->with(Mockery::on(fn($user) => $user->email === 'test@example.com'))
        ->andReturn(true);

    // Inject mock via container
    $this->app->instance(EmailService::class, $emailService);

    // Execute action
    $action = new CreateUserAction($this->app->make(EmailService::class));
    $user = $action->execute(['email' => 'test@example.com', ...]);

    // Verify user was created (not that email was sent — that's a separate test)
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
}
```

### Integration Tests: Selective Mocking

Real components, mocked external services:

```php
public function test_user_creation_event_triggers_notification(): void
{
    // Mock external API, not internal modules
    $slackApi = Mockery::mock(SlackApiClient::class);
    $slackApi->shouldReceive('sendMessage')->once();
    $this->app->instance(SlackApiClient::class, $slackApi);

    // Use real User model and Notification module
    $user = User::factory()->create();
    event(new UserCreated($user));

    // Verify notification was queued (without actually sending)
    Notification::assertSentTo(
        [$user],
        UserCreatedNotification::class
    );
}
```

### Feature Tests: Minimal Mocking

Prefer real components over mocks:

```php
public function test_user_can_register_via_api(): void
{
    // No mocking — use real database, real validation, real responses
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'SecurePassword123!',
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
}
```

---

## Database Testing

### Setup and Teardown

All Feature and Integration tests use `RefreshDatabase` trait:

```php
<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiModuleWorkflowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Database is rolled back after EACH test.
     * Migrations run fresh for each test.
     */
    public function test_workflow(): void
    {
        // Test implementation
    }
}
```

### Factory Usage

Use factories for consistent test data:

```php
use Modules\User\Database\Factories\UserFactory;
use Modules\Blog\Database\Factories\ArticleFactory;

public function test_article_belongs_to_user(): void
{
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create();

    $this->assertTrue($article->user->is($user));
}
```

### Database Assertions

```php
// Assert row exists with conditions
$this->assertDatabaseHas('users', ['email' => 'test@example.com']);

// Assert row missing
$this->assertDatabaseMissing('users', ['id' => $user->id]);

// Assert row count
$this->assertEquals(5, User::count());

// Assert soft deletes
$this->assertSoftDeleted($user);
$this->assertNotSoftDeleted($user);
```

---

## Parallel Execution

### Configuration

Use `phpunit-parallel.xml` for parallel test runs:

```bash
# Sequential (baseline, ~240-300s)
vendor/bin/phpunit --configuration phpunit.xml

# Parallel (target, ~45-60s)
vendor/bin/phpunit --configuration phpunit-parallel.xml

# Specific test group
vendor/bin/phpunit --configuration phpunit-parallel.xml --testsuite UnitModels
```

### Test Groups

Tests are organized into groups in `phpunit-parallel.xml`:

| Group | Tests | Parallel Jobs | Est. Time |
|-------|-------|---------------|-----------|
| UnitModels | ~100 | 4 | 10-15s |
| UnitActions | ~95 | 4 | 12-18s |
| UnitServices | ~40 | 2 | 5-8s |
| Integration | ~50 | 2 | 20-30s |
| Feature | ~68 | 1 | 40-60s |

### Avoiding Parallel Issues

1. **Database isolation:** Each test uses transactions via `RefreshDatabase`
2. **File locks:** Avoid writing to same files across parallel jobs
3. **Shared resources:** Don't mock `Cache::store('array')` — it may conflict
4. **Test independence:** Each test must not depend on other tests

---

## Coverage Targets

### Module-Level Targets

| Module | LOC | Priority | Target Coverage | Test Count |
|--------|-----|----------|-----------------|-----------|
| Xot | 38,385 | Critical | 75% | 120 |
| User | 36,364 | Critical | 75% | 100 |
| Blog | 17,599 | High | 70% | 60 |
| Geo | 16,678 | High | 60% | 50 |
| Notify | 15,671 | High | 60% | 40 |
| Fixcity | 8,997 | Medium | 55% | 35 |
| Job | 8,124 | Medium | 55% | 30 |
| Cms | 8,042 | Medium | 55% | 30 |
| Media | 6,622 | Medium | 50% | 25 |
| UI | 6,599 | Low | 50% | 25 |
| Comment | 5,072 | Low | 45% | 20 |
| Lang | 4,252 | Medium | 50% | 20 |
| Tenant | 3,742 | High | 65% | 25 |
| Other | ~35,000 | Low | 35% | 100 |

### Measuring Coverage

```bash
# Generate HTML coverage report
vendor/bin/phpunit --coverage-html storage/coverage

# View coverage by module
vendor/bin/phpunit --coverage-text

# Check specific file coverage
vendor/bin/phpunit --coverage-text Modules/Xot/app/Models/Module.php
```

---

## Common Patterns

### Testing Model Relationships

```php
public function test_user_has_many_articles(): void
{
    $user = User::factory()->create();
    Article::factory(3)->for($user)->create();

    $this->assertCount(3, $user->articles);
    $this->assertTrue($user->articles->first()->user->is($user));
}

public function test_article_belongs_to_user(): void
{
    $article = Article::factory()->create();

    $this->assertInstanceOf(User::class, $article->user);
}

public function test_article_has_many_tags(): void
{
    $article = Article::factory()->has(Tag::factory(3))->create();

    $this->assertCount(3, $article->tags);
}
```

### Testing Actions

```php
public function test_create_user_action_returns_user(): void
{
    $action = new CreateUserAction;

    $user = $action->execute([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'SecurePass123!',
    ]);

    $this->assertInstanceOf(User::class, $user);
    $this->assertEquals('Test User', $user->name);
}

public function test_create_user_action_throws_on_duplicate_email(): void
{
    User::factory()->create(['email' => 'duplicate@example.com']);

    $action = new CreateUserAction;

    $this->expectException(DuplicateEmailException::class);

    $action->execute([
        'email' => 'duplicate@example.com',
        ...
    ]);
}
```

### Testing Authorization

```php
public function test_user_can_edit_own_article(): void
{
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create();

    $response = $this->actingAs($user)->putJson(
        "/api/articles/{$article->id}",
        ['title' => 'Updated Title']
    );

    $response->assertOk();
}

public function test_user_cannot_edit_others_article(): void
{
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $article = Article::factory()->for($otherUser)->create();

    $response = $this->actingAs($user)->putJson(
        "/api/articles/{$article->id}",
        ['title' => 'Updated Title']
    );

    $response->assertForbidden();
}
```

### Testing Validation

```php
public function test_create_article_requires_title(): void
{
    $response = $this->postJson('/api/articles', [
        'content' => 'Article content...',
        // missing 'title'
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['title']);
}

public function test_create_article_title_must_be_unique(): void
{
    Article::factory()->create(['title' => 'Duplicate Title']);

    $response = $this->postJson('/api/articles', [
        'title' => 'Duplicate Title',
        'content' => 'Content...',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['title' => 'unique']);
}
```

---

## Troubleshooting

### Common Issues

**Issue:** Tests fail in parallel but pass sequentially
- **Cause:** Shared state or database pollution
- **Solution:** Ensure each test is isolated with `RefreshDatabase`, avoid static properties

**Issue:** Tests timeout on CI pipeline
- **Cause:** Insufficient parallel workers or slow database setup
- **Solution:** Reduce database refreshes, use factories instead of seeders, increase timeout

**Issue:** Coverage report shows 0% for included files
- **Cause:** Files not being executed by tests
- **Solution:** Add tests targeting those files, verify `coverage.include` paths in phpunit.xml

**Issue:** Mock expectations not met
- **Cause:** Method not called with expected arguments
- **Solution:** Use `Mockery::spy()` to debug actual calls, add `dd()` to test

### Debug Tips

```php
// Spy on mock calls
$mock = Mockery::spy(SomeClass::class);
$mock->someMethod('arg');
$mock->shouldHaveReceived('someMethod')->with('arg');

// Dump test data
dd($user->toArray());

// Check database state
DB::enableQueryLog();
$users = User::all();
dd(DB::getQueryLog());

// Verbose output
vendor/bin/phpunit --verbose --debug

// Run specific test
vendor/bin/phpunit tests/Unit/Path/To/TestFile.php::TestClass::test_method_name
```

---

## Next Steps

1. Review critical module tests (Xot, User, Blog)
2. Run coverage analysis: `vendor/bin/phpunit --coverage-text`
3. Identify coverage gaps
4. Add tests iteratively, targeting highest-impact components first
5. Re-run parallel tests: `vendor/bin/phpunit --configuration phpunit-parallel.xml`
6. Measure improvement: before/after comparison

---

**Last Updated:** 2026-07-09
**Phase:** BMAD Optimization Phase 3 — Testing & Coverage
**Next Review:** When coverage reaches 60% overall
