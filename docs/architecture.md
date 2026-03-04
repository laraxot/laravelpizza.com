# 🏗️ **Architettura Modulo Xot**

## 📋 **Panoramica Architetturale**

Il modulo Xot implementa un'architettura modulare robusta basata sui principi **DRY**, **KISS**, **SOLID**, **Robust** e **Laraxot**. Questa architettura garantisce scalabilità, manutenibilità e coerenza in tutto l'ecosistema.

## 🎯 **Principi Architetturali**

### **1. Modularità**
- **Isolamento**: Ogni modulo è indipendente e testabile
- **Interfacce chiare**: Contratti ben definiti tra moduli
- **Dipendenze gestite**: Sistema di dipendenze esplicite e controllate

### **2. Ereditarietà**
- **Classi base**: Forniscono funzionalità comuni a tutti i moduli
- **Estensibilità**: Facile estendere senza modificare il codice esistente
- **Consistenza**: Comportamento uniforme in tutto il sistema

### **3. Inversione di Controllo**
- **Service Container**: Gestione centralizzata delle dipendenze
- **Service Provider**: Bootstrap automatico dei moduli
- **Auto-discovery**: Rilevamento automatico di componenti

## 🏗️ **Struttura Architetturale**

### **Livello 0: Framework Laravel**
```
Laravel Core
├── Eloquent ORM
├── Service Container
├── Event System
└── Cache System
```

### **Livello 1: Modulo Xot (Base)**
```
Modules/Xot/
├── Models/
│   ├── XotBaseModel
│   └── BaseModel
├── Filament/
│   └── Resources/
│       └── XotBaseResource
├── Providers/
│   └── XotBaseServiceProvider
└── Database/
    └── Migrations/
        └── XotBaseMigration
```

### **Livello 2: Moduli Business**
```
Modules/BusinessModule/
├── Models/ (estendono BaseModel)
├── Filament/ (estendono XotBaseResource)
├── Providers/ (estendono XotBaseServiceProvider)
└── Database/ (estendono XotBaseMigration)
```

### **Livello 3: Applicazione**
```
Application Layer
├── Controllers
├── Middleware
├── Routes
└── Views
```

## 🔧 **Componenti Architetturali**

### **1. BaseModel**
```php
abstract class BaseModel extends XotBaseModel
{
    use HasXotTable;
    use HasExtra;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'extra' => 'array',
        ];
    }
}
```

**Responsabilità:**
- Gestione automatica dei campi `extra`
- Trait condivisi per funzionalità comuni
- Convenzioni standard per relazioni

### **2. XotBaseResource**
```php
abstract class XotBaseResource extends Resource
{
    use HasXotTable;

    public static function getFormSchema(): array
    {
        return static::getFormSchemaImplementation();
    }

    abstract protected static function getFormSchemaImplementation(): array;
}
```

**Responsabilità:**
- Gestione automatica delle traduzioni
- Pattern standardizzati per tabelle e form
- Integrazione nativa con Filament

### **3. XotBaseServiceProvider**
```php
abstract class XotBaseServiceProvider extends ServiceProvider
{
    protected string $module_name;

    public function boot(): void
    {
        $this->loadModuleResources();
        $this->registerModuleComponents();
    }

    protected function loadModuleResources(): void
    {
        // Caricamento automatico di views, traduzioni, migrazioni
    }
}
```

**Responsabilità:**
- Bootstrap automatico dei moduli
- Registrazione automatica di componenti
- Gestione centralizzata degli asset

## 📦 **Gestione Dipendenze (composer.json)**

Il file `composer.json` del modulo Xot è fondamentale per definire le sue dipendenze e configurazioni. Segue i principi di gestione delle dipendenze stabiliti per l'intero ecosistema Laraxot.

### **1. Dipendenze Obbligatorie (`require`)**
- **Vincoli di Versione**: Utilizzare sempre operatori di versione specifici (es. `^1.0` o `~1.2`) per garantire stabilità e prevedibilità negli aggiornamenti. Evitare l'uso di `"*"` per le dipendenze in produzione.
- **Dipendenze Core**: Il modulo Xot elenca le dipendenze Laravel e Filament necessarie per il funzionamento base dell'intero framework.

### **2. Dipendenze di Sviluppo (`require-dev`)**
- Includono strumenti per testing (Pest), analisi statica (PHPStan) e formattazione del codice (PHP-CS-Fixer), essenziali per mantenere l'alta qualità del codice base.

### **3. Repository di Percorso (`repositories`)**
- **Monorepo**: Per facilitare lo sviluppo locale all'interno del monorepo Laraxot, il modulo Xot può definire `path` repositories che puntano ad altri moduli locali (es. `./../AnotherModule`). Questo permette a Composer di risolvere le dipendenze dei moduli localmente.
- **Priorità**: Questi repository locali hanno la precedenza sui pacchetti Packagist, consentendo di testare le modifiche ai moduli dipendenti prima del rilascio.

