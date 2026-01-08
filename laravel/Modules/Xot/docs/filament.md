# Filament - Best Practices Centralizzate

## Principi Fondamentali

### Estensione delle Classi Base
- **SEMPRE** estendere `XotBaseResource` invece di `Resource` direttamente
- **SEMPRE** estendere `XotBaseServiceProvider` invece di `ServiceProvider` direttamente
- **SEMPRE** estendere `XotBaseWidget` per i widget
- **MAI** estendere direttamente le classi Filament

### 🚨 REGOLA CRITICA: NO METODO TABLE()

**Se una classe estende `XotBaseResource`, NON deve mai dichiarare:**
- `protected static ?string $navigationGroup`
- `protected static ?string $navigationLabel`
- `public static function table(Table $table): Table`

**Motivazione:**
- La gestione di navigationGroup/navigationLabel è centralizzata nella classe base o nei provider
- Il metodo `table()` viene gestito tramite trait, macro o configurazione centralizzata per garantire coerenza e DRY
- Dichiarare questi elementi nelle risorse che estendono XotBaseResource causa override indesiderati, perdita di automazione e incoerenza tra moduli

### Pattern Corretto
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class ExampleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('nome')->required(),
            DatePicker::make('data_nascita'),
            // Altri campi...
        ];
    }

    // ✅ CORRETTO - Solo metodi e proprietà specifiche non già gestite dalla base
    // NIENTE navigationGroup/navigationLabel/table()
}
```

### ❌ Esempio ERRATO
```php
class UserModerationResource extends XotBaseResource
{
    protected static ?string $navigationGroup = 'User Management'; // ERRORE
    protected static ?string $navigationLabel = 'User Moderation'; // ERRORE
    
    public static function table(Table $table): Table { // ERRORE
        return $table->columns([...]);
    }
}
```

### ✅ Esempio CORRETTO
```php
class UserModerationResource extends XotBaseResource
{
    // Solo metodi e proprietà specifiche non già gestite dalla base
    // NIENTE navigationGroup/navigationLabel/table()
}
```

## Service Providers

### Struttura Standard
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName'; // SEMPRE dichiarare subito

    public function boot(): void
    {
        parent::boot();
        // Solo personalizzazioni specifiche del modulo
    }

    public function register(): void
    {
        parent::register();
        // Solo registrazioni specifiche del modulo
    }
}
```

### Registrazione Corretta
```php
// config/app.php
'providers' => [
    // ...
    Modules\ModuleName\Providers\ModuleNameServiceProvider::class,
],
```

## Resources

### Metodi Obbligatori
```php
/**
 * @return array<string, \Filament\Forms\Components\Component>
 */
public static function getFormSchema(): array
{
    return [
        // Schema del form
    ];
}

/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        // Colonne della tabella
    ];
}
```

### Utilizzo Corretto dei Componenti
```php
// ✅ CORRETTO - Senza label hardcoded
TextInput::make('name')->required()
Select::make('role')->options($options)
DatePicker::make('birth_date')

// ❌ ERRATO - Con label hardcoded
TextInput::make('name')->label('Nome')->required()
Select::make('role')->label('Ruolo')->options($options)
```

## Widgets

### Estensione Corretta
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Widgets;

use Modules\UI\Filament\Widgets\XotBaseWidget;

class ExampleWidget extends XotBaseWidget
{
    // Implementazione widget
}
```

### Posizionamento Corretto
```php
/**
 * @return array<class-string<Widget>>
 */
protected function getHeaderWidgets(): array
{
    return [
        ExampleWidget::class,
    ];
}

/**
 * @return array<class-string<Widget>>
 */
protected function getFooterWidgets(): array
{
    return [
        ChartWidget::class,
    ];
}
```

## Actions

### Struttura Standard
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Actions;

use Filament\Actions\Action;
use Filament\Support\Colors\Color;

class CustomAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('modulename::actions.custom.label'))
            ->icon('heroicon-o-pencil')
            ->color(Color::BLUE)
            ->requiresConfirmation()
            ->modalHeading(__('modulename::actions.custom.modal_heading'))
            ->modalDescription(__('modulename::actions.custom.modal_description'))
            ->action(fn () => $this->executeAction());
    }

    protected function executeAction(): void
    {
        // Implementazione azione
    }
}
```

### Registrazione Actions
```php
/**
 * @return array<\Filament\Tables\Actions\Action>
 */
protected function getTableActions(): array
{
    return [
        CustomAction::make(),
    ];
}
```

## Pages

### Estensione Corretta
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class ExamplePage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'modulename::filament.pages.example-page';

    // Implementazione pagina
}
```

## View Custom

### Wrapper Principale
```blade
{{-- ✅ CORRETTO --}}
<x-filament::page>
    <div>
        <h2>{{ __('modulename::pages.example.title') }}</h2>
        <p>{{ __('modulename::pages.example.description') }}</p>
    </div>
</x-filament::page>
```

### Passaggio Dati
```php
/**
 * Dati da passare alla view.
 *
 * @return array<string, mixed>
 */
