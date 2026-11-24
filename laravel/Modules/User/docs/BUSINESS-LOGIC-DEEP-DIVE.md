# User Module - Business Logic Deep Dive

## 🎯 Module Overview

Il modulo User è il foundation layer per l'authentication, authorization e multi-tenancy dell'intera applicazione. Gestisce utenti, ruoli, permessi, team e tenant con integrazione sociale OAuth.

## 🏗️ Core Architecture

### Authentication Layer
```
BaseUser (Authenticatable)
├── HasApiTokens (Passport)
├── MustVerifyEmail
├── HasFactory
├── Notifiable
├── HasRoles (Spatie)
├── HasPermissions (Spatie)
├── HasTeams (Custom)
├── HasMedia (Spatie)
└── HasTenants (Filament)
```

### Business Logic Components

#### 1. User Identity Management
**Purpose**: Gestione identità utente completa con profili estesi
**Core Models**:
- `BaseUser.php` - 400+ linee, gestisce authentication + authorization + profiling
- `User.php` - Extension del BaseUser per l'applicazione
- `Profile.php` - Dati profilo estesi utente

**Business Rules**:
```php
// User lifecycle management
class UserLifecycleService
{
    public function createUser(array $data): User
    {
        // 1. Validate user data
        // 2. Create user record
        // 3. Assign default role
        // 4. Create profile
        // 5. Send welcome email
        // 6. Log activity
    }

    public function activateUser(User $user): bool
    {
        // 1. Update status
        // 2. Send activation email
        // 3. Create authentication log
        // 4. Clear failed attempts
    }

    public function deactivateUser(User $user, string $reason): bool
    {
        // 1. Revoke tokens
        // 2. Clear sessions
        // 3. Log deactivation
        // 4. Notify administrators
    }
}
```

#### 2. Multi-Tenant Architecture
**Purpose**: Isolamento dati per tenant multipli
**Core Models**:
- `BaseTenant.php` - Tenant configuration e metadata
- `Tenant.php` - Implementazione tenant specifica
- `TenantUser.php` - Relazione many-to-many con roles

**Business Logic**:
```php
// Tenant isolation patterns
abstract class TenantAwareModel extends BaseModel
{
    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check() && auth()->user()->currentTenant) {
                $builder->where('tenant_id', auth()->user()->currentTenant->id);
            }
        });

        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->currentTenant) {
                $model->tenant_id = auth()->user()->currentTenant->id;
            }
        });
    }
}

// Tenant switching logic
class TenantSwitchingService
{
    public function switchTenant(User $user, Tenant $tenant): bool
    {
        // 1. Verify user has access to tenant
        // 2. Clear current session data
        // 3. Update current_tenant_id
        // 4. Refresh permissions
        // 5. Redirect to tenant dashboard
    }
}
```

#### 3. Team Management System
**Purpose**: Gestione team collaborativi con ruoli gerarchici
**Core Models**:
- `BaseTeam.php` - Team configuration e settings
- `Team.php` - Team implementation
- `TeamUser.php` - Membership con ruoli
- `TeamInvitation.php` - Sistema inviti

**Business Patterns**:
```php
// Team hierarchy and permissions
class TeamHierarchyService
{
    public function getTeamHierarchy(Team $team): Collection
    {
        return Team::where('parent_id', $team->id)
            ->with(['children', 'users'])
            ->get()
            ->map(function ($childTeam) {
                return [
                    'team' => $childTeam,
                    'children' => $this->getTeamHierarchy($childTeam),
                    'permissions' => $this->getTeamPermissions($childTeam),
                ];
            });
    }

    public function inheritPermissions(Team $childTeam, Team $parentTeam): void
    {
        $parentPermissions = $parentTeam->permissions;
        foreach ($parentPermissions as $permission) {
            if (!$childTeam->hasPermissionTo($permission)) {
                $childTeam->givePermissionTo($permission);
            }
        }
    }
}

// Team invitation workflow
class TeamInvitationService
{
    public function inviteUser(Team $team, string $email, array $roles = []): TeamInvitation
    {
        // 1. Check if user already exists
        // 2. Create invitation record
        // 3. Generate secure token
        // 4. Send invitation email
        // 5. Log invitation activity
        // 6. Set expiration (7 days)
    }

    public function acceptInvitation(string $token): bool
    {
        // 1. Validate token and expiration
        // 2. Create or link user
        // 3. Add user to team
        // 4. Assign roles
        // 5. Send welcome email
        // 6. Delete invitation
    }
}
```

