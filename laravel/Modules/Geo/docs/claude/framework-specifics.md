# Framework Specifics

## 🚨 Filament 4 Critical Rules

### 1. EXTENSION OF BASE CLASSES (REQUIRED)

```php
// ✅ ALWAYS do this
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

// ❌ NEVER do this
use Filament\Resources\Resource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Pages\Page;
use Filament\Widgets\Widget;
```

**Reason**: Xot base classes provide automatic translations, standardized behaviors, and common functionality.

### 2. NO HARDCODED TRANSLATIONS

```php
// ✅ CORRECT - No translation methods
TextInput::make('name')
    ->required()
    ->maxLength(255);

// ❌ FORBIDDEN - Never use these methods
TextInput::make('name')
    ->label('Nome')           // FORBIDDEN
    ->placeholder('Inserisci nome')  // FORBIDDEN
    ->helperText('Nome completo')    // FORBIDDEN
```

**Reason**: Translations are handled automatically by the LangServiceProvider via module translation files.

### 3. CORRECT METHOD IMPLEMENTATION

```php
// ✅ CORRECT - Use get*() methods
public function getFormSchema(): array
{
    return [
        TextInput::make('name')->required(),
        EmailInput::make('email')->required(),
    ];
}

public function getTableColumns(): array
{
    return [
        TextColumn::make('name')->searchable()->sortable(),
        TextColumn::make('email')->searchable(),
    ];
}

// ❌ FORBIDDEN - Don't override these methods
public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema { /* FORBIDDEN */ }
public function table(Table $table): Table { /* FORBIDDEN */ }
```

## 🏗️ Filament Resource Structure

### Resource Base

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\NomeModulo\Models\User;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestione Utenti';
    protected static ?int $navigationSort = 1;
    
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informazioni Base')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                        
                    Forms\Components\EmailInput::make('email')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                ])
                ->columns(2),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
        ];
    }
}
```

## 🎯 Custom Actions

### Custom Action

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Actions;

use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Modules\NomeModulo\Models\User;

class ActivateUserAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(__('nomemodulo::actions.activate_user.label'))
            ->icon('heroicon-o-check-circle')
            ->color(Color::SUCCESS)
            ->requiresConfirmation()
            ->action(fn (User $record) => $this->activateUser($record));
    }
    
    protected function activateUser(User $user): void
    {
        $user->update(['is_active' => true]);
        
        // Log the action
        activity()
            ->performedOn($user)
            ->log('User activated');
    }
}
```

## 📱 Filament Pages

### Base Page

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class Dashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'nomemodulo::filament.pages.dashboard';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 1;
    
    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\StatsOverviewWidget::class,
            Widgets\ChartWidget::class,
        ];
    }
}
```

## 🎨 Filament Widgets

### Stats Widget

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\NomeModulo\Models\User;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?bool $isLazy = true;
    
    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make(
                __('nomemodulo::widgets.stats.total_users.label'),
                User::count()
            )
                ->description(__('nomemodulo::widgets.stats.total_users.description'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
```

## 🌐 Filament Translations

### Translation File Structure

```php
<?php

declare(strict_types=1);

// Modules/NomeModulo/lang/it/filament/resources/user-resource.php
return [
    'label' => 'Utente',
    'plural_label' => 'Utenti',
    'navigation_group' => 'Gestione Utenti',
    
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome completo',
            'help' => 'Nome e cognome dell\'utente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'Email utilizzata per l\'accesso al sistema',
        ],
    ],
    
    'actions' => [
        'create' => [
            'label' => 'Nuovo Utente',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
    ],
];
```

## 📋 Filament Checklist

### Before Every Resource
- [ ] Extends XotBaseResource
- [ ] No usage of ->label(), ->placeholder(), ->helperText()
- [ ] Complete translations in language files
- [ ] get*() methods implemented correctly
- [ ] Form schema complete and validated
- [ ] Table columns optimized
- [ ] Filters and actions implemented
- [ ] Bulk actions configured

### For Relation Managers
- [ ] Extends XotBaseRelationManager
- [ ] get*() methods implemented
- [ ] Form schema for relationships
- [ ] Table columns for relationships
- [ ] Appropriate actions for relationships

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: framework-specifics.md - Framework specific guidelines
