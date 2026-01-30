# Integrazione Filament - Modulo DbForge

## Panoramica

Il modulo DbForge integra Filament per fornire un'interfaccia amministrativa completa per la gestione del database. Questa documentazione descrive l'architettura Filament del modulo e come estenderla.

## Architettura Filament

### Provider Structure

```
Modules/DbForge/
├── app/
│   └── Providers/
│       └── Filament/
│           └── AdminPanelProvider.php
├── app/
│   └── Filament/
│       ├── Resources/
│       ├── Pages/
│       └── Widgets/
```

### AdminPanelProvider

Il provider principale per la configurazione del pannello Filament:

```php
<?php

namespace Modules\DbForge\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'DbForge';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Configurazioni specifiche per DbForge
        $panel->navigationItems([
            // Elementi di navigazione specifici
        ]);

        return $panel;
    }
}
```

## Resources Filament

### Struttura dei Resources

Il modulo DbForge fornisce i seguenti resources Filament:

#### DatabaseTableResource

Gestisce le operazioni sulle tabelle del database:

```php
<?php

namespace Modules\DbForge\Filament\Resources;

use Modules\DbForge\Filament\Resources\DatabaseTableResource\Pages;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DatabaseTableResource extends XotBaseResource
{
    protected static ?string $model = null;
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationGroup = 'Database Management';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Database Tables');
    }

    public static function getModelLabel(): string
    {
        return __('Database Table');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Database Tables');
    }
}
```

#### DatabaseMigrationResource

Gestisce le migrazioni personalizzate:

```php
<?php

namespace Modules\DbForge\Filament\Resources;

use Modules\DbForge\Filament\Resources\DatabaseMigrationResource\Pages;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DatabaseMigrationResource extends XotBaseResource
{
    protected static ?string $model = null;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationGroup = 'Database Management';
    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('Migrations');
    }

    public static function getModelLabel(): string
    {
        return __('Migration');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Migrations');
    }
}
```

#### DatabaseBackupResource

Gestisce i backup del database:

```php
<?php

namespace Modules\DbForge\Filament\Resources;

use Modules\DbForge\Filament\Resources\DatabaseBackupResource\Pages;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DatabaseBackupResource extends XotBaseResource
{
    protected static ?string $model = null;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Database Management';
    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('Backups');
    }

    public static function getModelLabel(): string
    {
        return __('Backup');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Backups');
    }
}
```

## Pages Filament

### Database Dashboard

Pagina principale per il monitoraggio del database:

```php
<?php

namespace Modules\DbForge\Filament\Pages;

use Filament\Pages\Page;
use Modules\Xot\Filament\Pages\XotBasePage;

class DatabaseDashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Database Management';
    protected static ?int $navigationSort = 0;

    protected static string $view = 'dbforge::pages.database-dashboard';

    public static function getNavigationLabel(): string
    {
        return __('Database Dashboard');
    }

    public function getTitle(): string
    {
        return __('Database Dashboard');
    }
}
```

### Query Builder

Pagina per la costruzione di query personalizzate:

```php
<?php

namespace Modules\DbForge\Filament\Pages;

use Filament\Pages\Page;
use Modules\Xot\Filament\Pages\XotBasePage;

class QueryBuilder extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';
    protected static ?string $navigationGroup = 'Database Management';
    protected static ?int $navigationSort = 4;

    protected static string $view = 'dbforge::pages.query-builder';

    public static function getNavigationLabel(): string
    {
        return __('Query Builder');
    }

    public function getTitle(): string
    {
        return __('Query Builder');
    }
}
```

## Widgets Filament

### DatabaseStatsWidget

Widget per visualizzare statistiche del database:

```php
<?php

namespace Modules\DbForge\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DatabaseStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tables', $this->getTotalTables())
                ->description('Tables in database')
                ->descriptionIcon('heroicon-m-table-cells')
                ->color('success'),
            
            Stat::make('Total Size', $this->getTotalSize())
                ->description('Database size')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('info'),
            
            Stat::make('Active Connections', $this->getActiveConnections())
                ->description('Current connections')
                ->descriptionIcon('heroicon-m-link')
                ->color('warning'),
        ];
    }

    private function getTotalTables(): int
    {
        // Implementazione per contare le tabelle
        return 0;
    }

    private function getTotalSize(): string
    {
        // Implementazione per calcolare la dimensione
        return '0 MB';
    }

    private function getActiveConnections(): int
    {
        // Implementazione per contare le connessioni
        return 0;
    }
}
```

### RecentOperationsWidget

Widget per visualizzare le operazioni recenti:

