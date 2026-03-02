# Form con Filament Components

## Introduzione

Questo documento descrive l'implementazione dei form nel modulo Notify utilizzando i componenti Filament. I form sono stati migrati da componenti custom a componenti Filament per garantire:

- Consistenza dell'interfaccia utente
- Validazione integrata
- Gestione degli errori standardizzata
- Supporto per dark mode
- Accessibilità WCAG 2.1

## Componenti Base

### Field Wrapper
```blade
<x-filament-forms::field-wrapper
    name="field_name"
    label="Etichetta Campo"
    helper-text="Testo di aiuto"
    hint="Suggerimento"
    required
>
    <!-- Campo form -->
</x-filament-forms::field-wrapper>
```

### Text Input
```blade
<x-filament-forms::text-input
    wire:model="title"
    placeholder="Inserisci il titolo"
    required
/>
```

### Textarea
```blade
<x-filament-forms::textarea
    wire:model="content"
    placeholder="Inserisci il contenuto"
    rows="4"
/>
```

### Select
```blade
<x-filament-forms::select
    wire:model="type"
    :options="[
        'email' => 'Email',
        'sms' => 'SMS',
        'push' => 'Push Notification'
    ]"
/>
```

## Form Completi

### Form Notifica
```blade
<x-filament::card>
    <form wire:submit.prevent="save">
        <x-filament-forms::field-wrapper
            name="title"
            label="Titolo"
            required
        >
            <x-filament-forms::text-input
                wire:model="title"
                required
            />
        </x-filament-forms::field-wrapper>

        <x-filament-forms::field-wrapper
            name="content"
            label="Contenuto"
            required
        >
            <x-filament-forms::textarea
                wire:model="content"
                rows="4"
                required
            />
        </x-filament-forms::field-wrapper>

        <x-filament-forms::field-wrapper
            name="type"
            label="Tipo"
            required
        >
            <x-filament-forms::select
                wire:model="type"
                :options="[
                    'info' => 'Informazione',
                    'warning' => 'Avviso',
                    'error' => 'Errore'
                ]"
                required
            />
        </x-filament-forms::field-wrapper>

        <x-filament::button type="submit">
            Salva
        </x-filament::button>
    </form>
</x-filament::card>
```

### Form Template Email
```blade
<x-filament::card>
    <form wire:submit.prevent="saveTemplate">
        <x-filament-forms::field-wrapper
            name="name"
            label="Nome Template"
            required
        >
            <x-filament-forms::text-input
                wire:model="name"
                required
            />
        </x-filament-forms::field-wrapper>

        <x-filament-forms::field-wrapper
            name="subject"
            label="Oggetto"
            required
        >
            <x-filament-forms::text-input
                wire:model="subject"
                required
            />
        </x-filament-forms::field-wrapper>

        <x-filament-forms::field-wrapper
            name="body"
            label="Corpo"
            required
        >
            <x-filament-forms::rich-editor
                wire:model="body"
                required
            />
        </x-filament-forms::field-wrapper>

        <x-filament-forms::field-wrapper
            name="variables"
            label="Variabili"
        >
            <x-filament-forms::repeater
                wire:model="variables"
            >
                <x-filament-forms::text-input
                    name="name"
                    label="Nome Variabile"
                />
                <x-filament-forms::text-input
                    name="default"
                    label="Valore Default"
                />
            </x-filament-forms::repeater>
        </x-filament-forms::field-wrapper>

        <x-filament::button type="submit">
            Salva Template
        </x-filament::button>
    </form>
</x-filament::card>
```

## Validazione

### Livewire Component
```php
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class NotificationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public $title;
    public $content;
    public $type;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->minLength(3)
                ->maxLength(100),
            Textarea::make('content')
                ->required()
                ->minLength(10),
            Select::make('type')
                ->required()
                ->options([
                    'info' => 'Informazione',
                    'warning' => 'Avviso',
                    'error' => 'Errore'
                ])
        ];
    }

    public function save()
    {
        $data = $this->form->getState();

        // Salvataggio dati
    }
}
```

## Gestione Errori

### Visualizzazione Errori
```blade
<x-filament-forms::field-wrapper
    name="field"
    label="Campo"
>
    <x-filament-forms::text-input
        wire:model="field"
    />
    <x-filament-forms::field-wrapper.error-message>
        {{ $errors->first('field') }}
    </x-filament-forms::field-wrapper.error-message>
</x-filament-forms::field-wrapper>
```

### Notifiche
```blade
<x-filament::notification
    :title="$title"
    :description="$description"
    :type="$type"
/>
```

## Best Practices

1. **Organizzazione del Codice**
   - Un componente Livewire per form
   - Validazione nel componente
   - Layout nel template Blade

2. **Validazione**
   - Utilizzare le regole di validazione Laravel
   - Validare sia lato client che server
   - Mostrare messaggi di errore chiari

3. **UX**
   - Feedback immediato agli utenti
   - Campi required chiaramente marcati
   - Messaggi di errore contestuali

4. **Accessibilità**
   - Label per ogni campo
   - Attributi ARIA appropriati
   - Contrasto colori adeguato

## Collegamenti

- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
- [Documentazione Layout](tailwind_layouts.md)
- [Documentazione Componenti](tailwind_components.md)
- [Architettura](architecture.md)
