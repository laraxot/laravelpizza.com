# Trait Alias Conflict Resolution

## Problem
During `composer update`, PHP 8.3 strict typing detected a duplicate `teams()` method in `BaseUser.php`. Both `HasSpatiePermission` and `HasTeams` traits define a `teams()` method, causing a fatal error.

## Solution
Alias the `teams()` method from `HasSpatiePermission` trait to `spatieTeams()` to avoid collision with `HasTeams::teams()`.

## Implementation

### File: `Modules/User/app/Models/BaseUser.php`

```php
use HasSpatiePermission {
    teams as spatieTeams; // alias to avoid collision
}
use HasTeams {
    teams as userTeams; // trait method alias
}
```

This allows both traits to coexist while providing unique method names:
- `$user->teams()` → uses `HasTeams::teams()` (user's teams)
- `$user->spatieTeams()` → uses `HasSpatiePermission::teams()` (Spatie permission teams)

## Error Message
```
Fatal error: Modules\User\Models\BaseUser cannot use 
Modules\User\Models\Traits\HasSpatiePermission and 
Modules\User\Models\Traits\HasTeams - they define 
conflicting aliased trait method teams()
```

## Verification
```bash
composer dump-autoload
php artisan package:discover
```
Both commands should complete without errors.

## Related
- Laravel 12 upgrade notes
- PHP 8.3 strict typing requirements
- Trait method aliasing pattern