protected function getViewData(): array
{
    return [
        'items' => ExampleModel::query()->latest()->get(),
        'title' => __('modulename::pages.example.title'),
    ];
}
```

## Traduzioni

### Struttura File di Traduzione
```php
// Modules/ModuleName/lang/it/filament.php
return [
    'resources' => [
        'example' => [
            'label' => 'Esempi',
            'plural_label' => 'Esempi',
            'navigation_group' => 'Gestione',
            'navigation_icon' => 'heroicon-o-document-text',
            'navigation_sort' => 1,
        ],
    ],
    'pages' => [
        'example' => [
            'title' => 'Pagina Esempio',
            'description' => 'Descrizione della pagina',
        ],
    ],
    'actions' => [
        'custom' => [
            'label' => 'Azione Personalizzata',
            'modal_heading' => 'Conferma Azione',
            'modal_description' => 'Sei sicuro di voler eseguire questa azione?',
            'success' => 'Azione completata con successo',
            'error' => 'Si è verificato un errore',
        ],
    ],
];
```

## Componenti UI

### Posizionamento Corretto
```
Modules/UI/resources/views/components/ui/
├── button.blade.php
├── card.blade.php
└── logo.blade.php
```

### Utilizzo Corretto
```blade
{{-- ✅ CORRETTO --}}
<x-ui::ui.button>Salva</x-ui::ui.button>
<x-ui::ui.card>Contenuto</x-ui::ui.card>

{{-- ❌ ERRATO --}}
<x-button>Salva</x-button>
<x-ui.button>Salva</x-ui.button>
```

## Best Practices

### 1. Ereditarietà
- Estendere sempre le classi base Xot
- Non duplicare funzionalità già presenti nelle classi base
- Utilizzare i metodi helper delle classi base

### 2. Traduzioni
- Mai utilizzare stringhe hardcoded
- Utilizzare sempre i file di traduzione del modulo
- Struttura espansa per tutte le traduzioni

### 3. Performance
- Utilizzare eager loading per le relazioni
- Implementare caching per dati statici
- Ottimizzare le query del database

### 4. Sicurezza
- Validare sempre i dati di input
- Utilizzare le policy per l'autorizzazione
- Implementare controlli di accesso appropriati

## Troubleshooting

### Problemi Comuni

#### Errore: "Class not found"
**Causa**: Namespace errato o autoload non aggiornato.

**Soluzione**:
```bash
composer dump-autoload
```

#### Errore: "Method not found"
**Causa**: Estensione diretta di classi Filament invece di XotBase.

**Soluzione**: Estendere sempre le classi base Xot.

#### Errore: "Translation key not found"
**Causa**: Chiave di traduzione mancante o namespace errato.

**Soluzione**: Verificare file di traduzione e namespace.

## Checklist di Conformità

### Prima dell'Implementazione
- [ ] Studiare la documentazione del modulo
- [ ] Verificare namespace e struttura
- [ ] Controllare ereditarietà delle classi
- [ ] Verificare file di traduzione

### Durante l'Implementazione
- [ ] Seguire convenzioni di naming
- [ ] Utilizzare tipizzazione rigorosa
- [ ] Implementare traduzioni complete
- [ ] Testare funzionalità

### Dopo l'Implementazione
- [ ] Eseguire PHPStan livello 9+
- [ ] Verificare traduzioni in tutte le lingue
- [ ] Aggiornare documentazione
- [ ] Testare regressioni

## Checklist Filament

### Prima del Commit
- [ ] Nessuna classe estende direttamente una classe Filament
- [ ] Tutte le classi Filament estendono la corrispondente XotBase
- [ ] Se estendi XotBaseResource, NON dichiarare navigationGroup
- [ ] Se estendi XotBaseResource, NON dichiarare navigationLabel
- [ ] Se estendi XotBaseResource, NON dichiarare il metodo table()
- [ ] Import inutili rimossi
- [ ] Naming conforme
- [ ] Proprietà critiche rispettate
- [ ] Moderazione centralizzata e neutra
- [ ] Audit trail tramite Spatie Activitylog
- [ ] Documentazione aggiornata e linkata

## Errori Comuni e Soluzioni

### Errore: Estensione Diretta di Classi Filament
**Sintomo**: `Call to undefined method Filament\Resources\Resource::getFormSchema()`

**Causa**: Estensione diretta di classi Filament invece delle classi base Xot.

**Soluzione**:
```php
// ❌ ERRATO
use Filament\Resources\Resource;
class ExampleResource extends Resource

// ✅ CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;
class ExampleResource extends XotBaseResource
```

### Errore: Metodo Table in XotBaseResource
**Sintomo**: Override accidentale del metodo table() o dichiarazione di navigationGroup/navigationLabel

**Causa**: Violazione della regola critica per XotBaseResource.

**Soluzione**:
```php
// ❌ ERRATO
class ExampleResource extends XotBaseResource
{
    protected static ?string $navigationGroup = 'Group'; // ERRORE
    protected static ?string $navigationLabel = 'Label'; // ERRORE
    
    public static function table(Table $table): Table { // ERRORE
        return $table->columns([...]);
    }
}

// ✅ CORRETTO
class ExampleResource extends XotBaseResource
{
    // Solo metodi e proprietà specifiche non già gestite dalla base
    // NIENTE navigationGroup/navigationLabel/table()
}
```

## Collegamenti

- [Best Practices](best-practices-consolidated.md)
- [PHPStan Guide](phpstan-consolidated.md)
- [Testing Guide](testing-consolidated.md)

---

*Ultimo aggiornamento: 2025-08-04*
*Modulo: Xot*
*Categoria: Filament*

