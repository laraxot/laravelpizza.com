# 📁 Module Structure - Architettura Moduli Laraxot

> **FONDAMENTALE**: La struttura modulare Laraxot è il cuore dell'architettura PTVX, garantendo separazione, manutenibilità e scalabilità.

## 🏗️ Architettura Moduli Laraxot

### Principi Fondamentali
- **Autonomia**: Ogni modulo è indipendente e auto-contenuto
- **Isolamento**: Minime dipendenze tra moduli
- **Standardizzazione**: Struttura coerente tra tutti i moduli
- **Estensibilità**: Facile aggiunta di nuove funzionalità

---

## 📂 Struttura Standard Modulo

```
Modules/ModuleName/
├── app/                           # Codice applicativo
│   ├── Actions/                   # Business logic (Spatie QueueableAction)
│   │   ├── Pdf/                   # PDF generation actions
│   │   └── Specific/              # Domain-specific actions
│   ├── Data/                      # Data Transfer Objects
│   ├── Enums/                     # Enum tipizzati
│   ├── Events/                    # Eventi del dominio
│   ├── Exceptions/                # Eccezioni personalizzate
│   ├── Filament/                  # UI Components
│   │   ├── Resources/             # Resource classes
│   │   ├── Pages/                 # Page classes
│   │   ├── Widgets/               # Dashboard widgets
│   │   └── Actions/               # Filament actions
│   ├── Http/                      # HTTP layer
│   │   ├── Controllers/           # API/Web controllers
│   │   ├── Middleware/            # Custom middleware
│   │   └── Requests/              # Form requests
│   ├── Jobs/                      # Queue jobs
│   ├── Listeners/                 # Event listeners
│   ├── Models/                    # Eloquent models
│   ├── Notifications/             # Notifications
│   ├── Observers/                 # Model observers
│   ├── Policies/                  # Authorization policies
│   ├── Providers/                 # Service providers
│   ├── Repositories/              # Data access layer
│   ├── Services/                  # Domain services (rari)
│   └── Traits/                    # Reusable traits
├── config/                        # Configuration files
│   └── module-name.php            # Module configuration
├── database/
│   ├── factories/                 # Model factories
│   ├── migrations/                # Database migrations
│   └── seeders/                   # Database seeders
├── resources/
│   ├── lang/                      # Translation files
│   │   ├── en/                    # English translations
│   │   └── it/                    # Italian translations
│   └── views/                     # Blade templates
│       ├── pdf/                   # PDF templates
│       ├── filament/              # Filament views
│       └── components/            # Blade components
├── routes/                        # Route definitions
│   ├── api.php                    # API routes
│   ├── web.php                    # Web routes
│   └── console.php                # Console routes
├── tests/                         # Module tests
│   ├── Feature/                   # Feature tests
│   ├── Unit/                      # Unit tests
│   └── Pest.php                   # Pest configuration
├── docs/                          # Module documentation
│   ├── README.md                  # Module overview
│   ├── architecture.md            # Architecture specifics
│   ├── api/                       # API documentation
│   └── examples/                  # Usage examples
├── composer.json                  # Module dependencies
└── module.json                    # Module metadata
```

---

## 🎯 Componenti Chiave

### 1. **Actions** - Business Logic

Le Actions sono il cuore della logica di business in PTVX:

```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\MyModule\Data\MyData;
use Modules\MyModule\Models\MyModel;

class CreateMyModelAction
{
    use QueueableAction;
    
    public function __construct(
        private readonly MyRepository $repository
    ) {}
    
    public function execute(MyData $data): MyModel
    {
        // Validation
        $data->validate();
        
        // Business logic
        $model = $this->repository->create($data->toArray());
        
        // Events
        event(new MyModelCreated($model));
        
        return $model;
    }
}
```

### 2. **Data Objects** - DTO Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;

class MyData extends Data
{
    public function __construct(
        #[Required]
        public readonly string $name,
        
        #[Required, Email]
        public readonly string $email,
        
        public readonly ?string $description = null,
    ) {}
    
    public static function fromModel(MyModel $model): self
    {
        return new self(
            name: $model->name,
            email: $model->email,
            description: $model->description,
        );
    }
}
```

### 3. **Models** - Eloquent Models

```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\MyModule\Database\Factories\MyModelFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class MyModel extends Model
{
    protected $fillable = [
        'name',
        'email',
        'description',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function children(): HasMany
    {
        return $this->hasMany(ChildModel::class);
    }
    
    protected static function newFactory(): MyModelFactory
    {
        return MyModelFactory::new();
    }
}
```

### 4. **Filament Resources**

```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\MyModule\Models\MyModel;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
            Textarea::make('description'),
        ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListMyRecords::route('/'),
            'create' => CreateMyRecord::route('/create'),
            'edit' => EditMyRecord::route('/{record}/edit'),
        ];
    }
}
```

---

## 🗄️ Database Layer

### Migrations

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('my_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['name', 'email']);
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('my_models');
    }
};
```

### Factories

```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\MyModule\Models\MyModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\MyModule\Models\MyModel>
 */
class MyModelFactory extends Factory
{
    protected $model = MyModel::class;
    
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'description' => fake()->sentence(),
        ];
    }
}
```

---

## 🌐 Internationalization

### Translation Structure

```
resources/lang/
├── en/
│   ├── my-module.php              # General translations
│   ├── models/
│   │   └── my-model.php           # Model translations
│   └── filament/
│       └── resources/
│           └── my-resource.php    # Filament translations
└── it/
    ├── my-module.php
    ├── models/
    │   └── my-model.php
    └── filament/
        └── resources/
            └── my-resource.php
```

