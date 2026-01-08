# Architettura Service Provider in Laraxot/PTVX

## Panoramica Business Logic

Il sistema Service Provider di Laraxot è progettato per **automatizzare completamente** la registrazione di risorse modulari (view, traduzioni, config, componenti) con un approccio **DRY** e **KISS**. Ogni modulo deve solo:

1. Definire `public string $name = 'NomeModulo'`
2. Chiamare `parent::boot()`
3. Tutto il resto è automatico

### Perché Questo Design?

**Business Logic**: In un'applicazione modulare con 50+ moduli, registrare manualmente view, traduzioni e componenti per ogni modulo sarebbe:
- ❌ Ripetitivo (anti-DRY)
- ❌ Propenso a errori
- ❌ Difficile da mantenere
- ❌ Lento da sviluppare

**Soluzione KISS**: Un ServiceProvider base che fa tutto automaticamente in base al `$name` del modulo.

## Gerarchia delle Classi

```
ServiceProvider (Laravel)
    ↓
XotBaseServiceProvider (Xot)
    ↓
[ModuleName]ServiceProvider (Es: ActivityServiceProvider)
```

### `XotBaseServiceProvider`

**Percorso**: `Modules/Xot/app/Providers/XotBaseServiceProvider.php`

**Scopo**: Classe astratta base che fornisce registrazione automatica di tutte le risorse modulari.

**Proprietà Richieste**:
```php
abstract class XotBaseServiceProvider extends ServiceProvider
{
    public string $name = '';         // Nome modulo PascalCase
    public string $nameLower = '';    // Calcolato automaticamente in lowercase
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

## Ciclo di Vita ServiceProvider

### 1. `register()` - Fase di Registrazione

**Quando**: Prima che l'applicazione sia completamente avviata
**Scopo**: Registrare binding nel container IoC

```php
public function register(): void
{
    // 1. Calcola namespace lowercase
    $this->nameLower = Str::lower($this->name);
    
    // 2. Normalizza module namespace
    $this->module_ns = collect(explode('\\', $this->module_ns))
        ->slice(0, -1)
        ->implode('\\');
    
    // 3. Registra altri provider del modulo
    $this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
    $this->app->register($this->module_ns.'\Providers\EventServiceProvider');
    
    // 4. Registra Blade Icons
    $this->registerBladeIcons();
}
```

**Business Logic**:
- `$nameLower` è utilizzato come namespace per view, config, traduzioni
- Il module namespace è normalizzato rimuovendo `\Providers`
- Route e Event provider sono caricati automaticamente
- Le icone SVG custom del modulo sono registrate

### 2. `boot()` - Fase di Bootstrap

**Quando**: Dopo che tutti i provider sono registrati
**Scopo**: Effettuare operazioni di setup che richiedono l'app completa

```php
public function boot(): void
{
    $this->registerTranslations();      // 1. Traduzioni
    $this->registerConfig();            // 2. Configurazioni
    $this->registerViews();             // 3. View namespace
    $this->loadMigrationsFrom(...);     // 4. Migrazioni
    $this->registerLivewireComponents();// 5. Livewire components
    $this->registerBladeComponents();   // 6. Blade components
    $this->registerCommands();          // 7. Artisan commands
}
```

**Ordine Critico**: L'ordine è importante perché alcune registrazioni dipendono da altre.

## Sistema di Registrazione View Namespace

### Il Problema che Risolve

**Senza namespace**: 
```blade
{{-- Deve sapere il percorso esatto --}}
@include('/var/www/html/ptvx/laravel/Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php')
```

**Con namespace**:
```blade
{{-- Semplice e portabile --}}
@include('activity::filament.pages.list-log-activities')
```

### Come Funziona `registerViews()`

```php
public function registerViews(): void
{
    // 1. Validazione nome modulo
    if ($this->name === '') {
        throw new Exception('name is empty on ['.static::class.']');
    }
    
    // 2. Calcola percorso view
    $viewPath = module_path($this->name, 'resources/views');
    
    // 3. Registra namespace
    $this->loadViewsFrom($viewPath, $this->nameLower);
}
```

**Cosa Succede Internamente** (Laravel):
```php
// Laravel registra internamente:
$viewFinder->addNamespace($this->nameLower, [$viewPath]);

// Ora disponibile:
View::make('activity::filament.pages.list-log-activities');
```

### Namespace Registrati

Per ogni modulo con `$name = 'Activity'`:

| Tipo | Namespace | Path |
|------|-----------|------|
| View | `activity::` | `Modules/Activity/resources/views/` |
| Traduzioni | `activity` | `Modules/Activity/lang/` |
| Config | `activity::` | `Modules/Activity/config/` |
| Componenti Blade | `activity::` | `Modules/Activity/View/Components/` |

## Anatomia di un Errore "No hint path"

### Stack di Chiamate

```
1. Filament\Pages\BasePage::render()
   ↓
