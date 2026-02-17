# Analisi di Ottimizzazione - Modulo User

## 🎯 Principi Applicati: DRY + KISS + SOLID + ROBUST + Laraxot

### 📊 Stato Attuale del Modulo

Il modulo User rappresenta il sistema di autenticazione e autorizzazione centrale, gestendo:
- **Autenticazione** multi-tipo con STI (Single Table Inheritance)
- **Autorizzazione** con Spatie Permission e RBAC
- **Multi-tenancy** con team e tenant
- **Security** con 2FA, audit trail e session management
- **API** con Laravel Passport e JWT

---

## 🚨 Problemi Critici Identificati

### 1. **VIOLAZIONE DRY - Enum Inconsistente**

#### Problema: UserType.php - Enum Non Allineato con Business Logic
```php
// ❌ PROBLEMATICO - Enum generico non specifico per dominio sanitario
enum UserType: string implements HasColor, HasIcon, HasLabel
{
    case MasterAdmin = 'master_admin';
    case BoUser = 'backoffice_user';
    case CustomerUser = 'customer_user';
    case System = 'system';
    case Technician = 'technician';
}
```

Il modulo User ha un enum generico che non rispecchia il dominio sanitario di <nome progetto>.

**✅ Soluzione DOMAIN-DRIVEN + DRY:**
```php
// Nel modulo base User - enum generico
enum UserType: string implements HasColor, HasIcon, HasLabel
{
    case ADMIN = 'admin';
    case USER = 'user';
    case SYSTEM = 'system';
}

// Nel modulo <nome progetto> - enum specifico del dominio
enum <nome progetto>UserType: string implements HasColor, HasIcon, HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
}
```

### 2. **VIOLAZIONE SOLID - Interface Segregation**

#### Problema: UserContract.php - Interfaccia Troppo Pesante
```php
// ❌ PROBLEMATICO - Una interfaccia fa troppo
interface UserContract extends Authenticatable
{
    // Authentication methods
    public function getKey(): mixed;
    
    // Team management
    public function currentTeam(): BelongsTo;
    public function teams(): BelongsToMany;
    public function ownsTeam(TeamContract $team): bool;
    
    // Permissions
    public function teamPermissions(TeamContract $team): array;
    public function hasTeamPermission(TeamContract $team, string $permission): bool;
    
    // Two Factor Auth
    public function recoveryCodes(): array;
    public function replaceRecoveryCode(string $code): void;
    
    // JWT
    public function getJWTIdentifier(): mixed;
    public function getJWTCustomClaims(): array;
    
    // Roles
    public function roles(): BelongsToMany;
}
```

**✅ Soluzione SOLID (Interface Segregation):**
```php
// Separare in interfacce specifiche
interface AuthenticatableUserContract extends Authenticatable
{
    public function getKey(): mixed;
}

interface TeamMemberContract
{
    public function currentTeam(): BelongsTo;
    public function teams(): BelongsToMany;
    public function ownsTeam(TeamContract $team): bool;
    public function belongsToTeam(TeamContract $team): bool;
}

interface HasPermissionsContract
{
    public function teamPermissions(TeamContract $team): array;
    public function hasTeamPermission(TeamContract $team, string $permission): bool;
    public function roles(): BelongsToMany;
}

interface TwoFactorAuthContract
{
    public function recoveryCodes(): array;
    public function replaceRecoveryCode(string $code): void;
}

interface JwtAuthContract
{
    public function getJWTIdentifier(): mixed;
    public function getJWTCustomClaims(): array;
}

// Composizione finale
interface UserContract extends 
    AuthenticatableUserContract,
    TeamMemberContract,
    HasPermissionsContract,
    TwoFactorAuthContract,
    JwtAuthContract
{
    // Interfaccia composta ma segregata
}
```

### 3. **VIOLAZIONE KISS - Complessità Eccessiva nei Trait**

#### Problema: BaseUser.php - Troppi Trait Sovrapposti
```php
// ❌ PROBLEMATICO - Troppi trait senza chiara separazione
class BaseUser extends Authenticatable implements HasMedia, UserContract, HasName, HasTenants
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasUuids;
    use Notifiable;
    use RelationX;
    use Traits\HasAuthenticationLogTrait;
    use Traits\HasTenants;
    use Traits\HasTeams;
    use HasChildren;
    use InteractsWithMedia;
}
```

