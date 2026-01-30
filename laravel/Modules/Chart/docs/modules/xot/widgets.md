# Widget nel Modulo Xot

## XotBaseWidget

### Panoramica
`XotBaseWidget` è la classe base per tutti i widget Filament nel progetto. Fornisce funzionalità comuni e gestisce il binding dei dati del form.

### Struttura Base
```php
namespace Modules\Xot\Filament\Widgets;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\Widget;

abstract class XotBaseWidget extends Widget implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    // OBBLIGATORIO: Per il binding dei dati del form
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    abstract public function getFormSchema(): array;

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }
}
```

### Caratteristiche Principali

#### 1. Gestione Dati Form
- Proprietà `$data` per il binding dei dati
- Inizializzazione automatica nel mount
- StatePath configurato per tutti i form

#### 2. Form Schema
- Metodo astratto `getFormSchema()`
- Configurazione standard del form
- Binding automatico con Livewire

#### 3. Funzionalità Comuni
- Interazione con i form
- Gestione degli eventi
- Configurazione standard

## Utilizzo

### 1. Creazione Widget
```php
namespace Modules\YourModule\Filament\Widgets;

class YourWidget extends XotBaseWidget
{
    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name')
                ->required(),
            Forms\Components\TextInput::make('last_name')
                ->required(),
        ];
    }
}
```

### 2. Template Blade
```blade
<x-filament-forms::field-wrapper>
    <x-filament-forms::text-input 
        wire:model="data.first_name"
        label="First Name"
    />
</x-filament-forms::field-wrapper>
```

### 3. Livewire Component
```php
use Livewire\Component;

class YourComponent extends Component
{
    public function render()
    {
        return view('your-view', [
            'widget' => new YourWidget(),
        ]);
    }
}
```

## Errori Comuni

### 1. Property Does Not Exist
```
Livewire: [wire:model="data.field"] property does not exist
```
Cause:
- Widget non estende XotBaseWidget
- Form non inizializzato nel mount
- StatePath non configurato

### 2. Binding Non Funzionante
```
Undefined property: $data
```
Cause:
- Manca prefisso "data." nel wire:model
- Proprietà non definita nel form schema
- Mount non chiamato correttamente

## Best Practices

### 1. Struttura Widget
- Estendere sempre XotBaseWidget
- Implementare getFormSchema()
- Usare type hints appropriati

### 2. Gestione Dati
- Usare sempre "data." per il binding
- Inizializzare i dati nel mount
- Validare i dati nel form schema

### 3. Template
- Usare i componenti Filament
- Seguire le convenzioni di naming
- Mantenere la consistenza

## Troubleshooting

### Checklist
1. Widget estende XotBaseWidget?
2. Form schema implementato?
3. Binding usa "data."?
4. Mount chiamato?

### Debug
```php
// Nel widget
public function mount(): void
{
    parent::mount(); // Importante!
    \Log::info($this->data);
}
```

## Note Importanti
- XotBaseWidget è fondamentale per i form
- La proprietà $data è essenziale
- Il binding richiede sempre "data."
- Mantenere la documentazione aggiornata 