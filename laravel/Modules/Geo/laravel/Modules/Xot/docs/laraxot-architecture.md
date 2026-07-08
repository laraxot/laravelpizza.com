# Laraxot Architecture Rules - Xot Module

## 🎯 Regole Fondamentali Laraxot

### 1. **MAI estendere direttamente classi Filament**
```php
// ❌ SBAGLIATO - Mai estendere direttamente
class MyPage extends ViewRecord
class MyPage extends CreateRecord
class MyPage extends EditRecord
class MyPage extends ListRecords
class MyPage extends Page

// ✅ CORRETTO - Sempre estendere XotBase
class MyPage extends XotBaseViewRecord
class MyPage extends XotBaseCreateRecord
class MyPage extends XotBaseEditRecord
class MyPage extends XotBaseListRecords
class MyPage extends XotBasePage
```

### 2. **Namespace Corretti per Estensioni**
```php
// ✅ CORRETTO
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Xot\Filament\Resources\XotBaseResource;

// ❌ SBAGLIATO
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Page;
use Filament\Widgets\Widget;
use Filament\Resources\Resource;
```

### 3. **Regole per XotBaseResource**
```php
// ✅ CORRETTO - XotBaseResource NON ha getTableColumns
class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;

    public static function getFormSchema(): array
    {
        return [
            // Form components
        ];
    }

    // ❌ NON includere getTableColumns in XotBaseResource
    // public static function getTableColumns(): array
}

// ✅ CORRETTO - Per tabelle usare TableWidget separato
class MyTableWidget extends XotBaseWidget
{
    public function getTableColumns(): array
    {
        return [
            // Table columns
        ];
    }
}
```

### 4. **Regole per XotBasePage**
```php
// ✅ CORRETTO - XotBasePage NON ha proprietà di navigazione
class MyPage extends XotBasePage
{
    // ❌ NON includere queste proprietà
    // protected static ?string $navigationIcon;
    // protected static ?string $title;
    // protected static ?string $navigationLabel;

    public function getFormSchema(): array
    {
        return [
            // Form components
        ];
    }
}
```

### 5. **Sistema di Traduzioni**
```php
// ❌ SBAGLIATO - Non usare label/placeholder/tooltip espliciti
TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci nome')
    ->tooltip('Nome del record')

// ✅ CORRETTO - Usare file di traduzione
TextInput::make('name')
    // LangServiceProvider gestisce automaticamente le traduzioni
```

### 6. **Deprecated Components**
```php
// ❌ SBAGLIATO - BadgeColumn deprecated
BadgeColumn::make('status')

// ✅ CORRETTO - Usare TextColumn con badge()
TextColumn::make('status')
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        'active' => 'success',
        'inactive' => 'danger',
        default => 'gray',
    })
```

### 7. **Actions invece di Services**
```php
// ❌ SBAGLIATO - Non usare services
class MyService
{
    public function doSomething()
    {
        // Service logic
    }
}

// ✅ CORRETTO - Usare Spatie Queueable Actions
use Spatie\QueueableAction\QueueableAction;

class MyAction
{
    use QueueableAction;

    public function execute()
    {
        // Action logic
    }
}
```

## 🏗️ Struttura Implementazione Corretta

### 1. **ViewRecord Page**
```php
<?php

declare(strict_types=1);

namespace Modules\healthcare_app\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\Pages;
namespace Modules\ExternalProject\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\healthcare_app\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\QuestionChartResource;
use Modules\ExternalProject\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\QuestionChartResource;

class ViewQuestionChart extends XotBaseViewRecord
{
    protected static string $resource = QuestionChartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->url(fn () => static::getResource()::getUrl('edit', ['record' => $this->record])),

            Action::make('generate')
                ->icon('heroicon-o-chart-bar')
                ->action('generateChart'),

            DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    protected function getInfolistSchema(): array
    {
        return [
            // Infolist components
        ];
    }

    public function generateChart(): void
    {
        // Action logic
    }
}
```

