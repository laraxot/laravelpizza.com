# Modulo Gdpr

Data: 2025-04-23 19:09:55

## Informazioni generali

- **Namespace principale**: Modules\\Gdpr
Modules\\Gdpr\\Database\\Factories
Modules\\Gdpr\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_gdpr_fila3
Marco Sottana
- **Dipendenze**: statikbe/laravel-cookie-consent * repositories type path url ../Xot type path url ../Tenant type path url ../UI scripts post-autoload-dump1 @php artisan vendor:publish --provider='Statikbe\\CookieConsent\\CookieConsentServiceProvider' --tag='cookie-public' 
- **Totale file PHP**: 68
- **Totale classi/interfacce**: 43

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
.git/objects/01
.git/objects/04
.git/objects/05
.git/objects/06
.git/objects/07
.git/objects/08
.git/objects/09
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
.git/objects/1b
.git/objects/1c
.git/objects/1d
.git/objects/21
.git/objects/23
.git/objects/24
.git/objects/26
.git/objects/27
.git/objects/29
.git/objects/2a
.git/objects/2b
.git/objects/2c
.git/objects/2e
.git/objects/2f
.git/objects/30
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
.git/objects/3d
.git/objects/3e
.git/objects/3f
.git/objects/40
.git/objects/41
.git/objects/42
.git/objects/43
.git/objects/45
.git/objects/48
.git/objects/4a
.git/objects/4b
.git/objects/4c
.git/objects/4d
.git/objects/4e
.git/objects/4f
.git/objects/50
.git/objects/51
.git/objects/52
.git/objects/54
.git/objects/55
.git/objects/56
.git/objects/57
.git/objects/59
.git/objects/5a
.git/objects/5d
.git/objects/5e
.git/objects/5f
.git/objects/60
.git/objects/61
.git/objects/66
.git/objects/69
.git/objects/6b
.git/objects/6c
.git/objects/6f
.git/objects/71
.git/objects/72
.git/objects/74
.git/objects/75
.git/objects/76
.git/objects/77
.git/objects/78
.git/objects/7a
.git/objects/7b
.git/objects/7c
.git/objects/7d
.git/objects/7f
.git/objects/80
.git/objects/81
.git/objects/82
.git/objects/84
.git/objects/85
.git/objects/86
.git/objects/87
.git/objects/88
.git/objects/89
.git/objects/8a
.git/objects/8b
.git/objects/8c
.git/objects/8e
.git/objects/8f
.git/objects/91
.git/objects/92
.git/objects/93
.git/objects/96
.git/objects/97
.git/objects/98
.git/objects/9a
.git/objects/9b
.git/objects/9c
.git/objects/9d
.git/objects/9e
.git/objects/a1
.git/objects/a2
.git/objects/a4
.git/objects/a5
.git/objects/a6
.git/objects/a7
.git/objects/a8
.git/objects/a9
.git/objects/ab
.git/objects/ac
.git/objects/ae
.git/objects/b1
.git/objects/b2
.git/objects/b4
.git/objects/b6
.git/objects/b8
.git/objects/b9
.git/objects/bb
.git/objects/bc
.git/objects/bf
.git/objects/c1
.git/objects/c2
.git/objects/c4
.git/objects/c7
.git/objects/c8
.git/objects/c9
.git/objects/cb
.git/objects/cc
.git/objects/cd
.git/objects/d0
.git/objects/d1
.git/objects/d3
.git/objects/d4
.git/objects/d5
.git/objects/d6
.git/objects/d8
.git/objects/d9
.git/objects/da
.git/objects/db
.git/objects/df
.git/objects/e1
.git/objects/e3
.git/objects/e4
.git/objects/e6
.git/objects/e7
.git/objects/e8
.git/objects/e9
.git/objects/ed
.git/objects/ee
.git/objects/ef
.git/objects/f0
.git/objects/f1
.git/objects/f2
.git/objects/f4
.git/objects/f5
.git/objects/f6
.git/objects/f9
.git/objects/fa
.git/objects/fb
.git/objects/fd
.git/objects/fe
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
app
app/Console
app/Console/Commands
app/Enums
app/Filament
app/Filament/Clusters
app/Filament/Clusters/Profile
app/Filament/Clusters/Profile/Resources
app/Filament/Clusters/Profile/Resources/ConsentResource
app/Filament/Clusters/Profile/Resources/ConsentResource/Pages
app/Filament/Clusters/Profile/Resources/ProfileResource
app/Filament/Clusters/Profile/Resources/ProfileResource/Pages
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/ConsentResource
app/Filament/Resources/ConsentResource/Pages
app/Filament/Resources/EventResource
app/Filament/Resources/EventResource/Pages
app/Filament/Resources/ProfileResource
app/Filament/Resources/ProfileResource/Pages
app/Filament/Resources/TreatmentResource
app/Filament/Resources/TreatmentResource/Pages
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Middleware
app/Http/Requests
app/Models
app/Providers
app/Providers/Filament
app/View
app/View/Components
config
database
database/factories
database/migrations
database/seeders
docs
docs/PHPStan
docs/packages
docs/performance
docs/phpstan
docs/roadmap
lang
lang/en
lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/img
resources/lang
resources/lang/it
resources/svg
resources/svg/navigation
resources/views
resources/views/components
resources/views/filament
resources/views/filament/pages
resources/views/layouts
routes
tests
tests/Feature
tests/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Gdpr\\": "app/",
            "Modules\\Gdpr\\Database\\Factories\\": "database/factories/",
            "Modules\\Gdpr\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "require": {
        "statikbe/laravel-cookie-consent": "*"
    },
    "require-dev": {},
    "repositories": [
        {
            "type": "path",
            "url": "../Xot"
        },
--
        "post-autoload-dump1": [
            "@php artisan vendor:publish --provider='Statikbe\\CookieConsent\\CookieConsentServiceProvider' --tag='cookie-public'"
        ],
        "post-update-cmd": [
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
            "pestphp/pest-plugin": true,
            "dealerdirect/phpcodesniffer-composer-installer": true,
```

## Dipendenze da altri moduli

-       6 Modules\Xot\Filament\Resources\XotBaseResource;
-       4 Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
-       3 Modules\Xot\Traits\Updater;
-       3 Modules\Xot\Database\Migrations\XotBaseMigration;
-       3 Modules\Xot\Contracts\ProfileContract;
-       2 Modules\User\Filament\Resources\BaseProfileResource\Pages\ListProfiles as UserListProfiles;
-       1 Modules\Xot\Providers\XotBaseServiceProvider;
-       1 Modules\Xot\Providers\XotBaseRouteServiceProvider;
-       1 Modules\Xot\Providers\Filament\XotBasePanelProvider;
-       1 Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)


## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](laravel/Modules/Gdpr/docs/structure.md)
* [structure.md](laravel/Modules/Notify/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/base/structure.md)
* [structure.md](laravel/Modules/Xot/docs/config/structure.md)
* [structure.md](laravel/Modules/User/docs/structure.md)
* [structure.md](laravel/Modules/UI/docs/structure.md)
* [structure.md](laravel/Modules/Lang/docs/structure.md)
* [structure.md](laravel/Modules/Job/docs/structure.md)
* [structure.md](laravel/Modules/Media/docs/structure.md)
* [structure.md](laravel/Modules/Tenant/docs/structure.md)
* [structure.md](laravel/Modules/Activity/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/themes/structure.md)
* [structure.md](laravel/Modules/Cms/docs/components/structure.md)

