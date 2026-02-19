# Standard UI

Questo documento contiene gli standard specifici per il modulo UI.

## Componenti

### Nomenclatura
- Nome in PascalCase
- Prefisso `XotBase` per le classi base
- Suffisso `Component` per i componenti Blade
- Suffisso `Widget` per i widget Filament

### Struttura
```php
namespace Modules\UI\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class XotBaseButton extends Component
{
    public function __construct(
        public string $type = 'button',
        public ?string $color = null,
        public ?string $size = null,
        public bool $disabled = false
    ) {}

    public function render(): View
    {
        return view('ui::components.button');
    }
}
```

### Blade
- Utilizzare componenti Blade per tutto
- Evitare direttive personalizzate
- Mantenere la logica nel componente PHP
- Utilizzare slots per contenuto dinamico

### Stili
- Utilizzare Tailwind CSS
- Evitare CSS personalizzato
- Utilizzare variabili CSS per colori e dimensioni
- Mantenere la coerenza visiva

## Widgets Filament

### Nomenclatura
- Nome in PascalCase
- Suffisso `Widget`
- Prefisso `XotBase` per le classi base

### Struttura
```php
namespace Modules\UI\app\Filament\Widgets;

use Filament\Widgets\Widget;

class XotBaseStatsOverview extends Widget
{
    protected static string $view = 'ui::widgets.stats-overview';

    protected function getViewData(): array
    {
        return [
            'stats' => $this->getStats(),
        ];
    }
}
```

### Performance
- Ottimizzare le query
- Utilizzare cache quando appropriato
- Evitare N+1 query
- Lazy loading per dati pesanti

## Temi

### Struttura
- Un tema per tenant
- Estensione del tema base
- Override solo delle variabili necessarie
- Documentazione delle variabili disponibili

### Personalizzazione
- Utilizzare variabili CSS
- Mantenere la coerenza
- Documentare le personalizzazioni
- Testare su tutti i dispositivi

## Accessibilità

### Requisiti
- WCAG 2.1 AA compliance
- Supporto screen reader
- Navigazione da tastiera
- Contrasto sufficiente

### Testing
- Test automatici
- Test manuali
- Test con screen reader
- Test su diversi dispositivi

## Performance Frontend

### Ottimizzazioni
- Lazy loading immagini
- Code splitting
- Minificazione assets
- Cache browser

### Monitoring
- Core Web Vitals
- Performance budget
- Errori JavaScript
- Tempi di caricamento
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
