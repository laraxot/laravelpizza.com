# Modulo User

Data: 2025-04-23 19:09:56
## Informazioni generali
- **Namespace principale**: Modules\\User
Modules\\User\\Database\\Factories
Modules\\User\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_user_fila3
Marco Sottana
- **Dipendenze**: flowframe/laravel-trend * jenssegers/agent * laravel/passport * socialiteproviders/auth0 * spatie/laravel-personal-data-export * repositories type path url ../Xot type path url ../Tenant type path url ../UI
- **Totale file PHP**: 673
- **Totale classi/interfacce**: 300
## Struttura delle directory
```
.devcontainer
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
.git/objects/3e
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
.git/objects/68
.git/objects/69
.git/objects/6a
.git/objects/6b
.git/objects/6c
.git/objects/6d
.git/objects/6e
.git/objects/6f
.git/objects/70
.git/objects/71
.git/objects/72
.git/objects/73
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
.git/objects/ae
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
.github/workflows
.vscode
_docs
app
app/Actions
app/Actions/Otp
app/Actions/Socialite
app/Actions/Socialite/Utils
app/Console
app/Console/Commands
app/Contracts
app/Datas
app/Enums
app/Enums/Enums
app/Events
app/Exceptions
app/Facades
app/Filament
app/Filament/Actions
app/Filament/Actions/Profile
app/Filament/Clusters
app/Filament/Clusters/Appearance
app/Filament/Clusters/Appearance/Pages
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Pages
app/Filament/Pages/Auth
app/Filament/Pages/Tenancy
app/Filament/Resources
app/Filament/Resources/BaseProfileResource
app/Filament/Resources/BaseProfileResource/Pages
app/Filament/Resources/DeviceResource
app/Filament/Resources/DeviceResource/Pages
app/Filament/Resources/DeviceResource/RelationManagers
app/Filament/Resources/FeatureResource
app/Filament/Resources/FeatureResource/Pages
app/Filament/Resources/PermissionResource
app/Filament/Resources/PermissionResource/Pages
app/Filament/Resources/PermissionResource/RelationManager
app/Filament/Resources/ProfileResource
app/Filament/Resources/ProfileResource/Pages
app/Filament/Resources/RoleResource
app/Filament/Resources/RoleResource/Pages
app/Filament/Resources/RoleResource/RelationManagers
app/Filament/Resources/SocialProviderResource
app/Filament/Resources/SocialProviderResource/Pages
app/Filament/Resources/TeamResource
app/Filament/Resources/TeamResource/Pages
app/Filament/Resources/TeamResource/RelationManagers
app/Filament/Resources/TenantResource
app/Filament/Resources/TenantResource/Pages
app/Filament/Resources/TenantResource/RelationManagers
app/Filament/Resources/UserResource
app/Filament/Resources/UserResource/Actions
app/Filament/Resources/UserResource/Pages
app/Filament/Resources/UserResource/RelationManagers
app/Filament/Resources/UserResource/Widgets
app/Filament/Traits
app/Filament/Widgets
app/Filament/Widgets/Auth
app/Http
app/Http/Controllers
app/Http/Controllers/Api
app/Http/Controllers/Auth
app/Http/Controllers/Socialite
app/Http/Livewire
app/Http/Livewire/Auth
app/Http/Livewire/Auth/Passwords
app/Http/Livewire/Modals
app/Http/Livewire/Profile
app/Http/Livewire/Socialite
app/Http/Livewire/Team
app/Http/Middleware
app/Http/Requests
app/Http/Response
app/Listeners
app/Listeners/Auth
app/Livewire
app/Mail
app/Models
app/Models/Models
app/Models/Policies
app/Models/Scopes
app/Models/Traits
app/Notifications
app/Notifications/Auth
app/Providers
app/Providers/Filament
app/Rules
app/Support
app/Traits
app/View
app/View/Components
app/View/Components/Mail
app/View/View
app/View/View/Components
app_old
config
config_old
database
database/factories
database/migrations
database/seeders
database_old
docs
docs/Contracts
docs/Models
docs/OAuth
docs/database
docs/database/migrations
docs/fixes
docs/img
docs/lang
docs/lang/en
docs/phpstan
docs/roadmap
docs/roadmap/features
docs/traits
lang
lang/ar
lang/cs
lang/de
lang/el
lang/en
lang/es
lang/fa
lang/fi
lang/fr
lang/he
lang/hu
lang/id
lang/it
lang/ja
lang/ko
lang/lang
lang/lang/ar
lang/lang/cs
lang/lang/de
lang/lang/el
lang/lang/en
lang/lang/es
lang/lang/fa
lang/lang/fi
lang/lang/fr
lang/lang/he
lang/lang/hu
lang/lang/id
lang/lang/it
lang/lang/ja
lang/lang/ko
lang/lang/ms
lang/lang/nl
lang/lang/pl
lang/lang/pt_BR
lang/lang/pt_PT
lang/lang/ro
lang/lang/ru
lang/lang/sk
lang/lang/sl
lang/lang/sq
lang/lang/tr
lang/lang/uk
lang/lang/vi
lang/lang/zh_TW
lang/ms
lang/nl
lang/pl
lang/pt_BR
lang/pt_PT
lang/ro
lang/ru
lang/sk
lang/sl
lang/sq
lang/tr
lang/uk
lang/vi
lang/zh_TW
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/css
resources/dist
resources/dist/assets
resources/img
resources/js
resources/js/components
resources/svg
resources/svg/navigation
resources/views
resources/views/Http
resources/views/Http/Livewire
resources/views/assets
resources/views/assets/css
resources/views/assets/js
resources/views/auth
resources/views/badges
resources/views/components
resources/views/components/blocks
resources/views/components/blocks/booking_form
resources/views/components/blocks/cta
resources/views/components/blocks/faq_accordion
resources/views/components/blocks/feature_sections
resources/views/components/blocks/footer
resources/views/components/blocks/hero
resources/views/components/blocks/paragraph
resources/views/components/blocks/sidebar
resources/views/components/blocks/testimonial_carousel
resources/views/components/layouts
resources/views/components/mail
resources/views/components/mail/html
resources/views/components/mail/html/themes
resources/views/components/mail/text
resources/views/components/ui
resources/views/components/ui/app
resources/views/components/ui/marketing
resources/views/config
resources/views/emails
resources/views/filament
resources/views/filament/auth
resources/views/filament/auth/pages
resources/views/filament/clusters
resources/views/filament/clusters/appearance
resources/views/filament/clusters/appearance/pages
resources/views/filament/layouts
resources/views/filament/pages
resources/views/filament/resources
resources/views/filament/resources/user-resource
resources/views/filament/resources/user-resource/widgets
resources/views/filament/widgets
resources/views/layouts
resources/views/livewire
resources/views/livewire/auth
resources/views/livewire/auth/passwords
resources/views/livewire/modals
resources/views/livewire/profile
resources/views/livewire/socialite
resources/views/livewire/team
resources/views/notifications
resources/views/pages
resources/views/pages/auth
resources/views/pages/auth/password
resources/views/pages/dashboard
resources/views/pages/errors
resources/views/pages/genesis
resources/views/pages/learn
resources/views/pages/pages
resources/views/pages/profile
resources/views/resources
resources/views/resources/views
resources/views/routes
resources/views/widgets
resources/views/widgets/auth
resources_old
routes
routes_old
tests
tests/Feature
tests/Unit
tests_old
## Namespace e autoload
```json
    "autoload": {
        "psr-4": {
            "Modules\\User\\": "app/",
            "Modules\\User\\Database\\Factories\\": "database/factories/",
            "Modules\\User\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "require": {
        "flowframe/laravel-trend": "*",
        "jenssegers/agent": "*",
        "laravel/passport": "*",
        "socialiteproviders/auth0": "*",
        "spatie/laravel-personal-data-export": "*"
    "require-dev": {},
    "repositories": [
--
        "post-autoload-dump1": [
            "@php vendor/bin/testbench package:discover --ansi"
        ],
        "post-update-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate"
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "dealerdirect/phpcodesniffer-composer-installer": true,
## Dipendenze da altri moduli
-      58 Modules\Xot\Contracts\UserContract;
-      54 Modules\Xot\Datas\XotData;
-      43 Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;
-      25 Modules\Xot\Database\Migrations\XotBaseMigration;
-      10 Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
-      10 Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
-       9 Modules\Xot\Filament\Resources\XotBaseResource;
-       8 Modules\Xot\Contracts\ProfileContract;
-       6 Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
-       5 Modules\Tenant\Services\TenantService;
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
- [Analisi strutturale complessiva](/project_docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/project_docs/phpstan/)
* [structure.md](bashscripts/project_docs/structure.md)
* [structure.md](../../../Gdpr/project_docs/structure.md)
* [structure.md](../../../Notify/project_docs/structure.md)
* [structure.md](../../../Xot/project_docs/structure.md)
* [structure.md](../../../Xot/project_docs/base/structure.md)
* [structure.md](../../../Xot/project_docs/config/structure.md)
* [structure.md](../../../User/project_docs/structure.md)
* [structure.md](../../../UI/project_docs/structure.md)
* [structure.md](../../../Lang/project_docs/structure.md)
* [structure.md](../../../Job/project_docs/structure.md)
* [structure.md](../../../Media/project_docs/structure.md)
* [structure.md](../../../Tenant/project_docs/structure.md)
* [structure.md](../../../Activity/project_docs/structure.md)
* [structure.md](../../../Cms/project_docs/structure.md)
* [structure.md](../../../Cms/project_docs/themes/structure.md)
* [structure.md](../../../Cms/project_docs/components/structure.md)