### Translation Files

```php
<?php

// resources/lang/it/my-module.php
return [
    'title' => 'Il Mio Modulo',
    'description' => 'Descrizione del modulo',
    
    'actions' => [
        'create' => 'Crea',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
    ],
    
    'messages' => [
        'created' => 'Elemento creato con successo',
        'updated' => 'Elemento aggiornato con successo',
        'deleted' => 'Elemento eliminato con successo',
    ],
];
```

---

## 🧪 Testing Structure

### Feature Tests

```php
<?php

declare(strict_types=1);

use Modules\MyModule\Models\MyModel;
use Modules\MyModule\Actions\CreateMyModelAction;
use Modules\MyModule\Data\MyData;

it('can create a model', function () {
    $data = MyData::from([
        'name' => 'Test Model',
        'email' => 'test@example.com',
    ]);
    
    $model = app(CreateMyModelAction::class)->execute($data);
    
    expect($model)
        ->toBeInstanceOf(MyModel::class)
        ->name->toBe('Test Model')
        ->email->toBe('test@example.com');
});
```

### Unit Tests

```php
<?php

declare(strict_types=1);

use Modules\MyModule\Services\MyService;
use Modules\MyModule\Repositories\MyRepositoryInterface;

it('calculates correct total', function () {
    $repository = Mockery::mock(MyRepositoryInterface::class);
    $repository->shouldReceive('getAll')
        ->once()
        ->andReturn(collect([
            ['price' => 100],
            ['price' => 200],
        ]));
    
    $service = new MyService($repository);
    
    $total = $service->calculateTotal();
    
    expect($total)->toBe(300);
});
```

---

## 📚 Documentation Structure

### Module Documentation

```
docs/
├── README.md                      # Module overview
├── installation.md                # Installation instructions
├── architecture.md                # Architecture details
├── api/                          # API documentation
│   ├── endpoints.md              # API endpoints
│   └── examples.md               # API examples
├── user-guide/                   # User documentation
│   ├── getting-started.md        # Getting started
│   └── advanced-usage.md         # Advanced features
└── developer-guide/              # Developer documentation
    ├── extending.md              # Extending the module
    └── contributing.md           # Contributing guidelines
```

---

## 🔧 Configuration

### Module Configuration

```php
<?php

// config/my-module.php
return [
    'default_options' => [
        'timeout' => 30,
        'retries' => 3,
    ],
    
    'features' => [
        'feature_a' => env('MY_MODULE_FEATURE_A', true),
        'feature_b' => env('MY_MODULE_FEATURE_B', false),
    ],
    
    'pdf' => [
        'engine' => 'spipu', // spipu|spatie
        'orientation' => 'P',
        'format' => 'A4',
    ],
];
```

### Module Metadata

```json
{
    "name": "MyModule",
    "alias": "my-module",
    "description": "My awesome module",
    "version": "1.0.0",
    "requires": [],
    "providers": [
        "Modules\\MyModule\\Providers\\MyModuleServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "autoload": {
        "psr-4": {
            "Modules\\MyModule\\": ""
        }
    }
}
```

---

## 🚀 Creazione Nuovo Modulo

### 1. Generazione Modulo Base

```bash
php artisan module:make MyModule
```

### 2. Generazione Componenti

```bash
# Model con Factory e Migration
php artisan module:make-model MyModel MyModule -m -f

# Controller
php artisan module:make-controller MyController MyModule

# Filament Resource
php artisan module:make-filament-resource MyResource MyModule

# Action
php artisan module:make-action CreateMyModelAction MyModule

# Data Object
php artisan module:make-data MyData MyModule
```

### 3. Configurazione Provider

```php
<?php

namespace Modules\MyModule\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\MyModule\Repositories\MyRepository;
use Modules\MyModule\Repositories\MyRepositoryInterface;

class MyModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MyRepositoryInterface::class, MyRepository::class);
    }
    
    public function boot(): void
    {
        $this->loadViewsFrom(module_path('MyModule', 'resources/views'), 'my-module');
        $this->loadTranslationsFrom(module_path('MyModule', 'resources/lang'), 'my-module');
    }
}
```

---

## 📋 Module Quality Checklist

### Structure
- [ ] Directory structure follows Laraxot conventions
- [ ] PSR-4 autoloading configured correctly
- [ ] Service provider registered
- [ ] Module metadata complete

### Code Quality
- [ ] Strict typing everywhere
- [ ] PHPStan Level 10 compliant
- [ ] Tests with adequate coverage
- [ ] Documentation complete

### Security
- [ ] Input validation implemented
- [ ] Authorization policies defined
- [ ] No hardcoded secrets
- [ ] SQL injection prevention

### Performance
- [ ] Database indexes optimized
- [ ] Eager loading for relationships
- [ ] Caching strategies implemented
- [ ] Queue jobs for heavy operations

---

## 📚 Riferimenti Correlati

- [Architecture Rules](architecture-rules.md) - Pattern architetturali
- [Core Rules](core.md) - Regole fondamentali
- [Code Quality](code-quality.md) - Standards di qualità
- [Framework Specifics](framework-specifics.md) - Dettagli framework

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: ⚡ ALTA - Architettura modulare fondamentale  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "Un buon modulo è come un buon libro: autonomo, ben strutturato e facile da capire."