**✅ Soluzione KISS + SOLID:**
```php
// Raggruppare trait per responsabilità
trait HasAuthentication
{
    use HasApiTokens;
    use HasUuids;
    use Notifiable;
}

trait HasAuthorization
{
    use HasRoles;
    use Traits\HasTenants;
    use Traits\HasTeams;
}

trait HasAuditTrail
{
    use Traits\HasAuthenticationLogTrait;
    use RelationX;
}

trait HasMediaManagement
{
    use InteractsWithMedia;
}

trait HasInheritance
{
    use HasChildren;
    use HasFactory;
}

// BaseUser semplificato
class BaseUser extends Authenticatable implements HasMedia, UserContract, HasName, HasTenants
{
    use HasAuthentication;
    use HasAuthorization;
    use HasAuditTrail;
    use HasMediaManagement;
    use HasInheritance;
}
```

---

## ⚡ Ottimizzazioni Performance

### 1. **Eager Loading Intelligente**

#### Problema: N+1 Query su Relazioni Utenti
```php
// ❌ PROBLEMATICO
$users = User::all();
foreach ($users as $user) {
    echo $user->roles->pluck('name'); // N+1 query
    echo $user->teams->count();       // N+1 query
}
```

**✅ Soluzione ROBUST:**
```php
// Scope per eager loading intelligente
class BaseUser extends Authenticatable
{
    public function scopeWithBasicRelations(Builder $query): Builder
    {
        return $query->with(['roles:id,name', 'currentTeam:id,name']);
    }
    
    public function scopeWithFullRelations(Builder $query): Builder
    {
        return $query->with([
            'roles:id,name,guard_name',
            'teams:id,name,slug',
            'currentTeam:id,name,slug',
            'permissions:id,name',
        ]);
    }
    
    public function scopeForApi(Builder $query): Builder
    {
        return $query->select(['id', 'name', 'email', 'type', 'is_active'])
                    ->with(['roles:id,name']);
    }
}

// Utilizzo
$users = User::withBasicRelations()->get();
$apiUsers = User::forApi()->get();
```

### 2. **Caching Strategy per Permissions**

```php
trait HasCachedPermissions
{
    public function getCachedPermissions(): Collection
    {
        return Cache::remember(
            "user_permissions_{$this->id}",
            3600, // 1 hour
            fn() => $this->getAllPermissions()
        );
    }
    
    public function getCachedRoles(): Collection
    {
        return Cache::remember(
            "user_roles_{$this->id}",
            3600,
            fn() => $this->roles()->get()
        );
    }
    
    public function flushPermissionCache(): void
    {
        Cache::forget("user_permissions_{$this->id}");
        Cache::forget("user_roles_{$this->id}");
    }
    
    protected static function bootHasCachedPermissions(): void
    {
        static::saved(fn($user) => $user->flushPermissionCache());
        static::deleted(fn($user) => $user->flushPermissionCache());
    }
}
```

### 3. **Database Indexing Strategy**

```php
// Migration ottimizzata
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Indici per performance
        $table->index(['type', 'is_active']); // Per filtri comuni
        $table->index(['email', 'type']);     // Per login multi-tipo
        $table->index('current_team_id');     // Per team queries
        $table->index('created_at');          // Per ordinamenti temporali
        
        // Indice composito per query frequenti
        $table->index(['type', 'is_active', 'created_at'], 'users_type_active_created_idx');
    });
}
```

---

## 🔒 Miglioramenti Sicurezza

### 1. **Rate Limiting Avanzato**

```php
class AuthenticationRateLimiter
{
    public function __construct(
        private RateLimiter $limiter,
        private EventDispatcher $events
    ) {}
    
    public function tooManyAttempts(Request $request): bool
    {
        $key = $this->throttleKey($request);
        
        if ($this->limiter->tooManyAttempts($key, 5)) {
            $this->events->dispatch(new TooManyLoginAttempts($request));
            return true;
        }
        
        return false;
    }
    
    public function hit(Request $request): void
    {
        $key = $this->throttleKey($request);
        $this->limiter->hit($key, 300); // 5 minutes
    }
    
    private function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }
}
```

