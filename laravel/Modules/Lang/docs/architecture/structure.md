# Modulo Lang

Data: 2025-04-23 19:09:56

## Informazioni generali

- **Namespace principale**: Modules\\Lang
Modules\\Lang\\Database\\Factories
Modules\\Lang\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_lang_fila3
Marco Sottana
- **Dipendenze**: mcamara/laravel-localization ^2.2 spatie/laravel-sluggable * repositories type path url ../Xot type path url ../Tenant type path url ../UI autoload psr-4 
- **Totale file PHP**: 103
- **Totale classi/interfacce**: 50

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
.git/objects/06
.git/objects/08
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
.git/objects/1c
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
.git/objects/2c
.git/objects/2d
.git/objects/2e
.git/objects/2f
.git/objects/31
.git/objects/32
.git/objects/33
.git/objects/34
.git/objects/35
.git/objects/36
.git/objects/37
.git/objects/38
.git/objects/39
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
.git/objects/4d
.git/objects/4e
.git/objects/4f
.git/objects/50
.git/objects/51
.git/objects/53
.git/objects/56
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
.git/objects/64
.git/objects/65
.git/objects/67
.git/objects/68
.git/objects/6a
.git/objects/6b
.git/objects/6c
.git/objects/6e
.git/objects/6f
.git/objects/70
.git/objects/71
.git/objects/72
.git/objects/73
.git/objects/75
.git/objects/76
.git/objects/77
.git/objects/78
.git/objects/79
.git/objects/7a
.git/objects/7b
.git/objects/7c
.git/objects/7d
.git/objects/7e
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
.git/objects/94
.git/objects/95
.git/objects/96
.git/objects/97
.git/objects/98
.git/objects/99
.git/objects/9a
.git/objects/9b
.git/objects/9c
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
.git/objects/cf
.git/objects/d0
.git/objects/d1
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
.git/objects/f4
.git/objects/f5
.git/objects/f6
.git/objects/f7
.git/objects/f8
.git/objects/f9
.git/objects/fa
.git/objects/fb
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
Database_old
Database_old/Migrations
Lang_old
Lang_old/.github
Lang_old/.github/ISSUE_TEMPLATE
Lang_old/.github/workflows
Lang_old/.vscode
Lang_old/View
Lang_old/View/Components
Lang_old/_docs
Lang_old/app
Lang_old/app/Actions
Lang_old/app/Actions/Filament
Lang_old/app/Casts
Lang_old/app/Console
Lang_old/app/Console/Commands
Lang_old/app/Datas
Lang_old/app/Filament
Lang_old/app/Filament/Forms
Lang_old/app/Filament/Forms/Components
Lang_old/app/Filament/Pages
Lang_old/app/Http
Lang_old/app/Http/Controllers
Lang_old/app/Http/Livewire
Lang_old/app/Http/Livewire/Lang
Lang_old/app/Http/Middleware
Lang_old/app/Http/Requests
Lang_old/app/Models
Lang_old/app/Models/Contracts
Lang_old/app/Models/Traits
Lang_old/app/Models/Traits/Extras
Lang_old/app/Models/Traits/Mutators
Lang_old/app/Models/Traits/Relationships
Lang_old/app/Models/Traits/Scopes
Lang_old/app/Providers
Lang_old/app/Providers/Filament
Lang_old/app/Providers/Traits
Lang_old/app/Services
Lang_old/app/View
Lang_old/app/View/Components
Lang_old/app/View/Composers
Lang_old/bashscripts
Lang_old/config
Lang_old/database
Lang_old/database/factories
Lang_old/database/migrations
Lang_old/database/seeders
Lang_old/docs
Lang_old/docs/.github
Lang_old/docs/.github/workflows
Lang_old/docs/performance
Lang_old/lang
Lang_old/lang/it
Lang_old/lang/lang
Lang_old/lang/lang/it
Lang_old/resources
Lang_old/resources/assets
Lang_old/resources/assets/js
Lang_old/resources/assets/sass
Lang_old/resources/css
Lang_old/resources/img
Lang_old/resources/js
Lang_old/resources/lang
Lang_old/resources/lang/it
Lang_old/resources/svg
Lang_old/resources/svg/flag
Lang_old/resources/views
Lang_old/resources/views/admin
Lang_old/resources/views/admin/dashboard
Lang_old/resources/views/components
Lang_old/resources/views/filament
Lang_old/resources/views/filament/pages
Lang_old/resources/views/layouts
Lang_old/resources/views/livewire
Lang_old/resources/views/livewire/lang
Lang_old/resources_old
Lang_old/routes
Lang_old/tests
Lang_old/tests/Feature
Lang_old/tests/Unit
View
View/Components
_docs
app
app/Actions
app/Actions/Filament
app/Casts
app/Console
app/Console/Commands
app/Datas
app/Filament
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Pages
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Livewire/Lang
app/Http/Middleware
app/Http/Requests
app/Models
app/Models/Contracts
app/Models/Traits
app/Models/Traits/Extras
app/Models/Traits/Mutators
app/Models/Traits/Relationships
app/Models/Traits/Scopes
app/Providers
app/Providers/Filament
app/Providers/Traits
app/Services
app/View
app/View/Components
app/View/Composers
bashscripts
config
database
database/factories
database/migrations
database/seeders
docs
docs/.github
docs/.github/workflows
docs/conflicts
docs/packages
docs/performance
docs/phpstan
lang
lang/it
lang/lang
lang/lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/css
resources/img
resources/js
resources/lang
resources/lang/it
resources/svg
resources/svg/flag
resources/views
resources/views/admin
resources/views/admin/dashboard
resources/views/components
resources/views/filament
resources/views/filament/pages
resources/views/layouts
resources/views/livewire
resources/views/livewire/lang
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
            "Modules\\Lang\\": "app/",
            "Modules\\Lang\\Database\\Factories\\": "database/factories/",
            "Modules\\Lang\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "scripts": {
        "post-autoload-dump": [],
        "post-update-cmd": [],
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "phpstan/extension-installer": true,
            "pestphp/pest-plugin": true
        }
    },
    "extra": {
        "laravel": {
```

## Dipendenze da altri moduli

-       8 Modules\Xot\Traits\Updater;
-       4 Modules\Xot\Actions\Factory\GetFactoryAction;
-       4 Modules\Xot\Actions\Array\SaveArrayAction;
-       2 Modules\Xot\Services\BladeService;
-       2 Modules\Xot\Providers\XotBaseServiceProvider;
-       2 Modules\Xot\Providers\XotBaseRouteServiceProvider;
-       2 Modules\Xot\Providers\Filament\XotBasePanelProvider;
-       2 Modules\Xot\Actions\GetViewAction;
-       2 Modules\Xot\Actions\GetTransKeyAction;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)


## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](../../../Gdpr/docs/structure.md)
* [structure.md](../../../Notify/docs/structure.md)
* [structure.md](../../../Xot/docs/structure.md)
* [structure.md](../../../Xot/docs/base/structure.md)
* [structure.md](../../../Xot/docs/config/structure.md)
* [structure.md](../../../User/docs/structure.md)
* [structure.md](../../../UI/docs/structure.md)
* [structure.md](../../../Lang/docs/structure.md)
* [structure.md](../../../Job/docs/structure.md)
* [structure.md](../../../Media/docs/structure.md)
* [structure.md](../../../Tenant/docs/structure.md)
* [structure.md](../../../Activity/docs/structure.md)
* [structure.md](../../../Cms/docs/structure.md)
* [structure.md](../../../Cms/docs/themes/structure.md)
* [structure.md](../../../Cms/docs/components/structure.md)

## Struttura della Registrazione dei Console Commands

- Tutti i comandi console sono autoregistrati tramite la struttura di XotBaseServiceProvider.
- Non aggiungere mai manualmente $this->commands([...]) nei provider.
- Perché? Vedi [lang-service-provider.md](./lang-service-provider.md) e [PHILOSOPHY.md](./PHILOSOPHY.md)

