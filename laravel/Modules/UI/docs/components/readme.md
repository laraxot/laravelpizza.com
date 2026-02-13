# Componenti UI

Questo documento contiene la documentazione dettagliata dei componenti UI.

## Struttura dei Componenti

### Base Components
- `XotBaseButton`: Pulsante base con varianti
- `XotBaseInput`: Campo input con validazione
- `XotBaseSelect`: Select con opzioni
- `XotBaseCheckbox`: Checkbox con label
- `XotBaseRadio`: Radio button con gruppo

### Layout Components
- `XotBaseCard`: Card con header e footer
- `XotBaseModal`: Modal con animazioni
- `XotBaseTabs`: Tabs con contenuto
- `XotBaseAccordion`: Accordion espandibile
- `XotBaseGrid`: Grid system responsive

### Data Components
- `XotBaseTable`: Tabella con sorting e pagination
- `XotBaseList`: Lista con items
- `XotBaseTimeline`: Timeline con eventi
- `XotBaseCalendar`: Calendario con eventi
- `XotBaseChart`: Grafici con dati

## Utilizzo

### Esempio Base
```php
<x-ui::button
    type="submit"
    color="primary"
    size="lg"
    :disabled="$isDisabled"
>
    {{ $slot }}
</x-ui::button>
```

### Props
```php
class XotBaseButton extends Component
{
    public function __construct(
        public string $type = 'button',
        public ?string $color = null,
        public ?string $size = null,
        public bool $disabled = false,
        public ?string $icon = null,
        public ?string $loading = null
    ) {}
}
```

### Slots
```php
<x-ui::card>
    <x-slot name="header">
        <h2>Titolo</h2>
    </x-slot>

    <p>Contenuto</p>

    <x-slot name="footer">
        <x-ui::button>Salva</x-ui::button>
    </x-slot>
</x-ui::card>
```

## Stili

### Tailwind
```css
@layer components {
    .btn {
        @apply px-4 py-2 rounded-md font-medium transition-colors;
    }

    .btn-primary {
        @apply bg-blue-600 text-white hover:bg-blue-700;
    }

    .btn-secondary {
        @apply bg-gray-600 text-white hover:bg-gray-700;
    }
}
```

### Variabili CSS
```css
:root {
    --primary-color: #3b82f6;
    --secondary-color: #4b5563;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --info-color: #3b82f6;
}
```

## Accessibilità

### ARIA
```php
class XotBaseButton extends Component
{
    public function getAriaAttributes(): array
    {
        return [
            'aria-disabled' => $this->disabled,
            'aria-busy' => $this->loading,
            'aria-label' => $this->getAriaLabel(),
        ];
    }
}
```

### Keyboard Navigation
```php
class XotBaseModal extends Component
{
    public function mount(): void
    {
        $this->setupKeyboardNavigation();
    }

    private function setupKeyboardNavigation(): void
    {
        $this->dispatchBrowserEvent('keydown', [
            'key' => 'Escape',
            'handler' => fn() => $this->close(),
        ]);
    }
}
```

## Performance

### Lazy Loading
```php
class XotBaseImage extends Component
{
    public function render(): View
    {
        return view('ui::components.image', [
            'src' => $this->src,
            'loading' => 'lazy',
            'width' => $this->width,
            'height' => $this->height,
        ]);
    }
}
```

### Code Splitting
```javascript
// resources/js/components/Chart.js
import { lazy } from 'react';

const Chart = lazy(() => import('./Chart'));

export default Chart;
```

## Testing

### Unit Tests
```php
class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_correctly(): void
    {
        $view = $this->blade(
            '<x-ui::button>Test</x-ui::button>'
        );

        $view->assertSee('Test');
    }
}
```

### Browser Tests
```php
class ButtonBrowserTest extends DuskTestCase
{
    /** @test */
    public function it_handles_click(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                   ->click('@submit-button')
                   ->assertSee('Success');
        });
    }
}
```
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](../../../Chart/docs/README.md)
* [README.md](../../../Reporting/docs/README.md)
* [README.md](../../../Gdpr/docs/phpstan/README.md)
* [README.md](../../../Gdpr/docs/README.md)
* [README.md](../../../Notify/docs/phpstan/README.md)
* [README.md](../../../Notify/docs/README.md)
* [README.md](../../../Xot/docs/filament/README.md)
* [README.md](../../../Xot/docs/phpstan/README.md)
* [README.md](../../../Xot/docs/exceptions/README.md)
* [README.md](../../../Xot/docs/README.md)
* [README.md](../../../Xot/docs/standards/README.md)
* [README.md](../../../Xot/docs/conventions/README.md)
* [README.md](../../../Xot/docs/development/README.md)
* [README.md](../../../Dental/docs/README.md)
* [README.md](../../../User/docs/phpstan/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../UI/docs/phpstan/README.md)
* [README.md](../../../UI/docs/README.md)
* [README.md](../../../UI/docs/standards/README.md)
* [README.md](../../../UI/docs/themes/README.md)
* [README.md](../../../UI/docs/components/README.md)
* [README.md](../../../Lang/docs/phpstan/README.md)
* [README.md](../../../Lang/docs/README.md)
* [README.md](../../../Job/docs/phpstan/README.md)
* [README.md](../../../Job/docs/README.md)
* [README.md](../../../Media/docs/phpstan/README.md)
* [README.md](../../../Media/docs/README.md)
* [README.md](../../../Tenant/docs/phpstan/README.md)
* [README.md](../../../Tenant/docs/README.md)
* [README.md](../../../Activity/docs/phpstan/README.md)
* [README.md](../../../Activity/docs/README.md)
* [README.md](../../../Patient/docs/README.md)
* [README.md](../../../Patient/docs/standards/README.md)
* [README.md](../../../Patient/docs/value-objects/README.md)
* [README.md](../../../Cms/docs/blocks/README.md)
* [README.md](../../../Cms/docs/README.md)
* [README.md](../../../Cms/docs/standards/README.md)
* [README.md](../../../Cms/docs/content/README.md)
* [README.md](../../../Cms/docs/frontoffice/README.md)
* [README.md](../../../Cms/docs/components/README.md)
* [README.md](../../../../Themes/Two/docs/README.md)
* [README.md](../../../../Themes/One/docs/README.md)
