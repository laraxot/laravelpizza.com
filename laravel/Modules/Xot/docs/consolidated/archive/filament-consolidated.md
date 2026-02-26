# Filament - Guida Completa Consolidata

**Ultimo aggiornamento**: 2025-01-06  
**Principi**: DRY + KISS  
**Status**: ✅ CONSOLIDATO  

## 🎯 Panoramica

Questa guida consolidata raccoglie tutte le informazioni Filament frammentate in un unico documento completo, seguendo i principi **DRY** e **KISS** per eliminare duplicazioni e semplificare la manutenzione.

## 🏗️ Architettura Filament

### Principi Fondamentali
- **NON estendere MAI direttamente le classi Filament**
- **SEMPRE usare le classi base XotBase**
- **Mantenere separazione tra logica e presentazione**

### Classi Base Obbligatorie
```php
// ✅ CORRETTO - Estensioni XotBase
class UserResource extends XotBaseResource
class UserPage extends XotBasePage
class UserWidget extends XotBaseWidget

// ❌ ERRATO - Estensioni dirette
class UserResource extends Resource
class UserPage extends Page
class UserWidget extends Widget
```

## 📦 Componenti Filament

### Resources
```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class PatientResource extends XotBaseResource
{
    /**
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            DatePicker::make('birth_date'),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id'),
            'name' => Tables\Columns\TextColumn::make('name'),
            'birth_date' => Tables\Columns\TextColumn::make('birth_date'),
        ];
    }
}
```

### Pages
```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class DashboardPage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = '<nome progetto>::filament.pages.dashboard';

    /**
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            \Modules\<nome progetto>\Filament\Widgets\StatsWidget::class,
        ];
    }
}
```

### Widgets
```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class StatsWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Statistiche';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'total_patients' => Patient::count(),
            'total_appointments' => Appointment::count(),
        ];
    }
}
```

## 🎨 Form Components

### Text Input
```php
TextInput::make('name')
    ->label(__('<nome progetto>::fields.name.label'))
    ->placeholder(__('<nome progetto>::fields.name.placeholder'))
    ->helperText(__('<nome progetto>::fields.name.help'))
    ->required()
    ->maxLength(255);
```

### Select
```php
Select::make('status')
    ->label(__('<nome progetto>::fields.status.label'))
    ->options([
        'active' => __('<nome progetto>::fields.status.options.active'),
        'inactive' => __('<nome progetto>::fields.status.options.inactive'),
    ])
    ->required();
```

### Date Picker
```php
DatePicker::make('appointment_date')
    ->label(__('<nome progetto>::fields.appointment_date.label'))
    ->placeholder(__('<nome progetto>::fields.appointment_date.placeholder'))
    ->required()
    ->minDate(now());
```

## 📊 Table Components

### Text Column
```php
Tables\Columns\TextColumn::make('name')
    ->label(__('<nome progetto>::fields.name.label'))
    ->searchable()
    ->sortable();
```

### Badge Column
```php
Tables\Columns\BadgeColumn::make('status')
    ->label(__('<nome progetto>::fields.status.label'))
    ->colors([
        'success' => 'active',
        'danger' => 'inactive',
    ]);
```

### Action Column
```php
Tables\Columns\TextColumn::make('actions')
    ->label(__('<nome progetto>::actions.label'))
    ->actions([
        Tables\Actions\EditAction::make()
            ->label(__('<nome progetto>::actions.edit.label')),
        Tables\Actions\DeleteAction::make()
            ->label(__('<nome progetto>::actions.delete.label')),
    ]);
```

## 🔧 Actions

### Create Action
```php
Tables\Actions\CreateAction::make()
    ->label(__('<nome progetto>::actions.create.label'))
    ->icon('heroicon-o-plus')
    ->color('primary');
```

### Edit Action
```php
Tables\Actions\EditAction::make()
    ->label(__('<nome progetto>::actions.edit.label'))
    ->icon('heroicon-o-pencil')
    ->color('warning');
```

### Delete Action
```php
Tables\Actions\DeleteAction::make()
    ->label(__('<nome progetto>::actions.delete.label'))
    ->icon('heroicon-o-trash')
    ->color('danger')
    ->requiresConfirmation()
    ->modalHeading(__('<nome progetto>::actions.delete.modal_heading'))
    ->modalDescription(__('<nome progetto>::actions.delete.modal_description'));
```

## 🎯 Best Practices

### 1. Traduzioni
```php
// ✅ CORRETTO - Usare file di traduzione
TextInput::make('name')  // Traduzione automatica

// ❌ ERRATO - Stringhe hardcoded
TextInput::make('name')->label('Nome')
```

### 2. Namespace
```php
// ✅ CORRETTO - Namespace senza 'App'
namespace Modules\<nome progetto>\Filament\Resources;

// ❌ ERRATO - Namespace con 'App'
namespace Modules\<nome progetto>\App\Filament\Resources;
```

### 3. Ereditarietà
```php
// ✅ CORRETTO - Estendere XotBase
class PatientResource extends XotBaseResource

// ❌ ERRATO - Estendere direttamente
class PatientResource extends Resource
```

### 4. Service Providers
```php
// ✅ CORRETTO - Estendere XotBaseServiceProvider
class <nome progetto>ServiceProvider extends XotBaseServiceProvider
{
    protected string $module_name = '<nome progetto>';
}

// ❌ ERRATO - Estendere direttamente
class <nome progetto>ServiceProvider extends ServiceProvider
```

## 🚨 Errori Comuni

### 1. Estensione Diretta
```php
// ❌ ERRATO
use Filament\Resources\Resource;
class PatientResource extends Resource

// ✅ CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;
class PatientResource extends XotBaseResource
```

### 2. Traduzioni Hardcoded
```php
// ❌ ERRATO
TextInput::make('name')->label('Nome')

// ✅ CORRETTO
TextInput::make('name')  // Traduzione automatica
```

### 3. Namespace Errato
```php
// ❌ ERRATO
namespace Modules\<nome progetto>\App\Filament\Resources;

// ✅ CORRETTO
namespace Modules\<nome progetto>\Filament\Resources;
```

## 📋 Checklist Pre-Commit

- [ ] Nessuna classe estende direttamente una classe Filament
- [ ] Tutte le classi Filament estendono la corrispondente XotBase
- [ ] Import inutili rimossi
- [ ] Naming conforme
- [ ] Traduzioni da file (no hardcoded)
- [ ] Namespace senza segmento 'App'
- [ ] Documentazione aggiornata e linkata

## 🔗 Collegamenti

### Documentazione Ufficiale
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Documentation](https://laravel.com/docs)

### Documentazione Interna
- [XotBase Classes](xot-base-classes.md)
- [Service Providers](service-providers.md)
- [Translation System](translation-system.md)

---

*Guida consolidata che elimina duplicazioni e semplifica la manutenzione della documentazione Filament.*
