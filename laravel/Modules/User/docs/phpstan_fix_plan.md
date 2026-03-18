# User Module - PHPStan Level 10 Fix Plan

## Analysis Date
2026-03-02

## Error Summary
**Total Errors**: 7+ errors across 10+ files

## Error Analysis

### 1. UserContract Property/Method Access (Major Impact)

**Files Affected**:
- `app/Models/Policies/UserPolicy.php` (Multiple lines)
- `app/Models/Policies/TeamPolicy.php` (Multiple lines)
- `app/Models/Policies/BaseUserPolicy.php` (Multiple lines)
- `app/Console/Commands/**/*.php` (Multiple lines)
- `app/Actions/Passport/**/*.php` (Multiple lines)
- `app/Actions/Socialite/**/*.php` (Multiple lines)

**Common Issues**:
- Access to undefined property `UserContract::$id`
- Access to undefined property `UserContract::$email`
- Access to undefined property `UserContract::$type`
- Access to undefined property `UserContract::$exists`
- Call to undefined method `UserContract::getKey()`

**Root Cause**: UserContract interface doesn't define these properties and methods

**Fix Strategy**:

This is the **highest priority fix** and will be addressed in the Xot module. Once UserContract is updated with all missing properties and methods, all these errors will be automatically resolved.

**See**: `laravel/Modules/Xot/docs/PHPSTAN_FIX_PLAN_2026-03-02.md`

### 2. User Model Inheritance (1 error)

**File**: `app/Models/User.php:112`

**Issue**: Interface `UserContract` requires implementing class to extend `Modules\Xot\Contracts\Model`, but `Modules\Fixcity\Models\User` does not

**Root Cause**: Fixcity's User model doesn't extend the required base class

**Fix Strategy**:

Check the base class hierarchy:

```php
// Current Fixcity User
namespace Modules\Fixcity\Models;

class User extends \Modules\User\Models\User
{
    // Implementation
}
```

Check if `\Modules\User\Models\User` extends `Modules\Xot\Contracts\Model`:

```php
// In Modules/User/Models/User.php
namespace Modules\User\Models;

class User extends BaseUser implements \Modules\Xot\Contracts\UserContract
{
    // Implementation
}
```

Check BaseUser:

```php
// In Modules/User/Models/BaseUser.php
namespace Modules\User\Models;

abstract class BaseUser extends \Modules\Xot\Models\XotBaseModel
{
    // Implementation
}
```

Check XotBaseModel:

```php
// In Modules/Xot/Models/XotBaseModel.php
namespace Modules\Xot\Models;

abstract class XotBaseModel extends \Illuminate\Database\Eloquent\Model implements \Modules\Xot\Contracts\Model
{
    // Implementation
}
```

**Resolution**:

If the inheritance chain is correct, the error might be a false positive. However, ensure the fix:

```php
// In Modules/Fixcity/Models/User.php
namespace Modules\Fixcity\Models;

use Modules\User\Models\User as BaseUser;

class User extends BaseUser
{
    // Already extends BaseUser which implements UserContract
    // This should resolve the issue
}
```

### 3. BaseUser Model (Related to UserContract)

**File**: `app/Models/BaseUser.php`

**Issue**: Related to UserContract property/method access

**Fix Strategy**:

Ensure BaseUser has all required properties and methods:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Contracts\UserContract;

/**
 * Base User Model
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Modules\User\Database\Factories\UserFactory factory()
 */
abstract class BaseUser extends XotBaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    UserContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return HasMany<\Modules\User\Models\TeamInvitation, $this>
     */
    public function teamInvitations(): HasMany
    {
        return $this->hasMany(\Modules\User\Models\TeamInvitation::class);
    }

    /**
     * @return HasOne<\Modules\User\Models\Team, $this>
     */
    public function currentTeam(): HasOne
    {
        return $this->hasOne(\Modules\User\Models\Team::class)->latestOfMany();
    }
}
```

### 4. BaseTeam Model (Related to UserContract)

**File**: `app/Models/BaseTeam.php`

**Issue**: Related to UserContract property/method access

**Fix Strategy**:

Ensure BaseTeam has proper relationships with User:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Xot\Models\XotBaseModel;

/**
 * Base Team Model
 *
 * @property int $id
 * @property string $name
 * @property int|null $user_id
 * @property string|null $personal_team
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\User\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\TeamUser> $users
 * @property-read int|null $users_count
 * @method static \Modules\User\Database\Factories\TeamFactory factory()
 */
abstract class BaseTeam extends XotBaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'personal_team',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'personal_team' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<\Modules\User\Models\User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'user_id');
    }

    /**
     * @return HasMany<\Modules\User\Models\TeamUser, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(\Modules\User\Models\TeamUser::class);
    }
}
```

### 5. Policy Classes (UserContract Access)

**Files**:
- `app/Models/Policies/UserPolicy.php`
- `app/Models/Policies/TeamPolicy.php`
- `app/Models/Policies/BaseUserPolicy.php`

**Issue**: Accessing UserContract properties that aren't defined

**Fix Strategy**:

These will be fixed automatically when UserContract is updated. However, ensure policies are properly typed:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;

class UserPolicy
{
    /**
     * Determine if the user can update the profile.
     *
     * @param UserContract $user
     * @param User $profile
     * @return bool
     */
    public function update(UserContract $user, User $profile): bool
    {
        // This will work once UserContract is updated
        return $user->id === $profile->id;
    }

