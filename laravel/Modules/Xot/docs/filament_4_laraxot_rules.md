# Filament 4 + Laraxot Rules - Xot Module

## 🎯 Regole Fondamentali

### 1. **MAI estendere direttamente classi Filament**
```php
// ❌ SBAGLIATO
class MyPage extends ViewRecord
{
    // Non estendere mai direttamente classi Filament
}

// ✅ CORRETTO
class MyPage extends XotBaseViewRecord
{
    // Estendere sempre le classi XotBase
}
```

### 2. **Struttura Namespace Corretta**
```php
// ✅ CORRETTO
namespace Modules\<nome progetto>\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\Pages;

// ❌ SBAGLIATO
namespace Modules\<nome progetto>\App\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\Pages;
```

### 3. **Uso di Schema invece di Form**
```php
// ✅ CORRETTO - Filament 4
public function form(Schema $schema): Schema
{
    return $schema->components($this->getFormSchema());
}

// ❌ SBAGLIATO - Filament 3
public function form(Form $form): Form
{
    return $form->schema($this->getFormSchema());
}
```

### 4. **Widget con XotBaseWidget**
```php
// ✅ CORRETTO
class MyWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        return [
            // Schema components
        ];
    }
}

// ❌ SBAGLIATO
class MyWidget extends Widget implements HasForms
{
    use InteractsWithForms;
}
```

## 🏗️ Architettura Pagine Resource

### 1. **ViewRecord Pages**
```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewQuestionChart extends XotBaseViewRecord
{
    protected static string $resource = QuestionChartResource::class;

    protected function getInfolistSchema(): array
    {
        return [
            // Infolist components
        ];
    }
}
```

### 2. **Widget per Filtri e Dati**
```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class QuestionChartDataWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        return [
            // Form components
        ];
    }
}
```

## 📋 Convenzioni Specifiche

### 1. **Metodi Obbligatori**
- `getFormSchema(): array` per widget
- `getInfolistSchema(): array` per ViewRecord pages
- `getTableColumns(): array` per table widgets

### 2. **Proprietà Standard**
```php
protected static string $resource = ResourceClass::class;
protected int | string | array $columnSpan = 'full';
protected static ?int $sort = 1;
```

### 3. **Trait da Usare**
```php
use InteractsWithForms; // Già incluso in XotBaseWidget
use TransTrait; // Per traduzioni
use NavigationLabelTrait; // Per etichette navigazione
```

## 🚫 Anti-Patterns da Evitare

### 1. **Duplicazione Interfacce**
```php
// ❌ SBAGLIATO
class MyPage extends XotBasePage implements HasForms
{
    use InteractsWithForms; // Duplicato!
}

// ✅ CORRETTO
class MyPage extends XotBasePage
{
    // XotBasePage già implementa HasForms
}
```

### 2. **Metodi Statici Errati**
```php
// ❌ SBAGLIATO
public static function getFormSchema(): array

// ✅ CORRETTO
public function getFormSchema(): array
```

### 3. **Namespace Errati**
```php
// ❌ SBAGLIATO
namespace Modules\<nome progetto>\App\Filament\Widgets;

// ✅ CORRETTO
namespace Modules\<nome progetto>\Filament\Widgets;
```

## 🔧 Implementazione Corretta

### 1. **ViewRecord Page Completa**
```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\<nome progetto>\Filament\Resources\SurveyPdfResource\Resources\QuestionCharts\QuestionChartResource;

class ViewQuestionChart extends XotBaseViewRecord
{
    protected static string $resource = QuestionChartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Chart')
                ->icon('heroicon-o-pencil')
                ->url(fn () => static::getResource()::getUrl('edit', ['record' => $this->record])),
            
            Action::make('generate')
                ->label('Generate Chart')
                ->icon('heroicon-o-chart-bar')
                ->action('generateChart'),
            
            DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    protected function getInfolistSchema(): array
    {
        return [
            // Infolist components per visualizzazione dati
        ];
    }

    public function generateChart(): void
    {
        // Logica generazione grafico
    }
}
```

### 2. **Widget con Filtri**
```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class QuestionChartFilterWidget extends XotBaseWidget
{
    public ?string $dateFrom = null;
    public ?string $dateTo = null;
    public ?string $answerFilter = null;

    public function getFormSchema(): array
    {
        return [
            DatePicker::make('dateFrom')
                ->label('From Date')
                ->live()
                ->afterStateUpdated(fn () => $this->updateFilters()),
            
            DatePicker::make('dateTo')
                ->label('To Date')
                ->live()
                ->afterStateUpdated(fn () => $this->updateFilters()),
            
            Select::make('answerFilter')
                ->label('Answer Filter')
                ->options([
                    'all' => 'All Answers',
                    'answered' => 'Answered Only',
                    'not_answered' => 'Not Answered',
                ])
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

## 📚 Riferimenti

- [XotBasePage Implementation](./xotbasepage_implementation.md)
- [XotBaseWidget Implementation](./xotbasewidget_implementation.md)
- [Filament 4 Migration Guide](./filament4_migration.md)

Queste regole garantiscono coerenza con l'architettura Laraxot e compatibilità con Filament 4.


