# Xot Contracts and Interfaces Documentation

**Last Updated**: 2025-01-23
**Status**: ✅ Complete Contract Documentation

## 🎯 Overview

The Xot module provides a comprehensive contract system that defines interfaces for type safety, consistency, and proper module integration. These contracts ensure that all modules follow established patterns and maintain compatibility.

## 📋 Core Contracts

### 1. UserContract
**File**: `app/Contracts/UserContract.php`
**Purpose**: Defines the standard user interface across the system

```php
interface UserContract extends
    Authenticatable,           // Laravel authentication
    Authorizable,             // Laravel authorization
    CanResetPassword,         // Password reset capability
    MustVerifyEmail,          // Email verification
    FilamentUser              // Filament panel access
{
    // Core User Properties
    public function getId(): string|int;
    public function getName(): ?string;
    public function getEmail(): string;
    public function getEmailVerifiedAt(): ?DateTime;

    // Profile Management
    public function profile(): HasOne;
    public function getProfile(): ?ProfileContract;

    // Team Management
    public function teams(): BelongsToMany;
    public function currentTeam(): BelongsTo;
    public function hasTeams(): bool;
    public function isMemberOfTeam(Model $team): bool;

    // Role & Permission System
    public function hasRole(string|BackedEnum $role): bool;
    public function hasPermission(string|BackedEnum $permission): bool;
    public function roles(): BelongsToMany;
    public function permissions(): BelongsToMany;

    // API Token Management
    public function tokens(): MorphMany;
    public function createToken($name, array $scopes = []): PersonalAccessTokenResult;
    public function token(): ?Token;

    // Device Management
    public function devices(): BelongsToMany;
    public function hasDevice(Model $device): bool;

    // Activity & Authentication
    public function authentications(): HasMany;
    public function getLatestAuthentication(): ?Model;

    // Filament Integration
    public function canAccessPanel(Panel $panel): bool;
    public function getFilamentName(): string;
    public function getFilamentAvatarUrl(): ?string;
}
```

> **Update 17-11-2025**  
> La PHPDoc di `UserContract` è stata estesa con:
> - `@property TeamContract|null $currentTeam`
> - `@property \Illuminate\Database\Eloquent\Collection<int, UserRole> $roles`
> - `@property \Illuminate\Database\Eloquent\Collection<int, TeamContract> $teams`
>
> Questo consente a PHPStan level 10 di riconoscere correttamente i magic attribute Eloquent quando i moduli (es. User, Quaeris) lavorano solo contro il contratto Xot.

### 2. ProfileContract
**File**: `app/Contracts/ProfileContract.php`
**Purpose**: Standardizes profile functionality across modules

```php
interface ProfileContract extends HasLabel
{
    // Core Profile Data
    public function getId(): string|int;
    public function getFullName(): string;
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
    public function getEmail(): ?string;
    public function getPhone(): ?string;

    // User Relationship
    public function user(): BelongsTo;
    public function getUser(): ?UserContract;

    // Avatar & Media
    public function getAvatar(): string;
    public function getAvatarUrl(): string;
    public function hasAvatar(): bool;

    // Contact Information
    public function getContactInfo(): array;
    public function getPrimaryContact(): ?string;

    // Profile Status
    public function isActive(): bool;
    public function isVerified(): bool;
    public function getStatus(): string;

    // Custom Attributes
    public function getExtraAttributes(): Collection;
    public function getExtraAttribute(string $key): mixed;
    public function setExtraAttribute(string $key, mixed $value): self;

    // Business Logic
    public function getDisplayName(): string;
    public function getInitials(): string;
    public function getProfileCompleteness(): int;
}
```

### 3. ModelContactContract
**File**: `app/Contracts/ModelContactContract.php`
**Purpose**: Defines contact functionality for models

```php
interface ModelContactContract
{
    // Contact Information
    public function getPhone(): ?string;
    public function getEmail(): ?string;
    public function getMobile(): ?string;
    public function getFax(): ?string;
    public function getWebsite(): ?string;

    // Contact Management
    public function getAllContacts(): Collection;
    public function getPrimaryContact(): ?array;
    public function getContactByType(string $type): ?string;
    public function hasContact(string $type): bool;

    // Contact Formatting
    public function getFormattedPhone(): ?string;
    public function getFormattedEmail(): ?string;
    public function getContactDisplay(): string;
    public function getContactLinks(): array;

    // Validation
    public function validatePhone(string $phone): bool;
    public function validateEmail(string $email): bool;
    public function normalizePhone(string $phone): string;
}
```

