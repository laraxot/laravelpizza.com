# Service Provider: Best Practices in Laraxot

Questo documento definisce le linee guida ufficiali e le best practices per l'implementazione dei Service Provider all'interno del framework Laraxot.

## Regole Fondamentali

### 1. Utilizzo delle Classi Base Corrette

#### ✅ DO - Estendere le classi base di Xot

È **obbligatorio** che tutti i Service Provider estendano le classi base appropriate di Xot:

```php
use Modules\Xot\Providers\XotBaseServiceProvider;

class BrainServiceProvider extends XotBaseServiceProvider
{
    // ...
}
```

```php
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    // ...
}
```

```php
use Modules\Xot\Providers\BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    // ...
}
```

#### ❌ DON'T - Non estendere mai direttamente le classi base di Laravel

```php
// NON FARE MAI QUESTO
use Illuminate\Support\ServiceProvider;

class BrainServiceProvider extends ServiceProvider
{
    // ...
}
```

```php
// NON FARE MAI QUESTO
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    // ...
}
```

```php
// NON FARE MAI QUESTO
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    // ...
}
```

### 2. Chiamata al parent::boot()

#### ✅ DO - Chiamare sempre parent::boot()

È **cruciale** chiamare sempre `parent::boot()` all'inizio del metodo boot():

```php
public function boot(): void
{
    parent::boot(); // Cruciale!

    // Il resto del codice...
}
```

#### ❌ DON'T - Non omettere mai la chiamata a parent::boot()

```php
// NON FARE MAI QUESTO
public function boot(): void
{
    // Codice...
}
```

### 3. Proprietà Necessarie nei Provider Principali

#### ✅ DO - Dichiarare sempre le proprietà richieste

```php
protected string $moduleName = 'Brain';
protected string $moduleNameLower = 'brain';
```

#### ❌ DON'T - Non omettere le proprietà richieste

```php
// NON FARE MAI QUESTO - Mancano le proprietà $moduleName e $moduleNameLower
class BrainServiceProvider extends XotBaseServiceProvider
{
    // ...
}
```

## Implementazione Dettagliata per Tipo di Provider

### 1. Provider Principale del Modulo (Minimale)

**⚠️ IMPORTANTE**: Se non c'è logica personalizzata, usare la struttura minima. Vedi [ServiceProvider Minimal Structure](./serviceprovider-minimal-structure.md) per dettagli.

#### Struttura Minima (Senza Logica Personalizzata)

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
```

**Cosa viene gestito automaticamente:**
- ✅ Registrazione traduzioni, configurazioni, viste
- ✅ Caricamento migrazioni
- ✅ Registrazione componenti Livewire e Blade
- ✅ Registrazione comandi console
- ✅ Registrazione RouteServiceProvider e EventServiceProvider
- ✅ Registrazione Blade Icons

#### Struttura con Logica Personalizzata

```php
<?php

declare(strict_types=1);

namespace Modules\Tenant\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class TenantServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Tenant';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    /**
     * Boot con logica personalizzata.
     */
    #[\Override]
    public function boot(): void
    {
        parent::boot(); // CRUCIALE: sempre per primo

        // Logica personalizzata qui
        $this->mergeConfigs();
        $this->registerDB();
        $this->registerMorphMap();
    }

    /**
     * Register con logica personalizzata.
     */
    #[\Override]
    public function register(): void
    {
        parent::register(); // CRUCIALE: sempre per primo

        // Registrazione servizi personalizzati
        $this->app->register(AdminPanelProvider::class);
    }
}
```

**⚠️ NON aggiungere metodi `register()` o `boot()` se chiamano solo `parent::register()` o `parent::boot()` senza logica aggiuntiva.**

### 2. Route Service Provider

```php
<?php