### 2. **Password Security Enhancement**

```php
trait HasSecurePassword
{
    public function setPasswordAttribute(string $value): void
    {
        // Validazione password strength
        if (!$this->isPasswordStrong($value)) {
            throw new WeakPasswordException('Password does not meet security requirements');
        }
        
        $this->attributes['password'] = Hash::make($value);
        $this->attributes['password_expires_at'] = now()->addMonths(3);
    }
    
    private function isPasswordStrong(string $password): bool
    {
        return strlen($password) >= 8 
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[0-9]/', $password)
            && preg_match('/[^A-Za-z0-9]/', $password);
    }
    
    public function isPasswordExpired(): bool
    {
        return $this->password_expires_at && $this->password_expires_at->isPast();
    }
}
```

### 3. **Session Security**

```php
class SecureSessionManager
{
    public function rotateSession(User $user): void
    {
        // Rigenera session ID per prevenire session fixation
        request()->session()->regenerate();
        
        // Log dell'evento di sicurezza
        activity('security')
            ->causedBy($user)
            ->log('Session rotated for security');
    }
    
    public function invalidateOtherSessions(User $user): void
    {
        // Invalida tutte le altre sessioni dell'utente
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', request()->session()->getId())
            ->delete();
            
        activity('security')
            ->causedBy($user)
            ->log('Other sessions invalidated');
    }
}
```

---

## 🏗️ Refactoring Architetturale

### 1. **Command Pattern per Azioni Utente**

```php
// Command per creazione utente
class CreateUserCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly UserType $type,
        public readonly array $attributes = []
    ) {}
}

// Handler del command
class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private EventDispatcher $events
    ) {}
    
    public function handle(CreateUserCommand $command): User
    {
        $user = $this->repository->create([
            'email' => $command->email,
            'password' => $command->password,
            'type' => $command->type->value,
            ...$command->attributes,
        ]);
        
        $this->events->dispatch(new UserCreated($user));
        
        return $user;
    }
}
```

### 2. **Strategy Pattern per Authentication**

```php
interface AuthenticationStrategyInterface
{
    public function authenticate(array $credentials): ?User;
    public function supports(array $credentials): bool;
}

class EmailPasswordStrategy implements AuthenticationStrategyInterface
{
    public function authenticate(array $credentials): ?User
    {
        return User::where('email', $credentials['email'])
                  ->where('is_active', true)
                  ->first();
    }
    
    public function supports(array $credentials): bool
    {
        return isset($credentials['email'], $credentials['password']);
    }
}

class TwoFactorStrategy implements AuthenticationStrategyInterface
{
    public function authenticate(array $credentials): ?User
    {
        // Implementazione 2FA
    }
    
    public function supports(array $credentials): bool
    {
        return isset($credentials['email'], $credentials['otp']);
    }
}

// Context
class AuthenticationManager
{
    /** @var AuthenticationStrategyInterface[] */
    private array $strategies = [];
    
    public function addStrategy(AuthenticationStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }
    
    public function authenticate(array $credentials): ?User
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($credentials)) {
                return $strategy->authenticate($credentials);
            }
        }
        
        return null;
    }
}
```

### 3. **Factory Pattern per User Types**

```php
interface UserFactoryInterface
{
    public function create(UserType $type, array $attributes): User;
}

class UserTypeFactory implements UserFactoryInterface
{
    public function create(UserType $type, array $attributes): User
    {
        return match($type) {
            UserType::ADMIN => $this->createAdmin($attributes),
            UserType::DOCTOR => $this->createDoctor($attributes),
            UserType::PATIENT => $this->createPatient($attributes),
            default => throw new InvalidUserTypeException("Unsupported user type: {$type->value}")
        };
    }
    
    private function createAdmin(array $attributes): Admin
    {
        $admin = Admin::create($attributes);
        $admin->assignRole('admin');
        return $admin;
    }
    
    private function createDoctor(array $attributes): Doctor
    {
        $doctor = Doctor::create($attributes);
        $doctor->assignRole('doctor');
        return $doctor;
    }
    
    private function createPatient(array $attributes): Patient
    {
        $patient = Patient::create($attributes);
        $patient->assignRole('patient');
        return $patient;
    }
}
```

---

## 📋 Testing Strategy

