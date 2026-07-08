# Componenti Filament Personalizzati in Laraxot

Questo documento descrive i componenti personalizzati di Filament disponibili nel framework Laraxot e come utilizzarli correttamente.

## XotBaseResource

### Descrizione
`XotBaseResource` è la classe base per tutte le risorse Filament in Laraxot. Estende le funzionalità standard di Filament aggiungendo caratteristiche specifiche per il sistema Laraxot.

### Caratteristiche Principali
- Gestione avanzata delle autorizzazioni
- Supporto integrato per i soft delete
- Gestione ottimizzata delle relazioni tra modelli
- Navigazione personalizzata in base ai cluster

### Utilizzo Corretto
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class ClienteResource extends XotBaseResource
{
    protected static ?string $model = Cliente::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $cluster = ClienteCluster::class;
    
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Colonne della tabella
            ])
            ->filters([
                // Filtri
            ]);
    }
}
```

## XotBaseCreateRecord

### Descrizione
`XotBaseCreateRecord` è la classe base per le pagine di creazione record in Laraxot. Fornisce funzionalità aggiuntive rispetto alla classe standard di Filament.

### Caratteristiche Principali
- Gestione migliorata dei dati in fase di creazione
- Supporto per valori predefiniti
- Integrazione con il sistema di autorizzazioni di Laraxot

### Utilizzo Corretto
```php
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateCliente extends XotBaseCreateRecord
{
    protected static string $resource = ClienteResource::class;
    
    public function getFormSchema(): array
    {
        return parent::getFormSchema();
    }
    
    // Opzionale
    protected function getFormDefaults(): array
    {
        return [
            'is_attivo' => true,
            // Altri valori predefiniti
        ];
    }
    
    // Necessario anche se vuoto
    public function fillForm(): void
    {
        // Anche se vuoto, deve essere presente
    }
}
```

## XotBaseEditRecord

### Descrizione
`XotBaseEditRecord` è la classe base per le pagine di modifica record in Laraxot.

### Caratteristiche Principali
- Caricamento ottimizzato dei dati del record
- Supporto per operazioni avanzate in fase di modifica
- Integrazione con le autorizzazioni e la validazione di Laraxot

### Utilizzo Corretto
```php
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCliente extends XotBaseEditRecord
{
    protected static string $resource = ClienteResource::class;
    
    public function getFormSchema(): array
    {
        return parent::getFormSchema();
    }
    
    // Necessario per il ciclo di vita
    public function fillForm(): void
    {
        // Logica per riempire il form
    }
}
```

## XotBaseListRecords

### Descrizione
`XotBaseListRecords` estende le funzionalità di lista records di Filament.

### Caratteristiche Principali
- Supporto per azioni di massa personalizzate
- Filtri avanzati
- Integrazione con il sistema di autorizzazioni

### Utilizzo Corretto
```php
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListClienti extends XotBaseListRecords
{
    protected static string $resource = ClienteResource::class;
    
    // Personalizzazioni...
}
```

## Cluster in Filament

### Descrizione
I Cluster sono un concetto specifico di Laraxot che permette di raggruppare risorse correlate in un'unica sezione di navigazione.

### Utilizzo Corretto
```php
namespace Modules\Broker\Filament\Clusters;

use Filament\Clusters\Cluster;

class ClienteCluster extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?int $navigationSort = 1;
    
    public static function getNavigationLabel(): string
    {
        return trans('broker::cliente.cluster.navigation_label');
    }
}
```

Nelle risorse:
```php
protected static ?string $cluster = ClienteCluster::class;
```

## Gestione delle Traduzioni

### Sistema di Traduzione
Laraxot utilizza un sistema di traduzione automatica basato sul LangServiceProvider:

```php
// In lang/it/broker.php
return [
    'resources' => [
        'cliente' => [
            'label' => 'Cliente',
            'plural_label' => 'Clienti',
        ],
    ],
    'fields' => [
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'tooltip' => 'Nome completo',
        ],
    ],
];
```

### Accesso alle Traduzioni
```php
// Traduzione automatica (preferito)
TextInput::make('nome')

// Traduzione manuale (da evitare)
trans('broker::cliente.fields.nome.label')
```

## Ciclo di Vita dei Componenti

È fondamentale rispettare il ciclo di vita dei componenti Filament in Laraxot:

1. **mount()**: Inizializzazione, chiamare sempre parent::mount()
2. **fillForm()**: Popolare il form, deve essere sempre presente anche se vuoto
3. **mutateFormData()**: Modifica dei dati prima della visualizzazione
4. **getFormDefaults()**: Valori predefiniti per la creazione

```php
public function mount(): void
{
    parent::mount();
    // Inizializzazione specifica
}

public function fillForm(): void
{
    // Popolare il form
}

protected function mutateFormData(array $data): array
{
    return array_merge($this->getFormDefaults(), parent::mutateFormData($data));
}

protected function getFormDefaults(): array
{
    return [
        'campo1' => 'valore_predefinito',
    ];
}
```
