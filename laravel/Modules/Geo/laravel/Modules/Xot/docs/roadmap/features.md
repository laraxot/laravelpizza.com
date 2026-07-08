# Xot Module - Features

## 📋 Table of Contents
- [Core Features](#core-features)
- [Base Classes](#base-classes)
- [Type Safety](#type-safety)
- [Filament Integration](#filament-integration)
- [Testing Infrastructure](#testing-infrastructure)
- [Helper Functions](#helper-functions)
- [Developer Tools](#developer-tools)

## Core Features

### 1. Base Class System
Xot provides a comprehensive base class system that all other modules extend.

#### XotBaseModel
**Purpose**: Foundation for all Eloquent models

**Features**:
- Automatic UUID primary keys
- Created/Updated by tracking
- Soft deletion support
- Model states management
- Relationship helpers
- Query scopes
- Casting management
- Translation support

**Methods**:
- `hasTranslations()` - Check translation support
- `getTranslatableAttributes()` - Get translatable fields
- `scopeOfModule()` - Query by module
- `scopeActive()` - Query active records
- `scopeRecent()` - Query recent records

**Usage**:
```php
class User extends XotBaseModel
{
    protected $table = 'users';
    protected $fillable = ['name', 'email'];
}
```

#### XotBaseResource
**Purpose**: Foundation for all Filament resources

**Features**:
- Standard form schema pattern
- Standard table columns pattern
- Automatic translations
- Permission handling
- Navigation management

**Methods**:
- `getFormSchema()` - Define form fields
- `getTableColumns()` - Define table columns
- `getTableFilters()` - Define filters
- `getTableActions()` - Define actions
- `getTableBulkActions()` - Define bulk actions

**Usage**:
```php
class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ];
    }
}
```

#### XotBaseServiceProvider
**Purpose**: Foundation for all service providers

**Features**:
- Module configuration
- Route registration
- View path management
- Translation loading
- Asset publishing

**Methods**:
- `register()` - Register services
- `boot()` - Boot services
- `registerRoutes()` - Register module routes
- `registerViews()` - Register view paths
- `registerTranslations()` - Register translations

**Usage**:
```php
class UserServiceProvider extends XotBaseServiceProvider
{
    protected $name = 'User';
    
    public function register(): void
    {
        // Register services
    }
}
```

#### XotBaseWidget
**Purpose**: Foundation for all Filament widgets

**Features**:
- Chart widgets
- Stat overview widgets
- Custom widgets
- Refresh interval support
- Permission checks

**Methods**:
- `getStats()` - Get stat data
- `getChartData()` - Get chart data
- `canView()` - Check view permission
- `getPollingInterval()` - Get refresh interval

#### XotBaseMigration
**Purpose**: Foundation for all database migrations

**Features**:
- Automatic timestamps
- UUID support
- Index management
- Foreign key constraints
- Table creation/update helpers

**Methods**:
- `tableCreate()` - Create table
- `tableUpdate()` - Update table
- `updateTimestamps()` - Add timestamp columns
- `addUuidColumn()` - Add UUID column

### 2. Type Safety

#### PHPStan Level 10 Compliance
Xot enforces strict type safety throughout:

**Features**:
- 100% type coverage
- Generic type parameters
- Return type declarations
- Parameter type hints
- Null safety checks

**Examples**:
```php
/**
 * @return Collection<int, Model>
 */
public function getActiveRecords(): Collection
{
    return $this->query()->where('is_active', true)->get();
}

public function processItem(string $itemId): ?Item
{
    return Item::find($itemId);
}
```

#### Type Definitions
Xot provides comprehensive type definitions:

- Model types with generics
- Collection types
- Relationship types
- Action return types
- Service types

### 3. Filament Integration

#### Resource Patterns
Xot standardizes Filament resource patterns:

**Form Schema Pattern**:
```php
public function getFormSchema(): array
{
    return [
        // No label() - handled by translations
        TextInput::make('name')->required(),
        Select::make('type')->options([...]),
    ];
}
```

**Table Columns Pattern**:
```php
public function getTableColumns(): array
{
    return [
        TextColumn::make('name')->searchable(),
        TextColumn::make('email')->searchable(),
        BooleanColumn::make('is_active'),
    ];
}
```

**No table() Override**:
```php
// ❌ DON'T DO THIS
public function table(Table $table): void
{
    $table->columns([...]);
}

// ✅ DO THIS
public function getTableColumns(): array
{
    return [...];
}
```

#### Permission Handling
Xot integrates with Spatie Permissions:

**Automatic Permission Checks**:
```php
protected static ?string $permission = 'users.view';

public static function canViewAny(): bool
{
    return auth()->user()?->can('view_any_users') ?? false;
}
```

#### Navigation Management
Xot handles navigation automatically:

**Auto-registration**:
```php
public static function getNavigationGroup(): ?string
{
    return 'Users';
}

public static function getNavigationLabel(): string
{
    return 'Users';
}
```

### 4. Testing Infrastructure

#### Test Base Classes
Xot provides test base classes:

**Feature Test Base**:
```php
abstract class FeatureTestCase extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        // Setup code
    }
}
```

**Unit Test Base**:
```php
abstract class UnitTestCase extends TestCase
{
    // Unit test helpers
}
```

#### Factories
Xot provides factory patterns:

**Base Factory**:
```php
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
```

#### Testing Utilities
Xot provides testing helpers:

```php
// Create model with relationships
$user = User::factory()->withRoles()->create();

// Create with factory
$item = Item::factory()->create();

// Act as user
$this->actingAs($user)->get('/items');
```

### 5. Helper Functions

#### String Helpers
```php
// Convert to snake_case
str_snake('MyClassName'); // my_class_name

// Convert to camelCase
str_camel('my_class_name'); // myClassName

// Generate slug
str_slug('My Title Here'); // my-title-here
```

#### Array Helpers
```php
// Filter empty values
array_filter_empty([1, null, 2, '']); // [1, 2]

// Get first non-null
array_first_not_null([null, null, 3, 4]); // 3
```

#### Model Helpers
```php
// Get model by class
getModelByClass(User::class); // User instance

// Get module from model
getModuleFromModel($user); // 'User'
```

### 6. Developer Tools

#### Macroable Methods
Xot provides macroable methods:

```php
Collection::macro('filterActive', function () {
    return $this->where('is_active', true);
});

$activeItems = Item::all()->filterActive();
```

#### Collection Extensions
Xot extends Laravel collections:

```php
// Get by module
$items = Item::all()->byModule('User');

// Filter by date range
$recent = Item::all()->inDateRange('2026-01-01', '2026-01-31');
```

#### Debugging Helpers
Xot provides debugging utilities:

```php
// Dump model with relationships
dd_model($user);

// Dump query with bindings
dd_query(User::query());

// Trace method calls
trace_method(User::class, 'save');
```

## Advanced Features

### 1. Model States
Xot provides model state management:

```php
class Order extends XotBaseModel
{
    protected $casts = [
        'status' => OrderStatus::class,
    ];
    
    public function canTransitionTo(string $status): bool
    {
        // State transition logic
    }
}
```

### 2. Relationship Helpers
Xot provides relationship utilities:

```php
// Eager load by module
$users = User::withModuleRelations()->get();

// Load nested relationships
$user->loadNested(['posts.comments', 'roles.permissions']);
```

### 3. Translation Support
Xot provides translation helpers:

```php
// Get translated attribute
$user->getTranslatedAttribute('name', 'it');

// Set translated attribute
$user->setTranslatedAttribute('name', 'Mario', 'it');
```

### 4. Performance Optimizations
Xot includes performance optimizations:

```php
// Cache query results
$users = User::cached()->get();

// Lazy load relationships
$user->loadLazy('posts');

// Batch processing
User::chunkById(100, function ($users) {
    // Process batch
});
```

## Integration Features

### 1. Livewire Integration
Xot provides Livewire utilities:

```php
// Base Livewire component
class UserForm extends XotBaseLivewireComponent
{
    public function mount(User $user): void
    {
        $this->user = $user;
    }
}
```

### 2. Event System
Xot provides event handling:

```php
// Base event listener
class UserCreatedListener extends XotBaseEventListener
{
    public function handle(UserCreated $event): void
    {
        // Handle event
    }
}
```

### 3. Job System
Xot provides job utilities:

```php
// Base job
class ProcessUserJob extends XotBaseJob
{
    public function handle(): void
    {
        // Process job
    }
}
```

---

