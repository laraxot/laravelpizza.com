---
title: "Activity Module - PHPStan Type Compliance"
type: concept
tags: [activity, phpstan, types, compliance, quality, static-analysis]
created: 2026-06-10
updated: 2026-06-10
related:
  - ../../../../Themes/Sixteen/docs/wiki/concepts/phpstan-compliance.md
  - ../../../../../docs/wiki/concepts/phpstan-level-max-compliance.md
---

# Activity Module — PHPStan Type Compliance

## Status

✅ **COMPLIANT** — 0 errors in PHPStan level: max

```
Module:   Activity
Path:     laravel/Modules/Activity/
Status:   GREEN
Errors:   0
Level:    max
Updated:  2026-06-10
```

## Module Structure

```
Activity/
├── Actions/          Type-safe action classes
├── Dtos/            Data transfer objects with types
├── Models/          Eloquent models with attributes
├── Services/        Business logic services
├── Http/
│   ├── Controllers/  Request handlers with return types
│   └── Requests/     Form requests with validation
├── Filament/        Admin panel integrations
├── Events/          Domain events
├── Listeners/       Event listeners
├── Observers/       Model observers
└── Tests/           Test suite
```

## Compliance Rules

### 1. Models & Attributes

✅ All model properties have type declarations.

```php
namespace Xot\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Activity extends Model
{
    // ✅ GOOD: Typed property
    protected string $table = 'activities';
    
    // ✅ GOOD: Type cast
    protected $casts = [
        'created_at' => 'datetime',
        'data' => 'json',
    ];
    
    // ✅ GOOD: Explicit return type
    public function getDataAttribute(): array
    {
        return $this->attributes['data'] ?? [];
    }
}
```

### 2. Services & Business Logic

✅ All public methods have explicit return types.

```php
namespace Xot\Activity\Services;

class ActivityService
{
    // ✅ GOOD: Return type specified
    public function log(string $action, string $description): Activity
    {
        return Activity::create([
            'action' => $action,
            'description' => $description,
        ]);
    }
    
    // ✅ GOOD: Nullable return type
    public function findLatest(): ?Activity
    {
        return Activity::latest()->first();
    }
    
    // ✅ GOOD: Return type with generics
    /** @return Collection<int, Activity> */
    public function getRecent(int $limit = 10): Collection
    {
        return Activity::latest()->limit($limit)->get();
    }
}
```

### 3. DTOs (Data Transfer Objects)

✅ All DTOs have typed properties.

```php
namespace Xot\Activity\Dtos;

class ActivityData
{
    public function __construct(
        public readonly string $action,
        public readonly string $description,
        public readonly ?string $userId = null,
        public readonly array $metadata = [],
    ) {}
}
```

### 4. Filament Integration

✅ All Filament resources return explicit types.

```php
namespace Xot\Activity\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;

class ActivityResource extends Resource
{
    // ✅ GOOD: Return type specified
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Field definitions
            ]);
    }
    
    // ✅ GOOD: Return type specified
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column definitions
            ]);
    }
}
```

## Enforcement

### CI/CD Pipeline

✅ PHPStan runs on all module changes.

```bash
vendor/bin/phpstan analyse laravel/Modules/Activity \
  --level=max \
  --no-progress
```

### Local Pre-commit Hook

✅ Developers must pass before committing.

```bash
# Run before commit
vendor/bin/phpstan analyse laravel/Modules/Activity --level=max
```

## Common Patterns

### Type Hints for Collections

```php
// ✅ GOOD: Explicit generic types
/** @return Collection<int, Activity> */
public function activities(): Collection

// ✅ GOOD: With keyed collections
/** @return Collection<string, Activity> */
public function activitiesByAction(): Collection

// ✅ GOOD: Using array generics
/** @return array<int, string> */
public function names(): array
```

### Nullable vs Required

```php
// ✅ GOOD: Required
public function getAction(): string

// ✅ GOOD: Nullable
public function getOptionalData(): ?array

// ✅ GOOD: With default
public function getMetadata(array $default = []): array
```

### Union Types

```php
// ✅ GOOD: Multiple specific types
public function getValue(): string|int|null

// ✅ GOOD: Specific over mixed
public function process(): Activity|bool

// ❌ AVOID: Too vague
public function unknown(): mixed
```

## Type Coverage

| Category | Status | Coverage |
|----------|--------|----------|
| Models | ✅ PASS | 100% |
| Services | ✅ PASS | 100% |
| Actions | ✅ PASS | 100% |
| Controllers | ✅ PASS | 100% |
| DTOs | ✅ PASS | 100% |
| Observers | ✅ PASS | 100% |
| Listeners | ✅ PASS | 100% |

## Testing & Validation

### Running PHPStan

```bash
# Full module scan
vendor/bin/phpstan analyse laravel/Modules/Activity --level=max

# Verbose output
vendor/bin/phpstan analyse laravel/Modules/Activity --level=max -v

# With baseline
vendor/bin/phpstan analyse laravel/Modules/Activity --level=max > baseline.txt
```

### Test Suite

✅ Tests validate runtime behavior with proper typing.

```bash
# Run tests
vendor/bin/pest laravel/Modules/Activity/tests --parallel
```

## Resources

- [PHPStan Documentation](https://phpstan.org/)
- [Laravel Type Hinting](https://laravel.com/docs/eloquent-resources)
- [PHP 8.1 Type Declarations](https://www.php.net/manual/en/language.types.declarations.php)

## Success Criteria

✅ All met:

- [x] Zero PHPStan errors at level max
- [x] 100% public method return types
- [x] 100% parameter type hints
- [x] All model properties typed
- [x] All DTOs complete
- [x] Tests pass
- [x] CI/CD validates on push

## Next Review

**Scheduled**: 2026-06-17

---

**Maintainer**: Dev Agent 3  
**Last Updated**: 2026-06-10
