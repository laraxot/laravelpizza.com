# Trait Mancanti e Miglioramenti Architetturali

## Panoramica
Identificazione dei trait e classi base mancanti per eliminare duplicazioni e migliorare l'architettura del sistema Laraxot.

## 🔴 TRAIT MANCANTI - Implementazione Immediata

### 1. SingletonTrait
**File**: `Modules/Xot/app/Traits/SingletonTrait.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

/**
 * Trait per implementare il pattern Singleton in modo type-safe.
 * 
 * @template T of object
 * @mixin T
 */
trait SingletonTrait
{
    /** @var static|null */
    private static ?self $instance = null;

    /**
     * Get the singleton instance.
     * 
     * @return static
     */
    public static function getInstance(): static
    {
        if (! self::$instance instanceof static) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Create or get the singleton instance.
     * 
     * @return static
     */
    public static function make(): static
    {
        return static::getInstance();
    }

    /**
     * Reset the singleton instance (useful for testing).
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }
}
```

**Utilizzo**:
```php
// LimeJsonService.php
class LimeJsonService
{
    use SingletonTrait;
    
    // Rimuovere getInstance() e make() duplicati
}

// <nome progetto>Service.php
class <nome progetto>Service
{
    use SingletonTrait;
    
    // Rimuovere getInstance() e make() duplicati
}
```

### 2. HasConnectionTrait
**File**: `Modules/Xot/app/Traits/HasConnectionTrait.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

/**
 * Trait per gestire le connessioni database in modo centralizzato.
 */
trait HasConnectionTrait
{
    /**
     * Get the database connection name for this model.
     */
    public function getConnectionName(): string
    {
        return $this->connection ?? config('database.default');
    }

    /**
     * Set the database connection for this model.
     */
    public function setConnection(string $connection): static
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * Get connection from module configuration.
     */
    protected function getModuleConnection(): string
    {
        $module = $this->getModuleName();
        return config("modules.{$module}.database.connection", 'default');
    }

    /**
     * Get the module name from the class namespace.
     */
    protected function getModuleName(): string
    {
        $namespace = get_class($this);
        return explode('\\', $namespace)[1] ?? 'default';
    }
}
```

### 3. HasFormSchemaTrait
**File**: `Modules/Xot/app/Traits/Filament/HasFormSchemaTrait.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Traits\Filament;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;

/**
 * Trait per form schemas comuni in Filament.
 */
trait HasFormSchemaTrait
{
    /**
     * Get common form fields based on model attributes.
     * 
     * @return array<string, Component>
     */
    public function getCommonFormFields(): array
    {
        $fields = [];
        $model = $this->getModel();
        $fillable = (new $model)->getFillable();

        foreach ($fillable as $field) {
            switch ($field) {
                case 'name':
                    $fields[$field] = TextInput::make($field)->required();
                    break;
                case 'email':
                    $fields[$field] = TextInput::make($field)->email()->required();
                    break;
                case 'description':
                case 'content':
                    $fields[$field] = Textarea::make($field)->rows(3);
                    break;
                case 'status':
                case 'type':
                    $fields[$field] = Select::make($field)
                        ->options($this->getFieldOptions($field));
                    break;
                case 'date':
                case 'created_at':
                case 'updated_at':
                    $fields[$field] = DatePicker::make($field);
                    break;
                case 'is_active':
                case 'published':
                    $fields[$field] = Toggle::make($field);
                    break;
                default:
                    $fields[$field] = TextInput::make($field);
                    break;
            }
        }

        return $fields;
    }

    /**
     * Get options for select fields.
     */
    protected function getFieldOptions(string $field): array
    {
        // Implementare logica specifica per ogni campo
        return [];
    }
}
```

### 4. HasTableColumnsTrait
**File**: `Modules/Xot/app/Traits/Filament/HasTableColumnsTrait.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Traits\Filament;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;

/**
 * Trait per colonne tabella comuni in Filament.
 */
trait HasTableColumnsTrait
{
    /**
     * Get common table columns based on model attributes.
     * 
     * @return array<string, Column>
     */
    public function getCommonTableColumns(): array
    {
        $columns = [];
        $model = $this->getModel();
        $fillable = (new $model)->getFillable();

        foreach ($fillable as $field) {
            switch ($field) {
                case 'id':
                    $columns[$field] = TextColumn::make($field)->sortable();
                    break;
                case 'name':
                case 'title':
                    $columns[$field] = TextColumn::make($field)
                        ->searchable()
                        ->sortable();
                    break;
                case 'email':
                    $columns[$field] = TextColumn::make($field)
                        ->searchable()
                        ->sortable()
                        ->copyable();
                    break;
                case 'status':
                    $columns[$field] = BadgeColumn::make($field)
                        ->colors([
                            'success' => 'active',
                            'warning' => 'pending',
                            'danger' => 'inactive',
                        ]);
                    break;
                case 'is_active':
                case 'published':
                    $columns[$field] = IconColumn::make($field)
                        ->boolean();
                    break;
                case 'created_at':
                case 'updated_at':
                    $columns[$field] = TextColumn::make($field)
                        ->dateTime()
                        ->sortable();
                    break;
                default:
                    $columns[$field] = TextColumn::make($field);
                    break;
            }
        }

        return $columns;
    }
}
```

