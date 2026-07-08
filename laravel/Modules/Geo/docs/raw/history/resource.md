# XotBaseResource

## Overview
`XotBaseResource` è la classe base astratta per tutti i Resource Filament nel sistema. Estende `Filament\Resources\Resource` e fornisce funzionalità comuni e standardizzate.

## Gestione Icone di Navigazione

### ❌ Modo Errato
```php
class MyResource extends XotBaseResource
{
    // NON definire l'icona direttamente nella classe
    protected static ?string $navigationIcon = 'heroicon-o-user';
}
```

### ✅ Modo Corretto
Le icone vanno definite nel file di traduzione del modulo:

```php
// Modules/{Module}/lang/{locale}/my_resource.php
return [
    'navigation' => [
        'group' => 'admin',
        'label' => 'My Resource',
        'icon' => 'heroicon-o-user',
        'sort' => 10
    ]
];
```

### Icone SVG Personalizzate
Per utilizzare icone SVG personalizzate:

1. Salvare l'icona SVG in:
```
Modules/{Module}/resources/svg/{nome-icona}.svg
```

2. Riferirsi all'icona nel file di traduzione:
```php
'navigation' => [
    'icon' => '{module}::{nome-icona}',
]
```

## Struttura Base

```php
namespace Modules\Broker\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecords::route('/'),
            'create' => Pages\CreateRecord::route('/create'),
            'edit' => Pages\EditRecord::route('/{record}/edit'),
            'view' => Pages\ViewRecord::route('/{record}'),
        ];
    }
}
```

## Regole Fondamentali

1. **NON Implementare nella Resource**
   - ❌ `table()`
   - ❌ `$navigationIcon`
   - ❌ `$navigationGroup`
   - ❌ `$navigationSort`
   - ❌ `getTableColumns()`
   - ❌ `getTableFilters()`
   - ❌ `getTableActions()`
   - ❌ `form(Form $form): Form` - Usare invece `getFormSchema()`

2. **IMPLEMENTARE nella Resource**
   - ✅ `protected static ?string $model`
   - ✅ `public static function getFormSchema(): array`
   - ✅ `public static function getPages(): array`

## Gestione Tabelle

La configurazione delle tabelle va implementata nelle pagine List:

```php
namespace Modules\Broker\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListRecords extends XotBaseListRecords
{
    protected static string $resource = MyResource::class;
    
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                // Definizione colonne
            ])
            ->filters([
                // Definizione filtri
            ])
            ->actions([
                // Azioni per singola riga
            ])
            ->bulkActions([
                // Azioni di massa
            ]);
    }

    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('resource.read'),
            403
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => auth()->user()->can('resource.write')),
        ];
    }
}
```

## Documentazione Resource

È importante documentare ogni Resource con un header completo:

```php
/**
 * Risorsa per la gestione di XXX
 * 
 * Menu:
 * - Gruppo: xxx
 * - Label: xxx
 * - Icona: heroicon-o-xxx
 * - Ordinamento: xx
 * 
 * Convertito da:
 * - Controller: xxx
 * - Template: xxx
 * - URL vecchi: xxx
 * - URL nuovi: xxx
 * 
 * Note sulla conversione:
 * - Permessi
 * - Funzionalità
 * - Miglioramenti
 * 
 * Struttura:
 * - Resource: Definisce solo model e form schema
 * - Pages/List: Gestisce la configurazione della tabella
 * - Pages/Create: Gestisce la creazione
 * - Pages/Edit: Gestisce la modifica
 * - Pages/View: Gestisce la visualizzazione
 */
```

## Best Practices

1. **Separazione delle Responsabilità**
   - Resource: model, form schema, routing
   - List Page: configurazione tabella
   - Create/Edit Pages: gestione form
   - View Page: visualizzazione dettagli

2. **Gestione Permessi**
   - Implementare controlli nei mount()
   - Usare can() per azioni condizionali
   - Centralizzare i nomi dei permessi

