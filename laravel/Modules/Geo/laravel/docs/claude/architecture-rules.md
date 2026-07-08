# 🏗️ Architecture Rules - Architettura e Pattern PTVX

> **FONDAMENTALE**: L'architettura PTVX si basa su pattern consolidati per massima manutenibilità e scalabilità.

## 🎯 Principi Architetturali

### SOLID + DRY + KISS
- **S**ingle Responsibility - Ogni classe ha uno scopo unico
- **O**pen/Closed - Estensibile senza modifiche
- **L**iskov Substitution - Componenti intercambiabili
- **I**nterface Segregation - Interfacce focalizzate
- **D**ependency Inversion - Dipende da astrazioni
- **DRY** - Don't Repeat Yourself
- **KISS** - Keep It Simple, Stupid

---

## 🔧 Laraxot Module Architecture

### Struttura Modulo Standard
```
Modules/MyModule/
├── app/
│   ├── Actions/           # Business logic (Spatie QueueableAction)
│   ├── Data/              # Data Transfer Objects (Spatie Laravel Data)
│   ├── Enums/             # Enum tipizzati
│   ├── Events/            # Eventi del dominio
│   ├── Exceptions/        # Eccezioni personalizzate
│   ├── Filament/          # UI Components
│   │   ├── Resources/     # Resource classes
│   │   ├── Pages/         # Page classes
│   │   ├── Widgets/       # Dashboard widgets
│   │   └── Actions/       # Filament actions
│   ├── Jobs/              # Queue jobs
│   ├── Listeners/         # Event listeners
│   ├── Models/            # Eloquent models
│   ├── Notifications/     # Notifications
│   ├── Observers/         # Model observers
│   ├── Policies/          # Authorization policies
│   ├── Providers/         # Service providers
│   ├── Repositories/      # Data access layer
│   ├── Services/          # Domain services (rari)
│   └── Traits/            # Reusable traits
├── config/                # Configuration files
├── database/
│   ├── factories/         # Model factories
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── lang/              # Translation files
│   └── views/             # Blade templates
├── routes/                # Route definitions
├── tests/                 # Module tests
└── docs/                  # Module documentation
```

---

## 🎨 Filament Architecture

### Resource Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\MyModule\Models\MyModel;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    
    // ❌ MAI getTableColumns() qui
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name'), // Nessun label() hardcoded
            Select::make('status')
                ->options([
                    'active' => __('my-module::statuses.active'),
                    'inactive' => __('my-module::statuses.inactive'),
                ]),
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

### List Page Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMyRecords extends XotBaseListRecords
{
    // ✅ SOLO qui implementare getTableColumns()
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            
            TextColumn::make('status')
                ->badge() // Non BadgeColumn
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                }),
            
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
    
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->options([
                    'active' => __('my-module::statuses.active'),
                    'inactive' => __('my-module::statuses.inactive'),
                ]),
        ];
    }
}
```

---

## 🔄 Actions Pattern (Spatie QueueableAction)

### Action Base Structure
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MyModule\Data\MyData;
use Modules\MyModule\Models\MyModel;

class CreateMyModelAction implements ShouldQueue
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

### Action Usage
```php
// In controller, job, or another action
$model = app(CreateMyModelAction::class)->execute($data);

// In Filament action
Action::make('create')
    ->action(function (array $data) {
        app(CreateMyModelAction::class)->execute(MyData::from($data));
    })
```

---

## 📦 Data Transfer Objects Pattern

### Data Object Structure
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;

class MyData extends Data
{
    public function __construct(
        #[Required, StringType]
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
    
    public function toModel(): MyModel
    {
        return new MyModel([
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
        ]);
    }
}
```

---

## 🗄️ Repository Pattern

### Interface and Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\MyModule\Models\MyModel;

interface MyRepositoryInterface
{
    public function findById(int $id): ?MyModel;
    public function create(array $data): MyModel;
    public function update(MyModel $model, array $data): MyModel;
    public function delete(MyModel $model): bool;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
}

class MyRepository implements MyRepositoryInterface
{
    public function __construct(
        private readonly MyModel $model
    ) {}
    
    public function findById(int $id): ?MyModel
    {
        return $this->model->find($id);
    }
    
    public function create(array $data): MyModel
    {
        return $this->model->create($data);
    }
    
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['relations'])->paginate($perPage);
    }
}
```

---

## 🎯 Event/Listener Pattern

### Event Definition
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\MyModule\Models\MyModel;

class MyModelCreated
{
    use Dispatchable, SerializesModels;
    
    public function __construct(
        public readonly MyModel $model
    ) {}
}
```

### Listener Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MyModule\Events\MyModelCreated;
use Modules\MyModule\Notifications\MyModelCreatedNotification;

class SendMyModelCreatedNotification implements ShouldQueue
{
    public function handle(MyModelCreated $event): void
    {
        $event->model->notify(new MyModelCreatedNotification($event->model));
    }
}
```

---

## 🔐 Policy Pattern

### Policy Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\MyModule\Models\MyModel;

class MyModelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-my-models');
    }
    
    public function view(User $user, MyModel $model): bool
    {
        return $user->hasPermissionTo('view-my-models') || 
               $user->id === $model->created_by;
    }
    
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-my-models');
    }
    
    public function update(User $user, MyModel $model): bool
    {
        return $user->hasPermissionTo('edit-my-models') || 
               $user->id === $model->created_by;
    }
    
    public function delete(User $user, MyModel $model): bool
    {
        return $user->hasPermissionTo('delete-my-models') || 
               $user->id === $model->created_by;
    }
}
```

---

## 📋 Architecture Checklist

### Module Structure
- [ ] Separazione chiara delle responsabilità
- [ ] Actions per business logic
- [ ] Data objects per trasferimento dati
- [ ] Repository per data access
- [ ] Events/Listeners per side effects

### Filament Implementation
- [ ] Resources estendono XotBaseResource
- [ ] Pages estendono XotBase classes
- [ ] getTableColumns() solo in List pages
- [ ] Nessun label hardcoded
- [ ] TextColumn::make()->badge() non BadgeColumn

### Quality Standards
- [ ] Strict typing in tutte le classi
- [ ] Dependency injection dove appropriato
- [ ] Interface segregation
- [ ] Single responsibility principle
- [ ] Test coverage adeguato

---

## 📚 Riferimenti Correlati

- [Core Rules](core.md) - Regole fondamentali
- [Module Structure](module-structure.md) - Dettagli struttura moduli
- [Code Quality](code-quality.md) - Standards di qualità
- [Common Pitfalls](common-pitfalls.md) - Errori architetturali

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: ⚡ ALTA - Architettura sistemica  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "La migliore architettura è quella che non hai bisogno di spiegare" - È auto-evidente e segue convenzioni consolidate.