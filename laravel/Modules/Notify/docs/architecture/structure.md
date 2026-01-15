# Modulo Notify

Data: 2025-04-23 19:09:56

## Informazioni generali

- **Namespace principale**: Modules\\Notify
Modules\\Notify\\Database\\Factories
Modules\\Notify\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_notify_fila3
Marco Sottana
- **Dipendenze**: aws/aws-sdk-php * filament/filament * illuminate/contracts * illuminate/support * irazasyed/telegram-bot-sdk * kreait/laravel-firebase * laravel-notification-channels/fcm * laravel-notification-channels/telegram * phpdocumentor/type-resolver * symfony/http-client * symfony/postmark-mailer * repositories type path url ../Xot type path 
- **Totale file PHP**: 165
- **Totale classi/interfacce**: 73

## Struttura del modulo Notify

## Rotte Web

Il file `routes/web.php` di questo modulo è **intenzionalmente vuoto**, poiché:

1. **Backoffice**: utilizza interamente Filament per la gestione delle rotte e delle pagine di amministrazione.
2. **Frontoffice**: è gestito da **Volt + Folio**, pertanto non servono route web in Laravel.

> Vedi anche il file `Modules/Notify/routes/web.php` per commenti esplicativi.

## Regola sulle rotte (`routes/web.php`)

Il file `routes/web.php` del modulo Notify **deve essere vuoto**:
- **Backoffice**: tutte le funzionalità di gestione sono fornite tramite Filament, che registra le proprie rotte automaticamente e in modo isolato.
- **Frontoffice**: l'esposizione di funzionalità pubbliche avviene tramite Volt/Folio, che gestisce le proprie rotte e controller.

> **Non vanno mai aggiunte rotte custom in `Modules/Notify/routes/web.php`.**
>
> - Garantisce separazione tra backoffice (Filament) e frontoffice (Volt/Folio)
> - Evita conflitti, duplicazioni e problemi di sicurezza
> - Mantiene il modulo riutilizzabile e conforme alle best practice