2. view($this->view)  // 'activity::filament.pages.list-log-activities'
   ↓
3. View::make('activity::...')
   ↓
4. ViewFactory::make()
   ↓
5. FileViewFinder::find()
   ↓
6. FileViewFinder::parseNamespaceSegments('activity', 'filament.pages...')
   ↓
7. FileViewFinder::getHints() 
   ↓
8. Se 'activity' non è in $hints → InvalidArgumentException
```

### Perché Succede

**Cause Possibili**:

1. **ServiceProvider Non Caricato**
   ```php
   // Il ServiceProvider non è in composer.json o module.json
   "providers": [
       // "Modules\\Activity\\Providers\\ActivityServiceProvider" ← MANCA!
   ]
   ```

2. **`$name` Non Definita**
   ```php
   class ActivityServiceProvider extends XotBaseServiceProvider
   {
       // public string $name = 'Activity';  ← MANCA!
   }
   ```

3. **`parent::boot()` Non Chiamato**
   ```php
   public function boot(): void
   {
       // parent::boot();  ← MANCA!
       $this->registerCustomStuff();
   }
   ```

4. **Cache Stale**
   ```bash
   # Cache contiene view hints vecchi
   bootstrap/cache/services.php  # ← contiene lista provider vecchia
   ```

5. **View Path Non Esiste**
   ```bash
   # Se manca la cartella:
   Modules/Activity/resources/views/  # ← NON ESISTE!
   ```

## System View Namespace Resolution

### Action: `GetViewNameSpacePathAction`

**Percorso**: `Modules/Xot/app/Actions/File/GetViewNameSpacePathAction.php`

**Scopo**: Risolvere un namespace view nel suo percorso fisico

```php
$path = app(GetViewNameSpacePathAction::class)->execute('activity');
// Ritorna: "/var/www/html/ptvx/laravel/Modules/Activity/resources/views"
```

**Implementazione**:
```php
public function execute(string $ns): ?string
{
    // 1. Ottieni view factory
    $viewFactory = View::getFacadeRoot();
    
    // 2. Ottieni finder
    $finder = $viewFactory->getViewFinder();
    
    // 3. Ottieni hints registrati
    $viewHints = $finder->getHints();
    
    // 4. Cerca il namespace
    if (isset($viewHints[$ns])) {
        return $viewHints[$ns][0];  // Primo path registrato
    }
    
    return null;  // Namespace non trovato
}
```

### Debugging View Namespaces

**In Tinker**:
```php
php artisan tinker

// Lista tutti i view namespaces registrati
>> app('view')->getFinder()->getHints()

// Output esempio:
=> [
     "activity" => [
       "/var/www/html/ptvx/laravel/Modules/Activity/resources/views",
     ],
     "xot" => [
       "/var/www/html/ptvx/laravel/Modules/Xot/resources/views",
     ],
     // ...
   ]

// Verifica namespace specifico
>> app('view')->getFinder()->getHints()['activity'] ?? 'NOT FOUND'
```

**Con GetViewNameSpacePathAction**:
```php
// In controller o command
$path = app(\Modules\Xot\Actions\File\GetViewNameSpacePathAction::class)
    ->execute('activity');

if ($path === null) {
    throw new Exception("Namespace 'activity' not registered!");
}
```

## Pattern di Implementazione Corretti

### ServiceProvider Minimale

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ActivityServiceProvider extends XotBaseServiceProvider
{
    // SOLO 3 proprietà necessarie - tutto il resto è automatico
    public string $name = 'Activity';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

**Business Logic**: Questa è TUTTA la configurazione necessaria per un modulo standard. Il parent fa tutto il resto.

### ServiceProvider con Personalizzazioni

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Override;

class ActivityServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Activity';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    /**
     * Boot del service provider.
     * SEMPRE chiamare parent::boot() per registrazione automatica.
     */
    #[Override]
    public function boot(): void
    {
        parent::boot();  // ← CRITICO: registra view, traduzioni, etc.
        
        // Personalizzazioni specifiche del modulo
        $this->registerCustomConfig();
    }
    
    /**
     * Registra configurazioni custom oltre a quelle standard.
     */
    protected function registerCustomConfig(): void
    {
        $this->publishes([
            module_path($this->name, 'config/activity.php') => config_path('activity.php'),
        ], 'config');
        
        $this->mergeConfigFrom(
            module_path($this->name, 'config/activity.php'),
            'activity'
        );
    }
}
```