```php
<?php

namespace Modules\DbForge\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOperationsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Query per le operazioni recenti
            )
            ->columns([
                Tables\Columns\TextColumn::make('operation_type')
                    ->label('Operation Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('table_name')
                    ->label('Table Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'failed' => 'danger',
                        'running' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
```

## Actions Filament

### Database Actions

Azioni per operazioni sul database:

```php
<?php

namespace Modules\DbForge\Filament\Actions;

use Filament\Actions\Action;
use Modules\DbForge\Services\DatabaseService;

class CreateTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'create_table';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Create Table')
            ->icon('heroicon-o-plus')
            ->color('success')
            ->form([
                // Form fields per la creazione tabella
            ])
            ->action(function (array $data): void {
                // Logica per creare la tabella
            });
    }
}
```

### Migration Actions

Azioni per gestire le migrazioni:

```php
<?php

namespace Modules\DbForge\Filament\Actions;

use Filament\Actions\Action;

class ExecuteMigrationAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'execute_migration';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Execute Migration')
            ->icon('heroicon-o-play')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (): void {
                // Logica per eseguire la migrazione
            });
    }
}
```

## Forms Filament

### Table Creation Form

Form per la creazione di tabelle:

```php
<?php

namespace Modules\DbForge\Filament\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;

class TableCreationForm
{
    public static function make(): Form
    {
        return Form::make()
            ->schema([
                Section::make('Table Information')
                    ->schema([
                        TextInput::make('table_name')
                            ->label('Table Name')
                            ->required()
                            ->maxLength(255)
                            ->unique('information_schema.tables', 'table_name'),
                        
                        Select::make('engine')
                            ->label('Storage Engine')
                            ->options([
                                'InnoDB' => 'InnoDB',
                                'MyISAM' => 'MyISAM',
                                'MEMORY' => 'MEMORY',
                            ])
                            ->default('InnoDB')
                            ->required(),
                        
                        Select::make('collation')
                            ->label('Collation')
                            ->options([
                                'utf8mb4_unicode_ci' => 'utf8mb4_unicode_ci',
                                'utf8mb4_general_ci' => 'utf8mb4_general_ci',
                                'latin1_swedish_ci' => 'latin1_swedish_ci',
                            ])
                            ->default('utf8mb4_unicode_ci')
                            ->required(),
                    ]),
                
                Section::make('Columns')
                    ->schema([
                        Repeater::make('columns')
                            ->label('Table Columns')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Column Name')
                                    ->required(),
                                
                                Select::make('type')
                                    ->label('Data Type')
                                    ->options([
                                        'bigint' => 'BIGINT',
                                        'int' => 'INT',
                                        'varchar' => 'VARCHAR',
                                        'text' => 'TEXT',
                                        'datetime' => 'DATETIME',
                                        'timestamp' => 'TIMESTAMP',
                                        'boolean' => 'BOOLEAN',
                                    ])
                                    ->required(),
                                
                                TextInput::make('length')
                                    ->label('Length')
                                    ->numeric()
                                    ->visible(fn ($get) => in_array($get('type'), ['varchar', 'int'])),
                                
                                Select::make('nullable')
                                    ->label('Nullable')
                                    ->options([
                                        true => 'Yes',
                                        false => 'No',
                                    ])
                                    ->default(false)
                                    ->required(),
                                
                                TextInput::make('default')
                                    ->label('Default Value'),
                                
                                Select::make('key')
                                    ->label('Key Type')
                                    ->options([
                                        '' => 'None',
                                        'PRI' => 'Primary Key',
                                        'UNI' => 'Unique',
                                        'MUL' => 'Index',
                                    ]),
                            ])
                            ->minItems(1)
                            ->required(),
                    ]),
            ]);
    }
}
```

## Views Blade

### Database Dashboard View

```blade
{{-- resources/views/dbforge/pages/database-dashboard.blade.php --}}
<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Database Stats Widget --}}
        <x-filament-widgets::widget
            :widget="$this->getWidget('database-stats-widget')"
        />
        
        {{-- Recent Operations Widget --}}
        <x-filament-widgets::widget
            :widget="$this->getWidget('recent-operations-widget')"
        />
        
        {{-- Quick Actions --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                {{ __('Quick Actions') }}
            </h3>
            
            <div class="space-y-3">
                <x-filament::button
                    icon="heroicon-o-plus"
                    color="success"
                    wire:click="createTable"
                >
                    {{ __('Create Table') }}
                </x-filament::button>
                
                <x-filament::button
                    icon="heroicon-o-archive-box"
                    color="info"
                    wire:click="createBackup"
                >
                    {{ __('Create Backup') }}
                </x-filament::button>
                
                <x-filament::button
                    icon="heroicon-o-code-bracket"
                    color="warning"
                    wire:click="openQueryBuilder"
                >
                    {{ __('Query Builder') }}
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-panels::page>
```