### 4. ModelWithUserContract
**File**: `app/Contracts/ModelWithUserContract.php`
**Purpose**: Models that have user relationships

```php
interface ModelWithUserContract
{
    // User Relationships
    public function user(): BelongsTo;
    public function creator(): BelongsTo;
    public function updater(): BelongsTo;

    // User Information
    public function getUser(): ?UserContract;
    public function getCreator(): ?UserContract;
    public function getUpdater(): ?UserContract;
    public function getUserName(): ?string;

    // User Assignment
    public function assignUser(UserContract $user): self;
    public function unassignUser(): self;
    public function hasUser(): bool;
    public function isOwnedBy(UserContract $user): bool;

    // Audit Trail
    public function getCreatedBy(): ?string;
    public function getUpdatedBy(): ?string;
    public function getLastModifier(): ?UserContract;
    public function getCreationDate(): ?DateTime;
    public function getLastModifiedDate(): ?DateTime;
}
```

### 5. WithStateStatusContract
**File**: `app/Contracts/WithStateStatusContract.php`
**Purpose**: Status and state management for models

```php
interface WithStateStatusContract
{
    // Status Management
    public function getStatus(): string;
    public function setStatus(string $status): self;
    public function getAvailableStatuses(): array;
    public function isStatus(string $status): bool;

    // State Transitions
    public function canTransitionTo(string $status): bool;
    public function transitionTo(string $status): self;
    public function getValidTransitions(): array;
    public function getStatusHistory(): Collection;

    // Status Queries
    public function isActive(): bool;
    public function isInactive(): bool;
    public function isPending(): bool;
    public function isCompleted(): bool;
    public function isCancelled(): bool;

    // Status Display
    public function getStatusLabel(): string;
    public function getStatusColor(): string;
    public function getStatusIcon(): string;
    public function getStatusBadge(): string;

    // Status Events
    public function onStatusChanged(string $from, string $to): void;
    public function beforeStatusChange(string $to): bool;
    public function afterStatusChange(string $from): void;
}
```

### 6. HasRecursiveRelationshipsContract
**File**: `app/Contracts/HasRecursiveRelationshipsContract.php`
**Purpose**: Hierarchical and tree-like model structures

```php
interface HasRecursiveRelationshipsContract
{
    // Parent-Child Relationships
    public function parent(): BelongsTo;
    public function children(): HasMany;
    public function ancestors(): Collection;
    public function descendants(): Collection;

    // Tree Navigation
    public function getParent(): ?self;
    public function getChildren(): Collection;
    public function hasChildren(): bool;
    public function hasParent(): bool;
    public function isRoot(): bool;
    public function isLeaf(): bool;

    // Hierarchy Queries
    public function getDepth(): int;
    public function getLevel(): int;
    public function getRoot(): self;
    public function getLeaves(): Collection;
    public function getSiblings(): Collection;

    // Tree Manipulation
    public function makeRoot(): self;
    public function makeChildOf(self $parent): self;
    public function moveTo(self $parent): self;
    public function moveToRoot(): self;

    // Tree Structure
    public function getTree(): Collection;
    public function getPath(): Collection;
    public function getPathString(string $separator = ' > '): string;
    public function getDescendantsTree(): Collection;
}
```

## 🔧 Contract Implementation Guidelines

### 1. Implementation Requirements

#### Mandatory Methods
All contracts define mandatory methods that must be implemented:
```php
class ExampleModel implements ModelContactContract
{
    // Required implementation
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    // ... other required methods
}
```

#### Type Safety
All contract methods include proper type hints:
```php
// Correct implementation with proper types
public function hasRole(string|BackedEnum $role): bool
{
    if ($role instanceof BackedEnum) {
        $role = $role->value;
    }
    return $this->roles()->where('name', $role)->exists();
}
```

### 2. Contract Composition

#### Multiple Contract Implementation
Models can implement multiple contracts:
```php
class User extends XotBaseModel implements
    UserContract,
    ModelContactContract,
    WithStateStatusContract
{
    // Implement all required methods from all contracts
}
```

#### Contract Extension
Contracts can extend other contracts:
```php
interface ExtendedUserContract extends UserContract
{
    // Additional methods specific to extended functionality
    public function getBusinessProfile(): ?BusinessProfileContract;
    public function getPreferences(): array;
}
```

