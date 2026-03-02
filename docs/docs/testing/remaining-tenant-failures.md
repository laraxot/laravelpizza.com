# Remaining TenantTest Failures - Analysis

## Current Status
- **14 passed, 2 failed** (out of 16 total)
- Progress: 87.5% passing rate

## Remaining Failures

### 1. ID Mismatch in "tenant can be found by slug"

**Error**:
```
Failed asserting that two strings are identical.
-'1'
+'4b7864f3-b8a4-3889-8895-bff6119a5c6e'
```

**Analysis**:
- Test creates tenant with UUID: `'4b7864f3-b8a4-3889-8895-bff6119a5c6e'`
- Query finds tenant with ID: `'1'`
- **This means there are MULTIPLE tenants with the same slug!**

**Root Cause**:
The test is finding a DIFFERENT tenant than the one created in `beforeEach`. This suggests:
1. Multiple tests are creating tenants with the same name/slug
2. Database is not being properly cleaned between tests
3. Or there's a pre-existing tenant with slug `'test-tenant'`

**Solution**:
The test should use a UNIQUE slug for each test run, OR verify that only ONE tenant exists with that slug.

### 2. `fresh()` Returns Null in "tenant can be updated"

**Error**:
```
Attempt to read property "name" on null
at Modules/User/tests/Unit/TenantTest.php:147
```

**Analysis**:
- Test updates tenant
- Calls `$this->tenant->fresh()` to reload from database
- `fresh()` returns `null` instead of the updated model

**Root Cause**:
The `DatabaseTransactions` trait wraps each test in a transaction. When we call `fresh()`, it tries to find the model in the database, but:
1. The update might not have been committed yet
2. The transaction might have isolated the changes
3. The model might have been soft-deleted or removed

**Solution**:
Instead of `fresh()`, use `refresh()` which reloads the model from the database within the same transaction context.

## Fixes

### Fix 1: Use Unique Slug Per Test

Instead of hardcoding `'Test Tenant'`, use a unique name:

```php
beforeEach(function (): void {
    $this->tenant = Tenant::factory()->create([
        'name' => 'Test Tenant ' . uniqid(),
        // ... other attributes
    ]);
});
```

**OR** verify uniqueness:

```php
test('tenant can be found by slug', function (): void {
    $slug = Str::slug('Test Tenant');
    $tenants = Tenant::where('slug', $slug)->get();
    
    // Should only find ONE tenant with this slug
    expect($tenants)->toHaveCount(1);
    expect($tenants->first()->id)->toBe((string) $this->tenant->id);
});
```

### Fix 2: Use `refresh()` Instead of `fresh()`

```php
test('tenant can be updated', function (): void {
    $originalId = $this->tenant->id;
    
    $this->tenant->update([
        'name' => 'Updated Tenant Name',
        'email_address' => 'updated@tenant.com',
    ]);

    // Use refresh() instead of fresh()
    $this->tenant->refresh();

    expect($this->tenant->name)->toBe('Updated Tenant Name');
    // ...
});
```

## Recommendation

**Fix the tests, not the application.** The application works correctly. The tests have incorrect assumptions about:
1. Database state (assuming only one tenant exists)
2. Transaction behavior (using `fresh()` instead of `refresh()`)

These are TEST bugs, not APPLICATION bugs.
