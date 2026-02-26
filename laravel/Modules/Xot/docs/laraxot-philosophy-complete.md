# Laraxot Philosophy - Complete Analysis

## 🏛️ Architectural Religion

### Core Tenets

#### 1. **Single Source of Truth**
- **Every entity has exactly one authoritative definition**
- No duplicates, no ambiguity, no parallel realities
- **Violation Example**: Having migrations in both `database/` and `app/Database/`
- **Zen Principle**: One truth, many manifestations

#### 2. **Consistency Over Flexibility**
- **Predictable behavior > Unlimited options**
- Same patterns across all modules, same file structures
- **Violation Example**: Different test structures across modules
- **Zen Principle**: Harmony through uniformity

#### 3. **DRY/KISS Compliance**
- **Eliminate redundancy, keep it simple**
- No useless method overrides, no duplicate functionality
- **Violation Example**: Replicating parent methods without added value
- **Zen Principle**: Simplicity is the ultimate sophistication

## 🏗️ Architectural Structure

### Module Hierarchy
```
Xot (Core Engine)
├── User (Authentication & Authorization)
<<<<<<< .merge_file_N11tJ1
├── healthcare_app (Core Business Logic - Surveys)
=======
├── ModuloEsempio (Core Business Logic - Surveys)
>>>>>>> .merge_file_8Z9hGv
├── Cms (Content Management)
├── Media (File Management)
├── Geo (Location Services)
├── Activity (Event Sourcing)
├── Notify (Notifications)
├── Gdpr (Compliance)
├── Job (Queue Management)
├── Chart (Data Visualization)
├── Lang (Translations)
├── UI (Frontend Components)
├── Tenant (Multi-tenancy)
├── Limesurvey (External Integration)
├── CloudStorage (Cloud Services)
└── DbForge (Database Tools)
```

### Technology Stack
- **PHP 8.3.27** - Modern PHP with strict typing
- **Laravel 12.38.1** - Latest Laravel framework
- **Filament 4.2.2** - Admin panel framework
- **Livewire 3.6.4** - Reactive UI components
- **MySQL** - Primary database
- **TailwindCSS 3.4.17** - Utility-first CSS

## 🧘‍♂️ Zen Principles

### Model Inheritance Zen
```php
// ❌ WRONG - Direct Model extension (breaks harmony)
class Team extends Model implements TeamContract { }

// ✅ CORRECT - Extend module BaseModel (maintains harmony)
class Team extends BaseTeam { }
```

### File Structure Zen
```
// ❌ WRONG - Mixed file structure (creates chaos)
Modules/Cms/
├── database/                    # Has files
└── app/Database/               # Empty directories (confusion)

// ✅ CORRECT - Single source of truth (creates harmony)
Modules/Cms/
├── database/                    # SINGLE SOURCE OF TRUTH
│   ├── factories/
│   ├── migrations/
│   └── seeders/
└── app/
    ├── Models/
    └── Filament/
```

### Translation Zen
```php
// ❌ WRONG - Hardcoded text (breaks translation harmony)
TextInput::make('name')
    ->label('Full Name')
    ->placeholder('Enter your name');

// ✅ CORRECT - Translation-first approach (maintains harmony)
TextInput::make('name');
// Auto-resolved from: resources/lang/{locale}/{module}::{field}.label
```

## 📚 Political Structure

### Power Distribution

#### 1. **Xot Module (The Government)**
- **Role**: Central authority, provides base classes and utilities
- **Power**: All other modules depend on Xot
- **Responsibility**: Maintain architectural consistency

#### 2. **User Module (The Security Forces)**
- **Role**: Authentication, authorization, user management
- **Power**: Controls access to all resources
- **Responsibility**: Security and permissions

<<<<<<< .merge_file_N11tJ1
#### 3. **healthcare_app Module (The Economy)**
=======
#### 3. **ModuloEsempio Module (The Economy)**
>>>>>>> .merge_file_8Z9hGv
- **Role**: Core business logic, surveys, reporting
- **Power**: Main revenue-generating functionality
- **Responsibility**: Business operations

#### 4. **Other Modules (The Ministries)**
- **Role**: Specialized functionality
- **Power**: Domain-specific operations
- **Responsibility**: Maintain module-specific standards

### Governance Rules

#### 1. **No Direct Filament Extension**
- **Rule**: Never extend Filament classes directly
- **Reason**: Maintains backward compatibility and auto-discovery
- **Correct**: Always extend `XotBaseResource`, `XotBasePage`, etc.

