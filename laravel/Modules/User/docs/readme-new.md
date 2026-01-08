# User Module - Authentication & Authorization

**Last Update**: 2025-12-05
**Status**: ✅ Production Ready
**PHPStan Level**: 10
**Maintainers**: Laraxot Team

---

## 📋 Table of Contents

- [Business Overview](#-business-overview)
- [Architecture](#-architecture)
- [Core Components](#-core-components)
- [Quick Start](#-quick-start)
- [Development Guide](#-development-guide)
- [Security](#-security)
- [API & Integration](#-api--integration)
- [Testing](#-testing)
- [Documentation Index](#-documentation-index)

---

## 🎯 Business Overview

### Purpose
The **User Module** provides comprehensive user management, authentication, and authorization infrastructure for the Laraxot PTVX ecosystem. It implements:
- **Multi-Authentication**: Support for multiple authentication methods (credentials, OAuth, SSO)
- **Role-Based Access Control**: Advanced permission system using Spatie Laravel Permission
- **Multi-Tenancy**: Complete tenant isolation and management
- **Team Collaboration**: Team-based user organization
- **Profile Management**: Flexible user profile system
- **Security Auditing**: Authentication logging and security monitoring

### Key Features
- **Flexible User Model**: BaseUser with Single Table Inheritance (STI) support
- **Advanced Permissions**: Granular role and permission management
- **OAuth Integration**: Social login (Google, Facebook, GitHub, etc.)
- **SSO Support**: Single Sign-On provider integration
- **Device Management**: Track and manage user devices
- **Authentication Logging**: Complete audit trail of login attempts
- **Password Security**: Advanced password policies and reset flows
- **Multi-Tenancy**: Tenant isolation with user-tenant associations

### Target Users
- **System Administrators**: Manage users, roles, and permissions
- **Application Users**: End users accessing the application
- **Team Managers**: Manage team members and collaborations
- **Tenant Administrators**: Manage tenant-specific users and settings
- **Security Officers**: Monitor authentication and security events

---

## 🏗️ Architecture

### Module Dependencies

```
User Module
├── Xot Module (Foundation) - REQUIRED
│   ├── XotBaseModel (Model foundation)
│   ├── XotBaseResource (Filament resources)
│   └── Core patterns and traits
├── Activity Module (Recommended)
│   └── User activity tracking
├── Lang Module (Recommended)
│   └── Translation and localization
└── Tenant Module (Optional)
    └── Enhanced multi-tenancy features
```

### Technology Stack
- **Laravel**: 12.x
- **Filament**: 4.x (for admin UI)
- **Spatie Laravel Permission**: 6.x
- **Laravel Sanctum**: API authentication
- **Laravel Socialite**: OAuth providers
- **PHP**: 8.3+
- **PHPStan**: Level 10

### Directory Structure

```
User/
├── app/
│   ├── Actions/              # Business actions
│   │   ├── Auth/             # Authentication actions
│   │   ├── User/             # User management actions
│   │   └── Team/             # Team management actions
│   ├── Events/               # Domain events
│   │   ├── UserCreated.php
│   │   ├── UserLoggedIn.php
│   │   └── PermissionGranted.php
│   ├── Filament/             # Filament resources
│   │   ├── Resources/        # User, Role, Team, Tenant resources
│   │   ├── Pages/            # Custom pages (EditProfile, etc.)
│   │   └── Widgets/          # User stats, security alerts
│   ├── Models/               # Eloquent models
│   │   ├── User.php          # Main user model
│   │   ├── BaseUser.php      # Base user class
│   │   ├── Profile.php       # User profile
│   │   ├── Role.php          # User roles
│   │   ├── Permission.php    # Permissions
│   │   ├── Team.php          # Teams
│   │   ├── Tenant.php        # Tenants
│   │   ├── Device.php        # User devices
│   │   └── AuthenticationLog.php  # Login audit
│   ├── Policies/             # Authorization policies
│   ├── Providers/            # Service providers
│   └── Services/             # Business logic services
│       ├── AuthService.php
│       ├── PermissionService.php
│       └── TenantService.php
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── docs/                     # Documentation
└── tests/                    # Tests
    ├── Feature/              # Feature tests
    └── Unit/                 # Unit tests
```

---

## 🔧 Core Components

### Models

#### User / BaseUser
**Purpose**: Core user model with authentication and authorization

**Key Features**:
- Single Table Inheritance (STI) support for different user types
- Integration with Spatie Laravel Permission
- Multi-tenancy support
- Team membership
- Device tracking
- OAuth connections

**Relationships**:
```php
// Core relationships
- hasOne(Profile::class)
- belongsToMany(Team::class)
- belongsToMany(Tenant::class)
- belongsToMany(Role::class)
- hasMany(Permission::class)
- hasMany(Device::class)
- hasMany(AuthenticationLog::class)
- hasMany(SocialProvider::class)
```

**Key Methods**:
```php
// Authorization
$user->hasRole('admin');
$user->can('edit-posts');
$user->givePermissionTo('edit-posts');

// Teams
$user->teams;
$user->currentTeam;
$user->switchTeam($team);

// Tenants
$user->tenant;
$user->switchTenant($tenant);

// Devices
$user->devices;
$user->revokeDevice($deviceId);
```

#### Profile / BaseProfile
**Purpose**: Extended user information and preferences

**Key Features**:
- Flexible schema using schemaless attributes
- Avatar management
- Preferences storage
- Localization settings

**Relationships**:
```php
- belongsTo(User::class)
- belongsToMany(Team::class)
```

#### Role
**Purpose**: User role definition with permissions

**Key Features**:
- Hierarchical roles support
- Permission association
- Scope management

**Relationships**:
```php
- belongsToMany(User::class)
- belongsToMany(Permission::class)
```

#### Permission
**Purpose**: Granular permission definition

**Key Features**:
- Action-based permissions
- Resource-based permissions
- Permission groups

**Relationships**:
```php
- belongsToMany(Role::class)
- belongsToMany(User::class) // Direct permissions
```

#### Team / BaseTeam
**Purpose**: Team collaboration and grouping

**Key Features**:
- Team ownership
- Member management
- Team invitations
- Role assignment within teams

**Relationships**:
```php
- belongsTo(User::class, 'user_id') // Team owner
- belongsToMany(User::class)
- hasMany(TeamInvitation::class)
```

#### Tenant / BaseTenant
**Purpose**: Multi-tenancy isolation

**Key Features**:
- Data isolation per tenant
- Tenant-specific configurations
- User-tenant associations

**Relationships**:
```php
- belongsToMany(User::class)
- hasMany(Team::class)
```

#### AuthenticationLog
**Purpose**: Security audit trail of login attempts

**Key Features**:
- Login success/failure tracking
- Device fingerprinting
- IP address logging
- User agent tracking

**Relationships**:
```php
- belongsTo(User::class)
```

#### Device / DeviceUser
**Purpose**: User device management and tracking

**Key Features**:
- Device registration
- Device verification
- Push notification support
- Device revocation

**Relationships**:
```php
- belongsToMany(User::class)
- belongsToMany(Profile::class)
```

### Filament Resources

#### UserResource
**Purpose**: Complete CRUD interface for user management

**Features**:
- User creation and editing
- Role and permission assignment
- Profile management
- Password management
- Team membership management
- Account status management

**Permissions Required**:
- `view_user`: View user list
- `create_user`: Create new users
- `edit_user`: Edit existing users
- `delete_user`: Delete users

#### RoleResource
**Purpose**: Role management interface

**Features**:
- Role creation and editing
- Permission assignment
- User assignment to roles
- Role hierarchy management

#### PermissionResource
**Purpose**: Permission management interface

**Features**:
- Permission creation
- Permission grouping
- Role assignment

#### TeamResource
**Purpose**: Team management interface

**Features**:
- Team creation and editing
- Member management
- Team invitations
- Team permissions

#### TenantResource
**Purpose**: Tenant management interface

**Features**:
- Tenant creation and configuration
- User assignment to tenants
- Tenant isolation settings

### Widgets & Pages

#### LoginWidget
**Purpose**: Multi-method login form

**Features**:
- Username/password login
- Social login buttons
- Remember me functionality
- Password reset link

#### UserStatsWidget
**Purpose**: Dashboard statistics for users

**Features**:
- Total users count
- New users this week/month
- Active users
- User growth charts

#### SecurityAlertsWidget
**Purpose**: Security monitoring dashboard

**Features**:
- Failed login attempts
- Suspicious activities
- Account lockouts
- Recent authentication logs

#### EditProfile Page
**Purpose**: User profile editing interface

**Features**:
- Personal information editing
- Avatar upload
- Password change
- Notification preferences
- Two-factor authentication setup

#### PasswordResetConfirmWidget
**Purpose**: Password reset confirmation flow

**Features**:
- Token validation
- New password setting
- Auto-login after reset
- Email confirmation

### Services

#### AuthService
**Purpose**: Authentication business logic

**Key Methods**:
```php
// Login operations
AuthService::login($credentials);
AuthService::loginViaOAuth($provider, $user);
AuthService::loginViaSso($token);

// Logout
AuthService::logout();

// Password operations
AuthService::resetPassword($email);
AuthService::changePassword($user, $newPassword);
```

#### PermissionService
**Purpose**: Permission management logic

**Key Methods**:
```php
// Role operations
PermissionService::assignRole($user, $role);
PermissionService::removeRole($user, $role);

// Permission operations
PermissionService::grantPermission($user, $permission);
PermissionService::revokePermission($user, $permission);

// Check permissions
PermissionService::userCan($user, $permission);
```

#### TenantService
**Purpose**: Multi-tenancy management

**Key Methods**:
```php
// Tenant operations
TenantService::createTenant($data);
TenantService::assignUserToTenant($user, $tenant);
TenantService::switchTenant($user, $tenant);

// Tenant context
TenantService::getCurrentTenant();
TenantService::setTenant($tenant);
```

---

## 🚀 Quick Start

### Prerequisites
1. Xot Module (foundation) - **REQUIRED**
2. Laravel Sanctum installed and configured
3. Spatie Laravel Permission installed
4. Database configured

### Installation

```bash
# 1. Ensure Xot module is installed and working
php artisan module:list

# 2. Run User module migrations
php artisan migrate --path=Modules/User/database/migrations

# 3. Seed default roles and permissions
php artisan db:seed --class=UserSeeder

# 4. Publish configuration (optional)
php artisan vendor:publish --tag=user-config

# 5. Clear caches
php artisan config:clear
php artisan cache:clear
```

### Configuration

```php
// config/user.php (after publishing)
return [
    // User model configuration
    'user_model' => \Modules\User\Models\User::class,

    // Profile configuration
    'profile_model' => \Modules\User\Models\Profile::class,

    // Authentication configuration
    'auth' => [
        'guards' => [
            'web' => 'web',
            'api' => 'sanctum',
        ],
        'password_reset_timeout' => 60, // minutes
        'max_login_attempts' => 5,
        'lockout_duration' => 15, // minutes
    ],

    // OAuth providers
    'oauth_providers' => [
        'google' => true,
        'facebook' => false,
        'github' => true,
    ],

    // Multi-tenancy
    'tenancy' => [
        'enabled' => true,
        'automatic_switching' => true,
    ],

    // Teams
    'teams' => [
        'enabled' => true,
        'invitations_enabled' => true,
    ],
];
```

### First Steps - Creating Users

#### Via Filament Admin Panel
1. Navigate to Users resource in Filament
2. Click "New User"
3. Fill in user details
4. Assign roles and permissions
5. Save

#### Via Code
```php
use Modules\User\Models\User;

// Create a user
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
]);

// Assign role
$user->assignRole('admin');

// Grant direct permission
$user->givePermissionTo('edit-posts');
```

#### Via Seeder
```php
// Create default admin user
php artisan db:seed --class=UserSeeder
```

---

## 💻 Development Guide

### Creating Custom User Types (STI)

```php
namespace Modules\YourModule\Models;

use Modules\User\Models\BaseUser;

class Doctor extends BaseUser
{
    protected static string $type = 'doctor';

    // Doctor-specific methods
    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }
}
```

### Custom Authentication

```php
namespace Modules\YourModule\Actions\Auth;

use Modules\User\Services\AuthService;

class CustomLoginAction
{
    public function execute(array $credentials): bool
    {
        // Custom authentication logic
        if ($this->validateCustomCredentials($credentials)) {
            return AuthService::login($credentials);
        }

        return false;
    }
}
```

### Permission Checking

```php
// In controllers
if ($user->can('edit-posts')) {
    // Allow editing
}

// In Blade
@can('edit-posts')
    <!-- Edit form -->
@endcan

// In Filament resources
public static function canViewAny(): bool
{
    return auth()->user()->can('view_users');
}

// In policies
public function update(User $user, Post $post): bool
{
    return $user->hasRole('admin') || $user->id === $post->user_id;
}
```

### Working with Teams

```php
// Create a team
$team = Team::create([
    'name' => 'Engineering Team',
    'user_id' => auth()->id(), // Team owner
]);

// Add members
$team->users()->attach($userId, [
    'role' => 'member',
]);

// Switch user's current team
$user->switchTeam($team);

// Check team membership
if ($user->belongsToTeam($team)) {
    // User is team member
}
```

### Working with Tenants

```php
// Create a tenant
$tenant = Tenant::create([
    'name' => 'Acme Corp',
    'domain' => 'acme',
]);

// Assign user to tenant
$tenant->users()->attach($userId);

// Switch user's tenant
$user->switchTenant($tenant);

// Scoped queries (automatic with tenancy enabled)
Post::all(); // Only returns posts from current tenant
```

### Code Standards
- **PHPStan Level**: 10
- **Security**: Follow OWASP best practices
- **Password Hashing**: Always use bcrypt/argon2
- **Authorization**: Always check permissions before actions
- **Validation**: Strict input validation required

### Best Practices

1. **Always Hash Passwords**
```php
// ✅ Correct
$user->password = Hash::make($password);

// ❌ Wrong
$user->password = $password;
```

2. **Use Policies for Authorization**
```php
// ✅ Correct
Gate::authorize('update', $post);

// ❌ Wrong
if ($user->id === $post->user_id) {
    // Direct check
}
```

3. **Validate User Input**
```php
// ✅ Correct
$validated = $request->validate([
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
]);

// ❌ Wrong
$user->email = $request->input('email');
```

4. **Log Security Events**
```php
// Always log authentication attempts
AuthenticationLog::create([
    'user_id' => $user->id,
    'ip_address' => $request->ip(),
    'success' => true,
]);
```

---

## 🔒 Security

### Password Policies
- Minimum length: 8 characters
- Complexity requirements configurable
- Password history tracking
- Periodic password expiration (optional)

### Authentication Security
- Rate limiting on login attempts
- Account lockout after failed attempts
- IP-based restrictions (optional)
- Two-factor authentication support
- Session management

### Authorization Security
- Role-based access control (RBAC)
- Permission-based access control
- Policy-based authorization
- Middleware protection
- API token management

### Audit & Monitoring
- Authentication log tracking
- Permission change logging
- User activity tracking (via Activity module)
- Security alert notifications

### Best Security Practices

```php
// 1. Always validate and sanitize input
$email = filter_var($request->email, FILTER_VALIDATE_EMAIL);

// 2. Use prepared statements (Eloquent does this automatically)
User::where('email', $email)->first();

// 3. Protect against mass assignment
protected $fillable = ['name', 'email']; // Explicitly list fillable fields

// 4. Use HTTPS in production
// Force HTTPS in middleware or app configuration

// 5. Implement CSRF protection (Laravel includes this)
@csrf // In forms

// 6. Implement rate limiting
Route::middleware('throttle:10,1')->group(function () {
    // Routes
});
```

---

## 🔗 API & Integration

### Authentication API

#### Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}

Response:
{
    "token": "sanctum-token-here",
    "user": { ... }
}
```

#### OAuth Login
```http
GET /auth/google/redirect
GET /auth/google/callback

Response:
{
    "token": "sanctum-token-here",
    "user": { ... }
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}

Response:
{
    "message": "Logged out successfully"
}
```

### User Management API

#### Get Current User
```http
GET /api/user
Authorization: Bearer {token}

Response:
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "roles": ["admin"],
    "permissions": ["edit-posts"]
}
```

#### Update Profile
```http
PUT /api/user/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Updated",
    "avatar": "data:image/..."
}
```

### Events

The User module fires the following events:

- `UserCreated`: When a new user is created
- `UserUpdated`: When user details are updated
- `UserDeleted`: When a user is deleted
- `UserLoggedIn`: When user successfully logs in
- `UserLoggedOut`: When user logs out
- `PermissionGranted`: When permission is granted to user
- `PermissionRevoked`: When permission is revoked
- `RoleAssigned`: When role is assigned to user
- `RoleRemoved`: When role is removed from user

```php
// Listen to events
Event::listen(UserLoggedIn::class, function ($event) {
    Log::info('User logged in', ['user_id' => $event->user->id]);
});
```

---

## 🧪 Testing

### Test Coverage
- **Target**: 90%+
- **Current**: ~88%
- **Critical Components**: 95%+

### Running Tests

```bash
# All User module tests
./vendor/bin/pest Modules/User

# Authentication tests
./vendor/bin/pest Modules/User/tests/Feature/AuthenticationTest.php

# Permission tests
./vendor/bin/pest Modules/User/tests/Feature/PermissionTest.php

# With coverage
./vendor/bin/pest Modules/User --coverage --min=90
```

### Test Examples

#### Authentication Test
```php
test('user can login with valid credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});
```

#### Permission Test
```php
test('user with permission can perform action', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('edit-posts');

    $this->actingAs($user);

    expect($user->can('edit-posts'))->toBeTrue();
});
```

#### Team Test
```php
test('user can switch teams', function () {
    $user = User::factory()->create();
    $team1 = Team::factory()->create();
    $team2 = Team::factory()->create();

    $user->teams()->attach([$team1->id, $team2->id]);
    $user->switchTeam($team2);

    expect($user->currentTeam->id)->toBe($team2->id);
});
```

---

## 📚 Documentation Index

### Architecture
- [User Model Architecture](./architecture/user-model.md) - User model design
- [Permission System](./architecture/permission-system.md) - RBAC architecture
- [Multi-Tenancy](./architecture/multi-tenancy.md) - Tenant isolation
- [Team System](./architecture/teams.md) - Team collaboration

### Authentication
- [Authentication Flow](./auth/authentication-flow.md) - Login/logout process
- [OAuth Integration](./auth/oauth.md) - Social login setup
- [SSO Integration](./auth/sso.md) - Single Sign-On
- [Two-Factor Auth](./auth/2fa.md) - 2FA implementation

### Authorization
- [Roles & Permissions](./authorization/roles-permissions.md) - RBAC guide
- [Policies](./authorization/policies.md) - Policy-based authorization
- [Permission Checking](./authorization/checking.md) - How to check permissions

### Development
- [Creating User Types](./development/user-types.md) - STI implementation
- [Custom Authentication](./development/custom-auth.md) - Custom auth methods
- [API Integration](./development/api.md) - API usage guide

### Security
- [Security Best Practices](./security/best-practices.md) - Security guidelines
- [Password Policies](./security/passwords.md) - Password requirements
- [Audit Logging](./security/audit-log.md) - Security audit trail

### Troubleshooting
- [Common Issues](./troubleshooting/common-issues.md) - Frequently encountered problems
- [Login Component Troubleshooting](./troubleshooting-login-component.md) - Login widget issues
- [FAQ](./troubleshooting/faq.md) - Frequently asked questions

---

## 🔄 Recent Updates

### v2.5.0 - 2025-12-05
- **Added**: Laravel 12 compatibility
- **Added**: Filament 4 support
- **Fixed**: Merge conflicts in EditProfile and PasswordResetConfirmWidget
- **Improved**: PHPStan Level 10 compliance

### v2.4.0 - 2025-11-04
- **Added**: Device management features
- **Added**: Enhanced authentication logging
- **Fixed**: File locking pattern implementation
- **Improved**: Security alert widgets

See [CHANGELOG.md](./CHANGELOG.md) for full history.

---

## 🗺️ Roadmap

### Next Release (v2.6.0)
- [ ] Enhanced two-factor authentication
- [ ] Biometric authentication support
- [ ] Advanced session management
- [ ] WebAuthn integration

### Future Plans
- Passwordless authentication
- Magic link login
- Social login enhancements
- Advanced audit reporting

See [ROADMAP.md](./ROADMAP.md) for details.

---

## 📖 Related Documentation

### Internal Modules
- [Xot Module](../Xot/docs/README.md) - Core foundation
- [Activity Module](../Activity/docs/README.md) - Activity tracking
- [Lang Module](../Lang/docs/README.md) - Translations
- [Tenant Module](../Tenant/docs/README.md) - Enhanced tenancy

### Project Documentation
- [CLAUDE.md](../../../CLAUDE.md) - Project architecture
- [Security Guidelines](../../../docs/security.md)

### External Resources
- [Laravel Authentication](https://laravel.com/docs/12.x/authentication)
- [Laravel Authorization](https://laravel.com/docs/12.x/authorization)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)
- [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
- [Filament Authentication](https://filamentphp.com/docs/4.x/panels/users)

---

**Module**: User (Authentication & Authorization)
**Version**: 2.5.0
**Framework**: Laravel 12 + Filament 4
**PHPStan**: Level 10 ✅
**Test Coverage**: 88%+ ✅
**Security**: OWASP Compliant ✅