3. **Performance**
   - Eager loading delle relazioni
   - Caching dove appropriato
   - Paginazione efficiente

4. **Manutenibilità**
   - Documentazione completa
   - Type hints appropriati
   - Nomi descrittivi per metodi e variabili

## Esempi Comuni

### 1. Form Schema con Relazioni
```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Select::make('cliente_id')
            ->relationship('cliente', 'nominativo')
            ->searchable()
            ->preload(),
        // Altri campi
    ];
}
```

### 2. Tabella con Filtri Avanzati
```php
public function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('cliente.nominativo')
                ->searchable()
                ->sortable(),
        ])
        ->filters([
            SelectFilter::make('stato')
                ->options([
                    'attivo' => 'Attivo',
                    'sospeso' => 'Sospeso',
                ]),
        ]);
}
```

### 3. Azioni Condizionali
```php
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make()
            ->visible(fn () => auth()->user()->can('create')),
        Actions\ExportAction::make()
            ->visible(fn () => auth()->user()->can('export')),
    ];
}
```

# XotBaseResource e XotBaseListRecords

## Gestione Tabelle e Traduzioni

### 1. Struttura delle Tabelle

XotBaseListRecords gestisce le tabelle attraverso metodi specifici invece del metodo `table()`:

```php
class ListMyRecords extends XotBaseListRecords
{
    // Definizione delle colonne
    public function getListTableColumns(): array
    {
        return [
            TextColumn::make('field_name')
                ->searchable()
                ->sortable(),
        ];
    }

    // Definizione dei filtri
    public function getListTableFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->relationship('status', 'name'),
        ];
    }

    // Definizione delle azioni per riga
    public function getListTableActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
        ];
    }

    // Definizione delle azioni di massa
    public function getListTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
```

### 2. Sistema di Traduzioni Automatico

Il `LangServiceProvider` gestisce automaticamente le traduzioni delle label:

1. **Struttura delle Traduzioni**:
```php
// lang/it/polizza_fuori_convenzione.php
return [
    'fields' => [
        'numero_adesione' => 'Numero Adesione',
        'cliente' => 'Cliente',
        'data_decorrenza' => 'Data Decorrenza',
    ],
    'actions' => [
        'view' => 'Visualizza',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
    ],
];
```

2. **NON Usare Label Manuali**:
```php
// ❌ ERRATO: Non specificare label manualmente
TextColumn::make('numero_adesione')
    ->label('Numero Adesione')

// ✅ CORRETTO: Le label vengono gestite automaticamente
TextColumn::make('numero_adesione')
```

3. **Come Funziona**:
- Il `LangServiceProvider` intercetta la creazione dei componenti
- Cerca automaticamente le traduzioni nei file di lingua
- Applica le traduzioni in base alla locale corrente
- Supporta la gestione multilingua

### 3. Gestione Permessi

Utilizzare la facade Auth per i controlli dei permessi:

```php
use Illuminate\Support\Facades\Auth;

class ListMyRecords extends XotBaseListRecords
{
    public function mount(): void
    {
        abort_unless(
            Auth::user()->can('resource.read'),
            403
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => Auth::user()->can('resource.write')),
        ];
    }
}
```

### 4. Best Practices

1. **Separazione delle Responsabilità**:
   - Resource: solo model e form schema
   - ListRecords: configurazione completa della tabella
   - Traduzioni: nei file di lingua

2. **Convenzioni di Naming**:
   - File di lingua: snake_case (es: `polizza_fuori_convenzione.php`)
   - Chiavi traduzioni: dot notation (es: `fields.numero_adesione`)
   - Metodi tabella: prefisso `getList` (es: `getListTableColumns`)

3. **Performance**:
   - Eager loading delle relazioni necessarie
   - Indici appropriati sul database
   - Paginazione efficiente

4. **Manutenibilità**:
   - Documentazione chiara dei metodi
   - Type hints appropriati
   - Commenti per logiche complesse