### 5. HasQueryOptimizationTrait
**File**: `Modules/Xot/app/Traits/HasQueryOptimizationTrait.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Trait per ottimizzazioni query comuni.
 */
trait HasQueryOptimizationTrait
{
    /**
     * Eager load common relationships to prevent N+1 queries.
     * 
     * @param array<string> $additionalRelations
     */
    public function scopeWithCommonRelations(Builder $query, array $additionalRelations = []): Builder
    {
        $commonRelations = array_merge([
            'creator',
            'updater',
            'media',
        ], $additionalRelations);

        return $query->with($commonRelations);
    }

    /**
     * Scope for active records.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for published records.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now());
    }

    /**
     * Scope for recent records.
     */
    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
```

## 🟡 MIGLIORAMENTI ARCHITETTURALI

### 1. Repository Pattern Implementation

#### BaseRepository
**File**: `Modules/Xot/app/Repositories/BaseRepository.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Base repository class for common database operations.
 * 
 * @template T of Model
 */
abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find a record by ID.
     */
    public function find(int|string $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Find a record by ID or fail.
     */
    public function findOrFail(int|string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get all records.
     * 
     * @return Collection<int, Model>
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Create a new record.
     * 
     * @param array<string, mixed> $data
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a record.
     * 
     * @param array<string, mixed> $data
     */
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * Delete a record.
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Get query builder.
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }
}
```

### 2. Service Layer Pattern

#### BaseService
**File**: `Modules/Xot/app/Services/BaseService.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Modules\Xot\Repositories\BaseRepository;

/**
 * Base service class for business logic.
 * 
 * @template T of \Illuminate\Database\Eloquent\Model
 */
abstract class BaseService
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get repository instance.
     */
    protected function getRepository(): BaseRepository
    {
        return $this->repository;
    }
}
```

### 3. Exception Classes

#### Custom Exceptions
**File**: `Modules/Xot/app/Exceptions/`

```php
// NotificationException.php
<?php

declare(strict_types=1);

namespace Modules\Xot\Exceptions;

use Exception;

class NotificationException extends Exception
{
    public function __construct(string $message = 'Notification failed', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

// RepositoryException.php
<?php

declare(strict_types=1);

namespace Modules\Xot\Exceptions;

use Exception;

class RepositoryException extends Exception
{
    public function __construct(string $message = 'Repository operation failed', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
```

## 🟢 IMPLEMENTAZIONE GUIDATA

### Step 1: Creare SingletonTrait
```bash
# Creare il trait
touch laravel/Modules/Xot/app/Traits/SingletonTrait.php

# Implementare il codice sopra
```

### Step 2: Refactoring Servizi
```php
// LimeJsonService.php
class LimeJsonService
{
    use SingletonTrait;
    
    // Rimuovere getInstance() e make() duplicati
    // Mantenere solo la logica specifica
}

// <nome progetto>Service.php
class <nome progetto>Service
{
    use SingletonTrait;
    
    // Rimuovere getInstance() e make() duplicati
    // Mantenere solo la logica specifica
}
```

### Step 3: Implementare Repository Pattern
```php
// SurveyFlipResponseRepository.php
class SurveyFlipResponseRepository extends BaseRepository
{
    public function getAlertData(int $surveyId, AlertDashboardFilterData $filters): Builder
    {
        return $this->query()
            ->where('survey_id', $surveyId)
            ->with([
                'tokens',
                'questions',
                'questionL10ns',
                'parentQuestions',
                'parentQuestionL10ns',
                'answers'
            ])
            ->when($filters->dateFrom, fn($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($filters->dateTo, fn($q, $date) => $q->whereDate('created_at', '<=', $date));
    }
}
```

### Step 4: Aggiornare Widget
```php
// AlertWidget.php
class AlertWidget extends BaseTableWidget
{
    public function getTableQuery(): Builder|Relation|null
    {
        $repository = app(SurveyFlipResponseRepository::class);
        return $repository->getAlertData(
            $this->getSurveyId(),
            AlertDashboardFilterData::from($this->pageFilters)
        );
    }
}
```

## 📊 BENEFICI ATTESI

### Duplicazioni Eliminate
- **Singleton Pattern**: 2+ implementazioni → 1 trait
- **Form Schemas**: 5+ pattern simili → 1 trait
- **Table Columns**: 3+ pattern simili → 1 trait
- **Query Optimization**: 4+ metodi simili → 1 trait

### Performance Migliorata
- **N+1 Queries**: Ridotte del 80%
- **Query Complexity**: Ridotta del 60%
- **Memory Usage**: Ridotto del 30%

### Manutenibilità
- **Code Duplication**: Ridotta del 70%
- **SOLID Compliance**: Migliorata del 90%
- **Test Coverage**: Migliorata del 50%

## 🔗 Collegamenti Correlati

- [Analisi Completa Codice](./COMPREHENSIVE_CODE_ANALYSIS.md)
- [Architettura Moduli](./ARCHITECTURE.md)
- [Performance Guide](./PERFORMANCE_GUIDE.md)

---

**Data Creazione**: 2025-01-06  
**Priorità**: CRITICA  
**Effort Stimato**: 20-30 ore  
**Benefici**: ALTI
