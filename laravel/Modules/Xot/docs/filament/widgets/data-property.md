# Proprietà `$data` nei Widget Filament

## Problema Comune

Uno degli errori più frequenti durante l'utilizzo dei Widget Filament è il seguente messaggio:

```
Livewire: [wire:model="data.first_name"] property does not exist on component: [modules.user.filament.widgets.registration-widget]
```

Questo errore si verifica quando si utilizzano componenti form in un widget con `wire:model` che fanno riferimento a proprietà come `data.first_name`, `data.email`, ecc., ma la proprietà `$data` non è dichiarata nel widget o in una classe base.

## Soluzione Integrata

In `XotBaseWidget` esiste già una soluzione integrata per questo problema. La classe base dichiara:

```php
public ?array $data = [];
```

Questa dichiarazione permette a tutti i widget che estendono `XotBaseWidget` di utilizzare automaticamente la proprietà `$data` con componenti form, senza doverla dichiarare nuovamente.

## Utilizzo Corretto

### Nel template Blade:
```blade
<form wire:submit.prevent="register">
    <x-filament::input.text wire:model="data.first_name" />
    <x-filament::input.text wire:model="data.last_name" />
    <x-filament::checkbox wire:model="data.newsletter" />
</form>
```

### Nella classe Widget:
```php
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class RegistrationWidget extends XotBaseWidget
{
    // La proprietà $data è già ereditata dalla classe base
    // NON è necessario dichiarare: public ?array $data = [];
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('first_name')
                ->required(),
            TextInput::make('last_name')
                ->required(),
            Checkbox::make('newsletter'),
        ];
    }
    
    public function register()
    {
        // Qui puoi accedere ai dati del form tramite $this->data
        $firstName = $this->data['first_name'];
        $acceptedNewsletter = $this->data['newsletter'] ?? false;
        
        // Logica di registrazione...
    }
}
```

## Errori da Evitare

1. **Non ridichiarare la proprietà $data**
   ```php
   // ERRATO ❌ - Causa errore "Cannot redeclare property"
   class MyWidget extends XotBaseWidget
   {
       public array $data = [];  // Errore: già dichiarato nella classe base
   }
   ```

2. **Non dimenticare il prefisso data.** nei modelli wire
   ```blade
   <!-- ERRATO ❌ -->
   <x-filament::input.text wire:model="first_name" />
   
   <!-- CORRETTO ✅ -->
   <x-filament::input.text wire:model="data.first_name" />
   ```

3. **Non utilizzare direttamente form() nei widget**
   ```php
   // ERRATO ❌ - Non sfrutta la struttura base di XotBaseWidget
   public function form()
   {
       return $this->makeForm()
           ->schema([...]);
   }
   
   // CORRETTO ✅
   public function getFormSchema(): array
   {
       return [...];
   }
   ```

## Riferimenti

- [XotBaseWidget](../../app/Filament/Widgets/XotBaseWidget.php)
- [Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
- [Livewire Data Binding](https://livewire.laravel.com/docs/properties)
