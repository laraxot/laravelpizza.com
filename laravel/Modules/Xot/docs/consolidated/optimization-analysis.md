# Analisi di Ottimizzazione - Modulo Xot (Framework Base)

## 🎯 Principi Applicati: DRY + KISS + SOLID + ROBUST + Laraxot

### 📊 Stato Attuale del Modulo

Il modulo Xot rappresenta il **cuore architetturale** di tutto il framework Laraxot, fornendo:
- **50+ Classi Base** per tutti i moduli (Models, Resources, Pages, Widgets)
- **20+ Service Providers** per configurazione automatica
- **15+ Trait Avanzati** per funzionalità condivise
- **Migration Pattern** XotBaseMigration per consistenza
- **Type Safety** PHPStan livello 10+ per tutto il codice

---

## 🚨 Problemi Critici Identificati

### 1. **VIOLAZIONE DRY - Duplicazione tra BaseModel e XotBaseModel**

#### Problema: Due Classi Base Simili
```php
// ❌ PROBLEMATICO - Due classi base quasi identiche
// BaseModel.php
abstract class BaseModel extends Model
{
    use HasFactory;
    use Updater;
    
    public static $snakeAttributes = true;
    public $incrementing = true;
    public $timestamps = true;
    protected $perPage = 30;
    protected $connection = 'xot';
}

// XotBaseModel.php  
abstract class XotBaseModel extends Model
{
    use Updater;
    
    public static $snakeAttributes = true;
    protected $perPage = 30;
    // Manca HasFactory, incrementing, timestamps, connection
}
```

**✅ Soluzione DRY + SOLID:**
```php
// Una sola classe base con configurazione modulare
abstract class XotBaseModel extends Model
{
    use HasFactory;
    use Updater;
    
    /**
     * Indicates whether attributes are snake cased on arrays.
     */
    public static $snakeAttributes = true;
    
    /** @var bool */
    public $incrementing = true;
    
    /** @var bool */
    public $timestamps = true;
    
    /** @var int */
    protected $perPage = 30;
    
    /** @var string */
    protected $connection = 'mysql'; // Default, override nei moduli specifici
    
    /** @var string */
    protected $primaryKey = 'id';
    
    /** @var string */
    protected $keyType = 'int'; // Default più comune
    
    /** @var list<string> */
    protected $fillable = [];
    
    /** @var list<string> */
    protected $hidden = [];
    
    /**
     * Get casts array with common datetime casts.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return app(GetFactoryAction::class)->execute(static::class);
    }
}
```

### 2. **VIOLAZIONE SOLID - Interface Segregation nei Widget**

#### Problema: XotBaseWidget Implementa Troppe Interfacce
```php
// ❌ PROBLEMATICO - Una classe fa troppo
abstract class XotBaseWidget extends FilamentWidget implements HasForms, HasActions
{
    use TransTrait;
    use InteractsWithPageFilters;
    use InteractsWithForms;
    use InteractsWithActions;
    
    // Troppa responsabilità in una sola classe
}
```

**✅ Soluzione SOLID (Interface Segregation):**
```php
// Interfacce specifiche
interface HasWidgetForms
{
    public function form(Form $form): Form;
    public function getFormSchema(): array;
}

interface HasWidgetActions  
{
    public function getActions(): array;
    public function callAction(string $name): mixed;
}

interface HasWidgetFilters
{
    public function getFilters(): array;
    public function applyFilters(array $filters): void;
}

// Widget base semplificato
abstract class XotBaseWidget extends FilamentWidget
{
    use TransTrait;
    
    // Implementazioni opzionali tramite trait
    // Solo se necessario per il widget specifico
}

// Widget specializzati
abstract class XotFormWidget extends XotBaseWidget implements HasWidgetForms
{
    use InteractsWithForms;
}

abstract class XotActionWidget extends XotBaseWidget implements HasWidgetActions
{
    use InteractsWithActions;
}

abstract class XotFilterWidget extends XotBaseWidget implements HasWidgetFilters
{
    use InteractsWithPageFilters;
}

// Widget completo solo se necessario
abstract class XotFullWidget extends XotBaseWidget implements 
    HasWidgetForms, 
    HasWidgetActions, 
    HasWidgetFilters
{
    use InteractsWithForms;
    use InteractsWithActions;
    use InteractsWithPageFilters;
}
```

### 3. **VIOLAZIONE KISS - XotData Troppo Complesso**

#### Problema: XotData Fa Troppe Cose
```php
// ❌ PROBLEMATICO - Una classe che fa tutto
class XotData extends Data
{
    // Gestione utenti
    public function getUserClass(): string
    public function getUser(): ?UserContract
    
    // Gestione moduli
    public function getModuleName(): string
    public function getModuleNamespace(): string
    
    // Gestione configurazioni
    public function getConfig(string $key): mixed
    
    // Gestione database
    public function getConnection(): string
    
    // Gestione cache
    public function getCacheKey(): string
    
    // E molto altro...
}
```