#### 4. Permission & Role System
**Purpose**: Granular access control con ereditarietà
**Core Models**:
- `Permission.php` - Permessi atomici
- `Role.php` - Raggruppamenti permessi
- `ModelHasPermission.php` - Direct permissions
- `ModelHasRole.php` - Role assignments

**Advanced Patterns**:
```php
// Dynamic permission system
class DynamicPermissionService
{
    public function createResourcePermissions(string $resource): void
    {
        $actions = ['view', 'create', 'update', 'delete', 'manage'];
        foreach ($actions as $action) {
            Permission::firstOrCreate([
                'name' => "{$action}_{$resource}",
                'guard_name' => 'web',
                'module' => $this->getModuleFromResource($resource),
            ]);
        }
    }

    public function syncUserPermissions(User $user): void
    {
        // 1. Get all role permissions
        $rolePermissions = $user->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->unique('id');

        // 2. Get direct permissions
        $directPermissions = $user->permissions;

        // 3. Merge and sync
        $allPermissions = $rolePermissions->merge($directPermissions)->unique('id');

        // 4. Cache for performance
        Cache::put("user_permissions_{$user->id}", $allPermissions, 3600);
    }
}

// Context-aware permissions
class ContextualPermissionService
{
    public function userCan(User $user, string $permission, ?Model $model = null): bool
    {
        // 1. Check direct permission
        if ($user->hasDirectPermission($permission)) {
            return true;
        }

        // 2. Check role-based permission
        if ($user->hasPermissionTo($permission)) {
            return true;
        }

        // 3. Check model-specific permission
        if ($model && $this->hasModelPermission($user, $permission, $model)) {
            return true;
        }

        // 4. Check context-specific rules
        return $this->checkContextualRules($user, $permission, $model);
    }

    private function checkContextualRules(User $user, string $permission, ?Model $model): bool
    {
        // Owner can always edit their content
        if ($model && isset($model->user_id) && $model->user_id === $user->id) {
            return str_contains($permission, 'edit') || str_contains($permission, 'delete');
        }

        // Team members can view team content
        if ($model && isset($model->team_id) && $user->teams->contains('id', $model->team_id)) {
            return str_contains($permission, 'view');
        }

        return false;
    }
}
```

#### 5. Social Authentication
**Purpose**: Login con provider esterni (Google, Facebook, GitHub)
**Core Models**:
- `SocialProvider.php` - Configurazione provider
- `SocialiteUser.php` - Collegamento accounts esterni

**Integration Patterns**:
```php
// Social authentication flow
class SocialAuthenticationService
{
    public function handleProviderCallback(string $provider, SocialiteUser $socialiteUser): User
    {
        // 1. Find existing social connection
        $existingSocial = SocialiteUser::where('provider', $provider)
            ->where('provider_id', $socialiteUser->getId())
            ->first();

        if ($existingSocial) {
            return $this->loginExistingUser($existingSocial->user);
        }

        // 2. Try to find user by email
        $user = User::where('email', $socialiteUser->getEmail())->first();

        if ($user) {
            return $this->linkSocialAccount($user, $provider, $socialiteUser);
        }

        // 3. Create new user
        return $this->createUserFromSocial($provider, $socialiteUser);
    }

    private function createUserFromSocial(string $provider, SocialiteUser $socialiteUser): User
    {
        DB::transaction(function () use ($provider, $socialiteUser) {
            // Create user
            $user = User::create([
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'email_verified_at' => now(),
                'avatar' => $socialiteUser->getAvatar(),
            ]);

            // Create social link
            $user->socialiteUsers()->create([
                'provider' => $provider,
                'provider_id' => $socialiteUser->getId(),
                'provider_token' => $socialiteUser->token,
                'provider_refresh_token' => $socialiteUser->refreshToken,
            ]);

            // Assign default role
            $user->assignRole('user');

            // Create profile
            $user->profile()->create([
                'avatar_url' => $socialiteUser->getAvatar(),
                'provider_data' => json_encode($socialiteUser->getRaw()),
            ]);

            return $user;
        });
    }
}
```

#### 6. Device Management
**Purpose**: Tracking e gestione dispositivi utente
**Core Models**:
- `Device.php` - Informazioni dispositivo
- `DeviceUser.php` - Associazione user-device
- `AuthenticationLog.php` - Log accessi

