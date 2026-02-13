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

namespace Modules\Quaeris\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Quaeris\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\QuestionChartResource;

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

namespace Modules\Quaeris\Filament\Widgets;

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

namespace Modules\Quaeris\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Quaeris\Models\QuestionChart;

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