    /**
     * Determine if the user can delete the profile.
     *
     * @param UserContract $user
     * @param User $profile
     * @return bool
     */
    public function delete(UserContract $user, User $profile): bool
    {
        return $user->id === $profile->id;
    }
}
```

### 6. Console Commands (UserContract Access)

**Files**: `app/Console/Commands/**/*.php`

**Issue**: Accessing UserContract methods that aren't defined

**Fix Strategy**:

These will be fixed automatically when UserContract is updated. Ensure commands are properly typed:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;

class ExampleCommand extends Command
{
    protected $signature = 'user:example';

    protected $description = 'Example command';

    public function handle(): int
    {
        /** @var UserContract $user */
        $user = User::first();

        if (!$user) {
            $this->error('No user found');
            return self::FAILURE;
        }

        // This will work once UserContract is updated
        $this->info("User ID: {$user->id}");
        $this->info("User Email: {$user->email}");

        return self::SUCCESS;
    }
}
```

### 7. Actions (UserContract Access)

**Files**:
- `app/Actions/Passport/**/*.php`
- `app/Actions/Socialite/**/*.php`

**Issue**: Accessing UserContract methods that aren't defined

**Fix Strategy**:

These will be fixed automatically when UserContract is updated. Ensure actions are properly typed:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;

class CreateTokenAction
{
    /**
     * Execute the action.
     *
     * @param UserContract $user
     * @param string $name
     * @param array<string, mixed> $abilities
     * @return string
     */
    public function execute(UserContract $user, string $name, array $abilities = []): string
    {
        // This will work once UserContract is updated
        /** @var User $typedUser */
        $typedUser = $user;

        return $typedUser->createToken($name, $abilities)->plainTextToken;
    }
}
```

## Implementation Steps

### Step 1: Wait for UserContract Update
The UserContract interface must be updated first in the Xot module.

### Step 2: Verify BaseUser and BaseTeam
Ensure both base models have all required properties and methods.

### Step 3: Verify Fixcity User
Ensure Fixcity's User model extends the correct base class.

### Step 4: Update Policy Classes
Verify all policies have proper type annotations.

### Step 5: Update Console Commands
Verify all commands have proper type annotations.

### Step 6: Update Actions
Verify all actions have proper type annotations.

### Step 7: Run PHPStan
```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/User --level=10 --memory-limit=2G
```

### Step 8: Update Tests
- Test policy classes
- Test console commands
- Test actions

## Testing Strategy

### Unit Tests

```php
test('UserPolicy allows user to update own profile', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $policy = new UserPolicy();

    expect($policy->update($user, $user))->toBeTrue();
    expect($policy->update($user, $otherUser))->toBeFalse();
});

test('User has team invitations relationship', function () {
    $user = User::factory()->create();
    $invitation = \Modules\User\Models\TeamInvitation::factory()->for($user)->create();

    expect($user->teamInvitations)->toHaveCount(1);
    expect($user->teamInvitations->first()->id)->toBe($invitation->id);
});
```

### Integration Tests

```php
test('Console command can access user properties', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    $this->artisan('user:example')
        ->assertExitCode(0)
        ->expectsOutput('User Email: test@example.com');
});
```

## Documentation Updates

1. Update User module README with UserContract usage
2. Document all policy classes
3. Document all console commands
4. Document all actions
5. Update AGENTS.md with User-specific patterns

## File Structure

```
Modules/User/
├── app/
│   ├── Models/
│   │   ├── User.php             [VERIFY]
│   │   ├── BaseUser.php         [VERIFY]
│   │   ├── BaseTeam.php         [VERIFY]
│   │   └── Policies/
│   │       ├── UserPolicy.php   [VERIFY]
│   │       ├── TeamPolicy.php   [VERIFY]
│   │       └── BaseUserPolicy.php  [VERIFY]
│   ├── Console/
│   │   └── Commands/            [VERIFY]
│   └── Actions/
│       ├── Passport/            [VERIFY]
│       └── Socialite/           [VERIFY]
└── tests/
    └── Unit/
        ├── UserPolicyTest.php   [UPDATE]
        └── UserTest.php         [UPDATE]
```

## Success Criteria

✅ All UserContract-related errors resolved
✅ BaseUser and BaseTeam have all required properties
✅ Fixcity User extends correct base class
✅ All policies have proper type annotations
✅ All commands have proper type annotations
✅ All actions have proper type annotations
✅ All tests pass
✅ Documentation updated

## Timeline

- **Day 1**: Wait for UserContract update in Xot module
- **Day 2**: Verify BaseUser and BaseTeam
- **Day 3**: Verify Fixcity User inheritance
- **Day 4**: Verify policies, commands, and actions
- **Day 5**: Update tests and documentation

## Notes

- User module errors are primarily caused by UserContract interface
- Most errors will be resolved automatically when UserContract is updated
- BaseUser and BaseTeam must have all required properties
- Policies, commands, and actions need proper type annotations
- Type safety is critical for authorization and authentication

## Dependencies

This fix plan depends on:
1. **Xot Module - UserContract Update** (Highest Priority)
2. **Fixcity Module - User Model Inheritance** (Medium Priority)

Without the UserContract update, most errors in the User module cannot be resolved.