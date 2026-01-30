# Interfaccia Utente il progetto

## Panoramica
L'interfaccia utente di il progetto è costruita su Filament 4.x con personalizzazioni estese e un tema custom.

## Architettura UI

### Struttura
```
├── theme_one_fila3/            # Tema principale Filament
│   ├── resources/
│   │   ├── css/                # Stili base
│   │   ├── js/                 # Script JS
│   │   └── views/              # Blade views
│   ├── src/                    # PHP classes
│   └── tailwind.config.js      # Config Tailwind
│
├── module_ui_fila3/            # Componenti riutilizzabili
│   ├── app/
│   │   ├── Filament/           # Pannelli e risorse
│   │   └── View/               # Componenti blade
│   └── resources/
│       ├── css/                # Stili custom
│       ├── js/                 # Script JS
│       └── views/              # Blade components
│
└── public/                     # Asset compilati
    ├── css/                    # CSS compilato
    ├── js/                     # JS compilato
    └── build/                  # Vite build
```

### Framework
- **Backend**: Laravel 11.x
- **Admin Panel**: Filament 4.x
- **Frontend**: 
  - Blade + Livewire
  - Alpine.js
  - Tailwind CSS
- **Build Tools**: Vite

## Componenti

### Filament Components
- Risorse CRUD
- Widgets personalizzati
- Form builder esteso
- Table builder esteso
- Pannelli multipli

### UI Components
- Form inputs
- Buttons
- Cards
- Alerts
- Modals
- Tables
- Menu
- Navigation
- Dashboard widgets

### Blade Components
Componenti riutilizzabili:
```php
// Esempio di button component
<x-ui::button color="primary" size="md">
    <x-ui::icon name="save" class="mr-2" />
    {{ __('Salva') }}
</x-ui::button>

// Esempio di card component
<x-ui::card title="Paziente">
    <x-slot name="header">
        <div class="flex justify-between">
            <h3>{{ $patient->name }}</h3>
            <x-ui::badge color="success">{{ $patient->status }}</x-ui::badge>
        </div>
    </x-slot>
    
    {{ $slot }}
    
    <x-slot name="footer">
        <x-ui::button link="{{ route('patients.edit', $patient) }}">
            {{ __('Modifica') }}
        </x-ui::button>
    </x-slot>
</x-ui::card>
```

## Tema

### Variabili Colore
```css
:root {
    --color-primary: 0 108 170; /* #006CAA */
    --color-primary-hover: 0 84 133; /* #005485 */
    --color-secondary: 220 38 38; /* #DC2626 */
    --color-success: 22 163 74; /* #16A34A */
    --color-warning: 234 179 8; /* #EAB308 */
    --color-danger: 220 38 38; /* #DC2626 */
    --color-info: 6 182 212; /* #06B6D4 */
    
    /* Grays */
    --color-gray-50: 249 250 251; /* #F9FAFB */
    --color-gray-100: 243 244 246; /* #F3F4F6 */
    --color-gray-200: 229 231 235; /* #E5E7EB */
    --color-gray-300: 209 213 219; /* #D1D5DB */
    --color-gray-400: 156 163 175; /* #9CA3AF */
    --color-gray-500: 107 114 128; /* #6B7280 */
    --color-gray-600: 75 85 99; /* #4B5563 */
    --color-gray-700: 55 65 81; /* #374151 */
    --color-gray-800: 31 41 55; /* #1F2937 */
    --color-gray-900: 17 24 39; /* #111827 */
}
```

### Typography
```css
:root {
    --font-family-sans: 'Inter', ui-sans-serif, system-ui;
    --font-family-mono: 'JetBrains Mono', ui-monospace, monospace;
    
    --font-size-xs: 0.75rem;
    --font-size-sm: 0.875rem;
    --font-size-base: 1rem;
    --font-size-lg: 1.125rem;
    --font-size-xl: 1.25rem;
    --font-size-2xl: 1.5rem;
    --font-size-3xl: 1.875rem;
    --font-size-4xl: 2.25rem;
}
```

