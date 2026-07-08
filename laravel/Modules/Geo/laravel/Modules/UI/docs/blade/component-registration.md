# Registrazione Componenti Blade nei Moduli

## Architettura dei componenti Blade

Nei moduli che estendono `XotBaseServiceProvider`, la registrazione dei componenti Blade avviene **automaticamente** seguendo una struttura ben definita.

## Struttura corretta

1. **Posizionamento dei file**:
   - Classe del componente: `Modules/<Module>/View/Components/<NomeComponente>.php`
   - Vista del componente: `Modules/<Module>/resources/views/components/<nome-componente>.blade.php`

2. **Namespace**:
   - Le classi dei componenti devono essere nel namespace `Modules\<Module>\View\Components`

3. **Naming**:
   - La classe PHP: PascalCase (es. `ChartAssets.php`)
   - Il file Blade: kebab-case (es. `chart-assets.blade.php`)

4. **Prefissi**:
   - Il nome del modulo in minuscolo viene utilizzato come prefisso per i componenti
   - Esempio: `<x-reporting-chart-assets />` per il componente `ReportingChartAssets` nel modulo `Reporting`

## Esempio completo

**Classe del componente**:
```php
// File: Modules/Reporting/View/Components/ReportingChartAssets.php
namespace Modules\Reporting\View\Components;

use Illuminate\View\Component;

class ReportingChartAssets extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('reporting::components.chart-assets');
    }
}
```

**Vista del componente**:
```blade
{{-- File: Modules/Reporting/resources/views/components/chart-assets.blade.php --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
```

**Utilizzo del componente**:
```blade
<x-reporting-chart-assets />
```

## Come funziona la registrazione automatica

1. `XotBaseServiceProvider::registerBladeComponents()` viene chiamato durante il boot
2. Questo metodo utilizza `RegisterBladeComponentsAction` per trovare tutti i componenti
3. Registra il namespace del modulo con un prefisso usando `Blade::componentNamespace()`
4. Registra ogni componente specifico usando `Blade::component()`

## Errori comuni da evitare

1. ❌ Registrare manualmente i componenti in ServiceProvider
2. ❌ Utilizzare namespace errati per i componenti
3. ❌ Posizionare i componenti in directory non standard
4. ❌ Posizionare le viste in percorsi non corretti
5. ❌ Non rispettare le convenzioni di naming (PascalCase per classi, kebab-case per viste)

## Riferimenti

- [XotBaseServiceProvider::registerBladeComponents()](../../Xot/app/Providers/XotBaseServiceProvider.php)
- [RegisterBladeComponentsAction](../../Xot/app/Actions/Blade/RegisterBladeComponentsAction.php)
- [Laravel Blade Components Documentation](https://laravel.com/docs/blade#components)