### 1. **Unit Tests per Authentication**

```php
class AuthenticationTest extends TestCase
{
    public function test_user_can_authenticate_with_valid_credentials(): void
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        
        // Act
        $result = Auth::attempt([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        
        // Assert
        $this->assertTrue($result);
        $this->assertAuthenticatedAs($user);
    }
    
    public function test_inactive_user_cannot_authenticate(): void
    {
        // Arrange
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);
        
        // Act
        $result = Auth::attempt([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        
        // Assert
        $this->assertFalse($result);
        $this->assertGuest();
    }
}
```

### 2. **Integration Tests per Permissions**

```php
class UserPermissionsTest extends TestCase
{
    public function test_user_with_role_has_correct_permissions(): void
    {
        // Arrange
        $user = User::factory()->create();
        $role = Role::create(['name' => 'doctor', 'guard_name' => 'web']);
        $permission = Permission::create(['name' => 'view appointments', 'guard_name' => 'web']);
        
        $role->givePermissionTo($permission);
        $user->assignRole($role);
        
        // Act & Assert
        $this->assertTrue($user->hasPermissionTo('view appointments'));
        $this->assertTrue($user->hasRole('doctor'));
    }
}
```

---

## 📈 Monitoring e Observability

### 1. **Authentication Metrics**

```php
class AuthenticationMetrics
{
    public function recordLoginAttempt(string $email, bool $successful): void
    {
        $tags = [
            'successful' => $successful ? 'true' : 'false',
            'user_type' => $this->getUserType($email),
        ];
        
        Metrics::increment('auth.login_attempts', 1, $tags);
        
        if (!$successful) {
            Metrics::increment('auth.failed_attempts', 1, $tags);
        }
    }
    
    public function recordPasswordReset(string $email): void
    {
        Metrics::increment('auth.password_resets', 1, [
            'user_type' => $this->getUserType($email),
        ]);
    }
    
    private function getUserType(string $email): string
    {
        $user = User::where('email', $email)->first();
        return $user ? $user->type->value : 'unknown';
    }
}
```

### 2. **Security Alerts**

```php
class SecurityAlertService
{
    public function __construct(
        private NotificationService $notifications,
        private Logger $logger
    ) {}
    
    public function handleSuspiciousActivity(User $user, string $activity): void
    {
        $this->logger->warning('Suspicious activity detected', [
            'user_id' => $user->id,
            'activity' => $activity,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        // Notifica amministratori
        $admins = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();
        
        foreach ($admins as $admin) {
            $this->notifications->send(
                $admin,
                new SuspiciousActivityAlert($user, $activity)
            );
        }
    }
}
```

---

## 🎯 Roadmap di Implementazione

### Fase 1: Refactoring Interface (Settimana 1-2)
- [ ] Separare UserContract in interfacce specifiche
- [ ] Implementare Interface Segregation Principle
- [ ] Raggruppare trait per responsabilità
- [ ] Aggiornare enum per domain-specific types

### Fase 2: Performance Optimization (Settimana 3-4)
- [ ] Implementare eager loading intelligente
- [ ] Aggiungere caching per permissions
- [ ] Ottimizzare indici database
- [ ] Implementare query scopes

### Fase 3: Security Enhancement (Settimana 5-6)
- [ ] Implementare rate limiting avanzato
- [ ] Aggiungere password security policies
- [ ] Implementare session security
- [ ] Aggiungere security monitoring

### Fase 4: Architecture Patterns (Settimana 7-8)
- [ ] Implementare Command Pattern
- [ ] Aggiungere Strategy Pattern per auth
- [ ] Implementare Factory Pattern
- [ ] Aggiungere comprehensive testing

---

## 🔗 Collegamenti

- [Spatie Permission Documentation](https://spatie.be/project_docs/laravel-permission)
- [Laravel Authentication](https://laravel.com/project_docs/authentication)
- [Multi-tenancy Best Practices](../../../project_docs/multi-tenancy-best-practices.md)
- [Security Guidelines](../../../project_docs/security-guidelines.md)

---

*Documento creato: Gennaio 2025*  
*Principi: DRY + KISS + SOLID + ROBUST + Laraxot*  
*Stato: 🟡 Necessita Refactoring Interface e Performance*