### 2. **Widget Implementation**
```php
<?php

declare(strict_types=1);

namespace Modules\healthcare_app\Filament\Widgets;
namespace Modules\ExternalProject\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class QuestionChartFilterWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Filter Options';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    public ?string $dateFrom = null;
    public ?string $dateTo = null;
    public ?string $answerFilter = null;

    public function getFormSchema(): array
    {
        return [
            DatePicker::make('dateFrom')
                ->live()
                ->afterStateUpdated(fn () => $this->updateFilters()),

            DatePicker::make('dateTo')
                ->live()
                ->afterStateUpdated(fn () => $this->updateFilters()),

            Select::make('answerFilter')
                ->options([
                    'all' => 'All Answers',
                    'answered' => 'Answered Only',
                    'not_answered' => 'Not Answered',
                ])
                ->default('all')
                ->live()
                ->afterStateUpdated(fn () => $this->updateFilters()),
        ];
    }

    public function updateFilters(): void
    {
        $this->dispatch('filters-updated', [
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
            'answerFilter' => $this->answerFilter,
        ]);
    }
}
```

### 3. **Resource Implementation**
```php
<?php

declare(strict_types=1);

namespace Modules\healthcare_app\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\healthcare_app\Models\QuestionChart;
namespace Modules\ExternalProject\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\ExternalProject\Models\QuestionChart;

class QuestionChartResource extends XotBaseResource
{
    protected static ?string $model = QuestionChart::class;

    public static function getFormSchema(): array
    {
        return [
            // Form components
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionCharts::route('/'),
            'create' => Pages\CreateQuestionChart::route('/create'),
            'edit' => Pages\EditQuestionChart::route('/{record}/edit'),
            'view' => Pages\ViewQuestionChart::route('/{record}'),
        ];
    }
}
```

## 📋 Checklist Implementazione

### ✅ Prima di Implementare
- [ ] Verificare che estenda classe XotBase corretta
- [ ] Controllare namespace corretto
- [ ] Rimuovere proprietà di navigazione se XotBasePage
- [ ] Non includere getTableColumns in XotBaseResource
- [ ] Usare file di traduzione invece di label espliciti
- [ ] Usare TextColumn con badge() invece di BadgeColumn
- [ ] Usare Actions invece di Services

### ✅ Durante Implementazione
- [ ] Seguire convenzioni naming
- [ ] Implementare metodi obbligatori
- [ ] Usare type hints corretti
- [ ] Documentare PHPDoc
- [ ] Testare funzionalità

### ✅ Dopo Implementazione
- [ ] Verificare PHPStan livello 10
- [ ] Controllare conformità PSR-12
- [ ] Aggiornare documentazione
- [ ] Testare integrazione

## 🚫 Anti-Patterns da Evitare

### 1. **Estensioni Dirette Filament**
```php
// ❌ MAI FARE
class MyPage extends ViewRecord
class MyWidget extends Widget
class MyResource extends Resource
```

### 2. **Proprietà di Navigazione in XotBasePage**
```php
// ❌ MAI FARE
class MyPage extends XotBasePage
{
    protected static ?string $navigationIcon;
    protected static ?string $title;
    protected static ?string $navigationLabel;
}
```

### 3. **getTableColumns in XotBaseResource**
```php
// ❌ MAI FARE
class MyResource extends XotBaseResource
{
    public static function getTableColumns(): array
    {
        // Non appartiene a XotBaseResource
    }
}
```

### 4. **Label Espliciti**
```php
// ❌ MAI FARE
TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci nome')
```

### 5. **BadgeColumn Deprecated**
```php
// ❌ MAI FARE
BadgeColumn::make('status')
```

## 📚 Riferimenti

- [XotBasePage Implementation](./xotbasepage_implementation.md)
- [XotBaseWidget Implementation](./xotbasewidget_implementation.md)
- [XotBaseResource Implementation](./xotbaseresource_implementation.md)
- [Translation System](./translation_system.md)
- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)

Queste regole garantiscono coerenza con l'architettura Laraxot e compatibilità con Filament 4.
# Laraxot Architecture: Philosophy, Religion, Politics, and Zen

## Core Philosophy (Filosofia)

