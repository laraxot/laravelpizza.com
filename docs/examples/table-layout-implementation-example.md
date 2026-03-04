# Esempio Pratico: Implementazione TableLayoutEnum

## Panoramica

Questo esempio dimostra come implementare il TableLayoutEnum in una pagina ListRecords di Filament, mostrando l'integrazione completa con il trait HasXotTable e la gestione del layout toggle.

## Implementazione Completa

### 1. Pagina ListRecords

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Filament\Resources\UserResource\Pages;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Example\Filament\Resources\UserResource;

class ListUsers extends XotBaseListRecords
{
    use HasXotTable;

    protected static string $resource = UserResource::class;

    protected TableLayoutEnum $layout;

    public function mount(): void
    {
        parent::mount();
        $this->layout = TableLayoutEnum::init();
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid())
            ->extraAttributes([
                'class' => $this->layout->getContainerClasses(),
            ]);
    }

    /**
     * Get appropriate columns for current layout.
     */
    protected function getColumnsForLayout(): array
    {
        $listColumns = [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                    default => 'gray',
                }),
        ];

        $gridColumns = [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name')
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->size('lg'),
                Tables\Columns\TextColumn::make('email')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
            ])->space(2),
        ];

        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }

    /**
     * Layout toggle action.
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleLayout')
                ->action(function () {
                    $this->layout = $this->layout->toggle();
                    $this->resetTable();
                }),
        ];
    }
}
```

### 2. File di Traduzione

```php
<?php

// Modules/Example/lang/it/table-layout.php
return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione tradizionale a righe',
        'tooltip' => 'Mostra i dati in righe di tabella',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia responsive',
        'tooltip' => 'Mostra i dati in formato griglia con card',
    ],
    'toggle' => [
        'label' => 'Cambia Layout',
        'tooltip' => 'Passa tra vista lista e griglia',
    ],
];
```

### 3. Resource Class

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Example\Models\User;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Attivo',
                    'inactive' => 'Inattivo',
                ])
                ->required(),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Attivo',
                        'inactive' => 'Inattivo',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

### 4. Test Unitario

```php
<?php

declare(strict_types=1);

namespace Modules\Example\Tests\Feature\Filament\Resources\UserResource\Pages;

use Tests\TestCase;
use Modules\Example\Models\User;
use Modules\Example\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\UI\Enums\TableLayoutEnum;

class ListUsersTest extends TestCase
{
    public function test_can_view_users_list(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('filament.resources.users.index'))
            ->assertOk();
    }

    public function test_layout_toggle_works(): void
    {
        $user = User::factory()->create();
        $page = new ListUsers();

        // Test initial layout
        $this->assertEquals(TableLayoutEnum::LIST, $page->layout);

        // Test toggle
        $page->layout = $page->layout->toggle();
        $this->assertEquals(TableLayoutEnum::GRID, $page->layout);

        // Test toggle back
        $page->layout = $page->layout->toggle();
        $this->assertEquals(TableLayoutEnum::LIST, $page->layout);
    }

    public function test_columns_change_with_layout(): void
    {
        $user = User::factory()->create();
        $page = new ListUsers();

        $listColumns = [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
        ];

        $gridColumns = [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
            ]),
        ];

        // Test list layout columns
        $page->layout = TableLayoutEnum::LIST;
        $columns = $page->getColumnsForLayout();
        $this->assertEquals($listColumns, $columns);

        // Test grid layout columns
        $page->layout = TableLayoutEnum::GRID;
        $columns = $page->getColumnsForLayout();
        $this->assertEquals($gridColumns, $columns);
    }
}
```

## Vantaggi dell'Implementazione

### 1. Type Safety
- Enum tipizzato con PHP 8.1+
- Metodi con tipi di ritorno espliciti
- Controlli di tipo a compile time

### 2. Traduzioni Centralizzate
- Nessun `->label()` hardcoded
- Traduzioni nei file `lang/`
- Supporto multilingua automatico

### 3. Responsive Design
- Configurazione griglia responsive
- Breakpoints per tutti i dispositivi
- CSS classes dinamiche

### 4. Testabilità
- Metodi espliciti senza reflection
- Test unitari completi
- Mocking semplificato

### 5. Manutenibilità
- Codice pulito e ben documentato
- Separazione delle responsabilità
- Facile estensione

## Best Practices

### 1. Definizione Colonne
- Separare sempre colonne lista e griglia
- Utilizzare Stack per layout griglia
- Configurare responsive breakpoints

### 2. Gestione Stato
- Inizializzare layout nel mount()
- Utilizzare toggle() per cambiare layout
- Reset table dopo cambio layout

### 3. Traduzioni
- Implementare sempre file di traduzione
- Struttura espansa per tutti i campi
- Sincronizzazione IT/EN/DE

### 4. Testing
- Testare tutti i metodi dell'enum
- Verificare cambio layout
- Controllare traduzioni

## Collegamenti

- [TableLayoutEnum Documentation](../table-layout-enum-comprehensive.md)
- [UI Module Architecture](../architecture_rules.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)
- [Translation Standards](../../../docs/translation_standards.md)