**✅ Soluzione KISS + SOLID (Single Responsibility):**
```php
// Separare in classi specifiche
class UserDataService
{
    public function getUserClass(): string { /* ... */ }
    public function getUser(): ?UserContract { /* ... */ }
    public function createUser(array $data): UserContract { /* ... */ }
}

class ModuleDataService  
{
    public function getModuleName(): string { /* ... */ }
    public function getModuleNamespace(): string { /* ... */ }
    public function getModulePath(): string { /* ... */ }
}

class ConfigDataService
{
    public function getConfig(string $key, mixed $default = null): mixed { /* ... */ }
    public function setConfig(string $key, mixed $value): void { /* ... */ }
}

class CacheDataService
{
    public function getCacheKey(string $prefix = ''): string { /* ... */ }
    public function remember(string $key, callable $callback, int $ttl = 3600): mixed { /* ... */ }
}

// XotData semplificato come facade
class XotData extends Data
{
    public function __construct(
        public readonly UserDataService $users,
        public readonly ModuleDataService $modules,
        public readonly ConfigDataService $config,
        public readonly CacheDataService $cache,
    ) {}
    
    public static function make(): self
    {
        return new self(
            users: app(UserDataService::class),
            modules: app(ModuleDataService::class),
            config: app(ConfigDataService::class),
            cache: app(CacheDataService::class),
        );
    }
}
```

---

## ⚡ Ottimizzazioni Performance

### 1. **Lazy Loading per Classi Base**

```php
// Implementare lazy loading per classi pesanti
trait HasLazyRelations
{
    protected array $lazyRelations = [];
    
    public function getRelation($relation): mixed
    {
        if (!array_key_exists($relation, $this->lazyRelations)) {
            $this->lazyRelations[$relation] = parent::getRelation($relation);
        }
        
        return $this->lazyRelations[$relation];
    }
    
    public function clearLazyRelations(): void
    {
        $this->lazyRelations = [];
    }
}
```

### 2. **Caching Strategy per Service Providers**

```php
abstract class XotBaseServiceProvider extends ServiceProvider
{
    protected string $module_name;
    
    public function boot(): void
    {
        // Cache delle configurazioni per performance
        $cacheKey = "module_config_{$this->module_name}";
        
        $config = Cache::remember($cacheKey, 3600, function() {
            return [
                'views_path' => $this->getViewsPath(),
                'lang_path' => $this->getLangPath(),
                'migrations_path' => $this->getMigrationsPath(),
            ];
        });
        
        $this->loadViewsFrom($config['views_path'], $this->module_name);
        $this->loadTranslationsFrom($config['lang_path'], $this->module_name);
        $this->loadMigrationsFrom($config['migrations_path']);
    }
    
    protected function getViewsPath(): string
    {
        return __DIR__ . '/../resources/views';
    }
    
    protected function getLangPath(): string
    {
        return __DIR__ . '/../lang';
    }
    
    protected function getMigrationsPath(): string
    {
        return __DIR__ . '/../database/migrations';
    }
}
```

### 3. **Ottimizzazione Factory Pattern**

```php
class GetFactoryAction
{
    private static array $factoryCache = [];
    
    public function execute(string $modelClass): Factory
    {
        // Cache delle factory per evitare riflessione ripetuta
        if (isset(self::$factoryCache[$modelClass])) {
            return clone self::$factoryCache[$modelClass];
        }
        
        $factory = $this->createFactory($modelClass);
        self::$factoryCache[$modelClass] = $factory;
        
        return clone $factory;
    }
    
    private function createFactory(string $modelClass): Factory
    {
        // Logica esistente ottimizzata
        $reflection = new ReflectionClass($modelClass);
        $namespace = $reflection->getNamespaceName();
        $factoryClass = str_replace('\\Models\\', '\\Database\\Factories\\', $namespace) . '\\' . $reflection->getShortName() . 'Factory';
        
        if (class_exists($factoryClass)) {
            return new $factoryClass();
        }
        
        throw new FactoryNotFoundException("Factory not found for model: {$modelClass}");
    }
}
```

---

## 🔒 Miglioramenti Sicurezza

### 1. **Input Sanitization nelle Classi Base**

