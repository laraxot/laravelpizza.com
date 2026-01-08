### Versione HEAD

# Analisi della Discrepanza tra Namespace e Struttura Directory nei Moduli Laraxot

## Problema Identificato

È stata identificata una discrepanza critica tra i namespace dichiarati nei file PHP, la configurazione di autoloading in `composer.json` e la struttura fisica delle directory nei moduli Laraxot. Questa discrepanza causa problemi di autoloading delle classi nel progetto il progetto.

## Analisi del Modulo Chart

### Struttura Directory
Il modulo Chart ha la seguente struttura di directory:
```
Modules/Chart/
  ├── app/
  │   ├── Actions/
  │   ├── Console/
  │   ├── Datas/
  │   ├── Entities/
  │   ├── Enums/
  │   ├── Filament/
  │   ├── Http/
  │   ├── Models/
  │   ├── Providers/
  │   ├── Tables/
  │   └── View/
  ├── composer.json
  └── ...
```

### Configurazione Autoload in composer.json
Nel file `composer.json` del modulo Chart:
```json
"autoload": {
    "psr-4": {
        "Modules\\Chart\\": "app/"
    }
}
```

Questa configurazione indica che il namespace `Modules\Chart\` corrisponde alla directory `app/`.

### Namespace nei File PHP
Tuttavia, i file PHP nel modulo Chart utilizzano namespace diversi:

1. **Namespace con `App` nel percorso**:
   ```php
   namespace Modules\Chart\App\Providers;
   ```
   Esempio: `ChartServiceProvider.php`, `RouteServiceProvider.php`

2. **Namespace senza `App` nel percorso**:
   ```php
   namespace Modules\Chart\Actions\Chart;
   namespace Modules\Chart\Datas;
   ```
   Esempio: `GetTypeOptions.php`, `ChartData.php`

## Impatto del Problema

Questa discrepanza causa diversi problemi:

1. **Class not found errors**: Il sistema non può trovare classi che utilizzano un namespace non conforme alla mappatura di autoloading.
2. **Caricamento imprevedibile delle classi**: Alcune classi potrebbero essere caricate correttamente mentre altre no, a seconda del namespace utilizzato.
3. **Conflitti con altri pacchetti**: Questo potrebbe interferire con il pacchetto `nwidart/laravel-modules` che ha la sua convenzione di namespace.
4. **Difficoltà nella manutenzione**: La mancanza di coerenza rende più difficile la comprensione e la manutenzione del codice.

## Possibili Cause

1. **Migrazione da una struttura legacy**: Il progetto potrebbe essere stato migrato da una struttura di namespace precedente.
2. **Confusione tra convenzioni Laravel e regole PSR-4**: Laravel ha convenzioni specifiche per i namespace, che potrebbero essere state fraintese.
3. **Pacchetti originali vs fork**: Potrebbe esserci confusione tra la struttura del pacchetto originale e un fork personalizzato.
4. **Modifiche manuali inconsistenti**: Modifiche manuali ai namespace senza aggiornare la configurazione di autoloading.

## Soluzioni Raccomandate

Abbiamo due opzioni principali:

### 1. Modifica dei Namespace nei File PHP (Raccomandato)

Modificare tutti i file PHP che contengono `namespace Modules\Chart\App\...` per rimuovere il segmento `App\` e utilizzare invece `namespace Modules\Chart\...`.

Esempio:
```php
// Da
namespace Modules\Chart\App\Providers;

// A
namespace Modules\Chart\Providers;
```

**Vantaggi**:
- Rende i namespace conformi alla configurazione PSR-4 in composer.json
- Non richiede modifiche alla struttura fisica delle directory
- Mantiene la compatibilità con il resto del progetto
- Più allineato con gli standard PSR-4

### 2. Modifica della Configurazione di Autoload

Modificare il composer.json per aggiungere un mapping esplicito per i namespace con `App`:

```json
"autoload": {
    "psr-4": {
        "Modules\\Chart\\": "app/",
        "Modules\\Chart\\App\\": "app/"
    }
}
```

**Svantaggi**:
- Introduce ridondanza nell'autoloading
- Non risolve l'inconsistenza fondamentale del sistema
- Potrebbe causare problemi con le classi che hanno lo stesso nome in namespace diversi

## Script di Automazione per la Soluzione 1

Si può utilizzare un script per automatizzare la modifica dei namespace nei file PHP:

```bash
#!/bin/bash