#### 2. **Model Inheritance Hierarchy**
```
Illuminate\Database\Eloquent\Model
    ↓
Modules\Xot\Models\XotBaseModel
    ↓
Modules\{Module}\Models\BaseModel
    ↓
YourModel
```

#### 3. **Third-Party Package Integration**
- **Rule**: Extend package models directly, not our BaseModel
- **Reason**: Respect package architecture and functionality
- **Example**: `Permission extends SpatiePermission`, not `BaseModel`

## 🔄 Lifecycle Philosophy

### Development Flow

#### 1. **Analysis Phase**
- Study existing patterns in well-structured modules
- Understand the Laraxot philosophy deeply
- Identify consistency violations

#### 2. **Implementation Phase**
- Follow established patterns religiously
- Use auto-discovery features
- Maintain single source of truth

#### 3. **Quality Assurance Phase**
- Run PHPStan Level 10 analysis
- Use Laravel Pint for code formatting
- Verify architectural compliance

### Error Prevention

#### 1. **Magic Properties Awareness**
```php
// ❌ WRONG - property_exists() doesn't work with magic properties
if (property_exists($model, 'email')) { ... }

// ✅ CORRECT - Use isset() for magic properties
if (isset($model->email)) { ... }
```

#### 2. **Migration Consistency**
- **Rule**: One create_table migration per table
- **Reason**: Prevents migration order issues
- **Tool**: Use `XotBaseMigration` for auto-discovery

#### 3. **Test Structure Consistency**
- **Rule**: Tests in traditional Laravel structure only
- **Reason**: Predictable autoloader behavior
- **Location**: `Modules/{Module}/tests/`

## 🎯 Implementation Guidelines

### Creating New Models
```php
namespace Modules\YourModule\Models;

class YourModel extends BaseModel
{
    // Connection auto-discovered as 'yourmodule'
    // No need to set $connection unless different

    protected $fillable = ['field1', 'field2'];

    // Only add casts NOT in parent
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'your_custom_field' => 'datetime',
        ]);
    }
}
```

### Creating Filament Resources
```php
namespace Modules\YourModule\Filament\Resources;

class YourResource extends XotBaseResource
{
    // Model auto-resolved as Modules\YourModule\Models\YourResource
    // Pages auto-discovered following pattern

    public static function getFormSchema(): array
    {
        return [
            // Form components - NO hardcoded labels
        ];
    }

    public static function getInfolistSchema(): array
    {
        return [
            // Infolist components
        ];
    }
}
```

### Translation Standards
```php
// Modules/YourModule/lang/it/your_resource.php
return [
    'navigation' => [
        'name' => 'Proper Italian Name',
        'plural' => 'Proper Italian Plural Name',
        'group' => [
            'name' => 'Module Group Name',
            'description' => 'Group description',
        ],
        'label' => 'Navigation Label',
        'sort' => 85,
        'icon' => 'heroicon-o-chart-bar', // Actual icon, not placeholder
    ],
    // NO .navigation placeholders allowed
];
```

## 🚨 Critical Violations

### Architecture Violations
1. **Extending Model directly** - Breaks inheritance chain
2. **Mixed file structures** - Creates autoloader confusion
3. **Duplicate migrations** - Multiple create_table for same table
4. **Hardcoded translations** - Breaks multi-language support
5. **Direct Filament extension** - Loses auto-discovery features

### Quality Violations
1. **PHPStan errors** - Target Level 10 compliance
2. **Pint formatting issues** - Code style consistency
3. **Missing type hints** - PHP 8.3 strict typing
4. **Magic property misuse** - property_exists() on Eloquent models

## 🛠️ Verification Commands

### Architecture Compliance
```bash
# Check for consistency violations
find Modules -name "*create_*_table.php" | sort
find Modules -name "*.php" | grep -E "(factories|seeders|tests)" | sort
grep -r "extends Model" Modules/*/app/Models/
```

### Quality Assurance
```bash
# Static analysis
./vendor/bin/phpstan analyse --level=10

# Code formatting
vendor/bin/pint --dirty

# Translation checks
grep -r "\.navigation" Modules/*/lang/**/*.php
```

## 🌟 Success Metrics

### Architecture Health
- **100%** XotBase class usage
- **0** direct Model extensions
- **Consistent** file structures across modules
- **No** .navigation placeholder translations

### Code Quality
- **PHPStan Level 10** compliance
- **Pint formatting** adherence
- **Type safety** with PHP 8.3 features
- **DRY compliance** - no useless method overrides

---

**Maintained by**: Xot Module (The Laraxot Government)
**Philosophy**: Consistency, Predictability, Simplicity
**Goal**: Create a harmonious, maintainable, and scalable application architecture

