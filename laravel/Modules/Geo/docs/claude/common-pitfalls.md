# Common Pitfalls

## ⚠️ Critical Eloquent Property Handling

### NEVER Use property_exists() with Eloquent Models

**This is a CRITICAL ERROR that causes un<nome progetto>able behavior.**

#### ❌ Anti-Pattern (Never Do This)
```php
// ❌ GRAVELY WRONG - NEVER DO THIS
if (property_exists($user, 'full_name') && $user->full_name) {
    return $user->full_name;
}

if (property_exists($model, 'email') && $model->email) {
    return $model->email;
}
```

#### ✅ Correct Patterns
```php
// ✅ CORRECT - Use isset for magic properties
if (isset($user->full_name) && $user->full_name) {
    return $user->full_name;
}

if (isset($model->email) && $model->email) {
    return $model->email;
}

// ✅ CORRECT - Use null coalescing
if ($user->full_name ?? false) {
    return $user->full_name;
}

// ✅ CORRECT - Use hasAttribute for database properties
if ($model->hasAttribute('email') && $model->email) {
    return $model->email;
}

// ✅ CORRECT - Use hasGetMutator for accessors
if ($model->hasGetMutator('full_name') && $model->full_name) {
    return $model->full_name;
}

// ✅ CORRECT - Use method_exists for methods
if (method_exists($user, 'getFullName')) {
    return $user->getFullName();
}
```

#### When to Use property_exists
`property_exists()` can be used ONLY with:
1. **Standard PHP classes** (not Eloquent models)
2. **Objects without magic methods**
3. **Explicitly declared properties**

### Critical Motivation
- **Dynamic properties**: Eloquent models create properties dynamically when accessing database columns
- **Lazy loading**: Relationships and some properties don't exist until accessed
- **Accessors/Mutators**: Computed properties may not be detected correctly
- **Magic properties**: Laravel uses `__get()` and `__set()` for property access
- **Un<nome progetto>able behavior**: Can cause difficult-to-debug bugs and unexpected behavior

## 🚫 Other Common Pitfalls

### Forgetting Strict Types
```php
// ❌ WRONG
class SomeClass
{
    public function process($data) { ... }
}

// ✅ CORRECT
declare(strict_types=1);

class SomeClass
{
    public function process(array $data): bool { ... }
}
```

### Hardcoding Filament Labels
```php
// ❌ WRONG
TextInput::make('name')->label('Nome');

// ✅ CORRECT
TextInput::make('name') // Automatic translation
```

### Incorrect Module Namespace
```php
// ❌ WRONG
namespace Modules\User\App\Models;

// ✅ CORRECT
namespace Modules\User\Models;
```

### Not Using Actions for Business Logic
```php
// ❌ WRONG
class SomeService
{
    public function doSomething() { ... }
}

// ✅ CORRECT
class DoSomethingAction
{
    use QueueableAction;
    
    public function execute() { ... }
}
```

## 🎯 KISS and DRY Improvements

### After Fixing property_exists(), Apply These Patterns:

#### 1. **Null Coalescing Chain (`??`)**
```php
// ✅ CORRECT - Robust property handling
$value = $model->primary_property ?? $model->secondary_property ?? $model->fallback_property ?? 'default';
```

#### 2. **Null Safe Operator (`?.`)**
```php
// ✅ CORRECT - Safe nested property access
$value = $model?->relation?->property ?? 'default';
```

#### 3. **Early Return**
```php
// ✅ CORRECT - Handle edge cases early
if (!is_object($model)) {
    return 'default';
}
// Simplified main logic
```

### Anti-Patterns to Avoid

#### ❌ Repetitive Checks
```php
// ❌ WRONG - Repetitive pattern
if (isset($model->prop1) && $model->prop1) {
    return $model->prop1;
}
if (isset($model->prop2) && $model->prop2) {
    return $model->prop2;
}
```

#### ❌ Unnecessary Temporary Variables
```php
// ❌ WRONG - Unnecessary temporary variables
$temp = $model->relation;
if ($temp) {
    $result = $temp->property;
    return $result;
}
```

### Improvement Checklist
1. **Can we use null coalescing (`??`)?**
2. **Can we use the null safe operator (`?.`)?**
3. **Can we eliminate repetitive checks?**
4. **Can we use early return?**
5. **Can we eliminate temporary variables?**
6. **Is the code more readable and maintainable?**

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: common-pitfalls.md - Common mistakes to avoid