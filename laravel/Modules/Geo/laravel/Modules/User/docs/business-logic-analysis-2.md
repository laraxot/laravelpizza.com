# User Module - Business Logic Analysis

## Overview
The User module provides comprehensive user management, authentication, authorization, and team-based access control for the Quaeris platform. It serves as the foundation for all user-related operations across the entire application.

## Business Purpose
- **Authentication**: Secure user authentication with multiple options
- **Authorization**: Role-based access control (RBAC) system
- **Team Management**: Team-based collaboration and access control
- **Multi-factor Authentication**: Enhanced security with 2FA
- **Social Login**: OAuth integration for ease of access
- **User Lifecycle**: Complete user lifecycle management

## Core Business Logic

### 1. User Authentication
**Purpose**: Secure user access with multiple authentication methods
**Scope**: Platform-wide authentication and session management

**Key Components**:
- Standard email/password authentication
- Multi-factor authentication (2FA)
- OAuth social login integration
- Password policy enforcement
- Session management and security

**Business Rules**:
- Passwords must meet complexity requirements
- Failed login attempts trigger account lockout
- Sessions expire after inactivity period
- 2FA required for privileged accounts
- Password expiry forces renewal

### 2. Role-Based Access Control (RBAC)
**Purpose**: Fine-grained permission management
**Scope**: Application-wide authorization

**Key Components**:
- Roles and permissions system
- User role assignments
- Permission inheritance
- Resource-based permissions
- Dynamic permission checking

**Business Rules**:
- Users must have at least one role
- Permissions are additive across roles
- Super admin role bypasses all checks
- Permissions checked at controller and view level
- Role changes require approval for sensitive roles

### 3. Team Management
**Purpose**: Collaborative workspace organization
**Scope**: Multi-tenant team collaboration

**Key Components**:
- Team creation and management
- Team member invitations
- Role-based team permissions
- Team resource isolation
- Team switching functionality

**Business Rules**:
- Teams have owners and members
- Team owners can invite/remove members
- Resources belong to teams
- Users can belong to multiple teams
- Team deletion requires owner confirmation

### 4. User Profile Management
**Purpose**: User information and preferences
**Scope**: Personal user data and settings

**Key Components**:
- Profile information management
- Language and localization preferences
- Notification preferences
- Avatar and media management
- Account settings and privacy

**Business Rules**:
- Email addresses must be unique
- Profile changes logged for audit
- Privacy settings respected across platform
- Data retention policies enforced
- GDPR compliance for EU users

## Database Schema Analysis

### Core Tables
- `users`: Main user information and authentication
- `roles`: Available system roles
- `permissions`: Granular permissions
- `model_has_roles`: User role assignments
- `model_has_permissions`: Direct user permissions
- `teams`: Team management
- `team_user`: Team membership with roles
- `oauth_*`: OAuth authentication tables

### Issues Identified
1. **Password Security**: Password expiry tracking needs optimization
2. **Session Management**: Session cleanup not automated
3. **Team Relationships**: Missing cascade deletions
4. **Audit Trail**: User changes not fully logged

### Schema Improvements
```sql
-- Add indexes for performance
CREATE INDEX idx_users_email_verified ON users(email, email_verified_at);
CREATE INDEX idx_team_user_team_role ON team_user(team_id, role);
CREATE INDEX idx_users_type_active ON users(type, is_active);

-- Add foreign key constraints
ALTER TABLE team_user ADD CONSTRAINT fk_team_user_team
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE;

-- Optimize password expiry queries
CREATE INDEX idx_users_password_expires ON users(password_expires_at);
```

## Filament 4 Improvements

### Current Implementation Issues
1. **Basic User Forms**: Limited field validation and UX
2. **Team Management**: No advanced team management interface
3. **Permission Management**: Complex permissions hard to manage
4. **User Analytics**: No user behavior analytics

### Recommended Upgrades

