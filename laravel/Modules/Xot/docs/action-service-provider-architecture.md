# Action Pattern and Service Provider Architecture: The Sacred Systems

## Action Pattern: The Sacred Business Logic Container

### Core Philosophy
The Action Pattern is the cornerstone of business logic organization in Laraxot. Every operation, regardless of complexity, is encapsulated in a single-purpose action class.

### The Sacred Structure
Actions are organized by functionality in the Xot module:

```
Modules/Xot/app/Actions/
├── Arr/              # Array manipulation actions
├── Blade/            # Blade-related actions
├── Cast/             # Type casting actions
├── Class/            # Class manipulation actions
├── Collection/       # Collection operations
├── Export/           # Export functionality
├── Factory/          # Factory-related actions
├── Filament/         # Filament integration actions
├── File/             # File operations
├── Generate/         # Code generation actions
├── Geo/              # Geographic operations
├── Import/           # Import functionality
├── Livewire/         # Livewire integration actions
├── Mail/             # Email actions
├── Model/            # Model operations
├── ModelClass/       # Model class operations
├── Module/           # Module management actions
├── Panel/            # Panel operations
├── Pdf/              # PDF generation actions
├── Query/            # Query operations
├── String/           # String manipulation
├── Trans/            # Translation actions
├── Tree/             # Tree structure operations
├── View/             # View operations
└── ExecuteArtisanCommandAction.php
```

### Action Class Pattern
Standard action structure:

```php
class GetModelTypeByModelAction
{
    use QueueableAction;  // Makes action queueable when needed

    public function execute(ModelContract $modelContract): string
    {
        return Str::snake(class_basename($modelContract));
    }
}
```

### Queueable Action Pattern
Actions use the `QueueableAction` trait for performance and reliability:

```php
use Spatie\QueueableAction\QueueableAction;

class MyAction
{
    use QueueableAction;

    public function execute($parameter)
    {
        // Action implementation
    }
}
```

### Single Responsibility Principle
Each action has one, and only one, purpose:
- `GetModelTypeByModelAction` - Gets model type from model instance
- `GeneratePdfAction` - Generates PDF files
- `GetModelByModelTypeAction` - Gets model by type string
- `ParsePrintPageStringAction` - Parses page strings

### Usage Pattern
Actions are called using the service container:

```php
// Direct execution
$result = app(GetModelTypeByModelAction::class)->execute($model);

// Queued execution (when needed)
$result = app(MyAction::class)->onQueue()->execute($parameter);
```

### Action Categories

#### 1. Model Actions
- `GetModelByModelTypeAction` - Resolves models by type
- `GetModelClassByModelTypeAction` - Gets class names by type
- `GetModelTypeByModelAction` - Gets type from model instance

#### 2. File and Path Actions
- `GetModulePathByGeneratorAction` - Gets module paths by generator type
- `GetComponentsAction` - Discovers components in directories

#### 3. View Actions
- `GetViewAction` - Resolves view paths
- `GetViewByClassAction` - Gets views by class

#### 4. Registration Actions
- `RegisterBladeComponentsAction` - Registers Blade components
- `RegisterLivewireComponentsAction` - Registers Livewire components

## Service Provider Architecture: The Sacred Registration System

### The Sacred Inheritance Chain
```
ServiceProvider → XotBaseServiceProvider → Module ServiceProvider
```

### XotBaseServiceProvider: The Foundation

#### Core Structure
```php
abstract class XotBaseServiceProvider extends ServiceProvider
{
    use PathNamespace;

    public string $name = '';
    public string $nameLower = '';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom($this->module_dir.'/../Database/Migrations');
        $this->registerLivewireComponents();
        $this->registerBladeComponents();
        $this->registerCommands();
    }

    public function register(): void
    {
        $this->nameLower = Str::lower($this->name);
        $this->module_ns = collect(explode('\\', $this->module_ns))->slice(0, -1)->implode('\\');
        $this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
        $this->app->register($this->module_ns.'\Providers\EventServiceProvider');
        $this->registerBladeIcons();
    }
}
```

### Auto-Registration Features

#### 1. Translation Auto-Registration
```php
public function registerTranslations(): void
{
    $langPath = $this->getLangPath();
    $this->loadTranslationsFrom($langPath, $this->nameLower);
    $this->loadJsonTranslationsFrom($langPath);
}
```

#### 2. View Auto-Registration
```php
public function registerViews(): void
{
    $viewPath = module_path($this->name, 'resources/views');
    $this->loadViewsFrom($viewPath, $this->nameLower);
}
```

#### 3. Blade Component Auto-Registration
```php
public function registerBladeComponents(): void
{
    $componentViewPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'component-view');
    Blade::anonymousComponentPath($componentViewPath);

    $componentClassPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'component-class');
    $namespace = $this->module_ns.'\View\Components';
    Blade::componentNamespace($namespace, $this->nameLower);

    app(RegisterBladeComponentsAction::class)->execute($componentClassPath, $this->module_ns);
}
```

