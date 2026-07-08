# QueueableAction Architecture Rule

> **Philosophy**: Single-responsibility actions that can be queued or run synchronously.  
> **Package**: [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)  
> **Religion**: NEVER use Services, ALWAYS use QueueableActions.

## The Rule (DRY + KISS)

```
┌─────────────────────────────────────────────────────────────┐
│  ❌ BANNED: Services (Modules/*/Services AND laravel/app/Services) │
│  ❌ BANNED: App\Services\* (fuori nwidart)                    │
│  ✅ REQUIRED: Modules/{Modulo}/app/Actions/*Action + QueueableAction │
└─────────────────────────────────────────────────────────────┘
```

### ❌ NEVER DO THIS

```php
// WRONG - Service pattern is BANNED
namespace Modules\Fixcity\Services;

class TicketCategoryService  // ❌ NEVER CREATE SERVICES
{
    public function getCategories() { ... }
    public function countByType() { ... }
    public function doEverything() { ... }  // Grows into god class
}
```

### ✅ ALWAYS DO THIS

```php
// CORRECT - QueueableAction pattern
<?php

declare(strict_types=1);

namespace Modules\Fixcity\Actions;

use Spatie\QueueableAction\QueueableAction;

class BuildTicketCategoriesFromGeoJsonAction
{
    use QueueableAction;

    public function __construct(
        protected string $geoJsonPath,
        protected array $typeConfig,
    ) {}

    public function handle(): array
    {
        // Single responsibility: parse GeoJSON and return categories
        return $this->parseAndEnrich();
    }
}
```

## Why QueueableAction?

| Aspect | Service | QueueableAction | Winner |
|--------|---------|-----------------|--------|
| **Single Responsibility** | ❌ Often grows into god class | ✅ Enforced by pattern | QueueableAction |
| **Queuable** | ❌ Cannot be queued | ✅ `->onQueue()` support | QueueableAction |
| **Synchronous** | ✅ Can run sync | ✅ `->execute()` support | Tie |
| **Testability** | ⚠️ Requires mocking | ✅ Easy to test | QueueableAction |
| **Consistency** | ❌ Each dev does differently | ✅ Standardized pattern | QueueableAction |
| **Type Safety** | ⚠️ Varies | ✅ Constructor injection | QueueableAction |

## Pattern Structure

### 1. Basic Action

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Actions;

use Spatie\QueueableAction\QueueableAction;

/**
 * Action description here.
 * 
 * @see https://github.com/spatie/laravel-queueable-action
 */
class DoSomethingAction
{
    use QueueableAction;

    public function __construct(
        protected string $param1,
        protected array $param2,
    ) {
        // Validation in constructor
        if (empty($param1)) {
            throw new \InvalidArgumentException('param1 is required');
        }
    }

    public function handle(): ResultType
    {
        // Business logic here
        return $result;
    }
}
```

### 2. Usage Patterns

```php
// Synchronous execution (default)
$result = (new DoSomethingAction($arg1, $arg2))->execute();

// Queued execution
$result = (new DoSomethingAction($arg1, $arg2))
    ->onQueue('default')
    ->execute();

// With specific connection
$result = (new DoSomethingAction($arg1, $arg2))
    ->onConnection('redis')
    ->onQueue('heavy')
    ->execute();
```

### 3. In ViewModels

```php
namespace Modules\Fixcity\ViewModels;

use Illuminate\Support\Facades\Cache;
use Modules\Fixcity\Actions\BuildTicketCategoriesFromGeoJsonAction;

class TicketLayoutViewModel
{
    public function dynamicFilters(): array
    {
        return Cache::remember('key', 300, function () {
            $action = new BuildTicketCategoriesFromGeoJsonAction(
                geoJsonPath: public_path('/data/tickets.json'),
                typeConfig: config('fixcity.types'),
            );
            
            return $action->execute();
        });
    }
}
```

## File Structure

```
Modules/{Module}/
├── app/
│   ├── Actions/           # ← QueueableActions here
│   │   ├── DoSomethingAction.php
│   │   ├── ProcessDataAction.php
│   │   └── SendNotificationAction.php
│   ├── ViewModels/        # ← Use Actions in ViewModels
│   │   └── SomeViewModel.php
│   └── ...
```

## Naming Conventions

| Pattern | Example | Description |
|---------|---------|-------------|
| Action suffix | `BuildTicketCategoriesAction` | Always end with `Action` |
| Verb + Noun | `SendEmailAction` | Start with verb |
| Descriptive | `GenerateReportFromJsonAction` | Describe what it does |

## Testing

```php
<?php

namespace Modules\Fixcity\Tests\Unit\Actions;

use Modules\Fixcity\Actions\BuildTicketCategoriesFromGeoJsonAction;
use PHPUnit\Framework\TestCase;

class BuildTicketCategoriesFromGeoJsonActionTest extends TestCase
{
    public function test_it_parses_geojson(): void
    {
        $action = new BuildTicketCategoriesFromGeoJsonAction(
            geoJsonPath: base_path('tests/fixtures/tickets.json'),
            typeConfig: ['parks' => ['label' => 'Parks', 'icon' => 'tree', 'color' => '#00ff00']],
        );
        
        $result = $action->execute();
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('count', $result[0]);
    }
}
```

## Configuration

```php
// config/queuableaction.php
<?php

use Spatie\QueueableAction\ActionJob;

return [
    'job_class' => ActionJob::class,
];
```

## Common Mistakes to Avoid

### ❌ Mistake 1: Creating Services

```php
// DON'T
class UserService { ... }
```

### ✅ Correct: Create Actions

```php
// DO
class CreateUserAction { ... }
class UpdateUserAction { ... }
class DeleteUserAction { ... }
```

### ❌ Mistake 2: Logic in ViewModels

```php
// DON'T - Heavy logic in ViewModel
class SomeViewModel {
    public function getData(): array {
        // Complex parsing, API calls, file reading...
        // This should be in an Action!
    }
}
```

### ✅ Correct: Delegate to Action

```php
// DO
class SomeViewModel {
    public function getData(): array {
        return (new FetchAndProcessDataAction($this->params))->execute();
    }
}
```

## Examples from Codebase

### CreateUserAction (Modules/User)

```php
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction {
    use QueueableAction;
    
    public function __construct(
        protected string $name,
        protected string $email,
        protected string $password,
    ) {}
    
    public function handle(): User {
        // Create user
        // Send welcome email
        // Create audit log
        return $user;
    }
}
```

### GenerateTicketsJsonAction (Modules/Fixcity)

```php
use Spatie\QueueableAction\QueueableAction;

class GenerateTicketsJsonAction {
    use QueueableAction;
    
    public function handle(): array {
        // Generate GeoJSON
        return $geoJson;
    }
}
```

## Quick Reference

```php
// 1. Create Action
class MyAction {
    use QueueableAction;
    public function __construct(protected array $data) {}
    public function handle(): Result { ... }
}

// 2. Use Action
$result = (new MyAction($data))->execute();

// 3. Queue Action
$result = (new MyAction($data))->onQueue('default')->execute();

// 4. In ViewModel
return (new MyAction($this->data))->execute();

// 5. Test Action
$action = new MyAction($testData);
$result = $action->execute();
$this->assertEquals($expected, $result);
```

## References

- [Spatie Laravel Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Queues Documentation](https://laravel.com/docs/queues)
- [Single Responsibility Principle](https://en.wikipedia.org/wiki/Single-responsibility_principle)

---

**Remember**: When in doubt, create a QueueableAction. Never create a Service.
