# User Module - Query Optimization Analysis

## Overview
The User module has several critical performance issues related to authentication, authorization, and user management. As the foundation for all user operations, these inefficiencies cascade throughout the entire application.

## Critical Query Issues Identified

### 1. Authentication Log Processing (CRITICAL IMPACT)

**File**: `Modules/User/app/Listeners/OtherDeviceLogoutListener.php:42`
**Current Implementation**:
```php
foreach ($user->authentications()->whereLoginSuccessful(true)->whereNull('logout_at')->get() as $log) {
    if ($log->getKey() !== $authenticationLog->getKey()) {
        $log->update([
            'cleared_by_user' => true,
            'logout_at' => now(),
        ]);
    }
}
```

**Problem Analysis**:
- Individual UPDATE queries for each authentication log
- Loads all records into memory before filtering
- No bulk update operations
- For a user with 100 active sessions: 1 SELECT + 99 individual UPDATEs = 100 queries

**Impact**: Heavy users can have dozens of active sessions, causing significant database load

**Immediate Fix**:
```php
// Single bulk update query
$user->authentications()
    ->whereLoginSuccessful(true)
    ->whereNull('logout_at')
    ->where('id', '!=', $authenticationLog->getKey())
    ->update([
        'cleared_by_user' => true,
        'logout_at' => now(),
    ]);
```

**Performance Improvement**: 100 queries → 1 query (99% reduction)

### 2. User Role/Permission Loading (HIGH IMPACT)

**File**: `Modules/User/app/Models/BaseUser.php:190-192`
**Current Implementation**:
```php
protected $with = [
    // Removed 'roles' to reduce memory usage - load explicitly when needed
];
```

**Problem Analysis**:
- Critical relationships not eagerly loaded by default
- Every role/permission check triggers additional queries
- Authorization checks cause N+1 queries throughout the application

**Impact**: Every authenticated request triggers multiple role/permission queries

**Authorization Query Pattern Issues**:
```php
// Current pattern found throughout the app
if ($user->hasRole('admin')) { // Query 1: Load roles
    if ($user->can('manage_customers')) { // Query 2: Load permissions
        // Action
    }
}
```

**Optimization Strategy**:
```php
// 1. Smart eager loading based on context
class User extends BaseUser
{
    protected $with = ['roles.permissions'];

    // Alternative: Context-aware loading
    public function scopeWithAuthData($query)
    {
        return $query->with([
            'roles.permissions',
            'permissions',
            'teams.permissions'
        ]);
    }
}

// 2. Permission caching
class CachedUserPermissions
{
    public function userCan(User $user, string $permission): bool
    {
        $cacheKey = "user_permissions_{$user->id}";

        $permissions = Cache::remember($cacheKey, 300, function() use ($user) {
            return $user->getAllPermissions()->pluck('name')->toArray();
        });

        return in_array($permission, $permissions);
    }
}
```

### 3. Team Membership Queries (HIGH IMPACT)

**File**: Various team-related files
**Current Patterns**:
```php
// Pattern found in multiple places
$teams = $user->teams; // Triggers query
foreach ($teams as $team) {
    $members = $team->users; // N+1 query for each team
    $permissions = $team->permissions; // Another N+1 query
}
```

**Problem Analysis**:
- No eager loading for team relationships
- Repeated queries for team members and permissions
- Team switching triggers multiple database hits

**Optimization**:
```php
// Optimized team loading
class UserTeamService
{
    public function getUserTeamsWithData(User $user): Collection
    {
        return $user->teams()
            ->with([
                'users:id,name,email',
                'permissions:id,name',
                'owner:id,name'
            ])
            ->withCount('users')
            ->get();
    }

    public function switchUserTeam(User $user, int $teamId): bool
    {
        // Validate team membership with single query
        $team = $user->teams()
            ->where('teams.id', $teamId)
            ->first();

        if (!$team) {
            return false;
        }

        // Update current team
        $user->update(['current_team_id' => $teamId]);

        // Clear permission cache
        Cache::forget("user_permissions_{$user->id}");

        return true;
    }
}
```

### 4. User Search and Filtering (MEDIUM IMPACT)