**Security Patterns**:
```php
// Device fingerprinting and security
class DeviceSecurityService
{
    public function registerDevice(User $user, Request $request): Device
    {
        $fingerprint = $this->generateDeviceFingerprint($request);

        $device = Device::firstOrCreate([
            'fingerprint' => $fingerprint,
        ], [
            'name' => $this->getDeviceName($request),
            'type' => $this->getDeviceType($request),
            'browser' => $request->header('User-Agent'),
            'platform' => $this->getPlatform($request),
            'ip_address' => $request->ip(),
            'is_trusted' => false,
        ]);

        $user->devices()->syncWithoutDetaching([$device->id => [
            'last_used_at' => now(),
            'login_count' => DB::raw('login_count + 1'),
        ]]);

        return $device;
    }

    public function detectSuspiciousActivity(User $user, Device $device): bool
    {
        // 1. Check unusual location
        $recentIps = $user->authenticationLogs()
            ->where('created_at', '>', now()->subDays(30))
            ->pluck('ip_address')
            ->unique();

        if ($recentIps->count() > 1 && !$recentIps->contains($device->ip_address)) {
            $this->notifySecurityTeam($user, 'unusual_location', $device);
            return true;
        }

        // 2. Check unusual timing
        $lastLogin = $user->authenticationLogs()->latest()->first();
        if ($lastLogin && $lastLogin->created_at->diffInMinutes(now()) < 5) {
            $this->notifySecurityTeam($user, 'rapid_login', $device);
            return true;
        }

        return false;
    }
}
```

## 🎨 Design Patterns Utilizzati

### 1. Repository Pattern
```php
// User repository with advanced querying
class UserRepository
{
    public function findActiveUsersWithRoles(): Collection
    {
        return User::with(['roles', 'permissions'])
            ->where('is_active', true)
            ->whereNotNull('email_verified_at')
            ->get();
    }

    public function findByTeamAndRole(Team $team, string $role): Collection
    {
        return User::whereHas('teams', function ($query) use ($team) {
            $query->where('team_id', $team->id);
        })->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
    }
}
```

### 2. Observer Pattern
```php
// User model observers
class UserObserver
{
    public function creating(User $user): void
    {
        // Generate UUID if not set
        if (!$user->id) {
            $user->id = Str::uuid();
        }

        // Set default tenant if multi-tenant
        if (!$user->tenant_id && auth()->check()) {
            $user->tenant_id = auth()->user()->currentTenant?->id;
        }
    }

    public function created(User $user): void
    {
        // Create default profile
        $user->profile()->create([
            'display_name' => $user->name,
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
        ]);

        // Assign default role
        $user->assignRole('user');

        // Send welcome email
        $user->notify(new WelcomeNotification());
    }

    public function updated(User $user): void
    {
        // Clear permission cache when roles change
        if ($user->isDirty('roles')) {
            Cache::forget("user_permissions_{$user->id}");
        }

        // Log important changes
        if ($user->isDirty(['email', 'password'])) {
            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties($user->getDirty())
                ->log('user_updated');
        }
    }
}
```

### 3. Strategy Pattern
```php
// Authentication strategy
interface AuthenticationStrategyInterface
{
    public function authenticate(array $credentials): bool;
    public function supports(string $type): bool;
}

class LocalAuthenticationStrategy implements AuthenticationStrategyInterface
{
    public function authenticate(array $credentials): bool
    {
        return auth()->attempt($credentials);
    }

    public function supports(string $type): bool
    {
        return $type === 'local';
    }
}

class LdapAuthenticationStrategy implements AuthenticationStrategyInterface
{
    public function authenticate(array $credentials): bool
    {
        // LDAP authentication logic
        return $this->ldapService->authenticate($credentials);
    }

    public function supports(string $type): bool
    {
        return $type === 'ldap';
    }
}

class AuthenticationManager
{
    private array $strategies = [];

    public function addStrategy(AuthenticationStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    public function authenticate(string $type, array $credentials): bool
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($type)) {
                return $strategy->authenticate($credentials);
            }
        }

        throw new UnsupportedAuthenticationTypeException($type);
    }
}
```

## 🔧 Technical Debt & Issues

### 1. BaseUser Complexity
**Problem**: 400+ linee in un singolo model
**Issues**:
- Troppi concerns in una classe
- Difficile testing e maintenance
- Violazione SRP

**Solution**:
```php
// Decomposed user model
class User extends Authenticatable implements UserContract
{
    use HasFactory, Notifiable, HasRoles;

    // Only core user data and relationships
}

// Separate concerns
class UserProfileService {
    // Profile management logic
}

class UserSecurityService {
    // Security and authentication logic
}

class UserTeamService {
    // Team management logic
}
```

### 2. Trait Mixing Issues
**Problem**: Conflitti tra traits multipli
**Examples**:
- `HasTeams` + `HasRoles` method conflicts
- `HasMedia` + `HasUuids` property conflicts

