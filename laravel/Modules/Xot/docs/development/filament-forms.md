# Filament Forms

## Best Practices

### Struttura Base
```php
declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Forms;
use Modules\Performance\Models\Performance;

class PerformanceResource extends XotBaseResource
{
    protected static ?string $model = Performance::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
                    static::getBasicFields(),
                    static::getAdvancedFields(),
                ])
                ->columns(2),
        ];
    }

    protected static function getBasicFields(): array
    {
        return [
            Forms\Components\TextInput::make('nome')
                ->required()
                ->string()
                ->maxLength(255),
                
            Forms\Components\TextInput::make('punteggio')
                ->required()
                ->numeric()
                ->min(0)
                ->max(100),
        ];
    }

    protected static function getAdvancedFields(): array
    {
        return [
            Forms\Components\DatePicker::make('data_valutazione')
                ->nullable()
                ->displayFormat('d/m/Y'),
                
            Forms\Components\Select::make('stato')
                ->options([
                    'bozza' => 'Bozza',
                    'completato' => 'Completato',
                ])
                ->required(),
        ];
    }
}
```

### Validazione

1. **Regole Base**
```php
Forms\Components\TextInput::make('email')
    ->email()
    ->required()
    ->unique(table: 'users', column: 'email')
    ->regex('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/')
```

2. **Regole Complesse**
```php
Forms\Components\TextInput::make('codice_fiscale')
    ->required()
    ->string()
    ->rules(['size:16', new ValidaCodiceFiscale()])
    ->formatStateUsing(fn (string $state): string => strtoupper($state))
```

### Relazioni

1. **Select con Relazioni**
```php
Forms\Components\Select::make('dipartimento_id')
    ->relationship('dipartimento', 'nome')
    ->searchable()
    ->preload()
    ->required()
```

2. **BelongsToMany**
```php
Forms\Components\CheckboxList::make('ruoli')
    ->relationship('roles', 'name')
    ->columns(2)
    ->searchable()
```

### Form Layout

1. **Tabs**
```php
Forms\Components\Tabs::make('Principale')
    ->tabs([
        Forms\Components\Tabs\Tab::make('Informazioni Base')
            ->schema(static::getBasicFields()),
        Forms\Components\Tabs\Tab::make('Dettagli Avanzati')
            ->schema(static::getAdvancedFields()),
    ])
```

2. **Sections**
```php
Forms\Components\Section::make('Dati Personali')
    ->description('Inserire i dati personali del dipendente')
    ->schema([
        Forms\Components\TextInput::make('nome')
            ->required(),
        Forms\Components\TextInput::make('cognome')
            ->required(),
    ])
    ->columns(2)
```

### Computed Fields

```php
Forms\Components\TextInput::make('nome_completo')
    ->disabled()
    ->dehydrated(false)
    ->formatStateUsing(function ($record) {
        return $record ? "{$record->nome} {$record->cognome}" : '';
    })
```

### Conditional Fields

```php
Forms\Components\Toggle::make('ha_patente')
    ->reactive(),

Forms\Components\TextInput::make('numero_patente')
    ->required()
    ->visible(fn (Closure $get) => $get('ha_patente'))
```

### File Upload

```php
Forms\Components\FileUpload::make('documento')
    ->directory('documenti')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(1024)
    ->enableDownload()
    ->enableOpen()
    ->preserveFilenames()
```

### Rich Editor

```php
Forms\Components\RichEditor::make('descrizione')
    ->toolbarButtons([
        'bold',
        'italic',
        'link',
        'bulletList',
        'orderedList',
    ])
    ->fileAttachmentsDisk('public')
    ->fileAttachmentsDirectory('editor-attachments')
```

### Repeater

```php
Forms\Components\Repeater::make('esperienze')
    ->schema([
        Forms\Components\TextInput::make('azienda')
            ->required(),
        Forms\Components\DatePicker::make('data_inizio')
            ->required(),
        Forms\Components\DatePicker::make('data_fine')
            ->nullable(),
    ])
    ->defaultItems(1)
    ->createItemButtonLabel('Aggiungi Esperienza')
```

### Select Dipendenti

```php
Forms\Components\Select::make('dipendenti')
    ->multiple()
    ->relationship('dipendenti', 'nome_completo')
    ->searchable()
    ->preload()
    ->optionsLimit(50)
    ->getSearchResultsUsing(function (string $search) {
        return User::query()
            ->where('nome', 'like', "%{$search}%")
            ->orWhere('cognome', 'like', "%{$search}%")
            ->limit(50)
            ->get()
            ->mapWithKeys(fn ($user) => [$user->id => $user->nome_completo]);
    })
```

### Validazione Avanzata

```php
Forms\Components\Grid::make()
    ->schema([
        Forms\Components\TextInput::make('data_inizio')
            ->type('date')
            ->required(),
        Forms\Components\TextInput::make('data_fine')
            ->type('date')
            ->nullable()
            ->rules([
                'nullable',
                'date',
                'after:data_inizio',
            ]),
    ])
```

### Eventi Form

```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('codice')
            ->required()
            ->string()
            ->afterStateUpdated(function (Forms\Components\TextInput $component, $state) {
                $component->state(strtoupper($state));
            }),
            
        Forms\Components\Select::make('tipo')
            ->options([
                'A' => 'Tipo A',
                'B' => 'Tipo B',
            ])
            ->reactive()
            ->afterStateUpdated(function (Closure $set) {
                $set('sottotipo', null);
            }),
    ];
}
```

### Best Practices Specifiche

1. **Organizzazione del Codice**
   - Separare i campi in metodi dedicati
   - Utilizzare costanti per valori ripetuti
   - Mantenere la coerenza nella struttura

2. **Validazione**
   - Preferire le regole di validazione native
   - Implementare regole custom quando necessario
   - Utilizzare i messaggi di errore in italiano

3. **Performance**
   - Preload delle relazioni quando possibile
   - Limitare i risultati delle ricerche
   - Ottimizzare le query

4. **UX**
   - Raggruppare campi correlati
   - Utilizzare descrizioni chiare
   - Implementare validazione real-time

5. **Manutenibilità**
   - Documentare le personalizzazioni
   - Utilizzare type hints
   - Seguire le convenzioni di naming