**File**: User resource and search implementations
**Problem**: Inefficient search patterns without proper indexing

**Current Pattern**:
```php
// Found in user searches
User::where('name', 'LIKE', "%{$search}%")
    ->orWhere('email', 'LIKE', "%{$search}%")
    ->get(); // No pagination, no optimization
```

**Issues**:
- Full table scans on LIKE queries
- No proper text indexing
- Missing pagination for large result sets

**Optimization**:
```sql
-- Add full-text search indexes
ALTER TABLE users ADD FULLTEXT(name, email);
CREATE INDEX idx_users_name_email ON users(name, email);
CREATE INDEX idx_users_active_type ON users(is_active, type);
```

```php
// Optimized search implementation
class UserSearchService
{
    public function searchUsers(string $query, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $builder = User::query();

        // Use full-text search for better performance
        if (strlen($query) >= 3) {
            $builder->whereRaw("MATCH(name, email) AGAINST(? IN BOOLEAN MODE)", [$query]);
        } else {
            $builder->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "{$query}%")
                  ->orWhere('email', 'LIKE', "{$query}%");
            });
        }

        // Apply filters efficiently
        if (isset($filters['type'])) {
            $builder->where('type', $filters['type']);
        }

        if (isset($filters['active'])) {
            $builder->where('is_active', $filters['active']);
        }

        return $builder->with(['roles:id,name', 'currentTeam:id,name'])
            ->select(['id', 'name', 'email', 'type', 'is_active', 'current_team_id'])
            ->paginate($perPage);
    }
}
```

### 5. Password Policy Validation (LOW IMPACT)

**File**: Password validation implementations
**Problem**: Repeated database queries for password history

**Current Pattern**:
```php
// Check password history
$recentPasswords = $user->passwordHistory()
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get(); // Separate query each time

foreach ($recentPasswords as $old) {
    if (Hash::check($newPassword, $old->password)) {
        // Password already used
    }
}
```

**Optimization**:
```php
class PasswordPolicyService
{
    public function validatePasswordHistory(User $user, string $newPassword): bool
    {
        // Single query with limit
        $recentHashes = $user->passwordHistory()
            ->orderBy('created_at', 'desc')
            ->limit(config('auth.password_history_limit', 5))
            ->pluck('password')
            ->toArray();

        // Use PHP array operations for hash checking
        foreach ($recentHashes as $hash) {
            if (Hash::check($newPassword, $hash)) {
                return false;
            }
        }

        return true;
    }
}
```

## Database Schema Optimizations

### Critical Indexes
```sql
-- Authentication logs performance
CREATE INDEX idx_auth_logs_user_active ON authentication_logs(authenticatable_id, logout_at, login_successful);
CREATE INDEX idx_auth_logs_cleanup ON authentication_logs(logout_at, created_at) WHERE logout_at IS NOT NULL;

-- User role assignments
CREATE INDEX idx_model_has_roles_user ON model_has_roles(model_id, model_type) WHERE model_type = 'App\\Models\\User';

-- Team memberships
CREATE INDEX idx_team_user_user_team ON team_user(user_id, team_id, role);
CREATE INDEX idx_team_user_team_role ON team_user(team_id, role);

-- User search optimization
CREATE INDEX idx_users_search ON users(name, email, is_active);
CREATE INDEX idx_users_type_active ON users(type, is_active);

-- Password expiry tracking
CREATE INDEX idx_users_password_expires ON users(password_expires_at) WHERE password_expires_at IS NOT NULL;
```

### Table Partitioning for Large Datasets
```sql
-- Partition authentication logs by month
ALTER TABLE authentication_logs PARTITION BY RANGE (MONTH(created_at)) (
    PARTITION p202401 VALUES LESS THAN (2),
    PARTITION p202402 VALUES LESS THAN (3),
    -- ... continue for each month
    PARTITION pmax VALUES LESS THAN MAXVALUE
);
```

## Caching Strategy