## Livewire Components

### Database Table Manager

```php
<?php

namespace Modules\DbForge\Http\Livewire;

use Livewire\Component;
use Modules\DbForge\Services\DatabaseService;

class DatabaseTableManager extends Component
{
    public string $tableName = '';
    public array $columns = [];
    public string $engine = 'InnoDB';
    public string $collation = 'utf8mb4_unicode_ci';

    protected $rules = [
        'tableName' => 'required|string|max:255',
        'columns' => 'required|array|min:1',
        'engine' => 'required|string',
        'collation' => 'required|string',
    ];

    public function createTable()
    {
        $this->validate();

        try {
            app(DatabaseService::class)->createTable(
                $this->tableName,
                $this->columns,
                $this->engine,
                $this->collation
            );

            $this->dispatch('table-created', tableName: $this->tableName);
            $this->reset(['tableName', 'columns']);
            
            $this->notify('success', 'Table created successfully');
        } catch (\Exception $e) {
            $this->notify('error', 'Failed to create table: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('dbforge::livewire.database-table-manager');
    }
}
```

## Permissions e Policies

### Database Permissions

```php
<?php

namespace Modules\DbForge\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;

class DatabasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('dbforge.view');
    }

    public function view(User $user): bool
    {
        return $user->can('dbforge.view');
    }

    public function create(User $user): bool
    {
        return $user->can('dbforge.manage');
    }

    public function update(User $user): bool
    {
        return $user->can('dbforge.manage');
    }

    public function delete(User $user): bool
    {
        return $user->can('dbforge.manage');
    }

    public function executeMigration(User $user): bool
    {
        return $user->can('dbforge.migrate');
    }

    public function createBackup(User $user): bool
    {
        return $user->can('dbforge.backup');
    }
}
```

## Configurazione

### Filament Configuration

```php
// config/filament.php
return [
    'panels' => [
        'dbforge' => [
            'path' => 'dbforge/admin',
            'domain' => null,
            'home_url' => '/',
            'login_url' => '/login',
            'logout_url' => '/logout',
            'registration_url' => '/register',
            'password_reset_url' => '/password-reset',
            'email_verification_url' => '/email-verification',
            'profile_url' => '/profile',
        ],
    ],
];
```

## Best Practices

### 1. Estensione delle Classi Base

Sempre estendere le classi base di Xot:

```php
// ✅ Corretto
class DatabaseTableResource extends XotBaseResource

// ❌ Sbagliato
class DatabaseTableResource extends Resource
```

### 2. Organizzazione dei Namespace

Seguire la struttura dei namespace:

```php
// ✅ Corretto
namespace Modules\DbForge\Filament\Resources;

// ❌ Sbagliato
namespace Modules\DbForge\app\Filament\Resources;
```

### 3. Gestione delle Permissions

Sempre verificare le permissions:

```php
public function mount(): void
{
    $this->authorize('dbforge.view');
}
```

### 4. Gestione degli Errori

Implementare gestione errori robusta:

```php
try {
    $result = $this->databaseService->performOperation($data);
    $this->notify('success', 'Operation completed successfully');
} catch (DatabaseException $e) {
    $this->notify('error', 'Database operation failed: ' . $e->getMessage());
    Log::error('Database operation failed', [
        'operation' => $operation,
        'error' => $e->getMessage(),
        'user_id' => auth()->id(),
    ]);
}
```

### 5. Performance

Ottimizzare per le performance:

```php
// Utilizzare lazy loading per grandi dataset
protected function getTableQuery(): Builder
{
    return DatabaseTable::query()
        ->select(['id', 'name', 'engine', 'rows'])
        ->withCount('columns');
}

// Implementare caching per operazioni costose
public function getDatabaseStats(): array
{
    return Cache::remember('database_stats', 300, function () {
        return $this->databaseService->getStats();
    });
}
```

## Troubleshooting

### Problemi Comuni

1. **Provider non trovato**: Verificare che il provider sia registrato in `module.json`
2. **Resources non visualizzati**: Controllare i namespace e le permissions
3. **Errori di autoloading**: Eseguire `composer dump-autoload`
4. **Permessi mancanti**: Verificare che l'utente abbia i permessi necessari

### Debug

Abilitare il debug per Filament:

```php
// In .env
FILAMENT_DEBUG=true
```

### Logging

Monitorare i log per problemi:

```bash
tail -f storage/logs/laravel.log | grep DbForge
```

Questa integrazione Filament fornisce un'interfaccia completa e user-friendly per la gestione del database attraverso il modulo DbForge. 