### Spacing
```css
:root {
    --spacing-px: 1px;
    --spacing-0: 0;
    --spacing-0.5: 0.125rem;
    --spacing-1: 0.25rem;
    --spacing-1.5: 0.375rem;
    --spacing-2: 0.5rem;
    --spacing-2.5: 0.625rem;
    --spacing-3: 0.75rem;
    --spacing-3.5: 0.875rem;
    --spacing-4: 1rem;
    --spacing-5: 1.25rem;
    --spacing-6: 1.5rem;
    --spacing-8: 2rem;
    --spacing-10: 2.5rem;
    --spacing-12: 3rem;
    --spacing-16: 4rem;
    --spacing-20: 5rem;
}
```

## Responsive

### Breakpoints
```css
/* Tailwind breakpoints */
--screen-sm: 640px;
--screen-md: 768px;
--screen-lg: 1024px;
--screen-xl: 1280px;
--screen-2xl: 1536px;
```

### Mobile First
- Layout fluido
- Menu collassabili
- Tavolozza ridotta su mobile
- Versioni semplificate dei form
- Stack di componenti su mobile
- Focus su elementi principali

### Desktop Optimized
- Layout multi-colonna
- Menu espansi
- Tabelle complete
- Form avanzati
- Componenti affiancati
- Dashboard ricca

## Accessibilità

### WCAG 2.1 Compliance
- Conformità di livello AA
- Contrasto colori ≥ 4.5:1
- Testi ridimensionabili
- Keyboard navigation
- Focus visible
- Aria attributes
- Screen reader support

### Skip Links
```html
<a href="#main-content" class="sr-only focus:not-sr-only">
    {{ __('Vai al contenuto principale') }}
</a>
```

### Contrasto Colori
```php
// Esempio di utility color contrast
function hasGoodContrast($foreground, $background): bool {
    // WCAG 2.1 calculations
    // ...
}
```

## Performance

### Loading
- Lazy loading assets
- Lazy loading components
- Code splitting
- Preload critici
- Dynamic imports
- Progress indicators

### Ottimizzazione
- Minified assets
- Compressed images
- Tree shaking
- Inline critical CSS
- HTTP/2 preload
- Browser caching

### Monitoring
```php
// Performance tracking
window.addEventListener('load', () => {
    const timing = window.performance.timing;
    const pageLoadTime = timing.loadEventEnd - timing.navigationStart;
    
    // Log o invio metrica
    fetch('/api/metrics/page-load', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ time: pageLoadTime, page: window.location.pathname })
    });
});
```

## Dark Mode

### Configurazione
```php
// config/filament.php
return [
    'dark_mode' => [
        'enabled' => true,
        
        // Accetta 'system', 'light', 'dark'
        'default' => 'system',
    ],
];
```

### Tema Dark
```css
.dark {
    --color-primary: 14 165 233; /* #0EA5E9 */
    --color-secondary: 252 165 165; /* #FCA5A5 */
    
    --color-gray-50: 17 24 39; /* #111827 - Invertito */
    --color-gray-100: 31 41 55; /* #1F2937 - Invertito */
    --color-gray-200: 55 65 81; /* #374151 - Invertito */
    /* ... altri colori ... */
    
    --color-background: 17 24 39; /* #111827 */
    --color-foreground: 249 250 251; /* #F9FAFB */
}
```

## Testing

### Screenshot Tests
```php
use Spatie\Snapshots\MatchesSnapshots;

class ButtonTest extends TestCase
{
    use MatchesSnapshots;
    
    public function test_renders_correctly()
    {
        $html = Blade::render('<x-ui::button>Test</x-ui::button>');
        $this->assertMatchesSnapshot($html);
    }
}
```

### Browser Tests
```php
use Laravel\Dusk\Browser;

class PatientPageTest extends DuskTestCase
{
    public function test_patient_page_loads_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user)
                    ->visit('/patients')
                    ->assertSee('Lista Pazienti')
                    ->assertVisible('@patient-table');
        });
    }
}
```

### Visual Regression
```php
use Laravel\Dusk\Browser;

class PatientPageTest extends DuskTestCase
{
    public function test_patient_page_visual()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user)
                    ->visit('/patients')
                    ->waitFor('@patient-table')
                    ->screenshot('patient-index');
                    
            $this->assertScreenshotIdentical('patient-index');
        });
    }
} 
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
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

