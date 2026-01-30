# Bolt Plugin Registration Issue - <nome progetto>

## Problema Identificato

### Errore
```
Plugin [zeus-bolt] is not registered for panel [<nome progetto>::admin].
```

### Contesto
- **URL**: `/it/patient/referto`
- **Component**: `<livewire:bolt.fill-form slug="prova-1" inline="true" />`
- **Panel ID**: `<nome progetto>::admin`
- **Plugin**: Lara Zeus Bolt (form builder per Filament)

## Analisi Approfondita

### Filosofia e Logica del Sistema
Dal punto di vista **epistemologico**, il problema rappresenta un conflitto tra architettura modulare (Laraxot) e plugin system (Filament). La **fenomenologia** dell'errore rivela una disconnessione tra la registrazione del plugin e il momento dell'utilizzo.

### Governance e Controllo
Il sistema di panel di Filament opera secondo principi di **autorità distribuita**, dove ogni modulo registra i propri plugin autonomamente. La **trasparenza** del sistema richiede che ogni plugin sia correttamente identificabile dal panel manager.

### Struttura Attuale
1. **Plugin installato**: `"lara-zeus/bolt": "*"` in `composer.json`
2. **Plugin registrato**: `BoltPlugin::make()` in `AdminPanelProvider`
3. **Panel ID**: Configurato come `<nome progetto>::admin` nella classe base

## Causa Radice

### Timing di Registrazione
Il problema deriva dalla **cronologia** di caricamento dei provider. Il plugin viene registrato ma non è disponibile al momento dell'uso del componente Livewire.

### Architettura Modulare
La **topologia** del sistema Laraxot prevede che ogni modulo registri i propri plugin, ma il timing della registrazione può causare problemi di **sincronicità**.

## Soluzione Completa

### 1. Verifica della Configurazione Bolt

#### Configurazione Richiesta
Creare/verificare il file di configurazione Bolt:

```php
// config/zeus-bolt.php
return [
    'models' => [
        'Form' => \LaraZeus\Bolt\Models\Form::class,
        'Field' => \LaraZeus\Bolt\Models\Field::class,
        'Section' => \LaraZeus\Bolt\Models\Section::class,
        'Response' => \LaraZeus\Bolt\Models\Response::class,
        'Entry' => \LaraZeus\Bolt\Models\Entry::class,
        'Collection' => \LaraZeus\Bolt\Models\Collection::class,
    ],
    
    'table_prefix' => 'bolt_',
    
    'resources' => [
        'enabled' => true,
        'label' => 'Forms',
        'plural_label' => 'Forms',
        'navigation_group' => 'CMS',
        'navigation_sort' => 1,
        'navigation_icon' => 'heroicon-o-rectangle-stack',
    ],
    
    'pages' => [
        'enabled' => true,
        'show_title_and_description' => true,
    ],
];
```

### 2. Migrazione Provider Pattern

#### Problema: Plugin Registration Timing
Il plugin deve essere registrato prima che il panel sia completamente inizializzato.

#### Soluzione: Early Plugin Registration
Modifica dell'`AdminPanelProvider` per garantire registrazione anticipata:

```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Providers\Filament;

use Filament\Panel;
use LaraZeus\Bolt\BoltPlugin;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = '<nome progetto>';

    public function panel(Panel $panel): Panel
    {
        // 1. Prima configura il panel base
        $panel = parent::panel($panel);
        
        // 2. Configura tenancy e calendar
        $panel = app(ApplyTenancyToPanelAction::class)->execute($panel);
        $panel = app(ApplyCalendarToPanelAction::class)->execute($panel);

        // 3. CRITICAL: Registra Bolt plugin prima di tutto
        $boltPlugin = BoltPlugin::make()
            ->hideResources()  // Nasconde risorse admin se non necessarie
            ->enableComponents(); // Abilita solo componenti Livewire

        $plugins = [
            $boltPlugin,
            SpatieLaravelTranslatablePlugin::make()
                ->defaultLocales([config('app.locale')]),
        ];
        
        $panel->plugins($plugins);

        return $panel;
    }

    /**
     * Bootstrap del provider - registrazione anticipata
     */
    public function boot(): void
    {
        parent::boot();
        
        // Forza pre-caricamento modelli Bolt
        $this->preloadBoltModels();
    }

    /**
     * Pre-carica i modelli Bolt per evitare problemi di timing
     */
    private function preloadBoltModels(): void
    {
        if (class_exists(\LaraZeus\Bolt\Models\Form::class)) {
            // Verifica che le tabelle esistano prima di caricare
            try {
                \LaraZeus\Bolt\Models\Form::first();
            } catch (\Exception $e) {
                // Log warning ma non bloccare
                \Log::warning('Bolt models not ready yet: ' . $e->getMessage());
            }
        }
    }
}
```