**Collegamenti:**
- [database-mail.md](database-mail.md#regola-sulle-rotte)
- [grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)

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
.git/objects/11
.git/objects/12
.git/objects/13
.git/objects/14
.git/objects/16
.git/objects/17
.git/objects/19
.git/objects/1a
.git/objects/1c
.git/objects/1d
.git/objects/1e
.git/objects/1f
.git/objects/21
.git/objects/22
.git/objects/23
.git/objects/24
.git/objects/25
.git/objects/26
.git/objects/27
.git/objects/29
.git/objects/2a
.git/objects/2b
.git/objects/2c
.git/objects/2d
.git/objects/2f
.git/objects/30
.git/objects/31
.git/objects/32
.git/objects/33
.git/objects/34
.git/objects/35
.git/objects/36
.git/objects/37
.git/objects/39
.git/objects/3a
.git/objects/3b
.git/objects/3d
.git/objects/3e
.git/objects/3f
.git/objects/40
.git/objects/41
.git/objects/43
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
.git/objects/50
.git/objects/51
.git/objects/53
.git/objects/54
.git/objects/55
.git/objects/56
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
.git/objects/66
.git/objects/68
.git/objects/69
.git/objects/6d
.git/objects/6e
.git/objects/70
.git/objects/71
.git/objects/74
.git/objects/75
.git/objects/76
.git/objects/78
.git/objects/79
.git/objects/7a
.git/objects/7c
.git/objects/7f
.git/objects/80
.git/objects/81
.git/objects/82
.git/objects/83
.git/objects/87
.git/objects/8b
.git/objects/8c
.git/objects/8d
.git/objects/8e
.git/objects/8f
.git/objects/91
.git/objects/92
.git/objects/93
.git/objects/95
.git/objects/96
.git/objects/97
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
.git/objects/c0
.git/objects/c1
.git/objects/c3
.git/objects/c4
.git/objects/c5
.git/objects/c6
.git/objects/c8
.git/objects/c9
.git/objects/ca
.git/objects/cb
.git/objects/cc
.git/objects/cd
.git/objects/d0
.git/objects/d2
.git/objects/d4
.git/objects/d5
.git/objects/d7
.git/objects/d8
.git/objects/d9
.git/objects/da
.git/objects/db
.git/objects/dc
.git/objects/dd
.git/objects/de
.git/objects/df
.git/objects/e1
.git/objects/e2
.git/objects/e3
.git/objects/e4
.git/objects/e5
.git/objects/e6
.git/objects/e7
.git/objects/e8
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
.git/objects/fc
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
.github/workflows
.vscode
_docs
app
app/Actions
app/Actions/NotifyTheme
app/Actions/NotifyTheme/Attachment
app/Console
app/Console/Commands
app/Contracts
app/Datas
app/Emails
app/Enums
app/Filament
app/Filament/Auth
app/Filament/Clusters
app/Filament/Clusters/Test
app/Filament/Clusters/Test/Pages
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/ContactResource
app/Filament/Resources/ContactResource/Pages
app/Filament/Resources/NotificationLogResource
app/Filament/Resources/NotificationLogResource/Pages
app/Filament/Resources/NotificationResource
app/Filament/Resources/NotificationResource/Pages
app/Filament/Resources/NotifyThemeResource
app/Filament/Resources/NotifyThemeResource/Pages
app/Filament/Resources/NotifyThemeResource/RelationManagers
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Livewire/Auth
app/Http/Middleware
app/Http/Requests
app/Mail
app/Models
app/Models/Policies
app/Notifications
app/Notifications/Channels
app/Providers
app/Providers/Filament
app/Services
app/Services/MailEngines
app/View
app/View/Components
bashscripts
config
config/Config
config_old
database
database/factories
database/migrations
database/seeders
docs
docs/phpstan
lang
lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/css
resources/img
resources/img/ark
resources/img/minty
resources/img/sunny
resources/img/widgets
resources/scss
resources/svg
resources/views
resources/views/admin
resources/views/admin/dashboard
resources/views/admin/home
resources/views/admin/home/acts
resources/views/admin/index
resources/views/admin/index/acts
resources/views/components
resources/views/components/mail
resources/views/emails
resources/views/emails/appointments
resources/views/emails/samples
resources/views/emails/templates
resources/views/emails/templates/ark
resources/views/emails/templates/minty
resources/views/emails/templates/sunny
resources/views/emails/templates/widgets
resources/views/filament
resources/views/filament/clusters
resources/views/filament/clusters/test
resources/views/filament/clusters/test/pages
resources/views/filament/pages
resources/views/layouts
resources/views/livewire
resources/views/notifications
routes
tests
tests/Feature
tests/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Notify\\": "app/",
            "Modules\\Notify\\Database\\Factories\\": "database/factories/",
            "Modules\\Notify\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "require": {
        "aws/aws-sdk-php": "*",
        "filament/filament": "*",
        "illuminate/contracts": "*",
        "illuminate/support": "*",
        "irazasyed/telegram-bot-sdk": "*",
        "kreait/laravel-firebase": "*",
        "laravel-notification-channels/fcm": "*",
        "laravel-notification-channels/telegram": "*",
--
        "post-autoload-dump1": [
            "@php vendor/bin/testbench package:discover --ansi"
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

-       6 Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;
-       4 Modules\Xot\Datas\XotData;
-       4 Modules\Xot\Database\Migrations\XotBaseMigration;
-       3 Modules\Xot\Traits\Updater;
-       3 Modules\Xot\Filament\Traits\NavigationLabelTrait;
-       3 Modules\Xot\Filament\Resources\XotBaseResource;
-       3 Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
-       3 Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
-       3 Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
-       2 Modules\Dental\Models\Appointment;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)

---

## Collegamenti correlati
- [Regola sulle rotte vuote in database-mail.md](database-mail.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)
### Versione HEAD


### Versione Incoming


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


---

