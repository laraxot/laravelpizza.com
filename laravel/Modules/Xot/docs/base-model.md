# Module System and BaseModel Pattern: The Sacred Architecture

## Module System Architecture

### Core Structure
Each module in Laraxot follows a strict, consistent structure:

```
Modules/[ModuleName]/
├── app/
│   ├── Models/          # Eloquent models
│   ├── Providers/       # Service providers
│   ├── Filament/        # Filament resources, pages, widgets
│   ├── Actions/         # Single-purpose action classes
│   ├── Services/        # Business logic services
│   └── Http/           # Controllers and middleware
├── config/             # Module-specific configuration
├── database/           # Migrations, seeders, factories
├── resources/          # Views, assets, translations
├── routes/             # Web and API routes
├── tests/              # Pest tests
├── docs/               # Module documentation
└── composer.json       # Module dependencies
```

### Module Registration
- Modules are enabled/disabled in `modules_statuses.json`
- Each module has its own Service Provider extending `XotBaseServiceProvider`
- Auto-discovery of module components through the service provider chain

## BaseModel Pattern: The Sacred Inheritance Chain

### The Golden Rule
```
Model → Module BaseModel → XotBaseModel → Laravel Model
```

This inheritance pattern is the cornerstone of Laraxot's architecture and must be strictly followed:

### 1. XotBaseModel - The Foundation
Located in `Modules/Xot/app/Models/XotBaseModel.php`, it provides:

```php
abstract class XotBaseModel extends Model
{
    use HasXotFactory;
    use Traits\RelationX;
    use Updater;

    // Common configurations
    public static $snakeAttributes = true;
    public $incrementing = true;
    public $timestamps = true;
    protected $perPage = 30;
    protected $connection = 'user';

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'published_at' => 'datetime',
            // ... common casts
        ];
    }
}
```

### 2. Module BaseModel - The Customizer
Each module has its own BaseModel that extends XotBaseModel:

```php
<<<<<<< .merge_file_HVxwtm
// Example from healthcare_app module
=======
<<<<<<< HEAD
// Example from ExternalProject module
=======
// Example from ModuloEsempio module
>>>>>>> f04e1ab44 (refactor: update project references from <nome progetto> to PTVX)
>>>>>>> .merge_file_MDxGG7
abstract class BaseModel extends XotBaseModel implements HasMedia, ModelContract
{
    use Cachable;
    use HasExtraTrait;
    use InteractsWithMedia;

<<<<<<< .merge_file_HVxwtm
    protected $connection = 'healthcare_app'; // Module-specific connection
=======
    protected $connection = 'ptvx'; // Module-specific connection
>>>>>>> .merge_file_MDxGG7

    protected $with = [
        'extra', // Always load extra fields
    ];
}
```

### 3. Concrete Models - The Implementer
Actual models extend their module's BaseModel:

```php
class SurveyPdf extends BaseModel
{
    // Module-specific functionality
}
```

## Sacred Rules of BaseModel Pattern

### Rule 1: Never Extend XotBaseModel Directly
❌ **WRONG:**
```php
class SurveyPdf extends XotBaseModel // Never do this!
```

✅ **CORRECT:**
```php
<<<<<<< .merge_file_HVxwtm
// In healthcare_app module
=======
<<<<<<< HEAD
// In ExternalProject module
=======
// In ModuloEsempio module
>>>>>>> f04e1ab44 (refactor: update project references from <nome progetto> to PTVX)
>>>>>>> .merge_file_MDxGG7
class SurveyPdf extends BaseModel // Extends module's BaseModel
```

### Rule 2: Module BaseModel Must Extend XotBaseModel
✅ **CORRECT:**
```php
abstract class BaseModel extends XotBaseModel
{
    // Module-specific traits and configurations
}
```

### Rule 3: Module BaseModel Implements Module-Specific Functionality
The module BaseModel is where you add:
- Module-specific database connections
- Module-specific traits (Cachable, HasMedia, etc.)
- Module-specific relationship loading
- Module-specific configurations

## Authentication Model Pattern

For authentication models, there's an additional layer:

```
User Model → BaseUser → XotBaseModel → Laravel Authenticatable
```

```php
// In User module
abstract class BaseUser extends Authenticatable implements HasMedia, HasName, HasTenants, ...
{
    // Authentication-specific functionality
}

// Concrete user models extend BaseUser
class User extends BaseUser { ... }
```

## Migration Philosophy within Modules

### One Migration Rule
- Each table gets exactly ONE creation migration per module
- Subsequent changes use `tableUpdate()` method
- Check for column/index existence before adding

### Example Migration Pattern
```php
// Correct approach
if (!Schema::hasColumn('table_name', 'column_name')) {
    Schema::table('table_name', function (Blueprint $table) {
        $table->string('column_name');
    });
}
```

## Module Communication and Relationships

### Cross-Module Relationships
Modules can reference each other through:
- Foreign keys with proper naming conventions
- Service layer abstractions
- Event-based communication

### Example: User and Survey Relationship
```php
class SurveyPdf extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(
            config('user.model'), // Configurable user model
            'user_id',
            'id'
        );
    }
}
```

## The DRY/KISS Implementation in BaseModel Pattern

### DRY (Don't Repeat Yourself)
- Common functionality in XotBaseModel
- Module-specific common functionality in Module BaseModel
- No duplication across models

### KISS (Keep It Simple, Stupid)
- Clear inheritance chain
- <nome progetto>able patterns
- Minimal configuration needed

## Type Safety and Contracts

### ModelContract Interface
Models implement contracts for type safety:
- `ModelContract` for general model behavior
- `UserContract` for user models
- `HasRecursiveRelationshipsContract` for tree models

### Example Contract Implementation
```php
interface ModelContract
{
    public function withoutRelations();
    public function forceFill(array $attributes);
    public function save(array $options = []);
    // ... other contract methods
}
```

## Best Practices

### 1. Connection Management
Each module typically has its own database connection:
```php
protected $connection = 'module_name';
```

### 2. Default Relationships
Use `$with` property for frequently needed relationships:
```php
protected $with = ['extra', 'translations'];
```

### 3. Trait Organization
Group related functionality in traits:
- `HasExtraTrait` for extra fields
- `HasRecursiveRelationships` for tree structures
- Module-specific traits for specialized functionality

## The Philosophy Behind BaseModel Pattern

The BaseModel pattern embodies the Laraxot philosophy of:
- **Consistency**: Same patterns across all modules
- **Maintainability**: Clear inheritance hierarchy
- **Extensibility**: Easy to add module-specific functionality
- **Type Safety**: Contract-based development
- **DRY Compliance**: No duplicated base functionality

This pattern ensures that every model in the system follows the same foundational principles while allowing for module-specific customizations where needed.
