# Base Classes Architecture

## 📋 Overview

Xot fornisce oltre 50 classi base che costituiscono il fondamento di tutti i moduli Laraxot. Queste classi implementano pattern consolidati e forniscono funzionalità comuni.

## 🚨 **CRITICAL FILAMENT RULES - READ FIRST**

### NEVER Extend Filament Classes Directly

**ASSOLUTAMENTE VIETATO estendere classi Filament direttamente:**

```php
// ❌ WRONG - VIETATO
class MyPage extends Filament\Resources\Pages\CreateRecord
class MyPage extends Filament\Resources\Pages\EditRecord
class MyPage extends Filament\Resources\Pages\ListRecords
class MyPage extends Filament\Resources\Pages\Page

// ✅ CORRECT - OBBLIGATORIO
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseListRecords
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBasePage
```

### XotBaseResource Restrictions
**Chi estende `XotBaseResource` NON DEVE avere `getTableColumns()`:**

```php
class MyResource extends XotBaseResource
{
    // ✅ OK - Ha getFormSchema()
    public static function getFormSchema(): array { /* ... */ }

    // ❌ VIETATO - ERRORE GRAVE
    // public function getTableColumns(): array { /* ... */ }
}
```

### XotBasePage Restrictions
**Chi estende `XotBasePage` NON DEVE avere queste proprietà:**

```php
class MyPage extends XotBasePage
{
    // ❌ VIETATO - Gestite automaticamente
    // protected static ?string $navigationIcon = 'heroicon-o-star';
    // protected static ?string $title = 'My Title';
    // protected static ?string $navigationLabel = 'My Label';

    // ✅ OK - Solo proprietà specifiche
    protected static string $resource = MyResource::class;
}
```

## 🏗️ Core Base Classes

### XotBaseModel - Modello Base

```php
<?php
declare(strict_types=1);

abstract class XotBaseModel extends Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;
    use HasTranslations; // Spatie Laravel-Translatable

    protected $guarded = [];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Global scopes
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_active', true);
        });

        // Observers automatici
        static::observe(ModelObserver::class);
    }

    /**
     * Get the table name dynamically.
     */
    public function getTable(): string
    {
        return Str::snake(Str::pluralStudly(class_basename($this)));
    }
}
```

**Features:**
- ✅ UUID primary keys
- ✅ Soft deletes
- ✅ Global scopes
- ✅ Automatic observers
- ✅ Dynamic table naming
- ✅ Translation support

### XotBaseResource - Filament Resource Base

```php
<?php
declare(strict_types=1);

abstract class XotBaseResource extends Filament\Resources\Resource
{
    use NavigationLabelTrait;
    use TransTrait;

    protected static ?string $model = null;
    protected static bool $shouldRegisterNavigation = true;

    /**
     * Get the model class.
     */
    public static function getModel(): string
    {
        return static::$model ?? static::getModelFromClassName();
    }

    /**
     * Get form schema with automatic translations.
     */
    public static function getFormSchema(): array
    {
        return [
            Section::make(__('filament.section.general'))
                ->schema(static::getMainFormFields()),
        ];
    }

    /**
     * Get navigation label with translation.
     */
    public static function getNavigationLabel(): string
    {
        return static::trans('navigation.label');
    }
}
```

**Features:**
- ✅ Automatic translations (NO ->label() methods)
- ✅ Navigation configuration
- ✅ Form schema standardization
- ✅ Resource registration

### XotBaseServiceProvider - Provider Base

```php
<?php
declare(strict_types=1);

abstract class XotBaseServiceProvider extends ServiceProvider
{
    protected string $moduleName;

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfig();
        $this->registerRepositories();
        $this->registerServices();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadTranslations();
        $this->loadViews();
        $this->loadMigrations();
        $this->registerCommands();
        $this->publishAssets();
    }

    /**
     * Merge module configuration.
     */
    protected function mergeConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__."/../config/{$this->moduleName}.php",
            "xot.{$this->moduleName}"
        );
    }
}
```

**Features:**
- ✅ Automatic resource loading
- ✅ Configuration merging
- ✅ Repository binding
- ✅ Command registration

### XotBaseSection - Filament Schemas Section Base