#### 4. Livewire Component Auto-Registration
```php
public function registerLivewireComponents(): void
{
    $prefix = '';
    app(RegisterLivewireComponentsAction::class)
        ->execute($this->module_dir.'/../Http/Livewire', Str::before($this->module_ns, '\Providers'), $prefix);
}
```

#### 5. Blade Icon Auto-Registration
```php
public function registerBladeIcons(): void
{
    $this->callAfterResolving(BladeIconsFactory::class, function (BladeIconsFactory $factory): void {
        $assetsPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'assets');
        $svgPath = $assetsPath.'/../svg';
        $factory->add($this->nameLower, ['path' => $svgPath, 'prefix' => $this->nameLower]);
    });
}
```

### Module Service Provider Pattern

#### Standard Structure
```php
class ModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName';

    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Module-specific boot logic
    }

    public function register(): void
    {
        parent::register();
        // Module-specific registration
    }
}
```

#### Required Properties
- `$name` - The module name (required for auto-registration)
- `$module_dir` - Directory path for the service provider
- `$module_ns` - Namespace of the module

### Service Provider Auto-Registration

#### 1. RouteServiceProvider
Automatically registers the module's route provider:

```php
$this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
```

#### 2. EventServiceProvider
Automatically registers the module's event provider:

```php
$this->app->register($this->module_ns.'\Providers\EventServiceProvider');
```

#### 3. Command Registration
Automatically discovers and registers console commands:

```php
public function registerCommands(): void
{
    $comps = app(GetComponentsAction::class)
        ->execute($this->module_dir.'/../Console/Commands', 'Modules\\'.$this->name.'\\Console\\Commands', $prefix);
    // Auto-registers discovered commands
}
```

## The Sacred Rules of Action and Service Provider Architecture

### Rule 1: Action Single Responsibility
❌ **WRONG:**
```php
class UserAction
{
    public function createUser() { /* ... */ }
    public function updateUser() { /* ... */ }
    public function deleteUser() { /* ... */ }
    public function sendEmail() { /* ... */ }  // Different responsibility!
}
```

✅ **CORRECT:**
```php
class CreateUserAction { /* only creates user */ }
class UpdateUserAction { /* only updates user */ }
class SendUserEmailAction { /* only sends email */ }
```

### Rule 2: Always Extend XotBaseServiceProvider
❌ **WRONG:**
```php
class MyModuleServiceProvider extends ServiceProvider
```

✅ **CORRECT:**
```php
class MyModuleServiceProvider extends XotBaseServiceProvider
```

### Rule 3: Set Module Name
✅ **REQUIRED:**
```php
class MyModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName';  // Must be set!
}
```

### Rule 4: Never Override Core Registration Methods
Don't override methods like `registerTranslations()` without calling parent, unless you want to disable the functionality.

## Advanced Patterns

### 1. Conditional Component Registration
```php
public function registerBladeComponents(): void
{
    $componentClassPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'component-class');

    try {
        app(RegisterBladeComponentsAction::class)->execute($componentClassPath, $this->module_ns);
    } catch (Exception $e) {
        // Handle missing component directories gracefully
    }
}
```

### 2. Action Composition
Actions can call other actions for complex operations:

```php
class ComplexOperationAction
{
    use QueueableAction;

    public function execute($input)
    {
        $result1 = app(SimpleAction1::class)->execute($input);
        $result2 = app(SimpleAction2::class)->execute($result1);
        return app(SimpleAction3::class)->execute($result2);
    }
}
```

### 3. Action with Dependencies
```php
class DataProcessingAction
{
    use QueueableAction;

    public function __construct(
        private readonly SomeService $service,
        private readonly AnotherAction $subAction
    ) {}

    public function execute($data)
    {
        $processed = $this->service->process($data);
        return $this->subAction->execute($processed);
    }
}
```

## Performance Considerations

### 1. Queued Actions for Heavy Operations
Use queueable actions for time-consuming operations:

```php
app(HeavyDataProcessAction::class)
    ->onQueue()
    ->execute($largeDataSet);
```

### 2. Conditional Service Provider Loading
Service providers only load what's needed by checking for file existence.

## The Philosophy Behind Action and Service Provider Architecture

The Action and Service Provider patterns embody Laraxot's core principles:

### DRY (Don't Repeat Yourself)
- Common registration logic in XotBaseServiceProvider
- Reusable action patterns across modules
- Auto-discovery prevents repetitive code

### KISS (Keep It Simple, Stupid)
- Clear, predictable patterns
- Minimal configuration needed
- Consistent API across all modules

### Separation of Concerns
- Actions handle business logic
- Service providers handle registration
- Models handle data
- Views handle presentation

### Type Safety
- Strict typing in actions
- Interface contracts
- Predictable method signatures

### Modularity
- Self-contained actions
- Module-specific service providers
- Independent registration systems

This architecture ensures that every part of the system has a clear role and responsibility while maintaining the flexibility needed for complex applications.