```php
trait HasSecureInput
{
    /**
     * Sanitize input data before filling model.
     *
     * @param array<string, mixed> $attributes
     * @return array<string, mixed>
     */
    protected function sanitizeAttributes(array $attributes): array
    {
        return collect($attributes)->map(function ($value, $key) {
            if ($this->isSecureField($key)) {
                return $this->sanitizeValue($value);
            }
            return $value;
        })->toArray();
    }
    
    protected function isSecureField(string $field): bool
    {
        return !in_array($field, ['password', 'remember_token', 'api_token']);
    }
    
    protected function sanitizeValue(mixed $value): mixed
    {
        if (is_string($value)) {
            return strip_tags(trim($value));
        }
        
        if (is_array($value)) {
            return array_map([$this, 'sanitizeValue'], $value);
        }
        
        return $value;
    }
    
    public function fill(array $attributes): static
    {
        return parent::fill($this->sanitizeAttributes($attributes));
    }
}
```

### 2. **Audit Trail nelle Classi Base**

```php
trait HasAuditTrail
{
    protected static function bootHasAuditTrail(): void
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });
        
        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
        
        static::deleting(function ($model) {
            if (method_exists($model, 'trashed') && !$model->trashed()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by');
    }
    
    public function updater(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'updated_by');
    }
    
    public function deleter(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'deleted_by');
    }
}
```

---

## 🏗️ Refactoring Architetturale

### 1. **Registry Pattern per Componenti Base**

```php
class XotComponentRegistry
{
    private static array $components = [];
    
    public static function register(string $type, string $class): void
    {
        self::$components[$type] = $class;
    }
    
    public static function get(string $type): string
    {
        if (!isset(self::$components[$type])) {
            throw new ComponentNotFoundException("Component not found: {$type}");
        }
        
        return self::$components[$type];
    }
    
    public static function create(string $type, array $parameters = []): mixed
    {
        $class = self::get($type);
        return new $class(...$parameters);
    }
    
    public static function all(): array
    {
        return self::$components;
    }
}

// Utilizzo nel ServiceProvider
class XotServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        XotComponentRegistry::register('model', XotBaseModel::class);
        XotComponentRegistry::register('resource', XotBaseResource::class);
        XotComponentRegistry::register('page', XotBasePage::class);
        XotComponentRegistry::register('widget', XotBaseWidget::class);
    }
}
```

### 2. **Template Method Pattern per Migration**

```php
abstract class XotBaseMigration extends Migration
{
    /**
     * Template method che definisce il flusso standard.
     */
    final public function up(): void
    {
        if ($this->shouldSkip()) {
            $this->logSkipped();
            return;
        }
        
        $this->beforeMigration();
        $this->executeMigration();
        $this->afterMigration();
        $this->logCompleted();
    }
    
    /**
     * Hook methods da implementare nelle sottoclassi.
     */
    abstract protected function executeMigration(): void;
    
    protected function shouldSkip(): bool
    {
        return false; // Override se necessario
    }
    
    protected function beforeMigration(): void
    {
        // Hook per azioni pre-migrazione
    }
    
    protected function afterMigration(): void
    {
        // Hook per azioni post-migrazione
    }
    
    private function logSkipped(): void
    {
        Log::info("Migration skipped: " . static::class);
    }
    
    private function logCompleted(): void
    {
        Log::info("Migration completed: " . static::class);
    }
    
    /**
     * Helper methods comuni.
     */
    protected function hasTable(string $table): bool
    {
        return Schema::hasTable($table);
    }
    
    protected function hasColumn(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }
    
    protected function tableComment(string $table, string $comment): void
    {
        DB::statement("ALTER TABLE `{$table}` COMMENT = '{$comment}'");
    }
    
    protected function columnComment(string $table, string $column, string $comment): void
    {
        DB::statement("ALTER TABLE `{$table}` MODIFY COLUMN `{$column}` COMMENT '{$comment}'");
    }
}
```

### 3. **Observer Pattern per Eventi Base**

```php
class XotModelObserver
{
    public function creating(Model $model): void
    {
        $this->setTimestamps($model);
        $this->setCreator($model);
    }
    
    public function updating(Model $model): void
    {
        $this->setUpdater($model);
    }
    
    public function deleting(Model $model): void
    {
        $this->setDeleter($model);
    }
    
    private function setTimestamps(Model $model): void
    {
        if ($model->usesTimestamps()) {
            $now = $model->freshTimestamp();
            $model->setAttribute($model->getCreatedAtColumn(), $now);
            $model->setAttribute($model->getUpdatedAtColumn(), $now);
        }
    }
    
    private function setCreator(Model $model): void
    {
        if ($this->hasField($model, 'created_by')) {
            $model->created_by = auth()->id();
        }
    }
    
    private function setUpdater(Model $model): void
    {
        if ($this->hasField($model, 'updated_by')) {
            $model->updated_by = auth()->id();
        }
    }
    
    private function setDeleter(Model $model): void
    {
        if ($this->hasField($model, 'deleted_by')) {
            $model->deleted_by = auth()->id();
        }
    }
    
    private function hasField(Model $model, string $field): bool
    {
        return in_array($field, $model->getFillable()) || 
               (empty($model->getFillable()) && !in_array($field, $model->getGuarded()));
    }
}
```