```php
<?php
declare(strict_types=1);

namespace Modules\Xot\Filament\Schemas\Components;

use Filament\Schemas\Components\Section;

/**
 * Base class for custom Section components following Laraxot philosophy.
 *
 * In the Laraxot framework, all custom Section components MUST extend
 * `XotBaseSection` instead of directly extending `Filament\Schemas\Components\Section`.
 * This ensures consistency with the framework's architecture and allows us
 * to centralize common behaviour.
 */
abstract class XotBaseSection extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        // Common setup for all XotBaseSection components can be added here.
        // IMPORTANT: do NOT call non-existent macros / methods on Section
        // (e.g. disableLiveUpdates()) because they will trigger
        // BadMethodCallException at runtime.
    }
}
```

**Regole pratiche:**

- ✅ Tutte le Section custom dei moduli (es. `AddressSection`, `ContactSection`, `CompanySection`)
  devono estendere `XotBaseSection`.
- ✅ La logica comune va centralizzata in `XotBaseSection::setUp()` usando SOLO API Filament
  documentate e metodi realmente esistenti.
- ❌ Vietato introdurre chiamate a macro/metodi non garantiti (es. `disableLiveUpdates()`),
  che causano `BadMethodCallException` in produzione.
- ✅ Se serve disabilitare comportamenti live, usare i metodi previsti da Filament
  sui singoli componenti di form (es. `->live(false)` dove supportato), non sulla Section.

## 🎯 Extension Patterns

### Extending XotBaseModel

```php
<?php
declare(strict_types=1);

namespace Modules\YourModule\Models;

class YourModel extends XotBaseModel
{
    protected $fillable = [
        'name',
        'description',
        'custom_field',
    ];

    protected function casts(): array
    {
        return parent::casts() + [
            'custom_field' => 'encrypted',
        ];
    }

    // Your custom methods...
    public function getDisplayNameAttribute(): string
    {
        return Str::title($this->name);
    }
}
```

### Extending XotBaseResource

```php
<?php
declare(strict_types=1);

class YourResource extends XotBaseResource
{
    protected static ?string $model = YourModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            Section::make('custom_section')
                ->schema([
                    TextInput::make('custom_field'), // NO ->label()
                ]),
        ];
    }

    // ❌ VIETATO: getTableColumns() qui - va nelle Page classes
}
```

### Extending XotBasePage

```php
<?php
declare(strict_types=1);

class ListRecords extends XotBaseListRecords // ✅ CORRECT
{
    protected static string $resource = MyResource::class;

    // ❌ VIETATO: $navigationIcon, $title, $navigationLabel qui

    public function getTableColumns(): array // ✅ OK - Solo in Pages
    {
        return [
            TextColumn::make('name')->badge(), // ✅ NO BadgeColumn
            TextColumn::make('status')->badge(),
        ];
    }
}
```

## 🚀 Filament 4.x Compatibility

### ✅ Upgrade Status: COMPLETE

Il modulo Xot è completamente compatibile con **Filament 4.x** e fornisce le classi base aggiornate per tutti i moduli del sistema.

### Breaking Changes Handled

#### 1. Namespace Updates
```php
// Filament 4.x compatible imports in XotBase classes
use Filament\Schemas\Components\Section;    // ✅ NEW
use Filament\Schemas\Components\Grid;      // ✅ NEW
use Filament\Schemas\Components\Component; // ✅ NEW

// Legacy support maintained
use Filament\Forms\Components\TextInput;   // ✅ STILL VALID
```

#### 2. Override Syntax
```php
// ✅ CORRECT in XotBase classes
#[Override]  // Filament 4.x syntax

// ❌ DEPRECATED (but still works)
#[\Override]
```

#### 3. Type Hints Optimization
```php
// ✅ OPTIMIZED in XotBase classes
/** @return array<string, Component> */
public static function getFormSchema(): array

/** @return array<string, PageRegistration> */
public static function getPages(): array
```

#### 4. File Visibility Configuration
```php
// ✅ HANDLED in XotBaseServiceProvider
FileUpload::configureUsing(fn (FileUpload $fileUpload) => $fileUpload
    ->visibility('public'));

ImageColumn::configureUsing(fn (ImageColumn $imageColumn) => $imageColumn
    ->visibility('public'));
```