#### 1. Enhanced User Management
```php
// Advanced user form with Filament 4
public static function getFormSchema(): array
{
    return [
        Forms\Components\Tabs::make('User Information')
            ->tabs([
                Forms\Components\Tabs\Tab::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, Forms\Set $set) =>
                                $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('type')
                            ->options([
                                'admin' => 'Administrator',
                                'customer' => 'Customer User',
                                'analyst' => 'Data Analyst',
                            ])
                            ->required(),
                    ]),
                Forms\Components\Tabs\Tab::make('Security')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\Toggle::make('is_otp')
                            ->label('Require 2FA'),
                        Forms\Components\DateTimePicker::make('password_expires_at')
                            ->label('Password Expires')
                            ->minDate(now()->addDays(30)),
                    ]),
                Forms\Components\Tabs\Tab::make('Teams & Roles')
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('teams')
                            ->relationship('teams', 'name')
                            ->multiple()
                            ->preload(),
                    ]),
            ]),
    ];
}
```

#### 2. Team Management Interface
```php
// Advanced team management with nested resources
class TeamResource extends XotBaseResource
{
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
            'members' => Pages\ManageTeamMembers::route('/{record}/members'),
            'permissions' => Pages\ManageTeamPermissions::route('/{record}/permissions'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MembersRelationManager::class,
            RelationManagers\PermissionsRelationManager::class,
        ];
    }
}
```

#### 3. Permission Management Dashboard
```php
// Permission matrix with visual interface
Forms\Components\Grid::make(3)
    ->schema([
        Forms\Components\Section::make('User Permissions')
            ->schema([
                Forms\Components\CheckboxList::make('user_permissions')
                    ->options(Permission::where('group', 'users')->pluck('name', 'id'))
                    ->columns(2),
            ]),
        Forms\Components\Section::make('Survey Permissions')
            ->schema([
                Forms\Components\CheckboxList::make('survey_permissions')
                    ->options(Permission::where('group', 'surveys')->pluck('name', 'id'))
                    ->columns(2),
            ]),
        Forms\Components\Section::make('System Permissions')
            ->schema([
                Forms\Components\CheckboxList::make('system_permissions')
                    ->options(Permission::where('group', 'system')->pluck('name', 'id'))
                    ->columns(2),
            ]),
    ]),
```

## Code Quality Issues

### Current Challenges
1. **Complex Relationships**: User-team-permission relationships complex
2. **Authorization Logic**: Spread across multiple classes
3. **Password Policies**: Hard-coded password rules
4. **Session Handling**: Manual session management

### Improvements Needed
```php
// Centralized authorization service
class AuthorizationService
{
    public function userCan(User $user, string $permission, $resource = null): bool
    {
        // Check direct permissions
        if ($user->hasDirectPermission($permission)) {
            return true;
        }

        // Check role permissions
        if ($user->hasPermissionViaRole($permission)) {
            return true;
        }

        // Check team permissions if resource is team-scoped
        if ($resource && $this->isTeamScoped($resource)) {
            return $this->checkTeamPermission($user, $permission, $resource);
        }

        return false;
    }

    private function checkTeamPermission(User $user, string $permission, $resource): bool
    {
        $team = $this->getResourceTeam($resource);
        return $user->teams()
            ->where('team_id', $team->id)
            ->whereHas('pivot.permissions', fn($q) => $q->where('name', $permission))
            ->exists();
    }
}

// Password policy service
class PasswordPolicyService
{
    public function validatePassword(string $password, ?User $user = null): ValidationResult
    {
        $rules = [
            'min_length' => config('auth.password.min_length', 8),
            'require_uppercase' => config('auth.password.require_uppercase', true),
            'require_numbers' => config('auth.password.require_numbers', true),
            'require_symbols' => config('auth.password.require_symbols', true),
        ];

        return $this->applyRules($password, $rules, $user);
    }
}
```

## Integration Points

### Dependencies
- **Xot Module**: Base classes and utilities
- **Activity Module**: User action logging
- **Notify Module**: User notifications and communications

### Provides To All Modules
- Authentication services
- Authorization checking
- User context and information
- Team-based access control

## Performance Considerations

### Current Issues
1. **Permission Checking**: N+1 queries in authorization
2. **Team Loading**: Eager loading optimization needed
3. **Session Storage**: Database session storage optimization
4. **User Queries**: Missing indexes for common patterns