**Solutions**:
```php
// Trait conflict resolution
trait HasTeamsResolved
{
    use HasTeams {
        HasTeams::teams as protected teamsRelation;
    }

    public function teams(): BelongsToMany
    {
        return $this->teamsRelation()->withTimestamps();
    }
}
```

### 3. Permission Caching Issues
**Problem**: Cache invalidation inconsistente
**Impact**: Stale permissions, security risks

**Solution**:
```php
// Centralized permission cache management
class PermissionCacheManager
{
    public function invalidateUserPermissions(User $user): void
    {
        Cache::forget("user_permissions_{$user->id}");
        Cache::forget("user_roles_{$user->id}");

        // Invalidate team permissions if user is in teams
        foreach ($user->teams as $team) {
            Cache::forget("team_permissions_{$team->id}");
        }
    }

    public function warmUpUserPermissions(User $user): void
    {
        $permissions = $user->getAllPermissions();
        Cache::put("user_permissions_{$user->id}", $permissions, 3600);
    }
}
```

## 📊 Performance Optimizations

### 1. Eager Loading Strategy
```php
// Optimized user loading
class UserQueryService
{
    public function getUsersForDashboard(): Collection
    {
        return User::with([
            'profile:id,user_id,display_name,avatar_url',
            'roles:id,name,color',
            'currentTeam:id,name',
            'devices' => fn($q) => $q->where('last_used_at', '>', now()->subDays(30)),
        ])->get();
    }

    public function getUsersForAdmin(): Collection
    {
        return User::with([
            'profile',
            'roles.permissions',
            'teams',
            'devices',
            'authenticationLogs' => fn($q) => $q->latest()->limit(5),
        ])->get();
    }
}
```

### 2. Database Optimization
```php
// Optimized queries with indexes
class OptimizedUserQueries
{
    public function activeUsersCount(): int
    {
        return Cache::remember('active_users_count', 3600, function () {
            return User::where('is_active', true)
                ->whereNotNull('email_verified_at')
                ->count();
        });
    }

    public function usersWithRole(string $role): Builder
    {
        return User::select(['id', 'name', 'email'])
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });
    }
}
```

## 🚀 Modern Laravel 12 + PHP 8.3 Patterns

### 1. Enum Integration
```php
// Modern enums for type safety
enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case SUSPENDED = 'suspended';

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'success',
            self::PENDING => 'warning',
            self::INACTIVE, self::SUSPENDED => 'danger',
        };
    }

    public function canLogin(): bool
    {
        return $this === self::ACTIVE;
    }
}

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';
    case GUEST = 'guest';

    public function permissions(): array
    {
        return match($this) {
            self::ADMIN => ['*'],
            self::MANAGER => ['manage_team', 'view_reports'],
            self::USER => ['view_dashboard'],
            self::GUEST => ['view_public'],
        };
    }
}
```

### 2. Enhanced Type Safety
```php
// Modern user model with strict typing
class User extends Authenticatable
{
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            'password_expires_at' => 'datetime',
            'is_active' => 'boolean',
            'is_otp' => 'boolean',
            'status' => UserStatus::class,
            'settings' => 'encrypted:json',
            'metadata' => UserMetadata::class, // Custom cast
        ];
    }
}

// Custom cast for user metadata
class UserMetadata implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?UserMetadataValue
    {
        return $value ? new UserMetadataValue(json_decode($value, true)) : null;
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        return $value ? json_encode($value instanceof UserMetadataValue ? $value->toArray() : $value) : null;
    }
}
```

## 📈 Metrics & KPIs

### Current State
- **User Model Complexity**: 400+ lines (High)
- **Trait Conflicts**: 3 documented conflicts
- **Permission Query Time**: 150ms average
- **Cache Hit Rate**: 65%
- **Test Coverage**: 60%

### Target State
- **User Model Complexity**: <200 lines (Medium)
- **Trait Conflicts**: 0
- **Permission Query Time**: <50ms
- **Cache Hit Rate**: 90%+
- **Test Coverage**: 85%+

## 🎯 Refactoring Roadmap

### Phase 1: Decomposition (Week 1)
1. Extract services from BaseUser
2. Resolve trait conflicts
3. Implement proper interfaces

### Phase 2: Performance (Week 2)
1. Optimize queries
2. Implement caching strategy
3. Add database indexes

### Phase 3: Modernization (Week 3)
1. Add enum support
2. Enhance type safety
3. Implement readonly classes

### Phase 4: Testing (Week 4)
1. Add comprehensive tests
2. Performance benchmarks
3. Security audits

Il modulo User rappresenta la spina dorsale dell'applicazione e richiede particular attenzione per refactoring e ottimizzazione seguendo principi SOLID e DRY.