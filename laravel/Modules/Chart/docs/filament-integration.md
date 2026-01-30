# Integrazione con Filament

## Descrizione
Questo documento descrive come integrare i componenti geografici del modulo Geo con Filament, seguendo le best practices del progetto.

## Componenti

### 1. LocationForm
Form per la selezione della località che fornisce una selezione a cascata per:
- Regione
- Provincia
- Città
- CAP

#### Utilizzo
```php
use Modules\Geo\App\Filament\Forms\LocationForm;

class MyForm extends XotBaseForm
{
    public function getSchema(): array
    {
        return [
            ...LocationForm::getSchema(),
            // Altri campi del form
        ];
    }
}
```

#### Caratteristiche
- Selezione a cascata
- Ricerca nei campi
- Validazione automatica
- Cache gestita automaticamente
- Traduzioni integrate

### 2. LocationWidget
Widget Filament che fornisce un'interfaccia per la selezione della località.

#### Utilizzo
```php
use Modules\Geo\App\Filament\Widgets\LocationWidget;

class MyPage extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            LocationWidget::class,
        ];
    }
}
```

#### Caratteristiche
- Form integrato
- Eventi Livewire
- Notifiche automatiche
- Traduzioni integrate

## Eventi

### 1. location-selected
Emitte quando viene selezionata una località:
```php
$this->dispatch('location-selected', [
    'region' => 'LO',
    'province' => 'MI',
    'city' => 'F205',
    'cap' => '20100'
]);
```

### 2. Gestione Eventi
```php
class MyComponent extends Component
{
    #[On('location-selected')]
    public function handleLocationSelected(array $data): void
    {
        // Gestione della selezione
    }
}
```

## Traduzioni

### 1. Campi
```php
// lang/it/fields.php
return [
    'region' => [
        'label' => 'Regione',
        'placeholder' => 'Seleziona una regione',
        'tooltip' => 'Seleziona la regione di appartenenza',
    ],
    // ...
];
```

### 2. Widget
```php
// lang/it/widgets.php
return [
    'location' => [
        'title' => 'Selezione Località',
        'submit' => 'Seleziona',
        'messages' => [
            'success' => 'Località selezionata con successo',
            'error' => 'Errore durante la selezione della località',
        ],
    ],
];
```

## Best Practices

### 1. Form
- Utilizzare sempre `LocationForm`
- Non creare form personalizzati
- Seguire le traduzioni fornite
- Gestire gli eventi correttamente

### 2. Widget
- Utilizzare sempre `LocationWidget`
- Non creare widget personalizzati
- Gestire gli eventi correttamente
- Seguire le traduzioni fornite

### 3. Cache
- Lasciare che il servizio gestisca la cache
- Non accedere direttamente al file JSON
- Pulire la cache quando necessario

## Esempi

### 1. Form Completo
```php
use Modules\Geo\App\Filament\Forms\LocationForm;

class AddressForm extends XotBaseForm
{
    public function getSchema(): array
    {
        return [
            ...LocationForm::getSchema(),
            TextInput::make('street')
                ->label('Indirizzo')
                ->required(),
            TextInput::make('number')
                ->label('Numero')
                ->required(),
        ];
    }
}
```

### 2. Widget con Eventi
```php
use Modules\Geo\App\Filament\Widgets\LocationWidget;

class AddressPage extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            LocationWidget::class,
        ];
    }

    #[On('location-selected')]
    public function handleLocationSelected(array $data): void
    {
        $this->form->fill([
            'region' => $data['region'],
            'province' => $data['province'],
            'city' => $data['city'],
            'cap' => $data['cap'],
        ]);
    }
}
```

## Collegamenti
- [README del Modulo](../README.md)
- [Documentazione JSON Database](json-database.md)
- [Best Practices Filament](../../../docs/filament-best-practices.md)
- [Clean Code](../../../docs/clean-code.md) 