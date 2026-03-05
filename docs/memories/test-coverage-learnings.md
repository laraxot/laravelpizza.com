# 100% Pest Coverage: Learnings & Patterns

**Project:** LaravelPizza - 100% Pest Test Coverage Initiative  
**Started:** 2026-03-04  
**Last Updated:** 2026-03-05

---

## Key Learnings

### 1. belongsToManyX vs belongsToMany (CRITICAL)

**Discovery:** Xot uses `belongsToManyX()` trait method, NOT standard Eloquent `belongsToMany()`.

**Key Differences:**
- Auto-creates pivot class (e.g., EventUser for Event↔User)
- Includes timestamps on pivot table
- Supports cross-connection relations
- Pivot class must exist in module's Models/ namespace

**Testing Pattern:**
```php
// Test attach with pivot data
$event->participants()->attach($user->id, ['role' => 'speaker']);
$pivot = $event->participants()->wherePivot('user_id', $user->id)->first()->pivot;
$this->assertEquals('speaker', $pivot->role);

// Test that timestamps exist
$this->assertNotNull($pivot->created_at);
```

**Memory:** Document this in every module's test-patterns.md

---

### 2. DatabaseTransactions is Essential

**Discovery:** Must use `DatabaseTransactions` trait, NEVER `RefreshDatabase`.

**Why:**
- RefreshDatabase is forbidden (rule in GEMINI.md)
- DatabaseTransactions rolls back changes per test
- Allows for faster parallel testing
- Preserves test isolation

**Pattern:**
```php
use DatabaseTransactions;  // ✅ Correct

// NOT:
use RefreshDatabase;  // ❌ Forbidden
```

---

### 3. Factory States Matter

**Discovery:** Create and test factory states (online(), past(), etc.)

**Example from EventTest:**
```php
#[Test]
public function event_factory_online_state_sets_correct_attendance_mode(): void
{
    $event = Event::factory()->online()->create();
    $this->assertEquals(EventAttendanceMode::ONLINE, $event->attendance_mode);
}

#[Test]
public function event_factory_past_state_creates_past_events(): void
{
    $event = Event::factory()->past()->create();
    $this->assertTrue($event->start_datetime->isPast());
}
```

---

### 4. Slug Generation Needs Unique Values

**Discovery:** When testing models with unique columns (slug, email), use `uniqid()`.

```php
// ❌ Will fail on 2nd test run
$event = Event::factory()->create(['slug' => 'laravel-2024']);

// ✅ Correct
$event = Event::factory()->create(['slug' => 'laravel-' . uniqid()]);
```

---

### 5. CMS Block System Integration

**Discovery:** Events have `toBlockArray()` method for CMS integration.

```php
#[Test]
public function event_to_block_array_includes_correct_status(): void
{
    $event = Event::factory()->create(['status' => EventStatus::PUBLISHED]);
    $block = $event->toBlockArray();
    
    $this->assertEquals('published', $block['status']);
}
```

**Pattern:** Test both presence and correctness of block data.

---

### 6. Schema.org Structured Data

**Discovery:** Events implement `toSchemaOrg()` for SEO.

```php
#[Test]
public function event_to_schema_org_includes_description_when_provided(): void
{
    $event = Event::factory()->create(['description' => 'Learn Laravel']);
    $schema = $event->toSchemaOrg();
    
    $this->assertEquals('Learn Laravel', $schema['description']);
}
```

**Coverage:** Test both with and without optional fields.

---

### 7. Composer Dependencies Must Be Updated

**Discovery:** Need `composer update -W` after adding packages to module composer.json files.

**Pattern:**
```bash
# Add package to Modules/{Module}/composer.json

# Then merge and update:
cd laravel
composer go  # Runs: composer update -W

# This merges all Modules/*/composer.json via wikimedia/composer-merge-plugin
```

---

### 8. Test Execution Speed

**Baseline (Meetup models):**
- 56 tests: 23.5 seconds
- Average: 0.4 seconds per test
- ~110 assertions

**Optimization Opportunities:**
- Parallel testing: `--parallel` flag
- Batch factory creation: `factory(5)->create()` vs loop
- In-memory SQLite for unit tests

---

## Patterns Discovered

### Pattern 1: Model Testing Template

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Tests\Unit\Models;

use Modules\{Module}\Models\{Model};
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class {Model}Test extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function model_can_be_instantiated(): void
    {
        $model = {Model}::factory()->create();
        $this->assertInstanceOf({Model}::class, $model);
    }

    #[Test]
    public function model_has_correct_fillable_fields(): void
    {
        $model = {Model}::factory()->make();
        $this->assertTrue(in_array('field_name', $model->getFillable()));
    }

    // ... more tests
}
```

---

### Pattern 2: Action Testing Template

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Tests\Unit\Actions;

use Modules\{Module}\Actions\{Action};
use Modules\{Module}\Datas\{Data};
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class {Action}Test extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function action_executes_with_valid_data(): void
    {
        $data = {Data}::from([/* ... */]);
        $result = app({Action}::class)->execute($data);
        
        // Assert result and side effects
    }

    #[Test]
    public function action_validates_input(): void
    {
        $this->expectException(ValidationException::class);
        app({Action}::class)->execute($invalidData);
    }
}
```

