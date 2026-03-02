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
* [README.md](bashscripts/docs/readme.md)
* [README.md](bashscripts/docs/it/readme.md)
* [README.md](docs/laravel-app/phpstan/readme.md)
* [README.md](docs/laravel-app/readme.md)
* [README.md](docs/moduli/struttura/readme.md)
* [README.md](docs/moduli/readme.md)
* [README.md](docs/moduli/manutenzione/readme.md)
* [README.md](docs/moduli/core/readme.md)
* [README.md](docs/moduli/installati/readme.md)
* [README.md](docs/moduli/comandi/readme.md)
* [README.md](docs/phpstan/readme.md)
* [README.md](docs/readme.md)
* [README.md](docs/module-links/readme.md)
* [README.md](docs/troubleshooting/git-conflicts/readme.md)
* [README.md](docs/tecnico/laraxot/readme.md)
* [README.md](docs/modules/readme.md)
* [README.md](docs/conventions/readme.md)
* [README.md](docs/amministrazione/backup/readme.md)
* [README.md](docs/amministrazione/monitoraggio/readme.md)
* [README.md](docs/amministrazione/deployment/readme.md)
* [README.md](docs/translations/readme.md)
* [README.md](docs/roadmap/readme.md)
* [README.md](docs/ide/cursor/readme.md)
* [README.md](docs/implementazione/api/readme.md)
* [README.md](docs/implementazione/testing/readme.md)
* [README.md](docs/implementazione/pazienti/readme.md)
* [README.md](docs/implementazione/ui/readme.md)
* [README.md](docs/implementazione/dental/readme.md)
* [README.md](docs/implementazione/core/readme.md)
* [README.md](docs/implementazione/reporting/readme.md)
* [README.md](docs/implementazione/isee/readme.md)
* [README.md](docs/it/readme.md)
* [README.md](laravel/vendor/mockery/mockery/docs/readme.md)
* [README.md](../../../chart/docs/readme.md)
* [README.md](../../../reporting/docs/readme.md)
* [README.md](../../../gdpr/docs/phpstan/readme.md)
* [README.md](../../../gdpr/docs/readme.md)
* [README.md](../../../notify/docs/phpstan/readme.md)
* [README.md](../../../notify/docs/readme.md)
* [README.md](../../../xot/docs/filament/readme.md)
* [README.md](../../../xot/docs/phpstan/readme.md)
* [README.md](../../../xot/docs/exceptions/readme.md)
* [README.md](../../../xot/docs/readme.md)
* [README.md](../../../xot/docs/standards/readme.md)
* [README.md](../../../xot/docs/conventions/readme.md)
* [README.md](../../../xot/docs/development/readme.md)
* [README.md](../../../dental/docs/readme.md)
* [README.md](../../../user/docs/phpstan/readme.md)
* [README.md](../../../user/docs/readme.md)
* [README.md](../../../user/docs/readme.md)
* [README.md](../../../ui/docs/phpstan/readme.md)
* [README.md](../../../ui/docs/readme.md)
* [README.md](../../../ui/docs/standards/readme.md)
* [README.md](../../../ui/docs/themes/readme.md)
* [README.md](../../../ui/docs/components/readme.md)
* [README.md](../../../lang/docs/phpstan/readme.md)
* [README.md](../../../lang/docs/readme.md)
* [README.md](../../../job/docs/phpstan/readme.md)
* [README.md](../../../job/docs/readme.md)
* [README.md](../../../media/docs/phpstan/readme.md)
* [README.md](../../../media/docs/readme.md)
* [README.md](../../../tenant/docs/phpstan/readme.md)
* [README.md](../../../tenant/docs/readme.md)
* [README.md](../../../activity/docs/phpstan/readme.md)
* [README.md](../../../activity/docs/readme.md)
* [README.md](../../../patient/docs/readme.md)
* [README.md](../../../patient/docs/standards/readme.md)
* [README.md](../../../patient/docs/value-objects/readme.md)
* [README.md](../../../cms/docs/blocks/readme.md)
* [README.md](../../../cms/docs/readme.md)
* [README.md](../../../cms/docs/standards/readme.md)
* [README.md](../../../cms/docs/content/readme.md)
* [README.md](../../../cms/docs/frontoffice/readme.md)
* [README.md](../../../cms/docs/components/readme.md)
* [README.md](../../../../themes/two/docs/readme.md)
* [README.md](../../../../themes/one/docs/readme.md)
