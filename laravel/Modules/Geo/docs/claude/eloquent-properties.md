# Eloquent Properties

## ⚠️ Critical Restriction: Never Use property_exists() for Magic Properties

### The Problem
Laravel Eloquent models use magic methods (`__get()` and `__set()`) to handle dynamic properties like relationships, accessors, and attributes. The `property_exists()` function will return `false` for these magic properties because they don't exist as real class properties.

### Incorrect Usage
```php
// ❌ Absolutely wrong - will return false for magic properties
if (property_exists($user, 'posts')) {
    // This will never execute for relationship properties
    return $user->posts;
}

// ❌ Wrong for accessors
if (property_exists($user, 'full_name')) {
    // full_name might be an accessor, but property_exists returns false
    return $user->full_name;
}
```

### Correct Usage
```php
// ✅ Always use isset() for magic properties
if (isset($user->posts)) {
    // correctly checks if posts relationship is loaded or accessible
    return $user->posts;
}

// ✅ For accessors and attributes
if (isset($user->full_name)) {
    // correctly handles both real and magic properties
    return $user->full_name;
}

// ✅ Alternative: check if relationship is loaded
if ($user->relationLoaded('posts')) {
    // specifically for relationships
    return $user->posts;
}
```

## When to Use property_exists (Rare Cases)

### Only for Real Class Properties
```php
// ✅ Correct usage - checking for actual class properties
if (property_exists($user, 'fillable')) {
    // $fillable is a real class property
    return $user->fillable;
}

// ✅ Checking for base model properties
if (property_exists($user, 'connection')) {
    // $connection is a real property in eloquent model
    return $user->connection;
}
```

### Never for Model Data Attributes
```php
// ❌ Never do this - attributes are magic properties
if (property_exists($user, 'email')) {
    // $email is a magic attribute, property_exists returns false
    return $user->email;
}

// ✅ Always use isset() for attributes
if (isset($user->email)) {
    // correctly handles both set and unset attributes
    return $user->email;
}
```

## Practical Examples

### Checking Relationship Existence
```php
// ❌ Wrong - property_exists doesn't work for relationships
public function hasPosts(User $user): bool
{
    return property_exists($user, 'posts'); // always false
}

// ✅ Correct - use isset() or relationship methods
public function hasPosts(User $user): bool
{
    return isset($user->posts) && $user->posts->isNotEmpty();
}

// ✅ Better - use relationship method
public function hasPosts(User $user): bool
{
    return $user->posts()->exists();
}
```

### Checking Accessor Availability
```php
// ❌ Wrong - property_exists doesn't work for accessors
public function getFullName(User $user): ?string
{
    if (property_exists($user, 'full_name')) {
        return $user->full_name; // never executes
    }
    return null;
}

// ✅ Correct - use isset() for accessors
public function getFullName(User $user): ?string
{
    if (isset($user->full_name)) {
        return $user->full_name;
    }
    return null;
}

// ✅ Alternative - check if accessor method exists
public function getFullName(User $user): ?string
{
    if (method_exists($user, 'getFullNameAttribute')) {
        return $user->full_name;
    }
    return null;
}
```

## PHPStan Considerations

### False Positives
PHPStan might report errors when using `isset()` on magic properties, but this is the correct approach. You can suppress these warnings when necessary:

```php
// PHPStan might complain about undefined property
if (isset($user->posts)) { // @phpstan-ignore-line
    return $user->posts;
}

// Better: add property to PHPDoc
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 */
class User extends Model
{
    // ...
}
```

## Testing Considerations

### Unit Testing Property Checks
```php
// Test that isset() works correctly
public function test_user_has_posts_relationship(): void
{
    $user = User::factory()->create();
    
    // Initially not set
    $this->assertFalse(isset($user->posts));
    
    // Load relationship
    $user->load('posts');
    
    // Now should be set
    $this->assertTrue(isset($user->posts));
}

// Test that property_exists works only for real properties
public function test_property_exists_only_real_properties(): void
{
    $user = new User();
    
    // Real properties
    $this->assertTrue(property_exists($user, 'fillable'));
    $this->assertTrue(property_exists($user, 'connection'));
    
    // Magic properties (always false)
    $this->assertFalse(property_exists($user, 'email'));
    $this->assertFalse(property_exists($user, 'posts'));
}
```

## Summary

### Always Use isset() for:
- Model attributes (database columns)
- Relationship properties
- Accessors (computed properties)
- Any magic property provided by Eloquent

### Only Use property_exists() for:
- Real class properties defined in the class
- Base Eloquent model properties
- Infrastructure properties (connection, table, etc.)

### Never Use property_exists() for:
- Database attributes
- Relationships
- Accessors
- Any property that might be handled by __get()/__set()

This rule is critical for maintaining correct behavior in Laravel applications and avoiding subtle bugs caused by incorrect property existence checks.

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: eloquent-properties.md - Eloquent property handling guidelines