### 3. Verifica e Configurazione Database

#### Migrazioni Bolt
Eseguire le migrazioni Bolt:

```bash
php artisan vendor:publish --tag=bolt-migrations
php artisan migrate
```

#### Seeder Dati Base
Creare form di test:

```bash
php artisan vendor:publish --tag=bolt-seeders
php artisan db:seed --class=BoltSeeder
```

### 4. Alternative Architecture Pattern

#### Pattern A: Global Plugin Registration
Registrare Bolt a livello globale nell'`app/Providers/AppServiceProvider.php`:

```php
public function boot()
{
    if (class_exists(\LaraZeus\Bolt\BoltPlugin::class)) {
        Filament::serving(function () {
            Filament::registerPlugin(\LaraZeus\Bolt\BoltPlugin::make());
        });
    }
}
```

#### Pattern B: Service Provider Bolt Dedicato
Creare un provider dedicato per Bolt:

```php
<?php

namespace Modules\<nome progetto>\Providers;

use Illuminate\Support\ServiceProvider;
use LaraZeus\Bolt\BoltPlugin;
use Filament\Facades\Filament;

class BoltServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->resolving('filament', function () {
            Filament::registerPlugin(BoltPlugin::make());
        });
    }
}
```

## Strategia di Testing

### 1. Verifica Plugin Registration
```bash
php artisan route:list | grep bolt
php artisan filament:list-panels
```

### 2. Test Component Loading
```php
// In tinker
>>> \LaraZeus\Bolt\Models\Form::where('slug', 'prova-1')->first()
>>> Filament::getPlugin('zeus-bolt')
```

### 3. Debug Panel Plugins
```php
// Nel controller o middleware
dd(Filament::getCurrentPanel()->getPlugins());
```

## Sostenibilità e Manutenzione

### Economic Value
- **ROI**: Form builder dinamico riduce sviluppo custom
- **Costi nascosti**: Debugging configurazione iniziale
- **Debito tecnico**: Dipendenza da plugin esterno

### Environmental Impact
- **Efficienza energetica**: Meno query grazie a caching forms
- **Longevità**: Plugin attivamente mantenuto
- **Legacy**: Compatibilità con future versioni Filament

## Governance Decisionale

### Democratica
La scelta di Bolt come form builder è stata valutata collettivamente considerando:
- Facilità d'uso per utenti non tecnici
- Integrazione nativa con Filament
- Community support attiva

### Trasparenza
Tutti i cambiamenti di configurazione devono essere documentati e versionati.

### Accountability
Ogni sviluppatore è responsabile di testare l'integrazione prima del deploy.

## Checklist Implementazione

- [ ] Verificare installazione Bolt in composer.json
- [ ] Pubblicare e eseguire migrazioni Bolt
- [ ] Modificare AdminPanelProvider con early registration
- [ ] Testare accesso al form 'prova-1'
- [ ] Verificare plugin registration in panel
- [ ] Documentare configurazione in module docs
- [ ] Creare test di regressione
- [ ] Aggiornare deployment procedures

## Collegamenti

- [LaraZeus Bolt Documentation](https://bolt.larazeus.com/)
- [Filament Plugin Development](https://filamentphp.com/docs/3.x/support/plugins)
- [<nome progetto> AdminPanelProvider](../laravel/Modules/<nome progetto>/app/Providers/Filament/AdminPanelProvider.php)
- [Xot Base Panel Provider](../laravel/Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php)

*Ultimo aggiornamento: Gennaio 2025* 