### Optimization Strategies
```php
// Optimized user loading with permissions
class UserRepository
{
    public function findWithPermissions(int $userId): ?User
    {
        return User::with([
            'roles.permissions',
            'permissions',
            'teams.permissions'
        ])->find($userId);
    }

    public function getActiveUsersForTeam(int $teamId): Collection
    {
        return User::whereHas('teams', fn($q) => $q->where('team_id', $teamId))
            ->where('is_active', true)
            ->with(['roles', 'teams'])
            ->get();
    }
}

// Permission caching
class CachedAuthorizationService extends AuthorizationService
{
    public function userCan(User $user, string $permission, $resource = null): bool
    {
        $cacheKey = "user_permission_{$user->id}_{$permission}_" .
                   ($resource ? class_basename($resource) . "_{$resource->id}" : 'global');

        return Cache::remember($cacheKey, 300, function () use ($user, $permission, $resource) {
            return parent::userCan($user, $permission, $resource);
        });
    }
}
```

## Security Considerations

### Current Implementation
- Standard Laravel authentication
- Spatie permission package
- Basic 2FA implementation
- OAuth integration

### Security Enhancements
```php
// Enhanced security service
class UserSecurityService
{
    public function checkLoginAttempts(string $email): bool
    {
        $attempts = Cache::get("login_attempts_{$email}", 0);
        return $attempts < config('auth.max_login_attempts', 5);
    }

    public function recordFailedLogin(string $email): void
    {
        $attempts = Cache::get("login_attempts_{$email}", 0) + 1;
        Cache::put("login_attempts_{$email}", $attempts, now()->addMinutes(15));

        if ($attempts >= config('auth.max_login_attempts', 5)) {
            event(new AccountLockedEvent($email, $attempts));
        }
    }

    public function requiresPasswordChange(User $user): bool
    {
        if (!$user->password_expires_at) {
            return false;
        }

        return $user->password_expires_at < now();
    }
}

// API rate limiting
class ApiRateLimitingMiddleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = $request->user();
        $key = "api_rate_limit_{$user->id}";

        if (RateLimiter::tooManyAttempts($key, $perMinute = 60)) {
            throw new TooManyRequestsHttpException(
                RateLimiter::availableIn($key)
            );
        }

        RateLimiter::hit($key);
        return $next($request);
    }
}
```

## Business Workflows

### User Onboarding Workflow
1. User registration or invitation
2. Email verification
3. Profile completion
4. Team assignment
5. Role and permission assignment
6. Welcome notification and training

### Team Management Workflow
1. Team creation by owner
2. Member invitation
3. Role assignment
4. Permission configuration
5. Resource access setup
6. Team activity monitoring

### User Lifecycle Management
1. Account creation and activation
2. Regular access review
3. Role and permission updates
4. Password and security maintenance
5. Account deactivation
6. Data archival and cleanup

## Development Priorities

### High Priority
1. **Performance Optimization**: Fix N+1 queries and add caching
2. **Security Hardening**: Implement comprehensive security measures
3. **Filament Interface**: Upgrade to advanced Filament 4 features
4. **Authorization Cleanup**: Consolidate and optimize authorization logic

### Medium Priority
1. **API Development**: RESTful API for user management
2. **Advanced 2FA**: Support for multiple 2FA methods
3. **User Analytics**: User behavior and access analytics
4. **Audit Logging**: Comprehensive user action logging

### Low Priority
1. **SSO Integration**: Enterprise SSO solutions
2. **Advanced Teams**: Hierarchical team structures
3. **User Self-Service**: Advanced self-service capabilities
4. **Machine Learning**: User behavior analysis and recommendations

## Business Value
- **Security**: Robust authentication and authorization
- **Collaboration**: Team-based access and collaboration
- **Scalability**: Supports large user bases efficiently
- **Compliance**: GDPR and security compliance
- **User Experience**: Intuitive user management interface

## Success Metrics
- User login success rate (>99%)
- Average session duration
- Permission errors (minimize)
- User satisfaction scores
- Security incident reduction
- Team collaboration effectiveness