Laraxot is built on the **DRY (Don't Repeat Yourself)** and **KISS (Keep It Simple, Stupid)** principles. The architecture emphasizes:

1. **Modularity**: Everything is organized into modules using the `nwidart/laravel-modules` package
2. **Inheritance Chain**: Clear inheritance pattern that maintains consistency across the application
3. **Convention over Configuration**: Predefined patterns and structures that reduce decision-making
4. **Single Responsibility**: Each component has a single, well-defined purpose

## Religion (Religione)

The architectural religion of Laraxot follows these sacred principles:

### 1. BaseModel Pattern (Sacred Inheritance Chain)
```
Model → Module BaseModel → XotBaseModel → Laravel Model
```
- Every module must have its own `BaseModel` that extends `XotBaseModel`
- Never extend `XotBaseModel` directly from a module model
- This pattern ensures consistent behavior while allowing module-specific customizations

### 2. Action Pattern (Sacred Business Logic Container)
- All business logic is encapsulated in single-purpose action classes
- Actions are located in `Modules/{ModuleName}/app/Actions/`
- Actions use the queueable pattern when needed
- Example: `GetModelTypeByModelAction`, `GeneratePdfAction`

### 3. Filament Integration (Sacred Admin Framework)
- All admin panels use Filament PHP
- Resources extend `XotBaseResource`
- Pages extend appropriate Xot base classes
- Widgets extend `XotBaseWidget`

## Politics (Politica)

### Module System Governance
- Each module is independent with its own namespace, routes, and services
- Modules can be enabled/disabled via `modules_statuses.json`
- Module ServiceProviders must extend `XotBaseServiceProvider`
- Module structure follows strict conventions

### Security and Access Control
- Authentication handled by the User module
- Authorization via Spatie permissions
- Multi-tenancy support built into the architecture
- Passport API tokens for API access

## Zen (Zen)

### The "Vestito" Philosophy (Theme as Clothing)
- Themes are like clothes ("vestito" in Italian) - they cover the application but don't change its core functionality
- Themes provide only visual presentation
- Business logic remains in modules
- Themes can be changed without affecting core functionality

### The Action-Oriented Mindset
- Every operation is an action
- Actions are pure and testable
- Actions can be queued for performance
- Actions maintain separation of concerns

## Architecture Patterns

### 1. BaseModel Inheritance Chain
```php
// Xot module provides the foundation
abstract class XotBaseModel extends Model { ... }

// Each module extends with its own base
abstract class BaseModel extends XotBaseModel {
    // Module-specific functionality
}

// Actual models extend the module's base
class SurveyPdf extends BaseModel { ... }
```

### 2. Service Provider Architecture
```php
// Base service provider handles common registration
abstract class XotBaseServiceProvider extends ServiceProvider { ... }

// Module service providers extend the base
class ModuleServiceProvider extends XotBaseServiceProvider { ... }
```

### 3. Filament Resource Pattern
```php
// Base resource with common functionality
abstract class XotBaseResource extends FilamentResource { ... }

// Module resources extend the base
class SurveyPdfResource extends XotBaseResource { ... }
```

## Core Components

### Xot Module - The Engine
- **50+ base classes** providing foundational functionality
- **20+ service providers** managing system components
- **15+ traits** offering reusable behavior patterns

### Actions System
- Located in `Modules/Xot/app/Actions/`
- Organized by functionality (Model, File, Export, etc.)
- Queueable for performance optimization
- Single responsibility principle implementation

### Service Provider Chain
1. `XotBaseServiceProvider` - Core registration logic
2. Module-specific provider - Extends base with module needs
3. Auto-registration of views, translations, components

### Model Contract System
- Interface-based contracts ensure consistency
- `ModelContract` defines common model behavior
- Type safety through contracts and interfaces

## Critical Rules and Restrictions

1. **Never use `property_exists()` on Eloquent models** - Use `hasAttribute()`, `isFillable()`, or `Schema::hasColumn()`
2. **Always extend module-specific BaseModel** - Never extend XotBaseModel directly
3. **Use Actions for business logic** - No business logic in controllers or models
4. **Theme as "Vestito"** - Themes only for presentation, not business logic
5. **Filament-first approach** - Admin functionality through Filament, not custom controllers

## Migration Philosophy
- One migration per table per module
- Use `tableUpdate()` for subsequent changes
- Check for column existence before adding (`hasColumn()`, `hasIndex()`)
- Multiple migrations for same table in same module is violation

## The Laraxot Way of Thinking

Laraxot is not just a framework but a **way of thinking** about application development:

- **Consistency over Flexibility**: Strict conventions ensure consistency
- **Modularity over Monolith**: Everything is a module
- **Actions over Controllers**: Business logic in actions, not controllers
- **Inheritance over Composition**: Clear inheritance chains for maintainability
- **Type Safety over Speed**: Strong typing for long-term maintainability

This architecture creates a harmonious system where all components work together in a predictable, maintainable way.