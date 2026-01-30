# Proprietà Livewire nei Widget Filament

## Principi Fondamentali

1. **XotBaseWidget**
   ```php
   // Modules/Xot/app/Filament/Widgets/XotBaseWidget.php
   class XotBaseWidget extends Widget
   {
       // IMPORTANTE: Questa proprietà è OBBLIGATORIA per il funzionamento dei form
       public ?array $data = [];
   }
   ```

2. **Perché è Necessario**
   - Livewire richiede che tutte le proprietà usate con `wire:model` siano dichiarate
   - `$data` è usato per il binding dei campi del form
   - Rimuovere questa proprietà causa errori di binding

## Uso Corretto

1. **Widget Form**
   ```php
   class RegistrationWidget extends XotBaseWidget
   {
       // ✅ Corretto: Eredita $data da XotBaseWidget
       protected function getFormSchema(): array
       {
           return [
               TextInput::make('first_name'),
               TextInput::make('last_name'),
           ];
       }
   }
   ```

2. **Template Blade**
   ```blade
   {{-- ✅ Corretto: Usa data.field_name --}}
   <input wire:model="data.first_name">
   <input wire:model="data.last_name">

   {{-- ❌ Errato: Accesso diretto --}}
   <input wire:model="first_name">
   ```

## Errori Comuni

1. ❌ **Rimozione di $data**
   ```php
   class XotBaseWidget extends Widget
   {
       // Errore: Manca la proprietà $data
   }
   ```
   Conseguenza: Errori Livewire per proprietà non esistenti

2. ❌ **Binding Errato**
   ```blade
   {{-- Errore: Non usa il namespace data --}}
   <input wire:model="email">
   ```

3. ❌ **Override Errato**
   ```php
   class MyWidget extends XotBaseWidget
   {
       public array $data = []; // Non necessario, già ereditato
   }
   ```

## Best Practices

1. **Inizializzazione Form**
   ```php
   public function mount(): void
   {
       $this->form->fill(); // Inizializza $data vuoto
   }
   ```

2. **Validazione**
   ```php
   protected function getFormSchema(): array
   {
       return [
           TextInput::make('data.email')
               ->email()
               ->required(),
       ];
   }
   ```

3. **Accesso ai Dati**
   ```php
   public function submit()
   {
       $data = $this->form->getState();
       // Non accedere direttamente a $this->data
   }
   ```

## Checklist

Prima di modificare un widget:
- [ ] La classe estende XotBaseWidget?
- [ ] La proprietà $data è presente nella classe base?
- [ ] I campi del form usano il namespace data?
- [ ] La validazione è configurata correttamente?

## Documentazione Correlata
- [Livewire Data Binding](https://laravel-livewire.com/docs/2.x/properties#data-binding)
- [Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
- [Widget Best Practices](https://filamentphp.com/docs/3.x/widgets/getting-started) 