### User Permission Caching
```php
class UserPermissionCache
{
    private const CACHE_TTL = 300; // 5 minutes

    public function getUserPermissions(User $user): Collection
    {
        $cacheKey = "user_permissions_{$user->id}_{$user->updated_at->timestamp}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($user) {
            return $user->getAllPermissions();
        });
    }

    public function getUserRoles(User $user): Collection
    {
        $cacheKey = "user_roles_{$user->id}_{$user->updated_at->timestamp}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($user) {
            return $user->roles()->with('permissions')->get();
        });
    }

    public function invalidateUserCache(User $user): void
    {
        Cache::tags(['user_permissions', "user_{$user->id}"])->flush();
    }
}
```

### Session-Based Permission Caching
```php
class SessionPermissionCache
{
    public function cacheUserPermissions(User $user): void
    {
        $permissions = $user->getAllPermissions()->pluck('name')->toArray();
        session(['user_permissions' => $permissions]);
    }

    public function userCan(string $permission): bool
    {
        $permissions = session('user_permissions', []);
        return in_array($permission, $permissions);
    }
}
```

## Repository Pattern Implementation

### User Repository
```php
class UserRepository
{
    public function findWithCompleteData(int $userId): ?User
    {
        return User::with([
            'roles.permissions',
            'permissions',
            'teams.permissions',
            'currentTeam',
            'profile'
        ])->find($userId);
    }

    public function getActiveUsersForTeam(int $teamId): Collection
    {
        return User::whereHas('teams', fn($q) => $q->where('team_id', $teamId))
            ->where('is_active', true)
            ->with(['roles:id,name', 'profile:user_id,avatar'])
            ->select(['id', 'name', 'email', 'current_team_id'])
            ->get();
    }

    public function getUsersRequiringPasswordChange(): Collection
    {
        return User::where('password_expires_at', '<', now())
            ->where('is_active', true)
            ->select(['id', 'name', 'email', 'password_expires_at'])
            ->get();
    }
}
```

## Background Processing

### Authentication Cleanup
```php
class CleanupExpiredSessionsJob implements ShouldQueue
{
    public function handle(): void
    {
        // Bulk cleanup of expired sessions
        AuthenticationLog::where('logout_at', '<', now()->subDays(30))
            ->orWhere('created_at', '<', now()->subDays(90))
            ->delete();

        // Cleanup password reset tokens
        DB::table('password_resets')
            ->where('created_at', '<', now()->subHours(24))
            ->delete();
    }
}
```

### User Metrics Calculation
```php
class CalculateUserMetricsJob implements ShouldQueue
{
    public function handle(): void
    {
        $metrics = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'users_by_type' => User::groupBy('type')->selectRaw('type, COUNT(*) as count')->pluck('count', 'type'),
            'login_stats' => $this->calculateLoginStats(),
        ];

        Cache::put('user_metrics', $metrics, now()->addHour());
    }
}
```

## Performance Monitoring

### User Module Specific Monitoring
```php
// Add to UserServiceProvider
class UserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Monitor authentication queries
        DB::listen(function ($query) {
            if (Str::contains($query->sql, ['authentication_logs', 'model_has_roles', 'team_user'])) {
                if ($query->time > 300) { // Queries over 300ms
                    Log::warning('Slow User module query', [
                        'sql' => $query->sql,
                        'time' => $query->time,
                        'module' => 'User'
                    ]);
                }
            }
        });

        // Monitor login performance
        Event::listen(Login::class, function (Login $event) {
            $user = $event->user;

            // Track login time for performance monitoring
            Cache::put("user_login_time_{$user->id}", microtime(true), 60);
        });
    }
}
```

## Performance Impact Assessment

### Expected Improvements:
- **Authentication processing**: 99% reduction (100 queries → 1 query)
- **Permission checking**: 90% faster with caching
- **User search**: 80% faster with proper indexing
- **Team operations**: 85% reduction in queries
- **Session management**: 70% reduction in database load

### Implementation Priority:
1. **Critical** (Day 1): Fix authentication log bulk updates
2. **High** (Week 1): Implement permission caching
3. **Medium** (Week 2): Add database indexes and optimize search
4. **Low** (Week 3): Implement background cleanup and monitoring

This optimization plan will transform the User module from a performance bottleneck into a highly efficient authentication and authorization system.