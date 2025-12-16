# Cms Module - PHPStan Level 10 Fixes Plan

## Overview

The Cms module has **30 PHPStan errors** that need to be resolved to achieve Level 10 compliance. This document outlines the specific fixes required.

## Error Breakdown

### 1. Missing Function Errors

**Files Affected:**
- `Actions/GetStyleClassAction.php:18`
- `Actions/GetViewThemeByViewAction.php:18`
- `Filament/Front/Pages/Home.php:38`
- `Filament/Front/Pages/Welcome.php:45`

**Issues:**
- `inAdmin` function not found
- `params2ContainerItem` function not found

**Solutions:**
- Create missing helper functions in appropriate locations
- Import existing functions if they exist elsewhere
- Add function declarations to composer autoload files

### 2. Type Safety Issues

**Files Affected:**
- `Filament/Front/Pages/Home.php:38`
- `Filament/Front/Pages/Welcome.php:45`

**Issues:**
- Array destructuring on mixed types
- Property type mismatches

**Solutions:**
- Add proper type hints for array destructuring
- Ensure properties accept correct types
- Add type assertions where needed

### 3. Controller Compatibility

**Files Affected:**
- `Http/Controllers/Admin/XotPanelController.php:16`

**Issues:**
- Method parameter contravariance issues

**Solutions:**
- Update method signatures to match parent class
- Use proper type hints for parameters

### 4. Middleware Return Types

**Files Affected:**
- `Http/Middleware/PageSlugMiddleware.php` (multiple lines)

**Issues:**
- Methods should return `Response` but return `mixed`
- Missing variable documentation

**Solutions:**
- Add proper return type declarations
- Ensure all execution paths return `Response`
- Add missing `@var` PHPDoc tags

### 5. UserContract Compatibility

**Files Affected:**
- `Http/Volt/Password/TokenComponent.php` (multiple lines)

**Issues:**
- Missing properties and methods in UserContract
- Type compatibility with Laravel interfaces

**Solutions:**
- Complete UserContract interface implementation
- Add missing methods and properties
- Ensure compatibility with Laravel authentication

## Implementation Plan

### Phase 1: Missing Functions (Week 1)

1. **Create Helper Functions**
   ```php
   // Create in app/helpers.php or appropriate module location
   function inAdmin(): bool {
       return request()->is('admin/*') || request()->is('admin');
   }

   function params2ContainerItem(array $params): array {
       // Implementation based on existing usage patterns
       return [
           'container' => $params['container'] ?? null,
           'items' => $params['items'] ?? []
       ];
   }
   ```

2. **Update Composer Autoload**
   - Add helper files to composer.json autoload section
   - Run `composer dump-autoload`

### Phase 2: Type Safety (Week 1)

1. **Fix Array Destructuring**
   ```php
   // Before
   [$containers, $items] = params2ContainerItem($params);

   // After
   $result = params2ContainerItem($params);
   $containers = $result['container'] ?? [];
   $items = $result['items'] ?? [];
   ```

2. **Update Property Types**
   ```php
   // Ensure properties accept correct types
   public array $containers = [];
   public array $items = [];
   ```

### Phase 3: Controller & Middleware (Week 2)

1. **Fix Controller Method Signatures**
   ```php
   // Update to match parent class
   public function __call(string $method, array $arg): mixed
   ```

2. **Fix Middleware Return Types**
   ```php
   public function handle($request, Closure $next): Response
   {
       // Ensure all paths return Response
       return $next($request);
   }
   ```

### Phase 4: UserContract (Week 2)

1. **Complete UserContract Interface**
   ```php
   interface UserContract extends Authenticatable
   {
       public function getPassword(): ?string;
       public function setRememberToken(?string $value): void;
       // Add other missing methods
   }
   ```

2. **Update Component Compatibility**
   ```php
   // Ensure User model implements all required methods
   class User extends BaseModel implements UserContract
   {
       public function getPassword(): ?string
       {
           return $this->attributes['password'] ?? null;
       }

       public function setRememberToken(?string $value): void
       {
           $this->attributes['remember_token'] = $value;
       }
   }
   ```

## Testing Strategy

### Unit Tests
- Test all helper functions
- Verify type safety
- Test middleware responses

### Integration Tests
- Test controller method calls
- Verify authentication compatibility
- Test component functionality

### PHPStan Validation
- Run PHPStan after each phase
- Ensure no new errors introduced
- Verify Level 10 compliance

## Success Criteria

- **PHPStan Level 10**: 0 errors
- **All Functions**: Properly defined and imported
- **Type Safety**: No mixed return types
- **Interface Compatibility**: Full Laravel authentication support
- **Code Quality**: Maintain or improve existing functionality

## Risk Assessment

- **Low Risk**: Helper function creation
- **Medium Risk**: Type safety changes
- **High Risk**: UserContract interface changes (affects authentication)

## Rollback Plan

1. Keep original code in comments during changes
2. Create feature branches for each phase
3. Test thoroughly before merging
4. Have database backups available

---

**Estimated Completion**: 2 weeks
**Priority**: High (30 errors affecting core functionality)
**Impact**: Critical UI and authentication components