namespace Modules\Brain\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * Nome del modulo in lowercase.
     */
    protected string $moduleNameLower = 'brain';

    /**
     * Namespace delle routes del controller.
     */
    protected string $namespace = 'Modules\Brain\Http\Controllers';

    /**
     * Boot del route service provider.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Mappa le routes API.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(module_path('Brain', '/routes/api.php'));
    }

    /**
     * Mappa le routes web.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(module_path('Brain', '/routes/web.php'));
    }

    /**
     * Mappa le routes admin.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'auth', 'admin'])
            ->prefix('admin')
            ->namespace($this->namespace . '\Admin')
            ->group(module_path('Brain', '/routes/admin.php'));
    }
}
```

### 3. Event Service Provider

```php
<?php

namespace Modules\Brain\Providers;

use Modules\Xot\Providers\BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    /**
     * Gli event listeners da registrare.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        'Modules\Brain\Events\SocioCreated' => [
            'Modules\Brain\Listeners\SendSocioNotification',
        ],
        'Modules\Brain\Events\ConvenzioneUpdated' => [
            'Modules\Brain\Listeners\NotifySocioConvenzione',
            'Modules\Brain\Listeners\UpdateConvenzioneStats',
        ],
    ];

    /**
     * Gli subscribers da registrare.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        'Modules\Brain\Listeners\BrainEventSubscriber',
    ];

    /**
     * Boot dell'event service provider.
     */
    public function boot(): void
    {
        parent::boot();

        // Eventuali registrazioni aggiuntive...
    }
}
```

## Funzionalità delle Classi Base di Xot

Le classi base di Xot implementano numerose funzionalità cruciali che non sono disponibili nelle classi base di Laravel:

### XotBaseServiceProvider

- Registrazione automatica delle traduzioni con supporto avanzato
- Caricamento intelligente di helper e traits
- Gestione automatica di hook di modulo
- Registrazione automatica dei comandi console
- Supporto per la pubblicazione di assets e configurazioni specifiche per i moduli
- Integrazione di middleware specifici

### XotBaseRouteServiceProvider

- Supporto per diversi gruppi di route (web, api, admin, etc.)
- Gestione avanzata dei middleware per route
- Pattern e prefissi configurabili a livello di modulo
- Integrazione con i sistemi di autorizzazione
- Cache intelligente delle route

### BaseEventServiceProvider

- Gestione avanzata degli eventi e listener
- Supporto per subscriber con funzionalità estese
- Integrazione con i sistemi di logging
- Gestione automatica delle dipendenze

## Vantaggi dell'Approccio Laraxot

L'utilizzo delle classi base di Xot offre numerosi vantaggi:

1. **Coerenza**: Tutti i moduli seguono lo stesso pattern, facilitando la manutenzione
2. **Funzionalità aggiuntive**: Accesso a funzionalità non disponibili nelle classi base di Laravel
3. **Automazione**: Registrazione automatica di molti componenti, riducendo il codice boilerplate
4. **Integrazione**: Perfetta integrazione con il resto dell'ecosistema Laraxot
5. **Performance**: Ottimizzazioni specifiche per l'architettura modulare

## Perché è Cruciale

Non estendere le classi base di Laravel può causare i seguenti problemi:

1. **Mancata inizializzazione**: Funzionalità fondamentali non vengono inizializzate correttamente
2. **Traduzioni non funzionanti**: I meccanismi di traduzione specifici di Laraxot non vengono attivati
3. **Routing errato**: Le route potrebbero non essere registrate correttamente o mancare di funzionalità critiche
4. **Incompatibilità**: Impossibilità di utilizzare caratteristiche specifiche di Laraxot
5. **Errori difficili da diagnosticare**: Problemi che emergono in fase di runtime

## Esempi di Errori Comuni

### Errore: Traduzioni Mancanti

Quando un Service Provider non estende `XotBaseServiceProvider` o non chiama `parent::boot()`:

```php
// Provider errato
class BrainServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Manca parent::boot() o estende la classe sbagliata
        $this->loadTranslationsFrom(...);
    }
}

// Risultato: le traduzioni non funzionano correttamente, mancano molte chiavi
// e l'integrazione con LangServiceProvider è compromessa
```

### Errore: Route Non Registrate

Quando un Route Service Provider non estende `XotBaseRouteServiceProvider`:

```php
// Provider errato
class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Codice personalizzato che non accede alle funzionalità di Xot
    }
}

// Risultato: le route potrebbero non essere caricate correttamente, mancare di
// middleware essenziali o non essere integrate con il sistema di permessi
```

## Troubleshooting

### Problema: Traduzioni non caricate

**Soluzione:** Verificare che:
1. Il Service Provider estenda `XotBaseServiceProvider`
2. Il metodo `boot()` chiami `parent::boot()`
3. Le proprietà `$moduleName` e `$moduleNameLower` siano definite correttamente

### Problema: Route non funzionanti

**Soluzione:** Verificare che:
1. Il Route Provider estenda `XotBaseRouteServiceProvider`
2. Il metodo `boot()` chiami `parent::boot()`
3. La proprietà `$moduleNameLower` sia definita correttamente
4. I file di route siano nei percorsi corretti (web.php, api.php, admin.php)

### Problema: Eventi non ascoltati

**Soluzione:** Verificare che:
1. L'Event Provider estenda `BaseEventServiceProvider`
2. Il metodo `boot()` chiami `parent::boot()`
3. Gli eventi e i listener siano definiti correttamente nell'array `$listen`

## Checklist di Implementazione

- [ ] Il Service Provider principale estende `XotBaseServiceProvider`
- [ ] Il Route Provider estende `XotBaseRouteServiceProvider`
- [ ] L'Event Provider estende `BaseEventServiceProvider`
- [ ] Tutti i metodi `boot()` chiamano `parent::boot()` all'inizio
- [ ] Le proprietà `$moduleName` e `$moduleNameLower` sono definite correttamente
- [ ] I metodi di registrazione specifici sono implementati e chiamati in ordine corretto
- [ ] I provider necessari sono registrati nel metodo `register()`
- [ ] Le pubblicazioni sono configurate correttamente

## Riferimenti

- [Documentazione Ufficiale Laravel Service Provider](https://laravel.com/docs/providers)
- [XotBaseServiceProvider](base_orisbroker_fila3/laravel/Modules/Xot/Providers/XotBaseServiceProvider.php)
- [XotBaseRouteServiceProvider](base_orisbroker_fila3/laravel/Modules/Xot/Providers/XotBaseRouteServiceProvider.php)
- [BaseEventServiceProvider](base_orisbroker_fila3/laravel/Modules/Xot/Providers/BaseEventServiceProvider.php)
