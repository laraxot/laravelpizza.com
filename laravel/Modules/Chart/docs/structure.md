# Modulo Chart

Data: 2025-04-23 19:09:55

## Informazioni generali

- **Namespace principale**: Modules\\Chart
- **Pacchetto Composer**: laraxot/module_chart_fila3
Marco Sottana
- **Dipendenze**: amenadiel/jpgraph ^4.1 laraxot/module_xot_fila3 * thecodingmachine/safe ^2.5 driftingly/rector-laravel ^0.26.2 enlightn/enlightn ^2.5 laravel/pint ^1.13 nunomaduro/collision * larastan/larastan ^2.6 nunomaduro/phpinsights ^2.9 orchestra/testbench ^9.4 pestphp/pest * pestphp/pest-plugin-arch * pestphp/pest-plugin-laravel * phpstan/phpstan-deprecation-rules * phpstan/phpstan-phpunit * psalm/plugin-laravel * 
- **Totale file PHP**: 58
- **Totale classi/interfacce**: 42

## Struttura delle directory

```

.github
.github/workflows
.vscode
Resources_old2
_docs
app
app/Actions
app/Actions/Chart
app/Actions/JpGraph
app/Actions/JpGraph/V1
app/Console
app/Console/Commands
app/Datas
app/Entities
app/Enums
app/Filament
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/ChartResource
app/Filament/Resources/ChartResource/Pages
app/Filament/Resources/MixedChartResource
app/Filament/Resources/MixedChartResource/Pages
app/Filament/Widgets
app/Filament/Widgets/Samples
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Middleware
app/Http/Requests
app/Models
app/Providers
app/Providers/Filament
app/Tables
app/Tables/Columns
app/View
app/View/Components
config
database
database/Factories
database/Migrations
database/Seeders
docs
docs/.github
docs/.github/workflows
docs/advanced
docs/components
docs/components/chartjs
docs/phpstan
lang
lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/css
resources/dist
resources/dist/.vite
resources/dist/assets
resources/img
resources/js
resources/lang
resources/lang/it
resources/sass
resources/svg
resources/views
resources/views/components
resources/views/filament
resources/views/filament/pages
resources/views/filament/widgets
resources/views/filament/widgets/samples
resources/views/layouts
resources/views/tables
resources/views/tables/columns
resources_old
routes
tests
tests/Feature
tests/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Chart\\": "app/"
        }
    },
    "require": {
        "amenadiel/jpgraph": "^4.1"
    },
    "require_comment": {
        "laraxot/module_xot_fila3": "*",
        "thecodingmachine/safe": "^2.5"
    },
    "require-dev_comment": {
        "driftingly/rector-laravel": "^0.26.2",
        "enlightn/enlightn": "^2.5",
        "laravel/pint": "^1.13",
```

## Dipendenze da altri moduli

-       2 Modules\Xot\Filament\Traits\TransTrait;
-       2 Modules\Xot\Filament\Resources\XotBaseResource;
-       2 Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
-       2 Modules\UI\Enums\TableLayoutEnum;
-       1 Modules\Xot\Traits\Updater;
-       1 Modules\Xot\Providers\XotBaseServiceProvider;
-       1 Modules\Xot\Providers\XotBaseRouteServiceProvider;
-       1 Modules\Xot\Providers\Filament\XotBasePanelProvider;
-       1 Modules\Xot\Actions\Factory\GetFactoryAction;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)

