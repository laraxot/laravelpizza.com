# Coverage Gaps Analysis & Test Implementation Guide

## Overview

This guide provides a systematic approach to:
1. Identify files and code paths not covered by tests
2. Prioritize test implementation efforts
3. Write effective tests to close coverage gaps
4. Verify 100% coverage is achieved

## Step 1: Analyze Coverage Gaps

### Generate Coverage Report with Details

```bash
cd laravel

# Full coverage report showing uncovered lines
php artisan test --coverage 2>&1 | tee coverage-full.txt

# Compact type coverage (only incomplete files)
php artisan test --type-coverage --compact 2>&1 | tee type-coverage-gaps.txt
```

### Parse Coverage Output

The coverage output shows:
- **File path** - Source file being analyzed
- **Percentage** - % of lines executed
- **Uncovered lines** - Red highlighted ranges (e.g., `52..60`)

Example:
```
Modules\Meetup\app\Models\Event.php
  Code Coverage:  72.5% - Lines: 52, 55, 61..67
```

This means lines 52, 55, and 61-67 are not executed during testing.

### SQL Tracking

Insert gaps into `coverage_gaps` table:

```sql
INSERT INTO coverage_gaps (id, module_id, file_path, coverage_percent, type_gap, priority, test_needed)
VALUES 
  ('meetup-event-1', 'meetup', 'Modules/Meetup/app/Models/Event.php', 72.5, NULL, 'high', 'Unit: Event model methods; Feature: Event CRUD flows'),
  ('user-auth-1', 'user', 'Modules/User/app/Actions/AuthenticateUserAction.php', 85.0, NULL, 'critical', 'Unit: Auth logic; Feature: Login/Register flows');
```

## Step 2: Prioritize by Module & Type

### Criticality Ranking

1. **Critical** - Core business logic in Actions (business must work)
2. **High** - Models, Validations (data integrity)
3. **Medium** - Filament resources, API endpoints
4. **Low** - UI helpers, formatters

### Test Implementation Order

1. **Actions** (Spatie QueueableAction) - Business logic MUST be tested
2. **Models** - Relationships, scopes, mutators
3. **Filament Resources** - Forms, tables, actions
4. **Validation & Rules** - Input constraints
5. **Services & Helpers** - Utility logic

## Step 3: Identify Uncovered Code Paths

### Common Coverage Gaps

#### Gap 1: Conditional Logic Not Exercised

```php
// Only 50% covered if only "success" path tested
public function processEvent(Event $event): void
{
    if ($event->isActive()) {  // ← Only tested when TRUE
        $this->activate($event);
    } else {  // ← NOT TESTED
        $this->deactivate($event);
    }
}
```

**Solution**: Write separate tests for both conditions:

```php
#[Test]
public function it_activates_active_event(): void { ... }

#[Test]
public function it_deactivates_inactive_event(): void { ... }
```

#### Gap 2: Exception Paths Not Tested

```php
public function delete(Event $event): void
{
    if (! $event->canBeDeleted()) {
        throw new EventException('Cannot delete');  // ← NOT TESTED
    }
    $event->delete();
}
```

**Solution**: Test exception path:

```php
#[Test]
public function it_throws_when_deleting_locked_event(): void
{
    $event = Event::factory()->locked()->create();
    
    $this->expectException(EventException::class);
    app(DeleteEventAction::class)->execute($event);
}
```

#### Gap 3: Model Methods Not Tested

```php
class Event extends XotBaseModel
{
    public function getFormattedDateAttribute(): string  // ← Likely uncovered
    {
        return $this->start_date->format('d/m/Y');
    }
    
    public function scopeActive($query)  // ← Scope not tested
    {
        return $query->where('is_active', true);
    }
}
```

**Solution**: Write model tests:

```php
#[Test]
public function it_formats_date_correctly(): void
{
    $event = Event::factory()->create(['start_date' => '2024-03-04']);
    
    $this->assertEquals('04/03/2024', $event->formatted_date);
}

#[Test]
public function scope_active_returns_only_active_events(): void
{
    Event::factory(3)->active()->create();
    Event::factory(2)->inactive()->create();
    
    $this->assertCount(3, Event::active()->get());
}
```

#### Gap 4: Filament Resource Methods Not Tested

```php
class EventResource extends XotBaseResource
{
    public static function getFormSchema(): array  // ← Often uncovered
    {
        return [
            TextInput::make('title')->required(),
            DatePicker::make('start_date'),
        ];
    }
}
```

**Solution**: Feature test the resource:

```php
#[Test]
public function it_can_view_event_form(): void
{
    $this->actingAs(User::factory()->admin()->create());
    
    $this->get('/admin/events/create')
        ->assertOk()
        ->assertSeeText('Title');
}
```

## Step 4: Write Tests to Close Gaps

### Test Template for Uncovered Code

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Actions\UpdateEventAction;
use Tests\TestCase;

uses(TestCase::class);

// Use DatabaseTransactions for isolation
beforeEach(function () {
    $this->useDatabase('testing');
});

