# Implementazione Xot

## Struttura del Codice

### Convenzioni
- Seguire PSR-12 per lo stile del codice
- Mantenere una lunghezza massima di 120 caratteri per riga
- Utilizzare indentazione di 4 spazi
- Inserire una riga vuota tra i metodi
- Utilizzare parentesi graffe su nuova riga per classi e metodi

### Nomenclatura
- **Classi**: PascalCase (es. `XotResource`)
- **Metodi**: camelCase (es. `validateXot`)
- **Variabili**: camelCase (es. `xotStatus`)
- **Costanti**: UPPER_SNAKE_CASE (es. `MAX_XOT`)
- **Interfacce**: PascalCase con suffisso Interface (es. `XotServiceInterface`)
- **Trait**: PascalCase con suffisso Trait (es. `XotTrait`)

### Type Hinting
- Utilizzare sempre type hints per parametri e return types
- Utilizzare tipi nullable quando appropriato (es. `?string`)
- Utilizzare union types quando necessario (es. `string|int`)
- Utilizzare mixed solo quando strettamente necessario

## Architettura

### Pattern Utilizzati
- Repository Pattern per l'accesso ai dati
- Service Layer per la logica di business
- Factory Pattern per la creazione di oggetti complessi
- Observer Pattern per eventi e notifiche
- Strategy Pattern per algoritmi variabili

### Directory Structure
```
Xot/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Filament/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── Models/
├── Providers/
├── Services/
└── Traits/
```

## Implementazione Filament

### Resource Base
```php
namespace Modules\Xot\Filament\Resources;

use Filament\Resources\Resource;

class XotResource extends Resource
{
    protected static ?string $model = null;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Xot';
    
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? Str::headline(static::getModelLabel());
    }
}
```

### Pages
```php
namespace Modules\Xot\Filament\Pages;

use Filament\Pages\Page;

class XotPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Xot';
    protected static string $view = 'xot::filament.pages.xot';
    
    public function mount()
    {
        $this->form->fill([
            'xots' => $this->getXots(),
        ]);
    }
    
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nome')
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label('Descrizione')
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Stato')
                ->options([
                    'draft' => 'Bozza',
                    'active' => 'Attivo',
                    'inactive' => 'Inattivo',
                ])
                ->required(),
        ];
    }
}
```

### Widgets
```php
namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class XotStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Xot', Xot::count())
                ->description('Xot attivi')
                ->descriptionIcon('heroicon-m-cube'),
            Stat::make('Elementi', Element::count())
                ->description('Elementi totali')
                ->descriptionIcon('heroicon-m-cube-transparent'),
        ];
    }
}
```

## Servizi

### Gestione Xot
```php
namespace Modules\Xot\Services;

interface XotServiceInterface
{
    public function createXot(array $data): void;
    public function updateXot(string $id, array $data): void;
    public function deleteXot(string $id): void;
    public function getXotDetails(string $id): array;
    public function getXotsByStatus(string $status): array;
}
```

### Gestione Elementi
```php
namespace Modules\Xot\Services;

interface ElementServiceInterface
{
    public function createElement(string $xotId, array $data): void;
    public function updateElement(string $id, array $data): void;
    public function deleteElement(string $id): void;
    public function getElementDetails(string $id): array;
    public function getElementsByXot(string $xotId): array;
}
```

## Database

### Convenzioni
- Nomi tabelle in snake_case plurale (es. `xots`)
- Nomi colonne in snake_case (es. `xot_status`)
- Chiavi esterne: `{table}_id` (es. `user_id`)
- Timestamps: `created_at`, `updated_at`, `deleted_at`
- Soft deletes per tutte le tabelle principali

### Migrazioni
```php
Schema::create('xots', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->string('status');
    $table->morphs('owner');
    $table->json('data')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('elements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('xot_id')->constrained();
    $table->morphs('elementable');
    $table->string('status');
    $table->json('data')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

### Indici
```php
Schema::table('xots', function (Blueprint $table) {
    $table->index(['status', 'created_at']);
    $table->index(['owner_type', 'owner_id']);
});

Schema::table('elements', function (Blueprint $table) {
    $table->index(['xot_id', 'status']);
    $table->index(['elementable_type', 'elementable_id']);
});
```

## Frontend

### Views
```php
// resources/views/xot/xot.blade.php
<x-filament::page>
    <x-filament::form wire:submit="save">
        <x-filament::card>
            <x-filament::form-section>
                <x-slot name="title">
                    Gestione Xot
                </x-slot>

                <x-slot name="description">
                    Gestisci i dettagli dell'Xot
                </x-slot>

                {{ $this->form }}
            </x-filament::form-section>
        </x-filament::card>
    </x-filament::form>
</x-filament::page>
```

### Folio
```php
// routes/folio.php
Route::get('/xot', \Modules\Xot\Filament\Pages\XotPage::class);
```

## Testing

### Convenzioni
- Test unitari per ogni classe
- Test di integrazione per flussi complessi
- Test di feature per Filament e Folio
- Utilizzare data providers quando appropriato
- Seguire il pattern "given-when-then"

### Unit Tests
```php
class XotServiceTest extends TestCase
{
    public function test_create_xot()
    {
        $data = [
            'name' => 'Test Xot',
            'description' => 'Descrizione Xot',
            'status' => 'draft'
        ];
        
        $this->xotService->createXot($data);
        
        $xot = Xot::where('name', $data['name'])->first();
        $this->assertNotNull($xot);
        $this->assertEquals($data['status'], $xot->status);
    }
}
```

### Feature Tests
```php
class XotPageTest extends TestCase
{
    public function test_can_render_xot_page()
    {
        $this->get('/xot')
            ->assertStatus(200)
            ->assertSee('Gestione Xot');
    }
    
    public function test_can_save_xot()
    {
        $this->post('/xot', [
            'name' => 'Test Xot',
            'description' => 'Descrizione Xot',
            'status' => 'draft'
        ])
        ->assertStatus(200)
        ->assertSessionHas('success');
    }
}
``` 
### Versione HEAD


## Collegamenti tra versioni di implementation.md
* [implementation.md](../../../Gdpr/docs/implementation.md)
* [implementation.md](../../../Xot/docs/implementation.md)
* [implementation.md](../../../Job/docs/implementation.md)


### Versione Incoming


---