### Base Classes Updated

**XotBaseResource**:
- ✅ Namespace imports aggiornati per v4
- ✅ Override syntax corretta
- ✅ Type hints ottimizzati
- ✅ Traduzioni automatiche mantenute

**XotBaseListRecords**:
- ✅ Table methods correttamente implementati
- ✅ Navigation properties non incluse (gestite automaticamente)
- ✅ BadgeColumn sostituito con TextColumn::badge()

**XotBaseServiceProvider**:
- ✅ File visibility configurata per dischi S3
- ✅ Service registration ottimizzata
- ✅ Asset publishing aggiornato

### Migration Benefits

#### For Module Developers
- ✅ **Zero Breaking Changes**: I moduli esistenti continuano a funzionare
- ✅ **Automatic Upgrades**: Le classi base gestiscono automaticamente i breaking changes
- ✅ **Future Proof**: Compatibilità garantita con Filament 4.x+

#### For Framework Maintainers
- ✅ **Centralized Updates**: Tutti gli upgrade gestiti in un posto
- ✅ **Consistent Behavior**: Comportamento uniforme across tutti i moduli
- ✅ **Quality Assurance**: PHPStan Level 10 garantito

### Testing & Verification

#### PHPStan Compatibility
- ✅ **Level 9+**: Tutte le classi base passano l'analisi statica
- ✅ **Type Safety**: Type hints corretti e completi
- ✅ **Import Resolution**: Tutti i namespace risolti correttamente

#### Functional Testing
- ✅ **Resource Classes**: Form schema e page routing funzionanti
- ✅ **Page Classes**: Table methods e navigation working
- ✅ **Service Providers**: Dependency injection corretta

### Documentation Links

- [Filament 4.x Upgrade Guide](../../../docs/filament-4-upgrade.md)
- [Module Upgrade Guide](../../../docs/upgrade-modules-to-filament-4.md)
- [Breaking Changes Reference](https://filamentphp.com/docs/4.x/upgrade-guide)

## 📊 Architecture Benefits

### Consistency
- **Uniform Interface**: Tutte le classi seguono gli stessi pattern
- **Predictable Behavior**: Comportamento consistente across modules
- **Standard Conventions**: Naming e structure conventions

### Maintainability
- **Centralized Logic**: Funzionalità comuni in un posto
- **Easy Updates**: Cambiamenti propagati automaticamente
- **Bug Prevention**: Pattern testati e validati

### Extensibility
- **Clean Overrides**: Metodi designed per essere sovrascritti
- **Hook System**: Punti di estensione ben definiti
- **Configuration**: Comportamento modificabile via config

### Performance
- **Optimized Queries**: Base models con eager loading
- **Caching**: Built-in caching per operazioni comuni
- **Lazy Loading**: Caricamento on-demand intelligente

## 🔧 Configuration

### Base Configuration Structure

```php
// config/xot.php
return [
    'modules' => [
        'autoload' => true,
        'cache' => [
            'enabled' => true,
            'ttl' => 3600,
        ],
    ],

    'models' => [
        'uuids' => true,
        'soft_deletes' => true,
        'timestamps' => true,
    ],

    'resources' => [
        'navigation' => [
            'sort' => 100,
            'group' => 'System',
        ],
    ],
];
```

## 🚀 Migration Guide

### From Custom Classes to XotBase

#### Before (Custom Implementation)
```php
class MyModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    // Custom logic...
}
```

#### After (XotBase Extension)
```php
class MyModel extends XotBaseModel
{
    protected $fillable = ['custom_field'];
    // Inherits all base functionality
    // Add only custom logic...
}
```

### Benefits of Migration
- ✅ **Reduced Code**: 60-80% less boilerplate
- ✅ **Consistency**: Same behavior across all models
- ✅ **Maintenance**: Updates applied automatically
- ✅ **Features**: Access to all Xot features

---

**See Also**: [Extension Patterns](../development/extensions.md) | [Best Practices](../development/practices.md) | [Critical Filament Rules](../../../docs/AI-GUIDELINES.md#️-critical-laraxot-filament-rules)
