# PHPStan Error Resolution Roadmap - User Module

## Executive Summary
The User module handles authentication, authorization, and user management. It's a critical component that requires PHPStan compliance to ensure security and stability.

## Current Status (as of 2026-01-21)
- **PHPStan Errors**: Multiple errors across key files
- **Error Categories**:
  - Missing property type declarations
  - Collection callback type mismatches
  - Class not found errors
  - Passport model type mismatches
- **Risk Level**: HIGH - Authentication/authorization errors affect security
- **Target**: 0 errors at PHPStan Level 10

## Error Analysis by File

### 1. Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php
- **Issues**:
  - Line 32: Property `$listeners` has no type specified
- **Fix Strategy**: Add proper property type declaration

### 2. Modules/User/app/Filament/Clusters/Socialite/Resources/SocialiteUserResource/Pages/ViewSocialiteUser.php
- **Issues**:
  - Line 41: Anonymous function return type mismatch (should return string|null but returns mixed)
  - Line 41: Unknown class reference to UserResource
- **Fix Strategy**: Add proper return type and fix class reference

### 3. Modules/User/app/Models/Traits/HasTeams.php
- **Issues**:
  - Line 184: Collection::flatMap() callback type mismatch
  - Template type resolution issues
- **Fix Strategy**: Add proper callback typing

### 4. Modules/User/app/Providers/EventServiceProvider.php
- **Issues**:
  - Line 36: Class `Modules\User\Providers\SocialiteWasCalled` not found
  - Line 37: Class `Modules\User\Providers\Auth0ExtendSocialite` not found
- **Fix Strategy**: Either create missing classes or remove references

### 5. Modules/User/app/Providers/PassportServiceProvider.php
- **Issues**:
  - Lines 104, 106, 108, 110: Parameter type mismatches for Passport model methods
- **Fix Strategy**: Use proper class-string types

### 6. Migration Files with Unsafe Function Usage
- **Issues**:
  - Unsafe `file_put_contents` usage in multiple migrations
- **Fix Strategy**: Add Safe library imports

## Implementation Plan

### Phase 1: Property Type Declarations (Day 1)
- [ ] Add type to `$listeners` property in PassportDashboard.php
- [ ] Verify property functionality after typing

### Phase 2: Collection Callback Fixes (Day 1)
- [ ] Fix callback types in HasTeams trait
- [ ] Add proper parameter and return types to Collection operations
- [ ] Test team functionality after changes

### Phase 3: Filament Component Fixes (Day 2)
- [ ] Fix return type in ViewSocialiteUser.php
- [ ] Resolve unknown class reference
- [ ] Test Socialite user functionality

### Phase 4: Service Provider Cleanup (Day 2)
- [ ] Address missing class references in EventServiceProvider
- [ ] Fix Passport model type issues
- [ ] Verify authentication functionality remains intact

### Phase 5: Migration Safe Library Integration (Day 3)
- [ ] Add Safe library imports to migration files
- [ ] Replace unsafe file_put_contents with Safe equivalent
- [ ] Test migration functionality

### Phase 6: Verification (Day 3)
- [ ] Run PHPStan on User module
- [ ] Execute authentication and authorization tests
- [ ] Verify all User module functionality works
- [ ] Test dependent modules still function

## Technical Implementation Details

### Property Type Declaration Pattern
```php
// Before
public $listeners = [];

// After
public array $listeners = [];
```

### Collection Callback Pattern
```php
// Before
->flatMap(function ($item) {
    return something;
})

// After - with proper typing
->flatMap(function (Type $item, int $key): array {
    return something;
})
```

### Class-string Type Pattern
```php
// Before
Passport::useTokenModel($modelClass);

// After
Passport::useTokenModel(UserToken::class); // where UserToken extends Passport\Token
```

### Safe Library Pattern for Migrations
```php
// At the top of the migration file
use function Safe\file_put_contents;

// Then use normally
file_put_contents($path, $content);
```

## Risk Mitigation
- [ ] Test authentication flow after each change
- [ ] Verify authorization policies remain functional
- [ ] Check that user management still works
- [ ] Ensure Passport integration continues to function
- [ ] Validate team functionality after HasTeams trait fixes

## Success Metrics
- [ ] 0 PHPStan errors in User module
- [ ] All authentication functionality preserved
- [ ] Authorization policies continue to work
- [ ] User management features remain functional
- [ ] Passport and Socialite integrations work properly
- [ ] No security vulnerabilities introduced