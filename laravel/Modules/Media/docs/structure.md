# Modulo Media

Data: 2025-04-23 19:09:56

## Informazioni generali

- **Namespace principale**: Modules\\Media
Modules\\Media\\Database\\Factories
Modules\\Media\\Database\\Seeders
Modules\\Media\\Tests
- **Pacchetto Composer**: laraxot/module_media_fila3
Marco Sottana
- **Dipendenze**: php ^8.2 pbmedia/laravel-ffmpeg ^8.5 intervention/image * repositories type path url ../User type path url ../Tenant type path url ../UI type path 
- **Totale file PHP**: 97
- **Totale classi/interfacce**: 64

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
.git/objects/0a
.git/objects/0b
.git/objects/0c
.git/objects/0d
.git/objects/0e
.git/objects/10
.git/objects/11
.git/objects/12
.git/objects/13
.git/objects/14
.git/objects/15
.git/objects/16
.git/objects/17
.git/objects/19
.git/objects/1a
.git/objects/1b
.git/objects/1c
.git/objects/1d
.git/objects/1f
.git/objects/20
.git/objects/21
.git/objects/22
.git/objects/24
.git/objects/26
.git/objects/27
.git/objects/28
.git/objects/29
.git/objects/2b
.git/objects/2c
.git/objects/2e
.git/objects/31
.git/objects/32
.git/objects/33
.git/objects/34
.git/objects/35
.git/objects/38
.git/objects/39
.git/objects/3b
.git/objects/3c
.git/objects/3e
.git/objects/3f
.git/objects/41
.git/objects/42
.git/objects/43
.git/objects/45
.git/objects/47
.git/objects/48
.git/objects/49
.git/objects/4a
.git/objects/4b
.git/objects/4c
.git/objects/4e
.git/objects/4f
.git/objects/51
.git/objects/52
.git/objects/54
.git/objects/57
.git/objects/59
.git/objects/5b
.git/objects/5c
.git/objects/5d
.git/objects/5e
.git/objects/5f
.git/objects/60
.git/objects/62
.git/objects/63
.git/objects/65
.git/objects/66
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
.git/objects/74
.git/objects/75
.git/objects/76
.git/objects/79
.git/objects/7b
.git/objects/7d
.git/objects/7e
.git/objects/7f
.git/objects/80
.git/objects/81
.git/objects/82
.git/objects/87
.git/objects/88
.git/objects/89
.git/objects/8a
.git/objects/8b
.git/objects/8d
.git/objects/8e
.git/objects/8f
.git/objects/90
.git/objects/91
.git/objects/92
.git/objects/94
.git/objects/95
.git/objects/98
.git/objects/99
.git/objects/9a
.git/objects/9b
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
.git/objects/ae
.git/objects/af
.git/objects/b1
.git/objects/b2
.git/objects/b3
.git/objects/b5
.git/objects/b6
.git/objects/b7
.git/objects/b9
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
.git/objects/ca
.git/objects/cd
.git/objects/cf
.git/objects/d0
.git/objects/d1
.git/objects/d2
.git/objects/d4
.git/objects/d5
.git/objects/d6
.git/objects/d7
.git/objects/d8
.git/objects/d9
.git/objects/db
.git/objects/dc
.git/objects/e0
.git/objects/e1
.git/objects/e2
.git/objects/e4
.git/objects/e5
.git/objects/e6
.git/objects/e8
.git/objects/e9
.git/objects/ea
.git/objects/eb
.git/objects/ed
.git/objects/ee
.git/objects/ef
.git/objects/f0
.git/objects/f1
.git/objects/f3
.git/objects/f4
.git/objects/f5
.git/objects/f6
.git/objects/f7
.git/objects/f8
.git/objects/f9
.git/objects/fa
.git/objects/fb
.git/objects/fd
.git/objects/ff
.git/objects/info
.git/objects/pack
.git/refs
.git/refs/heads
.git/refs/remotes
.git/refs/remotes/aurmich
.git/refs/tags
View
View/Components
_docs
app
app/Actions
app/Actions/Image
app/Actions/Video
app/Console
app/Console/Commands
app/Contracts
app/Conversions
app/Conversions/ImageGenerators
app/Conversions/VideoGenerators
app/Datas
app/Enums
app/Exceptions
app/Filament
app/Filament/Actions
app/Filament/Actions/Table
app/Filament/Infolists
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/HasMediaResource
app/Filament/Resources/HasMediaResource/Actions
app/Filament/Resources/HasMediaResource/Pages
app/Filament/Resources/HasMediaResource/RelationManagers
app/Filament/Resources/MediaConvertResource
app/Filament/Resources/MediaConvertResource/Pages
app/Filament/Resources/MediaResource
app/Filament/Resources/MediaResource/Pages
app/Filament/Resources/MediaResource/Widgets
app/Filament/Resources/TemporaryUploadResource
app/Filament/Resources/TemporaryUploadResource/Pages
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Livewire/Card
app/Http/Livewire/Card/Video
app/Http/Middleware
app/Http/Requests
app/Models
app/Providers
app/Providers/Filament
app/Rules
app/Services
app/Support
app/View
app/View/Components
app/View/View
app/View/View/Components
app_old
app_old/Enums
app_old/Filament
app_old/Filament/Resources
app_old/Filament/Resources/HasMediaResource
app_old/Filament/Resources/HasMediaResource/RelationManagers
app_old/Filament/Resources/MediaConvertResource
app_old/Filament/Resources/MediaConvertResource/Pages
app_old/Filament/Resources/MediaResource
app_old/Filament/Resources/MediaResource/Pages
app_old/Filament/Resources/TemporaryUploadResource
app_old/Filament/Resources/TemporaryUploadResource/Pages
config
config_old
database
database/factories
database/migrations
database/seeders
database_old
database_old/factories
database_old/migrations
database_old/seeders
docs
docs/actions
docs/archived
docs/contracts
docs/filament
docs/filament/relation-managers
docs/performance
docs/phpstan
docs/relation_managers
docs/resources
docs/support
lang
lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/svg
resources/views
resources/views/components
resources/views/filament
resources/views/filament/infolists
resources/views/filament/pages
resources/views/filament/widgets
resources/views/layouts
resources_old
resources_old/assets
resources_old/assets/js
resources_old/assets/sass
resources_old/svg
resources_old/views
resources_old/views/filament
resources_old/views/filament/infolists
resources_old/views/filament/pages
resources_old/views/filament/widgets
resources_old/views/layouts
routes
routes_old
tests
tests/Feature
tests/Filament
tests/Filament/Resources
tests/Unit
tests_old
tests_old/Feature
tests_old/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Media\\": "app/",
            "Modules\\Media\\Database\\Factories\\": "database/factories/",
            "Modules\\Media\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Modules\\Media\\Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump1": "@php ./vendor/bin/testbench package:discover --ansi",
        "analyse": "vendor/bin/phpstan analyse",
        "test": "vendor/bin/pest",
        "test-coverage": "vendor/bin/pest --coverage",
        "format": "vendor/bin/pint"
    },
    "minimum-stability": "dev",
    "prefer-stable": true,
    "config": {
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "wikimedia/composer-merge-plugin": true
        }
    }
}
```

## Dipendenze da altri moduli

-       6 Modules\Xot\Database\Migrations\XotBaseMigration;
-       4 Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
-       3 Modules\Xot\Filament\Resources\XotBaseResource;
-       3 Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
-       3 Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
-       2 Modules\Xot\Traits\Updater;
-       2 Modules\Xot\Filament\Traits\NavigationLabelTrait;
-       2 Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;
-       2 Modules\Xot\Actions\GetViewAction;
-       1 Modules\Xot\Providers\XotBaseServiceProvider;

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