### 3. Contract Validation

#### PHPStan Integration
Contracts are validated using PHPStan:
```php
// PHPStan configuration ensures:
// - All contract methods are implemented
// - Return types match contract definitions
// - Parameter types are respected
// - Documentation is consistent
```

#### Runtime Validation
Some contracts include runtime validation:
```php
public function validateImplementation(): bool
{
    // Validate that all required methods exist
    // Check return types at runtime
    // Verify business logic compliance
}
```

## 📊 Contract Usage Patterns

### 1. Service Layer Integration
```php
class UserService
{
    public function createUser(array $data): UserContract
    {
        // Service methods work with contracts, not concrete classes
        $user = app(UserContract::class);
        // ... implementation
        return $user;
    }

    public function updateProfile(UserContract $user, array $data): ProfileContract
    {
        $profile = $user->getProfile();
        // ... implementation
        return $profile;
    }
}
```

### 2. Dependency Injection
```php
class SomeController
{
    public function __construct(
        private UserContract $userRepository,
        private ProfileContract $profileRepository
    ) {}

    public function show(UserContract $user): JsonResponse
    {
        return response()->json([
            'user' => $user->toArray(),
            'profile' => $user->getProfile()?->toArray(),
        ]);
    }
}
```

### 3. Factory Pattern
```php
class ModelFactory
{
    public static function create(string $type): ModelContactContract
    {
        return match ($type) {
            'client' => new Client(),
            'supplier' => new Supplier(),
            'employee' => new Employee(),
            default => throw new InvalidArgumentException("Unknown type: {$type}"),
        };
    }
}
```

## 🧪 Testing Contracts

### 1. Contract Compliance Testing
```php
abstract class ContractTestCase extends TestCase
{
    abstract protected function getContractImplementation(): object;
    abstract protected function getContractInterface(): string;

    public function test_implements_contract(): void
    {
        $implementation = $this->getContractImplementation();
        $interface = $this->getContractInterface();

        $this->assertInstanceOf($interface, $implementation);
    }

    public function test_all_contract_methods_implemented(): void
    {
        $implementation = $this->getContractImplementation();
        $interface = $this->getContractInterface();

        $reflection = new ReflectionClass($interface);
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            $this->assertTrue(
                method_exists($implementation, $method->getName()),
                "Method {$method->getName()} not implemented"
            );
        }
    }
}
```

### 2. Contract Behavior Testing
```php
class UserContractTest extends ContractTestCase
{
    protected function getContractImplementation(): UserContract
    {
        return User::factory()->create();
    }

    protected function getContractInterface(): string
    {
        return UserContract::class;
    }

    public function test_user_can_have_profile(): void
    {
        $user = $this->getContractImplementation();
        $profile = Profile::factory()->for($user)->create();

        $this->assertInstanceOf(ProfileContract::class, $user->getProfile());
        $this->assertEquals($profile->id, $user->getProfile()->getId());
    }
}
```

## 🔗 Integration Examples

### 1. Filament Resource Integration
```php
class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form fields automatically respect UserContract
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->rule(fn (UserContract $record = null) =>
                        $record?->getValidationRules()['name'] ?? 'required'
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columns use contract methods
                Tables\Columns\TextColumn::make('display_name')
                    ->formatStateUsing(fn (UserContract $record) =>
                        $record->getProfile()?->getDisplayName() ?? $record->getName()
                    ),
            ]);
    }
}
```

### 2. Business Logic Integration
```php
class AppointmentService
{
    public function scheduleAppointment(
        UserContract $client,
        UserContract $technician,
        DateTime $scheduledDate
    ): AppointmentContract {
        // Business logic uses contracts for flexibility
        if (!$client->hasRole('client')) {
            throw new InvalidArgumentException('User must be a client');
        }

        if (!$technician->hasRole('technician')) {
            throw new InvalidArgumentException('User must be a technician');
        }

        // Create appointment using contract methods
        $appointment = new Appointment([
            'client_id' => $client->getId(),
            'technician_id' => $technician->getId(),
            'scheduled_date' => $scheduledDate,
        ]);

        return $appointment;
    }
}
```

---

*This documentation provides comprehensive guidance for implementing and using contracts within the Xot ecosystem, ensuring type safety and consistency across all modules.*