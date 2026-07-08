# Code Quality

## 🧪 PHPStan (Level 10 Required)

### Quick Commands

```bash
# Basic analysis (Level 10 - configured in phpstan.neon)
vendor/bin/phpstan analyse

# Specific paths
vendor/bin/phpstan analyse app/ Modules/

# Generate baseline (ignore current errors)
vendor/bin/phpstan analyse --generate-baseline

# Clear cache
vendor/bin/phpstan clear-result-cache

# Memory optimization
vendor/bin/phpstan analyse --memory-limit=2G
```

### Common Error Fixes

```php
// ❌ Mixed return type
public function getData()
{
    return $this->data ?? [];
}

// ✅ Explicit return type
public function getData(): array
{
    return $this->data ?? [];
}

// ❌ Missing null check
public function process(User $user)
{
    return $user->profile->name;
}

// ✅ Safe navigation
public function process(User $user): ?string
{
    return $user->profile?->name;
}

// ❌ Array shape unknown
public function config(): array
{
    return config('app');
}

// ✅ Array shape documented
/**
 * @return array{name: string, version: string}
 */
public function config(): array
{
    return config('app');
}
```

### Type Declarations

```php
// Property types
public string $name;
public ?User $user = null;
public Collection $items;

// Method parameters
public function process(int $id, ?string $name = null): bool

// Array shapes
/**
 * @param array{id: int, name: string} $data
 */
public function handle(array $data): void

// Generics
/**
 * @return Collection<int, User>
 */
public function getUsers(): Collection
```

### Module-Specific Rules

- Each module must pass Level 10 (maximum strictness)
- No `@phpstan-ignore-line` without justification
- Document all array shapes in complex returns
- Use strict property types for all new classes

## 🧪 Testing (Pest)

### Quick Commands

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter="test_name"

# Run module tests
php artisan test Modules/ModuleName/tests/

# Coverage report
php artisan test --coverage

# Parallel execution
php artisan test --parallel
```

### Test Patterns

```php
// Basic test
test('description', function () {
    expect($result)->toBe($expected);
});

// Model test
test('model works', function () {
    $model = Model::factory()->create();
    expect($model)->toBeInstanceOf(Model::class);
});

// Filament test
livewire(ListResources::class)
    ->assertCanSeeTableRecords($records);

// Volt test  
Volt::test('component')
    ->set('property', 'value')
    ->call('method')
    ->assertHasNoErrors();

// API test
$this->postJson('/api/endpoint', $data)
    ->assertSuccessful()
    ->assertJson(['status' => 'success']);
```

### Essential Assertions

```php
expect($value)
    ->toBe($expected)           // Exact match
    ->toEqual($expected)        // Loose match
    ->toBeTrue()               // Boolean true
    ->toBeNull()               // Null check
    ->toBeInstanceOf(Class::class)  // Type check
    ->toHaveCount(3)           // Collection count
    ->toContain($item)         // Array/collection contains
```

## 🧪 PHPMD (PHP Mess Detector)

PHPMD is used to detect potential problems in the code:

```bash
# Run PHPMD analysis
./vendor/bin/phpmd app,Modules text phpmd-ruleset.xml
```

## 🧪 PHP Insights

PHP Insights analyzes code quality:

```bash
# Run PHP Insights
./vendor/bin/phpinsights
```

## 🧪 Rector

Rector performs automated refactoring:

```bash
# Run Rector dry-run to see changes
./vendor/bin/rector process --dry-run

# Apply Rector changes
./vendor/bin/rector process
```

## 📋 Quality Checklist

### Before Every Commit
- [ ] Code passes PHPStan Level 10
- [ ] All tests pass
- [ ] PSR-12 formatting is correct
- [ ] PHPDoc complete for properties and methods
- [ ] Strict typing implemented
- [ ] Error handling appropriate
- [ ] Security and validation implemented

### For New Features
- [ ] Unit tests written
- [ ] Integration tests implemented
- [ ] Performance optimized
- [ ] Cache strategy implemented
- [ ] Queue for heavy operations
- [ ] Appropriate logging
- [ ] Documentation updated

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: code-quality.md - Code quality tools and standards