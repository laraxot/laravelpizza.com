# nWidart/laravel-modules - Guida Completa

**Data Creazione:** Gennaio 2026  
**Versione Package:** 12.0+  
**Fonte:** [GitHub Repository](https://github.com/nWidart/laravel-modules)  
**Documentazione:** https://laravelmodules.com/  
**Status:** Production Ready

---

## 📋 Indice

1. [Introduzione](#introduzione)
2. [Installazione](#installazione)
3. [Configurazione](#configurazione)
4. [Struttura Modulo](#struttura-modulo)
5. [Comandi Artisan](#comandi-artisan)
6. [Autoloading](#autoloading)
7. [Service Providers](#service-providers)
8. [Routes](#routes)
9. [Views](#views)
10. [Migrations](#migrations)
11. [Best Practices](#best-practices)
12. [Troubleshooting](#troubleshooting)

---

## Introduzione

`nwidart/laravel-modules` è un pacchetto Laravel che permette di gestire applicazioni Laravel grandi usando moduli. Un modulo è come un mini-package Laravel con i propri controller, modelli, viste e configurazioni.

**Versione Supportata**: Laravel 12.0+  
**PHP Requisito**: PHP 8.2+  
**Repository**: https://github.com/nWidart/laravel-modules

---

## Installazione

### 1. Installazione Package

```bash
composer require nwidart/laravel-modules
```

### 2. Pubblicazione Configurazione

```bash
# Pubblica tutti i file (config, stubs, vite)
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

# Pubblica solo la configurazione
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="config"

# Pubblica solo gli stubs
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="stubs"

# Pubblica solo il loader Vite (da v10.0.3)
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="vite"
```

### 3. Configurazione Autoloading

**⚠️ IMPORTANTE**: Da v11.0, autoloading `"Modules\\": "modules/"` NON è più richiesto e deve essere rimosso da `composer.json` se presente.

---

## Configurazione

### File di Configurazione

Il file di configurazione è in `config/modules.php`:

```php
return [
    'namespace' => 'Modules',
    'paths' => [
        'modules' => base_path('Modules'),
        'assets' => public_path('modules'),
        'migration' => base_path('database/migrations'),
    ],
    // ...
];
```

### Configurazione Composer.json

**⚠️ CRITICO**: Configurazione obbligatoria per autoloading moduli:

```json
{
    "extra": {
        "laravel": {
            "dont-discover": []
        },
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ],
            "recurse": true,
            "replace": false,
            "ignore-duplicates": false,
            "merge-dev": true,
            "merge-extra": false,
            "merge-extra-deep": false,
            "merge-scripts": false
        }
    }
}
```

**⚠️ IMPORTANTE**: Alla prima installazione verrà chiesto:

```bash
Do you trust "wikimedia/composer-merge-plugin" to execute code and wish to enable it now? (writes "allow-plugins" to composer.json) [y,n,d,?]
```

Rispondere `y` per permettere l'esecuzione del plugin. Altrimenti, abilitare manualmente:

```json
{
    "config": {
        "allow-plugins": {
            "wikimedia/composer-merge-plugin": true
        }
    }
}
```

**⚠️ CRITICO**: Se `"wikimedia/composer-merge-plugin": false`, i moduli NON verranno autoloadati.

**Tip**: Non dimenticare di eseguire `composer dump-autoload` dopo la modifica.

---

## Struttura Modulo

### Struttura Standard

```
Modules/
└── {ModuleName}/
    ├── app/
    │   ├── Actions/
    │   ├── Broadcasting/
    │   ├── Console/
    │   ├── Datas/
    │   ├── Enums/
    │   ├── Events/
    │   ├── Exceptions/
    │   ├── Filament/
    │   │   ├── Resources/
    │   │   ├── Pages/
    │   │   └── Widgets/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   ├── Middleware/
    │   │   └── Requests/
    │   ├── Jobs/
    │   ├── Listeners/
    │   ├── Models/
    │   ├── Notifications/
    │   ├── Policies/
    │   ├── Providers/
    │   └── Rules/
    ├── database/
    │   ├── factories/
    │   ├── migrations/
    │   └── seeders/
    ├── lang/
    │   ├── it/
    │   ├── en/
    │   └── de/
    ├── resources/
    │   ├── views/
    │   ├── assets/
    │   └── svg/
    ├── routes/
    │   ├── web.php
    │   └── api.php
    ├── tests/
    │   ├── Feature/
    │   └── Unit/
    ├── composer.json
    ├── module.json
    └── README.md
```

### Namespace Pattern

**⚠️ CRITICO**: Namespace senza segmento `App`:

```php
// ✅ CORRETTO
namespace Modules\{ModuleName}\Models;
namespace Modules\{ModuleName}\Filament\Resources;
namespace Modules\{ModuleName}\Actions;

// ❌ ERRATO
namespace Modules\{ModuleName}\App\Models;
namespace Modules\{ModuleName}\App\Filament\Resources;
```

**Mappatura PSR-4**:
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\NomeModulo\\": "Modules/NomeModulo/app/"
        }
    }
}
```

---

## Comandi Artisan

### Creazione Modulo

```bash
php artisan module:make ModuleName
```

### Lista Moduli

```bash
php artisan module:list
```

### Abilitare/Disabilitare Modulo

```bash
php artisan module:enable ModuleName
php artisan module:disable ModuleName
```

### Creazione Componenti

```bash
# Controller
php artisan module:make-controller ControllerName ModuleName

# Model
php artisan module:make-model ModelName ModuleName

# Migration
php artisan module:make-migration create_table_name ModuleName

# Seeder
php artisan module:make-seeder SeederName ModuleName

# Factory
php artisan module:make-factory FactoryName ModuleName

# Policy
php artisan module:make-policy PolicyName ModuleName

# Request
php artisan module:make-request RequestName ModuleName

# Resource Filament
php artisan module:make-filament-resource ResourceName ModuleName
```

---

## Autoloading

### Composer Merge Plugin

Il progetto usa `wikimedia/composer-merge-plugin` per unire le dipendenze dei moduli:

```json
{
    "extra": {
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ]
        }
    }
}
```

### Dump Autoload

Dopo ogni modifica a `composer.json` di un modulo:

```bash
composer dump-autoload
```

---

## Service Providers

### Struttura Service Provider Modulo

```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class {ModuleName}ServiceProvider extends XotBaseServiceProvider
{
    public string $name = '{ModuleName}';

    public function boot(): void
    {
        parent::boot();
        // Logica specifica modulo
    }

    public function register(): void
    {
        parent::register();
        // Registrazione servizi specifici
    }
}
```

### Registrazione Automatica

I Service Providers vengono registrati automaticamente tramite `module.json`:

```json
{
    "providers": [
        "Modules\\{ModuleName}\\Providers\\{ModuleName}ServiceProvider"
    ]
}
```

---

## Routes

### Routes Web

```php
// Modules/{ModuleName}/routes/web.php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('{modulename}::index');
    });
});
```

### Routes API

```php
// Modules/{ModuleName}/routes/api.php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {
    Route::get('/data', [Controller::class, 'index']);
});
```

---

## Views

### Namespace Views

Le views sono accessibili tramite namespace:

```blade
{{-- Modules/{ModuleName}/resources/views/index.blade.php --}}
{{-- Accessibile come: {modulename}::index --}}

<x-{modulename}::components.header />
```

### Caricamento Views

Le views vengono caricate automaticamente dal Service Provider:

```php
// In ServiceProvider boot()
$this->loadViewsFrom(__DIR__.'/../resources/views', '{modulename}');
```

---

## Migrations

### Struttura Migrations

```php
// Modules/{ModuleName}/database/migrations/2024_01_01_000000_create_table.php
<?php

declare(strict_types=1);

use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
};
```

### Esecuzione Migrations

```bash
# Tutte le migrations
php artisan migrate

# Singolo modulo
php artisan module:migrate ModuleName

# Rollback
php artisan module:migrate-rollback ModuleName
```

---

## Best Practices

### 1. Namespace senza App

**Sempre** usare namespace senza segmento `App`:

```php
namespace Modules\{ModuleName}\Models;  // ✅ CORRETTO
namespace Modules\{ModuleName}\App\Models;  // ❌ ERRATO
```

### 2. Estensione XotBase Classes

**Sempre** estendere classi XotBase:

```php
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\Xot\Database\Migrations\XotBaseMigration;
```

### 3. Composer.json Modulo

Ogni modulo deve avere il proprio `composer.json`:

```json
{
    "name": "laraxot/{modulename}",
    "description": "Module description",
    "type": "library",
    "autoload": {
        "psr-4": {
            "Modules\\{ModuleName}\\": "app/"
        }
    },
    "require": {
        "php": "^8.2"
    }
}
```

### 4. module.json

Ogni modulo deve avere `module.json`:

```json
{
    "name": "{ModuleName}",
    "alias": "{modulename}",
    "description": "Module description",
    "keywords": [],
    "priority": 0,
    "providers": [
        "Modules\\{ModuleName}\\Providers\\{ModuleName}ServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": []
}
```

### 5. Documentazione

Ogni modulo deve avere documentazione completa in `docs/`:

```
Modules/{ModuleName}/docs/
├── README.md
├── installation.md
├── configuration.md
└── ...
```

---

## Troubleshooting

### Problema: Modulo non autoloadato

**Causa**: Composer merge plugin non configurato correttamente.

**Soluzione**: 
1. Verifica `composer.json` root ha `merge-plugin` configurato
2. Verifica `allow-plugins` include `wikimedia/composer-merge-plugin: true`
3. Esegui `composer dump-autoload`

### Problema: Service Provider non registrato

**Causa**: `module.json` mancante o provider non configurato.

**Soluzione**: Verifica che `module.json` contenga il provider corretto.

### Problema: Routes non funzionanti

**Causa**: Routes non registrate nel Service Provider.

**Soluzione**: Verifica che `loadRoutesFrom()` sia chiamato in `boot()`.

### Problema: Views non trovate

**Causa**: Namespace view errato o views non caricate.

**Soluzione**: Verifica `loadViewsFrom()` in Service Provider e namespace corretto.

---

## Collegamenti Correlati

- [Laravel Modules Documentation](https://laravelmodules.com/)
- [GitHub Repository](https://github.com/nWidart/laravel-modules)
- [XotBaseServiceProvider Documentation](../filament-integration.md)
- [Module Structure Documentation](../base/structure.md)
- [Composer Merge Plugin Documentation](../../../../../../../../docs/composer-merge-plugin.md)

---

**Versione Package:** 12.0+  
**Compatibilità:** Laravel 12.x, PHP 8.2+