### 5. Esempio Completo

```php
namespace App\Filament\Resources\MyResource\Pages;

use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Lista dei record.
 *
 * Questa pagina gestisce la visualizzazione tabulare.
 * Le traduzioni delle label sono gestite automaticamente dal LangServiceProvider.
 */
class ListRecords extends XotBaseListRecords
{
    protected static string $resource = MyResource::class;

    public function mount(): void
    {
        abort_unless(
            Auth::user()->can('resource.read'),
            403
        );
    }

    public function getListTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('status')
                ->sortable(),
            TextColumn::make('created_at')
                ->date()
                ->sortable(),
        ];
    }

    public function getListTableFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->options([
                    'active' => 'Attivo',
                    'inactive' => 'Inattivo',
                ]),
        ];
    }

    public function getListTableActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    public function getListTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
```

# Implementazione Corretta dei Metodi della Tabella

## Metodi Standard per XotBaseListRecords

```php
class ListMyRecords extends XotBaseListRecords
{
    // ✅ CORRETTO: Usa i metodi standard di Filament
    public function getTableColumns(): array
    {
        return [
            // definizione delle colonne
        ];
    }

    public function getTableFilters(): array
    {
        return [
            // definizione dei filtri
        ];
    }

    public function getTableActions(): array
    {
        return [
            // definizione delle azioni
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            // definizione delle azioni bulk
        ];
    }
}
```

## Errori Comuni da Evitare

1. **❌ NON usare il prefisso `getListTable`**:
```php
// ❌ ERRATO
public function getListTableColumns(): array
public function getListTableFilters(): array
public function getListTableActions(): array
public function getListTableBulkActions(): array

// ✅ CORRETTO
public function getTableColumns(): array
public function getTableFilters(): array
public function getTableActions(): array
public function getTableBulkActions(): array
```

2. **❌ NON cambiare la visibilità dei metodi**:
```php
// ❌ ERRATO: protected
protected function getTableColumns(): array

// ✅ CORRETTO: public come nella classe padre
public function getTableColumns(): array
```

## Note Importanti

1. XotBaseListRecords estende Filament\Resources\Pages\ListRecords
2. Usa i metodi standard di Filament per la configurazione della tabella
3. Mantieni la visibilità pubblica dei metodi
4. Non aggiungere il prefisso "List" ai nomi dei metodi

## Tipizzazione degli Array

È **OBBLIGATORIO** utilizzare chiavi di tipo stringa per tutti gli array restituiti dai seguenti metodi:

### 1. Form Schema
```php
/**
 * @return array<string, Forms\Components\Component>
 */
public static function getFormSchema(): array
{
    return [
        'nome' => TextInput::make('nome'),
        'email' => TextInput::make('email'),
    ];
}
```

### 2. Table Columns
```php
/**
 * @return array<string, Tables\Columns\Column>
 */
public function getListTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'nome' => TextColumn::make('nome'),
    ];
}
```

### 3. Table Filters
```php
/**
 * @return array<string, Tables\Filters\BaseFilter>
 */
public function getTableFilters(): array
{
    return [
        'attivo' => Filter::make('attivo'),
        'tipo' => SelectFilter::make('tipo'),
    ];
}
```

### 4. Table Actions
```php
/**
 * @return array<string, Tables\Actions\Action|Tables\Actions\ActionGroup>
 */
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

### 5. Table Bulk Actions
```php
/**
 * @return array<string, Tables\Actions\BulkAction>
 */
public function getTableBulkActions(): array
{
    return [
        'delete' => DeleteBulkAction::make(),
        'export' => ExportBulkAction::make(),
    ];
}
```

### ⚠️ Importante
- NON utilizzare array numerici
- Le chiavi devono essere descrittive e rappresentare l'azione/campo
- Mantenere consistenza nei nomi delle chiavi tra diverse risorse
- Utilizzare sempre la tipizzazione PHPDoc corretta

// ... existing code ... 