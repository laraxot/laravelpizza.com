# User Module Policies Documentation

## Overview

The User module implements comprehensive policies for all its models to control access and authorization throughout the system. This document outlines the policy structure, implementation, and usage patterns.

## Base Policy

All User module policies extend `UserBasePolicy`:

```php
abstract class UserBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        $xotData = XotData::make();
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }
}
```

## Implemented Policies

### Core Authentication Policies

#### AuthenticationPolicy
**Purpose**: Controls access to authentication records
**Key Logic**: Users can view their own authentication records, admins can view all
**Permissions**: `authentication.viewAny`, `authentication.view`, `authentication.create`, etc.

#### AuthenticationLogPolicy  
**Purpose**: Manages authentication log access
**Key Logic**: Users can view their own logs, system admins have full access
**Special Considerations**: Includes relationship checking for user ownership

#### UserPolicy
**Purpose**: Core user management authorization
**Key Logic**: Users can view/edit their own profiles, role-based admin access
**Permissions**: Standard CRUD permissions with ownership checks

### Device and Profile Management

#### DevicePolicy
**Purpose**: Device management authorization
**Key Logic**: Users can manage devices associated with their account
**Relationship Checks**: Validates device-user associations

#### ProfilePolicy
**Purpose**: User profile access control
**Key Logic**: Users own their profiles, admins can manage all profiles
**Ownership Validation**: Strict user_id matching for profile access

### Multi-Tenant and Team Management

#### TenantPolicy
**Purpose**: Multi-tenant access control
**Key Logic**: Users can only access tenants they belong to
**Tenant Checking**: Uses tenant relationships for authorization

#### TeamPolicy
**Purpose**: Team management authorization
**Key Logic**: Team membership determines access levels
**Already Implemented**: This policy was pre-existing

#### TeamInvitationPolicy
**Purpose**: Team invitation management
**Key Logic**: Team members can invite others, invitees can accept
**Complex Logic**: Handles invitation email matching and team membership

### System and Feature Management

#### NotificationPolicy
**Purpose**: Notification access management
**Key Logic**: Users can manage their own notifications
**Ownership**: Based on notifiable_id matching

#### FeaturePolicy
**Purpose**: Feature flag access control
**Key Logic**: Admin-controlled feature access
**System-Level**: Primarily admin permissions

#### RolePolicy
**Purpose**: Role management authorization
**Already Implemented**: Pre-existing policy

#### PermissionPolicy
**Purpose**: Permission system access control  
**Already Implemented**: Pre-existing policy

### Additional Models with Policies

The following models now have complete policy implementations:

- **DeviceProfile**: Device-profile relationship management
- **DeviceUser**: Device-user associations
- **Extra**: Extended user data management
- **Feature**: Feature flag control
- **Membership**: Membership management
- **ModelHasPermission**: Permission assignments
- **ModelHasRole**: Role assignments
- **Notification**: User notifications
- **OauthAccessToken**: OAuth token management
- **OauthAuthCode**: OAuth authorization codes
- **OauthClient**: OAuth client management
- **OauthPersonalAccessClient**: Personal access tokens
- **OauthRefreshToken**: OAuth refresh tokens
- **PasswordReset**: Password reset management
- **PermissionRole**: Role-permission relationships
- **PermissionUser**: User-permission relationships
- **ProfileTeam**: Profile-team associations
- **RoleHasPermission**: Role permission assignments
- **SocialiteUser**: Social login management
- **SocialProvider**: Social provider configuration
- **TeamPermission**: Team-specific permissions
- **TenantUser**: Tenant-user relationships

## Permission Naming Convention

All policies follow the standard Laravel permission pattern:

```
{model_name}.viewAny
{model_name}.view  
{model_name}.create
{model_name}.update
{model_name}.delete
{model_name}.restore
{model_name}.forceDelete
```

Example for User model:
- `user.viewAny` - Can view any users
- `user.view` - Can view specific user
- `user.create` - Can create users
- `user.update` - Can update users
- `user.delete` - Can delete users

## Ownership Patterns

### Direct Ownership
Models where users own their own records:
- Profile (user_id field)
- AuthenticationLog (user_id field)
- Notification (notifiable_id field)

### Relationship-Based Access
Models accessed through relationships:
- Device (through users relationship)
- Tenant (through tenants relationship)
- Team (through teams relationship)

### Admin-Only Access
Models requiring administrative privileges:
- Permission management
- Role assignments
- OAuth client management

## Usage Examples

### In Controllers

```php
public function show(User $user)
{
    $this->authorize('view', $user);
    return view('users.show', compact('user'));
}

public function update(Request $request, User $user)
{
    $this->authorize('update', $user);
    // Update logic...
}
```

### In Filament Resources

```php
public static function table(Table $table): Table
{
    return $table
        ->actions([
            Tables\Actions\EditAction::make()
                ->visible(fn ($record) => auth()->user()->can('update', $record)),
            Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->can('delete', $record)),
        ]);
}
```

### In Blade Templates

```blade
@can('update', $user)
    <a href="{{ route('users.edit', $user) }}">Edit User</a>
@endcan

@can('delete', $user)
    <form action="{{ route('users.destroy', $user) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
@endcan
```

## Security Considerations

### Super Admin Override
All policies include super admin bypass in the `before()` method:
```php
public function before(UserContract $user, string $ability): ?bool
{
    if ($user->hasRole('super-admin')) {
        return true;
    }
    return null;
}
```

### Default Deny
All policies default to denying access unless explicitly granted through permissions or ownership rules.

### Relationship Validation
Policies validate relationships before granting access:
```php
public function view(UserContract $user, Device $device): bool
{
    return $user->hasPermissionTo('device.view') || $device->users->contains($user);
}
```

## Policy Registration

Policies are automatically registered through the module's service provider via the `XotBaseServiceProvider::registerPolicies()` method. No manual registration is required.

## Testing Policies

### Unit Tests
Each policy should have corresponding tests:

```php
public function test_user_can_view_own_profile()
{
    $user = User::factory()->create();
    $profile = Profile::factory()->create(['user_id' => $user->id]);
    
    $this->assertTrue($user->can('view', $profile));
}

public function test_user_cannot_view_other_profile()
{
    $user = User::factory()->create();
    $otherProfile = Profile::factory()->create();
    
    $this->assertFalse($user->can('view', $otherProfile));
}
```

### Integration Tests
Test policy integration with Filament resources and controllers.

## Maintenance

### Adding New Policies
1. Create policy class extending `UserBasePolicy`
2. Implement required methods with appropriate logic
3. Add corresponding permissions to database
4. Policy will be auto-registered on next boot

### Updating Existing Policies
1. Modify policy methods as needed
2. Update permission names if changed
3. Update corresponding tests
4. Clear policy cache if necessary

## Related Documentation

- [Main Policies Documentation](../../../docs/policies_implementation.md)
- [User Authentication](./authentication.md)
- [Permissions and Roles](./permissions.md)
- [Team Management](./teams.md)
- [Multi-Tenant Setup](./tenant.md)

## Troubleshooting

### Policy Not Working
1. Check policy is registered: `php artisan route:list --name=gate`
2. Verify user has required permissions
3. Check model relationships are correct
4. Clear cache: `php artisan cache:clear`

### Permission Denied Issues
1. Verify permission exists in database
2. Check user has permission or role
3. Validate model ownership logic
4. Test super admin override

*Last updated: January 2025*
