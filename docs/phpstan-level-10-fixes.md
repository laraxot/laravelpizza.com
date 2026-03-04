# PHPStan Level 10 Fixes - User Module

## Duplicate Method Declaration Fix

### Issue
- **File**: `Modules/User/app/Models/BaseUser.php`
- **Error**: `Cannot redeclare Modules\User\Models\BaseUser::token()`
- **Problem**: Two identical method declarations for `token()` at lines 179 and 197
- **Impact**: Fatal error preventing PHPStan analysis from completing

### Solution
- Removed the duplicate `token()` method declaration at line 197
- Kept the properly overridden method with correct return type and annotation
- Preserved the functionality while eliminating the syntax conflict

### Before
```php
#[\Override]
public function token(): Token|TransientToken|null
{
    /** @var Token|TransientToken|null $token */
    $token = $this->passportToken();

    return $token;
}

#[\Override]
public function tokenCan(string $scope): bool
{
    return $this->passportTokenCan($scope);
}

/**
 * Restituisce il token di accesso corrente garantendo la firma richiesta dal contratto.
 */
#[\Override]
public function token(): Token|TransientToken|null  // DUPLICATE - CAUSING FATAL ERROR
{
    /** @var Token|TransientToken|null $token */
    $token = $this->passportToken();

    return $token;
}
```

### After
```php
#[\Override]
public function token(): Token|TransientToken|null
{
    /** @var Token|TransientToken|null $token */
    $token = $this->passportToken();

    return $token;
}

#[\Override]
public function tokenCan(string $scope): bool
{
    return $this->passportTokenCan($scope);
}
```

### Result
- Fixed fatal error that was preventing PHPStan analysis
- Module now passes PHPStan level 10 analysis
- Maintained all original functionality
- Improved code quality and maintainability

### DRY/KISS Compliance
- Eliminated duplicate code (DRY principle)
- Simplified class structure (KISS principle)
- Maintained consistent method signatures
- Preserved all existing functionality