---

## 📋 Testing Strategy

### 1. **Base Test Classes**

```php
abstract class XotBaseModelTest extends TestCase
{
    abstract protected function getModelClass(): string;
    
    public function test_model_can_be_created(): void
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::factory()->create();
        
        $this->assertInstanceOf($modelClass, $model);
        $this->assertNotNull($model->id);
    }
    
    public function test_model_has_required_traits(): void
    {
        $modelClass = $this->getModelClass();
        $traits = class_uses_recursive($modelClass);
        
        $this->assertContains(HasFactory::class, $traits);
        $this->assertContains(Updater::class, $traits);
    }
    
    public function test_model_has_correct_casts(): void
    {
        $modelClass = $this->getModelClass();
        $model = new $modelClass();
        $casts = $model->getCasts();
        
        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertEquals('datetime', $casts['created_at']);
        $this->assertEquals('datetime', $casts['updated_at']);
    }
}

// Test concreto
class UserModelTest extends XotBaseModelTest
{
    protected function getModelClass(): string
    {
        return User::class;
    }
}
```

### 2. **Integration Tests per Service Providers**

```php
class XotServiceProviderTest extends TestCase
{
    public function test_service_provider_registers_components(): void
    {
        $registry = app(XotComponentRegistry::class);
        
        $this->assertNotEmpty($registry->all());
        $this->assertTrue($registry->has('model'));
        $this->assertTrue($registry->has('resource'));
        $this->assertTrue($registry->has('page'));
        $this->assertTrue($registry->has('widget'));
    }
    
    public function test_service_provider_loads_views(): void
    {
        $this->assertTrue(view()->exists('xot::layouts.app'));
        $this->assertTrue(view()->exists('xot::components.button'));
    }
    
    public function test_service_provider_loads_translations(): void
    {
        $this->assertNotEmpty(__('xot::common.save'));
        $this->assertNotEmpty(__('xot::common.cancel'));
    }
}
```

---

## 📈 Monitoring e Observability

### 1. **Performance Monitoring**

```php
class XotPerformanceMonitor
{
    private static array $metrics = [];
    
    public static function startTimer(string $operation): void
    {
        self::$metrics[$operation] = microtime(true);
    }
    
    public static function endTimer(string $operation): float
    {
        if (!isset(self::$metrics[$operation])) {
            return 0.0;
        }
        
        $duration = microtime(true) - self::$metrics[$operation];
        unset(self::$metrics[$operation]);
        
        // Log slow operations
        if ($duration > 1.0) {
            Log::warning("Slow operation detected", [
                'operation' => $operation,
                'duration' => $duration,
            ]);
        }
        
        return $duration;
    }
    
    public static function memory(string $operation): int
    {
        $memory = memory_get_usage(true);
        
        Log::debug("Memory usage", [
            'operation' => $operation,
            'memory' => $memory,
            'formatted' => self::formatBytes($memory),
        ]);
        
        return $memory;
    }
    
    private static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
```

---

## 🎯 Roadmap di Implementazione

### Fase 1: Consolidamento Classi Base (Settimana 1-2)
- [ ] Unificare BaseModel e XotBaseModel
- [ ] Separare responsabilità in XotData
- [ ] Implementare Interface Segregation nei Widget
- [ ] Rimuovere duplicazioni di codice

### Fase 2: Performance Optimization (Settimana 3-4)
- [ ] Implementare lazy loading per relazioni
- [ ] Aggiungere caching nei Service Providers
- [ ] Ottimizzare Factory pattern
- [ ] Implementare performance monitoring

### Fase 3: Security Enhancement (Settimana 5-6)
- [ ] Aggiungere input sanitization
- [ ] Implementare audit trail completo
- [ ] Aggiungere security monitoring
- [ ] Implementare rate limiting

### Fase 4: Architecture Patterns (Settimana 7-8)
- [ ] Implementare Registry Pattern
- [ ] Aggiungere Template Method Pattern
- [ ] Implementare Observer Pattern
- [ ] Aggiungere comprehensive testing

---

## 🔗 Collegamenti

- [Laravel Architecture Patterns](https://laravel.com/project_docs/architecture-concepts)
- [PHPStan Level 10 Guidelines](../../../project_docs/phpstan-level-10.md)
- [SOLID Principles in PHP](../../../project_docs/solid-principles.md)
- [Performance Best Practices](../../../project_docs/performance-best-practices.md)

---

*Documento creato: Gennaio 2025*  
*Principi: DRY + KISS + SOLID + ROBUST + Laraxot*  
*Stato: 🟠 Framework Solido ma Necessita Refactoring Architetturale*

