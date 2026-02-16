# Aggiungere un Form Sopra una Tabella in Filament

Questa guida illustra come implementare un form di creazione direttamente sopra una tabella di risorse in Filament, migliorando l'esperienza utente eliminando la necessità di navigare a una pagina separata per creare nuovi record.

## Indice
1. [Panoramica](#panoramica)
2. [Implementazione del Widget](#implementazione-del-widget)
3. [Creazione della Vista Blade](#creazione-della-vista-blade)
4. [Integrazione con la Pagina di Lista](#integrazione-con-la-pagina-di-lista)
5. [Comunicazione tra Componenti](#comunicazione-tra-componenti)
6. [Personalizzazioni Avanzate](#personalizzazioni-avanzate)
7. [Best Practices](#best-practices)

## Panoramica

In Filament, possiamo aggiungere un form di creazione sopra una tabella utilizzando un widget personalizzato. Questo approccio offre diversi vantaggi:

- Migliora l'esperienza utente consentendo la creazione rapida di record
- Elimina la necessità di navigare tra pagine diverse
- Aggiorna automaticamente la tabella sottostante quando vengono creati nuovi record
- Mantiene l'interfaccia utente pulita e intuitiva

## Implementazione del Widget

### 1. Creare un Widget Personalizzato

Per prima cosa, creiamo un widget che implementi l'interfaccia `HasForms`:

```php
<?php

namespace Modules\NomeModulo\Filament\Widgets;

use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\NomeModulo\Models\MioModello;

class CreateRecordWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    // Percorso della vista Blade per il widget
    protected static string $view = 'nomemodulo::filament.widgets.create-record-widget';

    // Imposta il widget a larghezza piena
    protected int | string | array $columnSpan = 'full';

    // Variabile per memorizzare i dati del form
    public ?array $data = [];

    // Inizializza il form quando il componente viene montato
    public function mount(): void
    {
        $this->form->fill();
    }

    // Definisci la struttura del form
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome_campo')
                    ->required(),
                // Altri campi del form...
            ])
            ->statePath('data');
    }

    // Metodo per gestire la creazione del record
    public function create(): void
    {
        // Ottieni i dati validati dal form
        $data = $this->form->getState();
        
        // Crea il nuovo record
        MioModello::create($data);
        
        // Resetta il form
        $this->form->fill();
        
        // Invia un evento Livewire per aggiornare la tabella
        $this->dispatch('record-created');
    }
}
```

### 2. Considerazioni importanti sul namespace

In il progetto, è fondamentale rispettare la struttura corretta dei namespace:

- Il widget deve essere posizionato in `Modules\NomeModulo\Filament\Widgets`
- Il namespace corretto è `Modules\NomeModulo\Filament\Widgets` (NON include `App`)
- Attenzione alla case sensitivity: `app` (minuscolo) per le cartelle standard di Laravel, `Filament` (PascalCase) per i namespace specifici

## Creazione della Vista Blade

### 1. Creare il File Blade

Creiamo la vista Blade per il widget, rispettando la struttura delle cartelle (minuscole):

```blade
<!-- /Modules/NomeModulo/resources/views/filament/widgets/create-record-widget.blade.php -->
<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit="create">
            {{ $this->form }}

            <x-filament::button type="submit" form="create" class="mt-3" wire:loading.attr="disabled">
                {{ __('filament-panels::resources/pages/create-record.form.actions.create.label') }}
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
```

### 2. Elementi chiave della vista

- `<x-filament-widgets::widget>`: Wrapper standard per i widget Filament
- `<x-filament::section>`: Componente per creare una sezione con stile coerente
- `wire:submit="create"`: Direttiva Livewire che chiama il metodo `create` del widget
- `{{ $this->form }}`: Renderizza il form definito nel widget
- `form="create"`: Collega il pulsante al form (opzionale, ma utile per mostrare lo spinner)
- `wire:loading.attr="disabled"`: Disabilita il pulsante durante l'invio del form

## Integrazione con la Pagina di Lista

### 1. Aggiungere il Widget alla Pagina di Lista

Modifichiamo la classe `ListRecords` per includere il nostro widget:

```php
<?php

namespace Modules\NomeModulo\Filament\Resources\MiaRisorsa\Pages;

use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;
use Modules\NomeModulo\Filament\Resources\MiaRisorsa;
use Modules\NomeModulo\Filament\Resources\MiaRisorsa\Widgets\CreateRecordWidget;

class ListMiaRisorsa extends ListRecords
{
    protected static string $resource = MiaRisorsa::class;

    // Ascolta l'evento 'record-created' e aggiorna la tabella
    #[On('record-created')]
    public function refresh() {}

    // Aggiungi il widget all'header della pagina
    protected function getHeaderWidgets(): array
    {
        return [
            CreateRecordWidget::class,
        ];
    }
}
```

### 2. Registrare il Widget nel Service Provider

Per garantire che il widget sia disponibile, registrarlo nel service provider del modulo:

```php
<?php

namespace Modules\NomeModulo\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Modules\NomeModulo\Filament\Widgets\CreateRecordWidget;

class NomeModuloServiceProvider extends ServiceProvider
{
    // ...

    public function boot(): void
    {
        // ...
        $this->registerFilamentWidgets();
    }

    protected function registerFilamentWidgets(): void
    {
        Filament::registerWidgets([
            CreateRecordWidget::class,
        ]);
    }
}
```

## Comunicazione tra Componenti

### 1. Eventi Livewire

La comunicazione tra il widget e la tabella avviene tramite eventi Livewire:

1. Il widget invia un evento quando un record viene creato: `$this->dispatch('record-created')`
2. La pagina di lista ascolta questo evento e aggiorna la tabella: `#[On('record-created')]`

### 2. Aggiornamento Automatico

Quando l'utente crea un nuovo record:
1. Il record viene salvato nel database
2. Il form viene resettato
3. L'evento `record-created` viene inviato
4. La tabella viene aggiornata automaticamente

## Personalizzazioni Avanzate

### 1. Aggiungere Notifiche

Per migliorare l'esperienza utente, possiamo aggiungere notifiche dopo la creazione:

```php
public function create(): void
{
    $data = $this->form->getState();
    MioModello::create($data);
    $this->form->fill();
    $this->dispatch('record-created');
    
    // Mostra una notifica di successo
    Notification::make()
        ->title('Record creato con successo')
        ->success()
        ->send();
}
```

### 2. Validazione Avanzata

Possiamo implementare regole di validazione più complesse:

```php
public function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('email')
                ->email()
                ->required()
                ->unique(table: MioModello::class, column: 'email'),
            // Altri campi...
        ])
        ->statePath('data');
}
```

### 3. Spinner nel Pulsante di Invio

Per mostrare uno spinner durante l'invio del form, assicurati di aggiungere l'attributo `form="create"` al pulsante:

```blade
<x-filament::button type="submit" form="create" class="mt-3" wire:loading.attr="disabled">
    {{ __('filament-panels::resources/pages/create-record.form.actions.create.label') }}
</x-filament::button>
```

## Best Practices

### 1. Struttura dei File e Namespace

In il progetto, rispetta sempre la struttura corretta:

- Widget: `Modules\NomeModulo\App\Filament\Widgets\NomeWidget.php`
- Vista: `Modules\NomeModulo\resources\views\filament\widgets\nome-widget.blade.php`
- Attenzione alla case sensitivity: `App` (maiuscolo) nei namespace, `app` (minuscolo) nelle cartelle

### 2. Riutilizzo del Form Schema

Per mantenere la coerenza, considera di riutilizzare lo schema del form dalla risorsa principale:

```php
use Modules\NomeModulo\Filament\Resources\MiaRisorsa;

public function form(Form $form): Form
{
    return $form
        ->schema(MiaRisorsa::getFormSchema())
        ->statePath('data');
}
```

### 3. Gestione degli Errori

Implementa una gestione degli errori robusta:

```php
public function create(): void
{
    try {
        $data = $this->form->getState();
        MioModello::create($data);
        $this->form->fill();
        $this->dispatch('record-created');
        
        Notification::make()
            ->title('Record creato con successo')
            ->success()
            ->send();
    } catch (\Exception $e) {
        Notification::make()
            ->title('Errore durante la creazione')
            ->body($e->getMessage())
            ->danger()
            ->send();
    }
}
```

### 4. Autorizzazioni

Considera di aggiungere controlli di autorizzazione:

```php
public function mount(): void
{
    abort_unless(auth()->user()->can('create', MioModello::class), 403);
    $this->form->fill();
}
```

## Conclusione

L'aggiunta di un form sopra una tabella in Filament migliora significativamente l'esperienza utente, consentendo una creazione rapida dei record senza cambiare pagina. Questa tecnica è particolarmente utile per tabelle con creazione frequente di record.

Seguendo questa guida e rispettando le convenzioni di il progetto, potrai implementare questa funzionalità in modo efficace e mantenibile.

## Risorse Aggiuntive

- [Documentazione ufficiale di Filament](https://filamentphp.com/docs)
- [Documentazione di Livewire](https://livewire.laravel.com/docs)
- [Repository di esempio su GitHub](https://github.com/LaravelDaily/Filament-Form-On-Top-Of-Resource)
- [FilamentExamples.com](https://filamentexamples.com)
