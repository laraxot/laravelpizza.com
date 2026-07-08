# Moduli

## Struttura Standard dei Moduli

Ogni modulo deve seguire una struttura standard per garantire consistenza e manutenibilità:

```
ModuleName/
├── app/
│   ├── Actions/           # Spatie QueueableActions
│   ├── Datas/            # Spatie Data Objects
│   ├── Filament/
│   │   ├── Pages/
│   │   └── Resources/    # Filament Resources
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/     # Form Requests
│   │   └── Resources/    # API Resources
│   └── Models/           # Eloquent Models
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── lang/            # File di traduzione per etichette
│   └── views/
└── routes/
    ├── api.php
    └── web.php
```

## Modulo Performance

Il modulo Performance gestisce le valutazioni e le performance del personale.

### Struttura Specifica
```
Performance/
├── app/
│   ├── Actions/
│   │   ├── Filament/
│   │   │   └── Filter/
│   │   │       └── GetYearFilter.php    # Filtro anni standard
│   │   └── Organizzativa/              # Azioni per gestione organizzativa
│   ├── Datas/
│   │   └── IndividualeData.php         # DTO per dati individuali
│   ├── Enums/
│   │   └── WorkerType.php              # Enumerazione tipi lavoratore
│   ├── Filament/
│   │   ├── Actions/
│   │   │   ├── Bulk/                   # Azioni bulk
│   │   │   ├── Header/                 # Azioni header
│   │   │   └── Table/                  # Azioni tabella
│   │   ├── Pages/
│   │   │   └── Dashboard.php
│   │   └── Resources/                  # Risorse Filament
│   ├── Mail/
│   │   ├── PerformanceMail.php
│   │   └── SchedaMail.php
│   ├── Models/
│   │   ├── Traits/                     # Traits per i modelli
│   │   │   ├── FunctionTrait.php
│   │   │   ├── MutatorTrait.php
│   │   │   └── RelationshipTrait.php
│   │   ├── Policies/                   # Policy per autorizzazioni
│   │   ├── BaseModel.php
│   │   ├── Individuale.php
│   │   └── Performance.php
│   ├── Providers/
│   │   ├── Filament/
│   │   │   └── AdminPanelProvider.php
│   │   └── PerformanceServiceProvider.php
│   └── Rules/
       └── ExcellenceRule.php           # Regole di validazione custom
```

### Convenzioni Specifiche

#### File di Traduzione
I file di traduzione del modulo devono includere le seguenti chiavi per la navigazione:
```php
// Modules/ModuleName/Resources/lang/it/module-name.php
return [
    // Etichette di navigazione
    'navigation_icon' => 'heroicon-o-rectangle-stack', // Icona di navigazione
    'navigation_group' => 'Nome Gruppo',               // Gruppo nel menu
    'navigation_sort' => 10,                          // Ordine di visualizzazione
    
    // Altre traduzioni...
];
```

#### Gestione Etichette
- **NON** utilizzare il metodo ->label() nei componenti Filament
- Le etichette vengono gestite automaticamente dal LangServiceProvider
- Definire le traduzioni nei file lang/ del modulo
- Il sistema utilizzerà automaticamente la chiave del campo come chiave di traduzione

#### Pages
- Tutte le pagine List devono estendere `XotBaseListRecords`
- **OBBLIGATORIO**: Implementare il metodo astratto `getListTableColumns()`
- La mancata implementazione causerà l'errore "contains 1 abstract method"
- Esempio:
```php
declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\AssenzeResource\Pages;

class ListAssenzes extends XotBaseListRecords
{
    public function getListTableColumns(): array
    {
        return [
            'matricola' => Tables\Columns\TextColumn::make('matricola')
                ->sortable(),
            'nome' => Tables\Columns\TextColumn::make('nome')
                ->searchable(),
        ];
    }
}
```

#### Resources
- Tutte le risorse devono estendere `XotBaseResource`
- **OBBLIGATORIO**: Implementare il metodo astratto `getFormSchema()`
- Utilizzare `heroicon-o-rectangle-stack` come icona di default
- Implementare tutti i metodi richiesti con type hints

Esempio completo di una Resource:
```php
declare(strict_types=1);

class IndividualeResource extends XotBaseResource
{
    protected static ?string $model = Individuale::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            'nome' => Forms\Components\TextInput::make('nome')
                ->string()
                ->required(),
            'valore' => Forms\Components\TextInput::make('valore')
                ->numeric()
                ->required(),
        ];
    }

    public static function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable(),
            'nome' => Tables\Columns\TextColumn::make('nome')
                ->searchable(),
            'valore' => Tables\Columns\TextColumn::make('valore')
                ->numeric()
                ->sortable(),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            'anno' => app(\Modules\Xot\Actions\Filament\Filter\GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            'edit' => Tables\Actions\EditAction::make(),
            'delete' => Tables\Actions\DeleteAction::make(),
        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            'delete' => Tables\Actions\DeleteBulkAction::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecords::route('/'),
            'create' => Pages\CreateRecord::route('/create'),
            'edit' => Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
```

#### Models
- Utilizzare Spatie Laravel Data per i DTO
- Implementare le relazioni con type hints
- Esempio:
```php
declare(strict_types=1);

class Individuale extends Model
{
    public function pesi(): HasMany
    {
        return $this->hasMany(IndividualePesi::class);
    }
}
```

#### Actions
- Utilizzare Spatie QueueableAction invece di Services
- Implementare l'interfaccia `ShouldQueue` per azioni pesanti
- Esempio:
```php
declare(strict_types=1);

class CalcolaPerformanceAction implements ShouldQueue
{
    public function execute(IndividualeData $data): void
    {
        // Logica di calcolo
    }
}
```

#### Policies
- Ogni modello deve avere la sua Policy corrispondente
- Le Policy gestiscono le autorizzazioni per le operazioni CRUD
- Esempio:
```php
declare(strict_types=1);

class IndividualePolicy
{
    public function view(User $user, Individuale $individuale): bool
    {
        return $user->can('view individuale');
    }

    public function create(User $user): bool
    {
        return $user->can('create individuale');
    }
}
```

#### Traits
- Utilizzare Traits per organizzare la logica dei modelli
- Separare le funzionalità in:
  - FunctionTrait: metodi di utilità
  - MutatorTrait: accessor e mutator
  - RelationshipTrait: relazioni con altri modelli
- Esempio:
```php
declare(strict_types=1);

trait RelationshipTrait
{
    public function performance(): BelongsTo
    {
        return $this->belongsTo(Performance::class);
    }
}
```

### Best Practices Specifiche
1. Campi Numerici:
   - Utilizzare sempre `->numeric()` per input numerici
   - Aggiungere `->sortable()` alle colonne numeriche

2. Filtri:
   - Utilizzare `GetYearFilter` per filtri anno
   - Range anni: da (anno corrente - 3) a anno corrente

3. Type Safety:
   - Utilizzare `declare(strict_types=1)` in ogni file
   - Aggiungere type hints a tutti i metodi
   - Utilizzare DTO per il trasferimento dati