#[Test]
public function it_updates_event_successfully(): void
{
    // Arrange
    $event = Event::factory()->create(['title' => 'Old Title']);
    $data = ['title' => 'New Title', 'description' => 'Updated'];
    
    // Act
    $result = app(UpdateEventAction::class)->execute($event, $data);
    
    // Assert
    $this->assertEquals('New Title', $result->title);
    $this->assertDatabaseHas('events', ['id' => $event->id, 'title' => 'New Title']);
}

#[Test]
public function it_validates_required_fields(): void
{
    // Arrange
    $event = Event::factory()->create();
    
    // Act & Assert
    $this->expectException(ValidationException::class);
    app(UpdateEventAction::class)->execute($event, []);
}

#[Test]
public function it_fires_event_updated_event(): void
{
    // Arrange
    Event::fake();
    $event = Event::factory()->create();
    
    // Act
    app(UpdateEventAction::class)->execute($event, ['title' => 'New']);
    
    // Assert
    Event::assertDispatched(EventUpdated::class);
}
```

### Feature Test Template for Filament Resources

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Filament;

use Modules\Meetup\Models\Event;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

#[Test]
public function admin_can_view_events_list(): void
{
    // Arrange
    Event::factory(3)->create();
    
    // Act & Assert
    $this->actingAs($this->admin)
        ->get('/admin/events')
        ->assertOk()
        ->assertSeeText('Events');
}

#[Test]
public function admin_can_create_event(): void
{
    // Arrange
    $data = Event::factory()->raw();
    
    // Act & Assert
    $this->actingAs($this->admin)
        ->post('/admin/events', $data)
        ->assertRedirectToRoute('filament.admin.resources.events.index');
    
    $this->assertDatabaseHas('events', ['title' => $data['title']]);
}

#[Test]
public function admin_can_edit_event(): void
{
    // Arrange
    $event = Event::factory()->create();
    $newData = ['title' => 'Updated Title'];
    
    // Act & Assert
    $this->actingAs($this->admin)
        ->patch("/admin/events/{$event->id}", $newData)
        ->assertRedirect();
    
    $event->refresh();
    $this->assertEquals('Updated Title', $event->title);
}
```

## Step 5: Verify Coverage Improvement

### Re-run Coverage Report

```bash
cd laravel

# Run full coverage after implementing tests
php artisan test --coverage --min=100

# Run type coverage
php artisan test --type-coverage --min=100
```

### Check Specific Module Coverage

```bash
# Check if specific module has 100% coverage
php artisan test Modules/Meetup --coverage --min=100

# If it passes, move to next module
php artisan test Modules/User --coverage --min=100
```

### Update SQL Tracking

```sql
UPDATE coverage_modules
SET code_coverage_percent = 100, status = 'done'
WHERE module_name = 'Meetup' AND code_coverage_percent < 100;
```

## Step 6: Module-Specific Gaps to Address

### Action Classes

**Typical Gap**: Exception handling paths not tested

```bash
# Find Action classes
find Modules/*/app/Actions -name "*.php" | xargs grep -l "throw new"

# Each exception path needs a test
```

### Model Relationships

**Typical Gap**: Relationship loaders, eager loading

```bash
# Test relationship accessors
Event::factory()->create();
$event->performers()->attach(Performer::factory()->create());
$this->assertCount(1, $event->performers);  // ← Often missing
```

### Filament Resources

**Typical Gap**: Resource configuration not tested

```bash
# Verify all resource methods are tested
# - getFormSchema()
# - getTableColumns()
# - getTableFilters()
# - getTableActions()
# - getPages()
```

## Continuous Integration

### GitHub Actions Coverage Check

Add to CI/CD workflow:

```yaml
- name: Run coverage
  run: cd laravel && php artisan test --coverage --min=100

- name: Check type coverage
  run: cd laravel && php artisan test --type-coverage --min=100
```

### Local Pre-commit Check

```bash
#!/bin/bash
cd laravel
php artisan test --coverage --min=100 || exit 1
php artisan test --type-coverage --min=100 || exit 1
git add .
```

## Troubleshooting Low Coverage

### Issue: Coverage Not Improving

**Causes**:
1. Tests exist but don't execute the code
2. Code path is truly unreachable (dead code)
3. Test setup incorrect (wrong database, missing factories)

**Solutions**:
```bash
# Verify test runs
php artisan test --filter 'YourTestName' --verbose

# Add dd() in code to verify execution
# Re-run test and check if dd() is hit

# If dd() not hit, test doesn't exercise code path
```

### Issue: Type Coverage Gaps

**Causes**:
1. Missing `declare(strict_types=1);` at top
2. Parameters without types
3. Return types missing

**Solutions**:
```bash
# Find files missing strict types
grep -r "declare(strict_types=1)" Modules/*/app | wc -l

# Find files without return types
grep -r "function.*{" Modules/*/app | grep -v ":" | head -20
```

## References

- [Pest Coverage Docs](https://pestphp.com/docs/test-coverage)
- [Type Coverage Plugin](https://pestphp.com/docs/type-coverage)
- [Testing Guidelines](testing-guidelines.md)