## Best Practice

### 1. Nome Modulo

```php
// ✅ CORRETTO: PascalCase
public string $name = 'Activity';
public string $name = 'IndennitaResponsabilita';

// ❌ ERRATO: lowercase, snake_case, kebab-case
public string $name = 'activity';
public string $name = 'indennita_responsabilita';
public string $name = 'indennita-responsabilita';
```

**Perché**: `$nameLower` viene calcolato automaticamente. Il namespace view sarà sempre lowercase.

### 2. Chiamata Parent

```php
// ✅ CORRETTO
public function boot(): void
{
    parent::boot();  // Prima!
    $this->customStuff();
}

// ❌ ERRATO
public function boot(): void
{
    $this->customStuff();
    parent::boot();  // Troppo tardi!
}

// ❌ GRAVISSIMO
public function boot(): void
{
    // parent::boot();  ← MANCA!
    $this->customStuff();
}
```

**Perché**: `parent::boot()` registra view namespace. Senza, nessuna view del modulo funzionerà.

### 3. Struttura Cartelle

```
Modules/[ModuleName]/
├── app/
│   └── Providers/
│       └── [ModuleName]ServiceProvider.php  ← DEVE chiamare parent::boot()
├── resources/
│   └── views/                               ← DEVE esistere per view namespace
│       └── filament/
│           └── pages/
│               └── custom-page.blade.php
├── lang/                                    ← Per traduzioni
│   ├── en/
│   └── it/
├── config/                                  ← Per configurazioni
│   └── config.php
└── module.json                              ← providers array DEVE includere ServiceProvider
```

### 4. Module.json

```json
{
    "name": "Activity",
    "alias": "activity",
    "priority": 10,
    "providers": [
        "Modules\\Activity\\Providers\\ActivityServiceProvider",
        "Modules\\Activity\\Providers\\Filament\\AdminPanelProvider"
    ]
}
```

**Priority**: Moduli con priority più alta vengono caricati prima. Se Activity è usato da altri moduli, aumentare priority.

## Troubleshooting Workflow

### Diagnostica Rapida

```bash
# 1. ServiceProvider registrato?
php artisan package:discover --ansi | grep Activity

# 2. View namespace disponibile?
php artisan tinker
>> app('view')->getFinder()->getHints()['activity'] ?? 'MISSING'

# 3. File view esiste?
ls -la Modules/Activity/resources/views/filament/pages/

# 4. Cache pulita?
php artisan optimize:clear
```

### Fix Completo

```bash
# Sequenza completa di ripristino
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
composer dump-autoload -o
php artisan package:discover --ansi
php artisan optimize:clear
```

## Anti-Pattern da Evitare

### ❌ Registrazione Manuale View

```php
// NON FARE QUESTO - il parent lo fa già!
public function boot(): void
{
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'activity');
    parent::boot();  // Registrerà di nuovo!
}
```

### ❌ Duplicazione Logic

```php
// NON FARE QUESTO - duplica logica del parent
public function boot(): void
{
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'activity');
    $this->loadTranslationsFrom(__DIR__.'/../lang', 'activity');
    $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    // ...tutto già fatto dal parent!
}
```

### ❌ Namespace Hardcoded

```php
// NON FARE QUESTO
$view = 'activity::some.view';  // ← hardcoded

// FARE QUESTO
$view = $this->nameLower.'::some.view';  // ← dinamico
```

## Performance e Ottimizzazione

### Cache in Produzione

```bash
# Dopo modifiche ai ServiceProvider in produzione:
php artisan config:cache
php artisan route:cache
php artisan view:cache

# MAI usare questi comandi in produzione:
php artisan config:clear  # ← toglie cache!
```

### Module Discovery

Il sistema `nwidart/laravel-modules` scansiona e registra automaticamente i moduli al boot dell'applicazione. 

**Per disabilitare moduli temporaneamente**:
```json
// module.json
{
    "active": 0  ← disabilita modulo
}
```

## Collegamenti

### Documentazione Correlata
- [Activity Module - Errore No Hint Path](../../Activity/docs/errori/no-hint-path-defined.md)
- [View Namespace Resolution System](./view-namespace-resolution.md)
- [Module Discovery Process](./module-discovery.md)

### File Sorgente
- [XotBaseServiceProvider.php](../app/Providers/XotBaseServiceProvider.php)
- [GetViewNameSpacePathAction.php](../app/Actions/File/GetViewNameSpacePathAction.php)
- [ModuleService.php](../app/Services/ModuleService.php)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Versione Laravel**: 12.35.1  
**Filosofia**: DRY + KISS per registrazione automatica risorse modulari