### **4. Script e Configurazione**
- **Script di Qualità**: Include script standardizzati per `analyse`, `test`, `test-coverage` e `format`, promuovendo l'automazione del controllo qualità.
- **Stabilità**: `minimum-stability: "dev"` e `prefer-stable: true` bilanciano la necessità di utilizzare versioni in sviluppo con la preferenza per versioni stabili.

## 🔄 **Flusso di Esecuzione**

### **1. Bootstrap Applicazione**
```
1. Laravel Boot
   ├── Service Container
   ├── Configuration Loading
   └── Service Providers Registration
```

### **2. Moduli Discovery**
```
2. Xot Discovery
   ├── Scan Modules Directory
   ├── Load Service Providers
   └── Register Components
```

### **3. Resource Loading**
```
3. Resource Loading
   ├── Views
   ├── Translations
   ├── Migrations
   └── Routes
```

### **4. Component Registration**
```
4. Component Registration
   ├── Filament Resources
   ├── Livewire Components
   ├── Blade Components
   └── Artisan Commands
```

## 📊 **Pattern Architetturali**

### **1. Repository Pattern**
```php
interface RepositoryInterface
{
    public function find(int $id): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
```

### **2. Service Layer Pattern**
```php
abstract class BaseService
{
    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    abstract public function execute(array $data): mixed;
}
```

### **3. Observer Pattern**
```php
abstract class BaseObserver
{
    public function created(Model $model): void
    {
        // Logica comune per creazione
    }

    public function updated(Model $model): void
    {
        // Logica comune per aggiornamento
    }
}
```

## 🚀 **Estensibilità e Personalizzazione**

### **1. Override di Metodi Base**
```php
class CustomModel extends BaseModel
{
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'custom_field' => 'json',
        ]);
    }
}
```

### **2. Trait Personalizzati**
```php
trait HasCustomBehavior
{
    public function customMethod(): string
    {
        return 'Custom behavior';
    }
}

class CustomModel extends BaseModel
{
    use HasCustomBehavior;
}
```

### **3. Service Provider Personalizzati**
```php
class CustomServiceProvider extends XotBaseServiceProvider
{
    protected string $module_name = 'Custom';

    public function boot(): void
    {
        parent::boot();

        // Personalizzazioni specifiche
        $this->registerCustomServices();
    }
}
```

## 🔒 **Sicurezza e Validazione**

### **1. Validazione Automatica**
```php
abstract class BaseModel extends XotBaseModel
{
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->validateModel();
        });
    }

    protected function validateModel(): void
    {
        // Validazione automatica del modello
    }
}
```

### **2. Autorizzazione**
```php
abstract class XotBaseResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('viewAny', static::getModel());
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create', static::getModel());
    }
}
```

## 📈 **Performance e Ottimizzazione**

### **1. Lazy Loading**
```php
abstract class XotBaseServiceProvider extends ServiceProvider
{
    protected function registerModuleComponents(): void
    {
        if (app()->environment('production')) {
            // Registrazione lazy per produzione
            $this->registerLazyComponents();
        } else {
            // Registrazione immediata per sviluppo
            $this->registerImmediateComponents();
        }
    }
}
```

### **2. Caching**
```php
abstract class BaseModel extends XotBaseModel
{
    protected function getCachedAttribute(string $key)
    {
        return cache()->remember(
            "model_{$this->id}_{$key}",
            now()->addMinutes(30),
            fn() => $this->getAttribute($key)
        );
    }
}
```

## 🧪 **Testing Architetturale**

### **1. Test di Integrazione**
```php
abstract class XotBaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Setup comune per tutti i test
        $this->withoutExceptionHandling();
    }

    protected function assertModelExists($model): void
    {
        $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
    }
}
```

### **2. Test di Architettura**
```php
test('all models extend base model', function () {
    $modelFiles = File::allFiles(app_path('Models'));

    foreach ($modelFiles as $file) {
        $className = 'App\\Models\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME);

        if (class_exists($className)) {
            $reflection = new ReflectionClass($className);

            if (!$reflection->isAbstract()) {
                expect($reflection->getParentClass()->getName())
                    ->toBe('Modules\\Xot\\Models\\BaseModel');
            }
        }
    }
});
```

## 🔗 **Collegamenti e Riferimenti**

- [**README.md**](readme.md) - Documentazione principale del modulo
- [**Best Practices**](../project_docs/best-practices.md) - Best practices globali
- [**Troubleshooting**](../project_docs/troubleshooting.md) - Risoluzione problemi

---

