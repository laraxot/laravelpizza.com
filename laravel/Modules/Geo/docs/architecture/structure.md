# Modulo Geo

Data: 2025-04-23 19:09:55

## Informazioni generali

- **Namespace principale**: Modules\\Geo
Modules\\Geo\\Database\\Factories
Modules\\Geo\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_geo_fila3
Marco Sottana
- **Dipendenze**: cheesegrits/filament-google-maps ^3.0 dotswan/filament-map-picker ^1.2 webbingbrasil/filament-maps ^3.0@beta repositories type path url ../Xot type path url ../Tenant type path url ../UI scripts post-autoload-dump_comment 
- **Totale file PHP**: 197
- **Totale classi/interfacce**: 129

## Struttura delle directory

```

.git
.git/branches
.git/hooks
.git/info
.git/logs
.git/logs/refs
.git/logs/refs/heads
.git/logs/refs/remotes
.git/logs/refs/remotes/aurmich
.git/objects
.git/objects/00
.git/objects/01
.git/objects/02
.git/objects/03
.git/objects/04
.git/objects/05
.git/objects/06
.git/objects/07
.git/objects/08
.git/objects/09
.git/objects/0a
.git/objects/0b
.git/objects/0c
.git/objects/0d
.git/objects/0e
.git/objects/0f
.git/objects/10
.git/objects/11
.git/objects/12
.git/objects/13
.git/objects/14
.git/objects/15
.git/objects/16
.git/objects/17
.git/objects/18
.git/objects/19
.git/objects/1a
.git/objects/1b
.git/objects/1d
.git/objects/1e
.git/objects/1f
.git/objects/20
.git/objects/21
.git/objects/22
.git/objects/23
.git/objects/24
.git/objects/25
.git/objects/26
.git/objects/27
.git/objects/28
.git/objects/29
.git/objects/2a
.git/objects/2b
.git/objects/2c
.git/objects/2d
.git/objects/2e
.git/objects/2f
.git/objects/30
.git/objects/31
.git/objects/32
.git/objects/33
.git/objects/34
.git/objects/35
.git/objects/36
.git/objects/37
.git/objects/38
.git/objects/39
.git/objects/3a
.git/objects/3b
.git/objects/3c
.git/objects/3d
.git/objects/3f
.git/objects/40
.git/objects/41
.git/objects/42
.git/objects/43
.git/objects/44
.git/objects/45
.git/objects/46
.git/objects/47
.git/objects/48
.git/objects/49
.git/objects/4a
.git/objects/4b
.git/objects/4c
.git/objects/4e
.git/objects/4f
.git/objects/50
.git/objects/51
.git/objects/52
.git/objects/53
.git/objects/54
.git/objects/55
.git/objects/56
.git/objects/57
.git/objects/58
.git/objects/59
.git/objects/5a
.git/objects/5b
.git/objects/5c
.git/objects/5d
.git/objects/5e
.git/objects/5f
.git/objects/60
.git/objects/61
.git/objects/62
.git/objects/63
.git/objects/64
.git/objects/65
.git/objects/66
.git/objects/67
.git/objects/69
.git/objects/6a
.git/objects/6b
.git/objects/6d
.git/objects/6e
.git/objects/6f
.git/objects/70
.git/objects/71
.git/objects/72
.git/objects/74
.git/objects/75
.git/objects/76
.git/objects/77
.git/objects/78
.git/objects/79
.git/objects/7a
.git/objects/7b
.git/objects/7c
.git/objects/7d
.git/objects/7f
.git/objects/80
.git/objects/81
.git/objects/82
.git/objects/83
.git/objects/84
.git/objects/85
.git/objects/86
.git/objects/87
.git/objects/88
.git/objects/89
.git/objects/8a
.git/objects/8b
.git/objects/8c
.git/objects/8d
.git/objects/8e
.git/objects/8f
.git/objects/90
.git/objects/91
.git/objects/92
.git/objects/93
.git/objects/94
.git/objects/95
.git/objects/96
.git/objects/97
.git/objects/98
.git/objects/99
.git/objects/9a
.git/objects/9b
.git/objects/9c
.git/objects/9d
.git/objects/9e
.git/objects/9f
.git/objects/a0
.git/objects/a1
.git/objects/a2
.git/objects/a3
.git/objects/a4
.git/objects/a5
.git/objects/a6
.git/objects/a7
.git/objects/a8
.git/objects/a9
.git/objects/aa
.git/objects/ab
.git/objects/ac
.git/objects/ad
.git/objects/af
.git/objects/b0
.git/objects/b1
.git/objects/b2
.git/objects/b3
.git/objects/b4
.git/objects/b5
.git/objects/b6
.git/objects/b7
.git/objects/b8
.git/objects/b9
.git/objects/ba
.git/objects/bb
.git/objects/bc
.git/objects/bd
.git/objects/be
.git/objects/bf
.git/objects/c0
.git/objects/c1
.git/objects/c2
.git/objects/c3
.git/objects/c4
.git/objects/c5
.git/objects/c6
.git/objects/c7
.git/objects/c8
.git/objects/c9
.git/objects/ca
.git/objects/cb
.git/objects/cc
.git/objects/cd
.git/objects/ce
.git/objects/d0
.git/objects/d1
.git/objects/d2
.git/objects/d3
.git/objects/d4
.git/objects/d5
.git/objects/d6
.git/objects/d7
.git/objects/d8
.git/objects/d9
.git/objects/da
.git/objects/db
.git/objects/dc
.git/objects/dd
.git/objects/de
.git/objects/df
.git/objects/e0
.git/objects/e1
.git/objects/e2
.git/objects/e3
.git/objects/e4
.git/objects/e5
.git/objects/e6
.git/objects/e7
.git/objects/e8
.git/objects/e9
.git/objects/ea
.git/objects/eb
.git/objects/ec
.git/objects/ed
.git/objects/ee
.git/objects/ef
.git/objects/f0
.git/objects/f1
.git/objects/f2
.git/objects/f3
.git/objects/f4
.git/objects/f5
.git/objects/f6
.git/objects/f7
.git/objects/f8
.git/objects/f9
.git/objects/fa
.git/objects/fb
.git/objects/fc
.git/objects/fd
.git/objects/fe
.git/objects/ff
.git/objects/info
.git/objects/pack
.git/refs
.git/refs/heads
.git/refs/remotes
.git/refs/remotes/aurmich
.git/refs/tags
.github
.github/ISSUE_TEMPLATE
.github/workflows
.vscode
_docs
_dump
_menuxml
_menuxml/Admin
app
app/Actions
app/Actions/Bing
app/Actions/BingMaps
app/Actions/Elevation
app/Actions/GoogleMaps
app/Actions/Here
app/Actions/IPGeolocation
app/Actions/LocationIQ
app/Actions/Mapbox
app/Actions/Nominatim
app/Actions/OpenCage
app/Actions/OpenStreetMap
app/Actions/Photon
app/Actions/TimeZone
app/Actions/Weather
app/Bus
app/Console
app/Console/Commands
app/Contracts
app/DataTransferObjects
app/Datas
app/Datas/GoogleMaps
app/Datas/HereMap
app/Datas/Map
app/Datas/Photon
app/Exceptions
app/Exceptions/GoogleMaps
app/Filament
app/Filament/Blocks
app/Filament/Columns
app/Filament/Fields
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/LocationResource
app/Filament/Resources/LocationResource/Pages
app/Filament/Resources/Pages
app/Filament/Widgets
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Middleware
app/Http/Requests
app/Models
app/Models/Policies
app/Models/Traits
app/Providers
app/Providers/Filament
app/Repositories
app/Rules
app/Services
app/Traits
app/Transformers
app/View
app/View/Components
app/View/Components/Card
app/View/Components/Dashboard
bashscripts
config
database
database/factories
database/migrations
database/seeders
docs
docs/phpstan
lang
lang/en
lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/css
resources/css/images
resources/icons
resources/img
resources/js
resources/js/components
resources/js/components/map
resources/markdown
resources/sass
resources/svg
resources/svg/navigation
resources/views
resources/views/admin
resources/views/admin/dashboard
resources/views/admin/home
resources/views/admin/home/acts
resources/views/components
resources/views/components/blocks
resources/views/components/blocks/article_list
resources/views/components/blocks/map
resources/views/components/card
resources/views/contribute
resources/views/contribute/css
resources/views/contribute/img
resources/views/contribute/js
resources/views/contribute/locales
resources/views/contribute/locales/de
resources/views/data
resources/views/data/undefined
resources/views/filament
resources/views/filament/pages
resources/views/filament/widgets
resources/views/fonts
resources/views/home
resources/views/layouts
resources/views/layouts/partials
resources/views/livewire
resources/views/maps
resources/views/maps/farmshops
resources/views/maps/farmshops/contribute
resources/views/maps/farmshops/contribute/css
resources/views/maps/farmshops/contribute/img
resources/views/maps/farmshops/contribute/js
resources/views/maps/farmshops/contribute/locales
resources/views/maps/farmshops/contribute/locales/de
resources/views/maps/farmshops/css
resources/views/maps/farmshops/css/images
resources/views/maps/farmshops/dist
resources/views/maps/farmshops/dist/css
resources/views/maps/farmshops/dist/js
resources/views/maps/farmshops/icons
resources/views/maps/farmshops/img
resources/views/maps/farmshops/js
resources/views/maps/farmshops/resources
resources/views/maps/farmshops/resources/css
resources/views/maps/farmshops/resources/js
resources/views/maps/farmshops/resources/sass
resources/views/maps/farmshops/webfonts
resources/views/webfonts
routes
tests
tests/Feature
tests/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Geo\\": "app/",
            "Modules\\Geo\\Database\\Factories\\": "database/factories/",
            "Modules\\Geo\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "require": {
        "cheesegrits/filament-google-maps": "^3.0",
        "dotswan/filament-map-picker": "^1.2",
        "webbingbrasil/filament-maps": "^3.0@beta"
    },
    "repositories": [
        {
            "type": "path",
            "url": "../Xot"
--
        "post-autoload-dump_comment": [
            "@php vendor/bin/testbench package:discover --ansi"
        ],
        "post-update-cmd_comment": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate"
        ],
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "phpstan/extension-installer": true,
            "pestphp/pest-plugin": true,
```

## Dipendenze da altri moduli

-       8 Modules\Xot\Filament\Pages\XotBasePage;
-       4 Modules\Xot\Traits\Updater;
-       2 Modules\Xot\Database\Migrations\XotBaseMigration;
-       2 Modules\Xot\Actions\GetViewAction;
-       1 Modules\Xot\View\Components\XotBaseComponent;
-       1 Modules\Xot\Providers\XotBaseServiceProvider;
-       1 Modules\Xot\Providers\XotBaseRouteServiceProvider;
-       1 Modules\Xot\Providers\XotBaseEventServiceProvider;
-       1 Modules\Xot\Providers\Filament\XotBasePanelProvider;
-       1 Modules\Xot\Filament\Widgets\EnvWidget;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)

