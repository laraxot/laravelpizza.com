# Gestione Form in Filament

## Struttura Base dei Form
1. **Componenti**:
   - `Widget` per form standalone
   - `Component` per form integrati
   - `HasForms` trait per gestione form

2. **Best Practices**:
   - Utilizzare `InteractsWithForms` trait
   - Implementare `HasForms` interface
   - Gestire lo stato con `statePath`

## Form sopra le Tabelle
1. **Implementazione**:
   ```php
   class CreateContactWidget extends Widget implements HasForms
   {
       use InteractsWithForms;
       protected static string $view = 'user::filament.widgets.create-contact-widget';
       protected int | string | array $columnSpan = 'full';
       public ?array $data = [];
   }
   ```

2. **Registrazione**:
   ```php
   public static function getWidgets(): array
   {
       return [
           User\Widgets\CreateContactWidget::class,
       ];
   }
   ```

3. **Posizionamento**:
   ```php
   protected function getHeaderWidgets(): array 
   {
       return [
           User\Widgets\CreateContactWidget::class,
       ];
   }
   ```

## Gestione Eventi
1. **Creazione Record**:
   ```php
   public function create(): void
   {
       Contact::create($this->form->getState());
       $this->form->fill();
       $this->dispatch('contact-created');
   }
   ```

2. **Aggiornamento Tabella**:
   ```php
   #[On('contact-created')] 
   public function refresh() {}
   ```

## Best Practices UI
1. **Pulsanti**:
   ```php
   <x-filament::button 
       type="submit" 
       form="create" 
       class="mt-3" 
       wire:loading.attr="disabled"
   >
       {{ __('filament-panels::resources/pages/create-record.form.actions.create.label') }}
   </x-filament::button>
   ```

2. **Loading States**:
   - Utilizzare `wire:loading`
   - Gestire stati disabilitati
   - Mostrare indicatori di progresso

## Integrazione con Moduli
1. **Struttura**:
   ```
   Modules/
   └── User/
       ├── app/
       │   └── Filament/
       │       ├── Resources/
       │       └── Widgets/
       └── resources/
           └── views/
               └── filament/
   ```

2. **Namespace**:
   - `Modules\User\Filament\Widgets`
   - `Modules\User\Filament\Resources`

## Gestione Errori
1. **Validazione**:
   - Utilizzare regole di validazione
   - Gestire messaggi di errore
   - Implementare feedback utente

2. **Stati**:
   - Gestire stati di caricamento
   - Mostrare messaggi di successo
   - Gestire errori di rete

## Performance
1. **Ottimizzazioni**:
   - Lazy loading dei componenti
   - Caching dei dati
   - Ottimizzazione delle query

2. **Monitoraggio**:
   - Tracciamento performance
   - Analisi utilizzo risorse
   - Ottimizzazione UI 