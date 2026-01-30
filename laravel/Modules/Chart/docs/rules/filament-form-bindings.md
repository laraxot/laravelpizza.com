# Regole per i Form Filament

## Principi Fondamentali

1. **Namespace dei Dati**
   - Tutti i campi del form devono usare il namespace `form`
   - NON usare `data` o altri namespace personalizzati
   - Esempio: `wire:model="form.field_name"`

2. **Struttura Form**
   ```php
   use Filament\Forms\Contracts\HasForms;
   use Filament\Forms\Concerns\InteractsWithForms;

   class MyWidget extends Widget implements HasForms
   {
       use InteractsWithForms;

       public function getFormSchema(): array
       {
           return [
               TextInput::make('email'),
               Checkbox::make('newsletter'),
           ];
       }
   }
   ```

3. **Binding dei Campi**
   ```blade
   {{-- ✅ Corretto --}}
   <x-filament::input wire:model="form.email" />
   <x-filament::checkbox wire:model="form.newsletter" />

   {{-- ❌ Errato --}}
   <x-filament::input wire:model="data.email" />
   <x-filament::checkbox wire:model="email" />
   ```

## Best Practices

1. **Validazione**
   ```php
   protected function getRules(): array
   {
       return [
           'form.email' => ['required', 'email'],
           'form.newsletter' => ['boolean'],
       ];
   }
   ```

2. **Accesso ai Dati**
   ```php
   public function submit()
   {
       // ✅ Corretto
       $data = $this->form->getState();

       // ❌ Errato
       $data = $this->data;
   }
   ```

3. **Reset del Form**
   ```php
   public function reset()
   {
       $this->form->fill();
   }
   ```

## Errori Comuni da Evitare

1. ❌ **Namespace Errato**
   - Non usare `data.field_name`
   - Non usare `field_name` direttamente
   - Non inventare namespace personalizzati

2. ❌ **Accesso Diretto**
   - Non accedere direttamente alle proprietà
   - Usare sempre i metodi del form

3. ❌ **Validazione Errata**
   - Non validare senza il prefisso `form.`
   - Non mischiare validazioni dirette e del form

## Checklist Verifica

Prima di implementare un form:
- [ ] Ho usato il trait `InteractsWithForms`?
- [ ] Ho implementato l'interfaccia `HasForms`?
- [ ] Ho definito correttamente `getFormSchema()`?
- [ ] Ho usato il namespace `form.` per tutti i campi?
- [ ] Ho implementato la validazione correttamente?

## Esempi Completi

1. **Widget di Registrazione**
   ```php
   class RegistrationWidget extends Widget implements HasForms
   {
       use InteractsWithForms;

       public function mount(): void
       {
           $this->form->fill();
       }

       protected function getFormSchema(): array
       {
           return [
               TextInput::make('email')
                   ->required()
                   ->email(),
               Checkbox::make('newsletter')
                   ->label('Subscribe to newsletter'),
           ];
       }

       public function submit(): void
       {
           $data = $this->form->getState();
           // Process the data...
       }
   }
   ```

2. **Vista del Form**
   ```blade
   <form wire:submit.prevent="submit">
       {{ $this->form }}

       <button type="submit">
           {{ __('Register') }}
       </button>
   </form>
   ```

## Documentazione Correlata

- [Filament Forms Documentation](https://filamentphp.com/docs/3.x/forms/installation)
- [Livewire Data Binding](https://laravel-livewire.com/docs/2.x/properties#data-binding)
- [Form Validation](https://filamentphp.com/docs/3.x/forms/validation) 