---

### Pattern 3: Scope Testing

```php
#[Test]
public function scope_filters_correctly(): void
{
    {Model}::factory(2)->create(['status' => Status::ACTIVE]);
    {Model}::factory(1)->create(['status' => Status::INACTIVE]);

    $active = {Model}::active()->get();

    $this->assertCount(2, $active);
    $this->assertTrue($active->every(fn ($m) => $m->status === Status::ACTIVE));
}
```

---

## Edge Cases Found

### 1. Null Optional Fields
Some models have optional fields that can be null. Always test:
```php
$event = Event::factory()->create(['description' => null]);
$this->assertNull($event->description);
```

### 2. Enum Casting
Ensure enum casts work correctly:
```php
$event = Event::factory()->create(['status' => 'published']);
$this->assertInstanceOf(EventStatus::class, $event->status);
$this->assertEquals(EventStatus::PUBLISHED, $event->status);
```

### 3. Cross-Connection Relations
Some models span multiple database connections (User in user DB, Event in meetup DB):
```php
$user = User::factory()->create();  // user connection
$event = Event::factory()->create();  // meetup connection
$event->participants()->attach($user->id);  // cross-connection!
```

---

## Gotchas Avoided

### 1. Anonymous Class Mock Fails Type Checking
❌ **Problem:** Creating anonymous class for Socialite\User contract fails strict typing
```php
// This fails!
$user = new class { public function getEmail() {} };
app(IsUserAllowedAction::class)->execute($user);  // TypeError!
```

✅ **Solution:** Mock the actual Socialite\User class or use proper interface implementation

### 2. Protected Methods in describe() Blocks Fail
❌ **Problem:** Pest describe blocks cannot contain protected/private methods
```php
describe('Action', function () {
    protected function helper() {}  // Parse error!
});
```

✅ **Solution:** Use closures/functions or move to top-level class

### 3. Composer Dependencies Issue
❌ **Problem:** Missing PHPUnit classes after partial install
```bash
Interface "PHPUnit\Framework\Test" not found
```

✅ **Solution:** Run `composer install` or `composer update -W` to fix

---

## Metrics & Progress

### Completed
- ✅ Meetup: EventTest.php (42 tests)
- ✅ Meetup: ProfileTest.php (14 tests)
- ✅ Total: 56 tests, 110 assertions
- ✅ All passing (23.5s execution)

### In Progress
- ⏳ Meetup Actions (10-15 files)
- ⏳ Xot Actions (108+ files)

### Estimated Remaining
- Meetup: 200+ tests
- Xot: 150+ tests
- Tenant: 40+ tests
- Lang: 50+ tests
- Others: 300+ tests
- **Total Goal:** 2000+ tests (1600+ new)

---

## Documentation Created

1. ✅ **Modules/Meetup/docs/test-strategy.md** - Meetup-specific test patterns
2. ✅ **.cursor/rules/pest-testing-patterns.md** - Unified testing patterns
3. ✅ **docs/memories/test-coverage-learnings.md** - This file

---

## Recommendations for Next Phase

### 1. Prioritize by Complexity
1. **Simple:** Enums, DTOs, ValueObjects
2. **Medium:** Services, Traits
3. **Complex:** Actions, Filament Resources, Relations

### 2. Create Test Helpers Library
Location: `tests/Helpers/` or `Modules/Xot/Tests/Helpers/`

**Include:**
- Mock Socialite user factory
- Event/Participant/Venue fixtures
- Common assertions

### 3. Document belongsToManyX Thoroughly
This is the most complex pattern and needs clear examples in every module.

### 4. Use Pest Parallel Testing
```bash
php artisan test --parallel
```

This significantly speeds up the test suite.

### 5. Generate Coverage Reports
```bash
bash bashscripts/testing/generate-coverage.sh
```

Creates `Modules/{Module}/docs/coverage.md` after tests pass.

---

## GitHub Issues Updated

| Issue | Status | Notes |
|-------|--------|-------|
| #191 (Epic) | Updated | Progress comment added |
| #195 (Meetup) | Updated | Model tests completed |
| #192 (Xot) | Updated | Analysis complete |
| #193 (Tenant) | Commented | Strategy documented |
| #194 (Lang) | Commented | Strategy documented |

---

## Code Committed

```
commit dd3958759
test(meetup): Add 56 comprehensive Pest tests for Event and Profile models

- EventTest.php: 42 tests (431 lines)
- ProfileTest.php: 14 tests (119 lines)
- All tests passing, 110 assertions
- Uses DatabaseTransactions
```

---

## Next Session Priorities

1. Generate Meetup Action tests (30-40 tests)
2. Start Xot Action tests (focus on Cast actions first - 8 files, simple)
3. Create shared test helpers
4. Document patterns in rules/
5. Update memories with new learnings

---

**Created by:** Copilot Coverage Initiative  
**Related:** Issue #191, Epic: 100% Pest Coverage Across All Modules