# Trova tutti i file PHP nel modulo Chart
find /var/www/html/<nome progetto>/laravel/Modules/Chart -type f -name "*.php" | while read file; do
    # Sostituisci namespace Modules\Chart\App\ con Modules\Chart\
    sed -i 's/namespace Modules\\\\Chart\\\\App\\\\/namespace Modules\\\\Chart\\\\/g' "$file"
    
    # Aggiorna anche gli use statement
    sed -i 's/use Modules\\\\Chart\\\\App\\\\/use Modules\\\\Chart\\\\/g' "$file"
    
    echo "Elaborato: $file"
done

# Ripeti lo stesso processo per gli altri moduli

# ...
```

## Test Prima dell'Implementazione

Prima di applicare queste modifiche in modo esteso, è consigliabile:

1. Eseguire la modifica su un singolo file come test
2. Verificare che il file modificato sia caricato correttamente
3. Controllare eventuali effetti collaterali, come dipendenze interne che potrebbero essere interrotte
4. Implementare la modifica in modo incrementale, modulo per modulo

## Impatto sul Roadmap del Progetto

La risoluzione di questa discrepanza è cruciale per:

1. Risolvere i problemi di autoloading attuali
2. Consentire la corretta integrazione con Filament
3. Assicurare il caricamento coerente di classi tra diversi moduli
4. Stabilire una base solida per lo sviluppo futuro

Si stima che la correzione di questa discrepanza risolverà circa il 70% dei problemi di autoloading attualmente riscontrati nel progetto.

## Conclusione

La discrepanza tra i namespace dichiarati e la struttura delle directory nei moduli Laraxot è un problema significativo che deve essere risolto per procedere con successo nello sviluppo del progetto il progetto. La soluzione raccomandata è di standardizzare i namespace nei file PHP per conformarsi alla mappatura PSR-4 specificata nei file composer.json dei moduli, rimuovendo il segmento "App" quando presente incorrettamente nel namespace.

# Struttura del Progetto

## Moduli
```
laravel/Modules/[Nome]/
├── app/
│   ├── Console/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   └── Services/
├── config/
├── database/
├── docs/
├── resources/
├── routes/
└── tests/
```

## Temi
```
laravel/Themes/[Nome]/
├── app/
│   ├── Console/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   └── Services/
├── config/
├── resources/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── views/
└── routes/
```

## Differenze Chiave
1. **Moduli**:
   - Hanno una struttura completa
   - Contengono logica di business
   - Possono avere database migrations
   - Hanno documentazione specifica

2. **Temi**:
   - Focus su presentazione
   - Struttura semplificata
   - No database migrations
   - Documentazione minima

## Regole per i Temi
1. **Struttura**:
   - Tutti i file PHP vanno in `app/`
   - I provider vanno in `app/Providers/`
   - Le viste vanno in `resources/views/`
   - Gli asset vanno in `resources/`

2. **Naming**:
   - Namespace: `Themes\[Nome]\`
   - Classi: `[Nome]ServiceProvider`
   - Viste: `theme::[nome].blade.php`

3. **Best Practices**:
   - Mantenere la struttura standard
   - Non modificare la gerarchia delle cartelle
   - Usare sempre percorsi relativi

### Versione HEAD

   - Documentare le personalizzazioni 

### Versione Incoming

   - Documentare le personalizzazioni 
   - Documentare le personalizzazioni 

### Versione Incoming


---

b6f667c (.)


# Struttura del Modulo Xot

## Struttura delle Directory

La struttura base del modulo deve seguire questo pattern:

```
Modules/Xot/
├── app/
│   ├── Exceptions/        # Tutte le eccezioni e i gestori di eccezioni vanno qui
│   │   ├── Handlers/     # Gestori di eccezioni personalizzati
│   │   ├── Formatters/   # Formattatori di eccezioni
│   │   └── ...          # Altre classi di eccezioni
│   ├── Providers/        # Service providers
│   └── ...              # Altri namespace
├── config/              # File di configurazione
├── database/           # Migrations, factories, seeders
├── resources/         # Views, lang, assets
└── tests/            # Test files
```

## Regole Importanti

1. **Posizione delle Eccezioni**
   - TUTTE le eccezioni e i gestori di eccezioni DEVONO essere posizionati in `app/Exceptions/`
   - NON posizionare mai le eccezioni in `Modules/Xot/Exceptions/`
   - Il namespace corretto è `Modules\Xot\Exceptions\*`

2. **Struttura dei Namespace**
   - Il namespace base è `Modules\Xot`
   - Le classi in `app/` mantengono lo stesso namespace senza includere "app" nel path
   - Esempio: Un file in `app/Exceptions/Handler.php` avrà namespace `Modules\Xot\Exceptions`

3. **Best Practices**
   - Mantenere una struttura di directory pulita e organizzata
   - Seguire le convenzioni di Laravel per la struttura delle directory

### Versione HEAD

   - Utilizzare i namespace appropriati che riflettono la struttura delle directory 

# Modulo Xot

Data: 2025-04-23 19:09:56

## Informazioni generali

- **Namespace principale**: Modules\\Xot
Modules\\Xot\\Database\\Factories
Modules\\Xot\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_xot_fila3
marco sottana
- **Dipendenze**: php ^8.2 calebporzio/sushi ^2.5 coolsam/panel-modules * doctrine/dbal * fidum/laravel-eloquent-morph-to-one * filament/filament ^3.3 filament/spatie-laravel-media-library-plugin ^3.2 filament/spatie-laravel-translatable-plugin ^3.2 aaronfrancis/fast-paginate * guzzlehttp/guzzle * laravel/folio ^1.1 laravel/framework * laravel/pennant ^1.11 laravel/pulse ^1.2 livewire/livewire * maatwebsite/excel ^3.1 nwidart/laravel-modules * predis/predis ^2.2 spatie/cpu-load-health-check ^1.0 spatie/laravel-data ^4.7 
- **Totale file PHP**: 968
- **Totale classi/interfacce**: 353

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
Console
Console/Commands
Helpers
Resources_old2
View
View/Components
app
app/Actions
app/Actions/Array
app/Actions/Blade
app/Actions/Class
app/Actions/Collection
app/Actions/Debug
app/Actions/Dummy
app/Actions/Export
app/Actions/Factory
app/Actions/Filament
app/Actions/Filament/Actions
app/Actions/Filament/Block
app/Actions/Filament/Filter
app/Actions/File
app/Actions/Generate
app/Actions/Import
app/Actions/Livewire
app/Actions/Mail
app/Actions/Model
app/Actions/Model/Store
app/Actions/Model/Update
app/Actions/ModelClass
app/Actions/Module
app/Actions/Panel
app/Actions/Pdf
app/Actions/Pdf/Engine
app/Actions/Query
app/Actions/String
app/Actions/Trans
app/Actions/Tree
app/Actions/View
app/Bus
app/Casts
app/Console
app/Console/Commands
app/Console/stubs
app/Console/stubs/panels
app/Console/stubs/policy
app/Contracts
app/DTOs
app/Datas
app/Enums
app/Events
app/Exceptions
app/Exceptions/Formatters
app/Exceptions/Handlers
app/Exports
app/Facades
app/Filament
app/Filament/Actions
app/Filament/Actions/Header
app/Filament/Actions/Table
app/Filament/Blocks
app/Filament/Clusters
app/Filament/Filters
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Infolists
app/Filament/Infolists/Components
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/CacheLockResource
app/Filament/Resources/CacheLockResource/Pages
app/Filament/Resources/CacheResource
app/Filament/Resources/CacheResource/Pages
app/Filament/Resources/ExtraResource
app/Filament/Resources/ExtraResource/Pages
app/Filament/Resources/LogResource
app/Filament/Resources/LogResource/Pages
app/Filament/Resources/ModuleResource
app/Filament/Resources/ModuleResource/Pages
app/Filament/Resources/Pages
app/Filament/Resources/RelationManagers
app/Filament/Resources/SessionResource
app/Filament/Resources/SessionResource/Pages
app/Filament/Resources/XotBaseResource
app/Filament/Resources/XotBaseResource/Pages
app/Filament/Resources/XotBaseResource/RelationManager
app/Filament/Resources/XotBaseResource/RelationManagers
app/Filament/Tables
app/Filament/Tables/Actions
app/Filament/Traits
app/Filament/Widgets
app/Helpers
app/Http
app/Http/Controllers
app/Http/Http
app/Http/Http/Controllers
app/Http/Livewire
app/Http/Middleware
app/Http/Requests
app/Jobs
app/Jobs/PanelCrud
app/Mail
app/Models
app/Models/Policies
app/Models/Traits
app/Parsers
app/Presenters
app/Providers
app/Providers/Filament
app/QueryFilters
app/Relations
app/Repositories
app/Resources
app/Resources/assets
app/Resources/assets/img
app/Resources/assets/img/backgrounds
app/Resources/assets/img/demo
app/Resources/assets/img/demo/cards
app/Resources/assets/img/illustrations
app/Resources/assets/img/illustrations/profiles
app/Resources/assets/js
app/Resources/assets/sass
app/Resources/css
app/Resources/img
app/Resources/img/logo
app/Resources/js
app/Resources/svg
app/Resources/views
app/Resources/views/acts
app/Resources/views/acts/artisan
app/Resources/views/admin
app/Resources/views/admin/acts
app/Resources/views/admin/home
app/Resources/views/admin/home/acts
app/Resources/views/admin/index
app/Resources/views/admin/index/acts
app/Resources/views/admin/standalone
app/Resources/views/admin/standalone/manage
app/Resources/views/admin/store
app/Resources/views/admin/store/acts
app/Resources/views/admin/store/acts/xls_import
app/Resources/views/admin/test
app/Resources/views/admin/test/index
app/Resources/views/admin/test/index/acts
app/Resources/views/components
app/Resources/views/components/dashboard
app/Resources/views/factory-generator
app/Resources/views/filament
app/Resources/views/filament/infolists
app/Resources/views/filament/infolists/components
app/Resources/views/filament/pages
app/Resources/views/filament/widgets
app/Resources/views/home
app/Resources/views/home/index
app/Resources/views/home/index/acts
app/Resources/views/layouts
app/Resources/views/livewire
app/Resources/views/livewire/manage_lang_module
app/Resources/views/livewire/rate
app/Resources/views/livewire/xot_base_table_component
app/Resources/views/pages
app/Resources/views/rss
app/Resources/views/services
app/Resources/views/sitemap
app/Resources/views/test
app/Resources/views/test/index
app/Resources/views/test/index/acts
app/Routes
app/Rules
app/Services
app/Services/Translators
app/Services/Trend
app/Services/Trend/Adapters
app/Services/bashscripts
app/Traits
app/Traits/Filament
app/ValueObjects
app/View
app/View/Components
app/View/Components/Dashboard
app/View/Composers
app/View/Creators
app/View/View
app/View/View/Components
app/ViewModels
app_old
bashscripts
config
database
database/factories
database/migrations
database/seeders
docs
docs/PHPStan
docs/actions
docs/actions/array
docs/actions/export
docs/actions/model
docs/actions/panel
docs/actions/query
docs/actions/view
docs/activity
docs/architecture
docs/assets
docs/assets/images
docs/assets/img
docs/base
docs/ci
docs/commands
docs/config
docs/conflicts
docs/console
docs/console/commands
docs/contracts
docs/data
docs/datas
docs/development
docs/docker
docs/errors
docs/exceptions
docs/exceptions/formatters
docs/exceptions/handlers
docs/features
docs/filament
docs/filament/actions
docs/filament/pages
docs/filament/resources
docs/filament/resources/pages
docs/filament/traits
docs/filament/widgets
docs/guides
docs/install
docs/integrations
docs/lang
docs/laragon
docs/laraxot
docs/links
docs/model
docs/model/action
docs/models
docs/modules
docs/no_console
docs/open_sources
docs/packages
docs/performance
docs/phpstan
docs/providers
docs/readme
docs/rules
docs/service
docs/services
docs/staudenmeir
docs/tools
docs/ubuntu
docs/view
docs/view/components
docs/view/composers
lang
lang/ar
lang/da
lang/de
lang/el
lang/en
lang/es
lang/et
lang/fa
lang/fr
lang/gr
lang/it
lang/ka
lang/lang
lang/lang/ar
lang/lang/da
lang/lang/de
lang/lang/el
lang/lang/en
lang/lang/es
lang/lang/et
lang/lang/fa
lang/lang/fr
lang/lang/gr
lang/lang/it
lang/lang/ka
lang/lang/nl
lang/lang/pl
lang/lang/pt
lang/lang/pt-br
lang/lang/pt_BR
lang/lang/ro
lang/lang/ru
lang/lang/sv
lang/lang/th
lang/lang/tr
lang/lang/vi
lang/lang/zh-CN
lang/lang/zh-TW
lang/nl
lang/pl
lang/pt
lang/pt-br
lang/pt_BR
lang/ro
lang/ru
lang/sv
lang/th
lang/tr
lang/vi
lang/zh-CN
lang/zh-TW
packages
packages/coolsam
packages/coolsam/panel-modules
packages/coolsam/panel-modules/.github
packages/coolsam/panel-modules/.github/ISSUE_TEMPLATE
packages/coolsam/panel-modules/.github/workflows
packages/coolsam/panel-modules/config
packages/coolsam/panel-modules/database
packages/coolsam/panel-modules/database/factories
packages/coolsam/panel-modules/database/migrations
packages/coolsam/panel-modules/resources
packages/coolsam/panel-modules/resources/views
packages/coolsam/panel-modules/src
packages/coolsam/panel-modules/src/Extensions
resources
resources/assets
resources/assets/img
resources/assets/img/backgrounds
resources/assets/img/demo
resources/assets/img/demo/cards
resources/assets/img/illustrations
resources/assets/img/illustrations/profiles
resources/assets/js
resources/assets/sass
resources/css
resources/img
resources/img/logo
resources/js
resources/lang
resources/lang/it
resources/resources
resources/resources/assets
resources/resources/assets/img
resources/resources/assets/img/backgrounds
resources/resources/assets/img/demo
resources/resources/assets/img/demo/cards
resources/resources/assets/img/illustrations
resources/resources/assets/img/illustrations/profiles
resources/resources/assets/js
resources/resources/assets/sass
resources/resources/css
resources/resources/img
resources/resources/img/logo
resources/resources/js
resources/resources/lang
resources/resources/lang/it
resources/resources/svg
resources/resources/views
resources/resources/views/acts
resources/resources/views/acts/artisan
resources/resources/views/admin
resources/resources/views/admin/acts
resources/resources/views/admin/home
resources/resources/views/admin/home/acts
resources/resources/views/admin/index
resources/resources/views/admin/index/acts
resources/resources/views/admin/standalone
resources/resources/views/admin/standalone/manage
resources/resources/views/admin/store
resources/resources/views/admin/store/acts
resources/resources/views/admin/store/acts/xls_import
resources/resources/views/admin/test
resources/resources/views/admin/test/index
resources/resources/views/admin/test/index/acts
resources/resources/views/components
resources/resources/views/components/dashboard
resources/resources/views/factory-generator
resources/resources/views/filament
resources/resources/views/filament/forms
resources/resources/views/filament/forms/components
resources/resources/views/filament/infolists
resources/resources/views/filament/infolists/components
resources/resources/views/filament/pages
resources/resources/views/filament/widgets
resources/resources/views/home
resources/resources/views/home/index
resources/resources/views/home/index/acts
resources/resources/views/layouts
resources/resources/views/livewire
resources/resources/views/livewire/manage_lang_module
resources/resources/views/livewire/rate
resources/resources/views/livewire/xot_base_table_component
resources/resources/views/pages
resources/resources/views/rss
resources/resources/views/services
resources/resources/views/sitemap
resources/resources/views/test
resources/resources/views/test/index
resources/resources/views/test/index/acts
resources_old
routes
stubs
tests
tests/Feature
tests/Unit
tests/Unit/Console
tests/Unit/Console/Commands
tests_old
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Xot\\": "app/",
            "Modules\\Xot\\Database\\Factories\\": "database/factories/",
            "Modules\\Xot\\Database\\Seeders\\": "database/seeders/",
            "Modules\\Xot\\Database\\Migrations\\": "database/migrations/",
            "Coolsam\\FilamentModules\\": "packages/coolsam/panel-modules/src/"
        },
        "files": [
            "Helpers/Helper.php"
        ]
    },
    "scripts": {
        "analyse": "vendor/bin/phpstan analyse",
        "test": "vendor/bin/pest",
        "test-coverage": "vendor/bin/pest --coverage",
```

## Dipendenze da altri moduli

-       4 Modules\UI\Enums\TableLayoutEnum;
-       4 Modules\Tenant\Services\TenantService;
-       3 Modules\Lang\Actions\SaveTransAction;
-       2 Modules\User\Models\Role;
-       1 Modules\User\Models\Tenant;
-       1 Modules\User\Models\Team;
-       1 Modules\User\Models\Membership;
-       1 Modules\User\Filament\Pages\MyProfilePage;
-       1 Modules\User\Contracts\TenantContract;
-       1 Modules\User\Contracts\TeamContract;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)


### Versione Incoming

   - Utilizzare i namespace appropriati che riflettono la struttura delle directory 

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


### Versione Incoming

   - Utilizzare i namespace appropriati che riflettono la struttura delle directory 

---

aurmich/dev
5693302 (.)
b6f667c (.)


## Regole sui Comandi Artisan Custom nei Moduli

- Tutti i comandi artisan custom di un modulo devono essere posizionati in:
  `app/Console/Commands/`
- La registrazione dei comandi nel ServiceProvider del modulo deve usare il namespace e path corretti.
- Aggiornare la documentazione del modulo con esempi e riferimenti.

Vedi anche la documentazione specifica del modulo per dettagli e casi particolari.
