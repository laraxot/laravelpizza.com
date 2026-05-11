# Filament V5 Widgets Guide - Modulo Xot

**Data**: 2026-03-23  
**Modulo**: Xot  
**Stato**: ✅ AGGIORNATO  

---

## Panoramica

Il modulo Xot fornisce le classi base per tutti i widget Filament nel progetto.

## Classi Widget

### 1. XotBaseWidget

**File**: `app/Filament/Widgets/XotBaseWidget.php`

**Scopo**: Classe base per tutti i widget Filament

**Caratteristiche**:
- ✅ Implementa `HasForms` e `HasActions`
- ✅ Usa trait `InteractsWithForms` e `InteractsWithActions`
- ✅ Fornisce metodo `getFormSchema()` protected (Filament V5 standard)
- ✅ Fornisce metodo `form()` public per configurazione schema

**Utilizzo**:

```php
<?php

namespace App\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\TextInput;

class MyWidget extends XotBaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')->label('Nome'),
        ];
    }
}
```

### 2. XotBaseTableWidget

**File**: `app/Filament/Widgets/XotBaseTableWidget.php`

**Scopo**: Classe base per widget con tabelle

**Caratteristiche**:
- ✅ Estende `Filament\Widgets\TableWidget`
- ✅ Usa trait `HasXotTable` e `InteractsWithPageFilters`
- ✅ Fornisce metodo `table()` public
- ✅ Fornisce metodi helper protected

**Utilizzo**:

```php
<?php

namespace App\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseTableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class MyTableWidget extends XotBaseTableWidget
{
    protected static ?int $sort = 2;
    
    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->columns($this->getColumns());
    }
    
    protected function getQuery(): Builder
    {
        return MyModel::query();
    }
    
    protected function getColumns(): array
    {
        return [
            TextColumn::make('name')->sortable(),
        ];
    }
}
```

---

## Filament V5 Changes

### Method Visibility

**PRIMA (V4)**:
```php
class XotBaseWidget extends FilamentWidget implements HasForms
{
    use InteractsWithForms;
    
    public function getFormSchema(): array  // ← ❌ WRONG
    {
        return [];
    }
}
```

**DOPO (V5)**:
```php
class XotBaseWidget extends FilamentWidget implements HasForms
{
    use InteractsWithForms;
    
    protected function getFormSchema(): array  // ← ✅ CORRECT
    {
        return [];
    }
}
```

### Property Declarations

**NON DICHIARARE**:
```php
class MyWidget extends TableWidget
{
    // ❌ NON DICHIARARE (già in Filament)
    protected static ?int $sort;
    protected static string $view;
}
```

**DICHIARARE SOLO**:
```php
class MyWidget extends TableWidget
{
    // ✅ DICHIARARE SOLO SE NECESSARIO
    protected int|string|array $columnSpan = 'full';
    protected ?string $pollingInterval = null;
}
```

---

## Quality Gate

Prima di commitare modifiche ai widget:

- [ ] ✅ **PHP Syntax**: `php -l app/Filament/Widgets/*.php`
- [ ] ✅ **PHPStan**: `composer phpstan` (NO errors)
- [ ] ✅ **PHPMD**: `php phpmd app/Filament/Widgets/*.php text ...`
- [ ] ✅ **PHPInsights**: `php vendor/bin/phpinsights analyze`
- [ ] ✅ **Method Visibility**: Controllare visibilità metodi (public/protected)
- [ ] ✅ **Property Declarations**: No duplicati con Filament
- [ ] ✅ **Runtime Test**: Testare widget in dashboard

---

## Riferimenti

- `docs/project/FILAMENT_V5_WIDGETS_UPGRADE_GUIDE.md`
- `Modules/Predict/docs/FILAMENT_V5_WIDGETS_GUIDE.md`
- [Filament 5.x Widgets](https://filamentphp.com/docs/5.x/widgets/overview)

---

**Status**: ✅ UPDATED  
**Last Review**: 2026-03-23
