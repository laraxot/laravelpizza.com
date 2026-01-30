# Best Practices Filament

## Naming Conventions

### 1. Resources
- Nome Classe: `ModelNameResource`
- Namespace: `Modules\{ModuleName}\Filament\Resources`
- File: `ModelNameResource.php`
- Directory: `app/Filament/Resources`

### 2. Pages
- Nome Classe: `ActionModelName`
- Namespace: `Modules\{ModuleName}\Filament\Pages`
- File: `ActionModelName.php`
- Directory: `app/Filament/Pages`

### 3. Widgets
- Nome Classe: `ModelNameWidget`
- Namespace: `Modules\{ModuleName}\Filament\Widgets`
- File: `ModelNameWidget.php`
- Directory: `app/Filament/Widgets`

### 4. Forms
- Nome Classe: `ModelNameForm`
- Namespace: `Modules\{ModuleName}\Filament\Forms`
- File: `ModelNameForm.php`
- Directory: `app/Filament/Forms`

### 5. Tables
- Nome Classe: `ModelNameTable`
- Namespace: `Modules\{ModuleName}\Filament\Tables`
- File: `ModelNameTable.php`
- Directory: `app/Filament/Tables`

## Struttura Directory

### 1. Modulo Base
```
Module/
├── app/
│   └── Filament/
│       ├── Resources/
│       ├── Pages/
│       ├── Widgets/
│       ├── Forms/
│       └── Tables/
├── resources/
│   └── views/
│       └── filament/
│           ├── resources/
│           ├── pages/
│           └── widgets/
└── providers/
    └── Filament/
        └── AdminPanelProvider.php
```

### 2. Views
```
resources/
└── views/
    └── filament/
        ├── resources/
        │   └── model-name/
        │       ├── index.blade.php
        │       ├── create.blade.php
        │       ├── edit.blade.php
        │       └── view.blade.php
        ├── pages/
        │   └── action-model-name.blade.php
        └── widgets/
            └── model-name-widget.blade.php
```

## Codice

### 1. Resources
```php
declare(strict_types=1);

namespace Modules\YourModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class YourResource extends XotBaseResource
{
    protected static ?string $model = YourModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Your Group';
    protected static ?string $navigationLabel = 'Your Label';

    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            // Colonne della tabella
        ];
    }
}
```

### 2. Pages
```php
declare(strict_types=1);

namespace Modules\YourModule\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class ListYourRecords extends XotBasePage
{
    protected static string $view = 'your-module::filament.pages.list-your-records';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Your Group';
    protected static ?string $navigationLabel = 'Your Label';

    public function getTitle(): string
    {
        return $this->trans('Lista Record');
    }
}
```

### 3. Widgets
```php
declare(strict_types=1);

namespace Modules\YourModule\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class YourWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Your Heading';
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '10s';

    public function getData(): array
    {
        return [
            // Dati del widget
        ];
    }
}
```

## Traduzioni

### 1. Struttura File
```
resources/
└── lang/
    ├── it/
    │   └── your-module.php
    └── en/
        └── your-module.php
```

### 2. Chiavi di Traduzione
```php
return [
    'resources' => [
        'your-resource' => [
            'title' => 'Your Title',
            'navigation' => [
                'group' => 'Your Group',
                'label' => 'Your Label',
            ],
        ],
    ],
    'pages' => [
        'list-your-records' => [
            'title' => 'Lista Record',
        ],
    ],
    'widgets' => [
        'your-widget' => [
            'heading' => 'Your Heading',
        ],
    ],
];
```

## Testing

### 1. Resource Test
```php
declare(strict_types=1);

namespace Modules\YourModule\Tests\Filament\Resources;

use Tests\TestCase;

class YourResourceTest extends TestCase
{
    public function test_can_list_records()
    {
        $this->get(route('filament.resources.your-resource.index'))
            ->assertSuccessful();
    }

    public function test_can_create_record()
    {
        $this->get(route('filament.resources.your-resource.create'))
            ->assertSuccessful();
    }
}
```

### 2. Page Test
```php
declare(strict_types=1);

namespace Modules\YourModule\Tests\Filament\Pages;

use Tests\TestCase;

class ListYourRecordsTest extends TestCase
{
    public function test_can_render_page()
    {
        $this->get(route('filament.pages.list-your-records'))
            ->assertSuccessful();
    }
}
```

## Performance

### 1. Query Optimization
- Utilizzare eager loading per le relazioni
- Limitare il numero di record per pagina
- Utilizzare indici per le colonne filtrate
- Implementare caching quando possibile

### 2. Asset Optimization
- Minificare CSS e JavaScript
- Ottimizzare le immagini
- Utilizzare lazy loading
- Implementare caching del browser

## Sicurezza

### 1. Validazione
- Validare sempre gli input
- Sanitizzare i dati
- Proteggere da XSS
- Validare file upload

### 2. Autorizzazioni
- Implementare controlli di accesso
- Utilizzare policy
- Validare permessi
- Proteggere le route

## Deployment

### 1. Pre-deployment
- Eseguire test
- Compilare assets
- Ottimizzare autoloader
- Verificare configurazioni

### 2. Post-deployment
- Pulire cache
- Aggiornare indici
- Verificare log
- Monitorare performance

## Manutenzione

### 1. Documentazione
- PHPDoc per tutte le classi
- README aggiornato
- CHANGELOG
- Documentazione API

### 2. Monitoraggio
- Log errori
- Performance metrics
- Usage statistics
- Security alerts

## Wizard Forms

### 1. Struttura
```php
declare(strict_types=1);

namespace Modules\YourModule\Filament\Widgets;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;

class YourWizard extends Component
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }
}
```

### 2. Best Practices
- Utilizzare il trait `InteractsWithForms`
- Definire `$data` come array nullable
- Implementare `mount()` per inizializzare il form
- Separare lo schema in `getFormSchema()`
- Utilizzare icone e descrizioni per ogni step
- Validare i dati per step
- Gestire la navigazione tra gli step
- Salvare i dati progressivamente
- Gestire gli errori appropriatamente

### 3. Struttura Directory
```
Module/
├── app/
│   └── Filament/
│       └── Widgets/
│           └── YourWizard.php
└── resources/
    └── views/
        └── widgets/
            └── your-wizard.blade.php
```

### 4. Views
```blade
<div>
    <form wire:submit="submit">
        {{ $this->form }}
    </form>
</div>

@script
<script>
    $wire.on('wizard-completed', (data) => {
        // Gestione completamento wizard
    });
</script>
@endscript
```

### 5. Testing
```php
declare(strict_types=1);

namespace Modules\YourModule\Tests\Filament\Widgets;

use Tests\TestCase;

class YourWizardTest extends TestCase
{
    public function test_can_render_wizard()
    {
        $wizard = new YourWizard();
        $this->assertInstanceOf(Form::class, $wizard->form(new Form()));
    }

    public function test_can_navigate_steps()
    {
        $wizard = new YourWizard();
        $wizard->nextStep();
        $this->assertEquals(1, $wizard->currentStep);
    }
}
``` 
## Collegamenti tra versioni di best-practices.md
* [best-practices.md](docs/tecnico/filament/best-practices.md)
* [best-practices.md](laravel/Modules/Xot/docs/laraxot/best-practices.md)
* [best-practices.md](laravel/Modules/UI/docs/best-practices.md)
* [best-practices.md](laravel/Themes/One/docs/best-practices.md)

