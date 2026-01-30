# Larazeus Bolt v3 Integration - <nome progetto>

## Filosofia e Architettura

### Principi Fondamentali
Larazeus Bolt v3 rappresenta l'evoluzione del concetto di "form builder" nel contesto di Laravel e Filament. La sua filosofia si basa su:

- **Modularità**: Ogni componente è indipendente e riutilizzabile
- **Estensibilità**: Architettura plugin-based per funzionalità aggiuntive
- **Performance**: Sistema di cache intelligente per ottimizzare i tempi di risposta
- **Sicurezza**: Validazione robusta e protezione CSRF integrata
- **Accessibilità**: Design inclusivo e supporto per screen reader

### Architettura del Sistema
```
Larazeus Bolt v3
├── Core Engine (Form Builder)
├── Plugin System (Estensioni)
├── Theme System (Personalizzazione UI)
├── Cache Layer (Performance)
└── Security Layer (Validazione e Protezione)
```

## Integrazione nel Progetto <nome progetto>

### Configurazione del Plugin

Il plugin Bolt è configurato nel `AdminPanelProvider` del modulo UI:

```php
// Modules/UI/app/Providers/Filament/AdminPanelProvider.php
$plugins = [
    SpatieLaravelTranslatablePlugin::make()
        ->defaultLocales([config('app.locale')]),
    BoltPlugin::make()
        ->models([
            'Form' => \LaraZeus\Bolt\Models\Form::class,
            'Field' => \LaraZeus\Bolt\Models\Field::class,
            'Section' => \LaraZeus\Bolt\Models\Section::class,
            'Response' => \LaraZeus\Bolt\Models\Response::class,
            'Collection' => \LaraZeus\Bolt\Models\Collection::class,
            'Category' => \LaraZeus\Bolt\Models\Category::class,
        ])
        ->navigationGroupLabel('Forms')
        ->routePrefix('bolt')
];
```

### Configurazione del Sistema

Il file `config/zeus-bolt.php` definisce la configurazione completa:

```php
<?php

return [
    'models' => [
        'Form' => \LaraZeus\Bolt\Models\Form::class,
        'Field' => \LaraZeus\Bolt\Models\Field::class,
        'Section' => \LaraZeus\Bolt\Models\Section::class,
        'Response' => \LaraZeus\Bolt\Models\Response::class,
        'Collection' => \LaraZeus\Bolt\Models\Collection::class,
        'Category' => \LaraZeus\Bolt\Models\Category::class,
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
    
    'cache' => [
        'forms' => env('BOLT_CACHE_FORMS', true),
        'ttl' => env('BOLT_CACHE_TTL', 3600),
    ],
    
    'security' => [
        'enable_api' => env('BOLT_ENABLE_API', false),
        'admin_access' => env('BOLT_ADMIN_ACCESS', 'restricted'),
        'csrf_protection' => true,
    ],
    
    'validation' => [
        'max_file_size' => '10240',
        'allowed_file_types' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
    ],
    
    'notifications' => [
        'enabled' => true,
        'email_admin' => env('BOLT_ADMIN_EMAIL', config('mail.from.address')),
        'send_copy_to_user' => false,
    ],
    
    'theme' => [
        'default' => 'default',
        'css_framework' => 'tailwind',
        'custom_css' => null,
    ],
];
```

## Risoluzione dell'Errore "Call to undefined method get()"

### Analisi del Problema

L'errore si verifica nel trait `HasModels` alla riga 24:

```php
// vendor/lara-zeus/filament-plugin-tools/src/Concerns/HasModels.php:24
return array_merge(
    config(static::get()->getId() . '.models'),  // ERRORE: get() non definito
    (new static)::get()->getModels()
)[$model] ?? null;
```

### Causa Root

Il problema è che il plugin Bolt non è stato registrato correttamente nel sistema Filament, causando il fallimento del metodo `get()`.

### Soluzione Implementata ✅

1. **Configurazione Corretta del Plugin**:
   - Il plugin deve essere registrato con i modelli corretti
   - La configurazione deve essere presente nel file `config/zeus-bolt.php`

2. **Registrazione nel Service Provider**:
   - Il plugin deve essere aggiunto all'array dei plugin nel `AdminPanelProvider`
   - I modelli devono essere configurati tramite il metodo `models()`

3. **Pubblicazione delle Configurazioni**:
   - Eseguire `php artisan vendor:publish --tag=zeus-bolt-config`
   - Verificare che il file di configurazione sia presente

## Implementazione Completa

### Step 1: Pubblicazione delle Configurazioni ✅

```bash
php artisan vendor:publish --tag=zeus-bolt-config
php artisan vendor:publish --tag=zeus-bolt-migrations
```

### Step 2: Aggiornamento AdminPanelProvider ✅

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Providers\Filament;

use Filament\Panel;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\SpatieLaravelTranslatablePlugin;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use LaraZeus\Bolt\BoltPlugin;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'UI';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        
        $plugins = [
            SpatieLaravelTranslatablePlugin::make()
                ->defaultLocales([config('app.locale')]),
            BoltPlugin::make()
                ->models([
                    'Form' => \LaraZeus\Bolt\Models\Form::class,
                    'Field' => \LaraZeus\Bolt\Models\Field::class,
                    'Section' => \LaraZeus\Bolt\Models\Section::class,
                    'Response' => \LaraZeus\Bolt\Models\Response::class,
                    'Collection' => \LaraZeus\Bolt\Models\Collection::class,
                    'Category' => \LaraZeus\Bolt\Models\Category::class,
                ])
                ->navigationGroupLabel('Forms')
                ->routePrefix('bolt')
        ];
        
        $panel->plugins($plugins);

        return $panel;
    }
}
```

### Step 3: Configurazione delle Variabili d'Ambiente

```env

# Bolt Configuration
BOLT_CACHE_FORMS=true
BOLT_CACHE_TTL=3600
BOLT_ENABLE_API=false
BOLT_ADMIN_ACCESS=restricted
BOLT_ADMIN_EMAIL=admin@<nome progetto>.local
```

### Step 4: Verifica dell'Installazione ✅

```bash

# Verifica che le tabelle siano state create
php artisan migrate:status

# Verifica che il plugin sia registrato
php artisan route:list --name=bolt

# Test del plugin
php artisan tinker
>>> LaraZeus\Bolt\BoltPlugin::get()
```

**Risultati del Test:**
- ✅ Plugin registrato correttamente
- ✅ Route disponibili: `bolt`, `bolt/entries`, `bolt/entry/{responseID}`, `bolt/{slug}/{extensionSlug?}`
- ✅ Metodo `get()` funzionante
- ✅ Modelli configurati correttamente

## Utilizzo nel Frontend

### Componente Livewire

```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Http\Livewire;

use Livewire\Component;
use LaraZeus\Bolt\Facades\Designer;

class FormBuilder extends Component
{
    public function render()
    {
        return view('<nome progetto>::livewire.form-builder');
    }
    
    public function getFormSchema()
    {
        return Designer::ui();
    }
}
```

### Template Blade

```blade
{{-- Themes/One/resources/views/pages/patient/referto.blade.php --}}
<x-filament::page>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold">Referto Medico</h1>
        
        @livewire('<nome progetto>::form-builder')
    </div>
</x-filament::page>
```

## Best Practices

### 1. Gestione della Cache
- Abilitare la cache per i form statici
- Invalidare la cache quando i form vengono modificati
- Utilizzare TTL appropriati per il tipo di contenuto

### 2. Sicurezza
- Validare sempre i dati in ingresso
- Utilizzare CSRF protection
- Limitare l'accesso admin ai form sensibili

### 3. Performance
- Utilizzare lazy loading per form complessi
- Ottimizzare le query del database
- Implementare caching intelligente

### 4. Accessibilità
- Utilizzare label semantiche
- Implementare ARIA attributes
- Testare con screen reader

## Troubleshooting

### Errore Comune: Plugin non registrato ✅ RISOLTO
```bash

# Soluzione: Verificare la registrazione nel Service Provider
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Errore Comune: Modelli non trovati ✅ RISOLTO
```bash

# Soluzione: Verificare la configurazione dei modelli
php artisan tinker
>>> config('zeus-bolt.models')
```

### Errore Comune: Tabelle mancanti ✅ RISOLTO
```bash

# Soluzione: Eseguire le migrazioni
php artisan migrate
php artisan migrate:status
```

## Collegamenti e Riferimenti

- [Documentazione Ufficiale Larazeus Bolt](https://larazeus.com/docs/bolt/v3/introduction)
- [GitHub Repository](https://github.com/lara-zeus/bolt)
- [Filament Plugin Tools](https://github.com/lara-zeus/filament-plugin-tools)

## Filosofia di Integrazione

L'integrazione di Larazeus Bolt v3 nel progetto <nome progetto> segue i principi di:

- **Modularità**: Ogni componente è indipendente e riutilizzabile
- **Estensibilità**: Architettura plugin-based per funzionalità aggiuntive
- **Performance**: Sistema di cache intelligente per ottimizzare i tempi di risposta
- **Sicurezza**: Validazione robusta e protezione CSRF integrata
- **Accessibilità**: Design inclusivo e supporto per screen reader

Questa integrazione rappresenta l'evoluzione naturale del sistema di form building nel contesto sanitario, garantendo flessibilità, sicurezza e performance ottimali.

## Stato dell'Implementazione

### ✅ Completato
- [x] Configurazione del plugin Bolt
- [x] Registrazione nel AdminPanelProvider
- [x] Pubblicazione delle configurazioni
- [x] Pubblicazione delle migrazioni
- [x] Test del plugin
- [x] Verifica delle route
- [x] Documentazione completa

### 🔄 In Corso
- [ ] Test del frontend
- [ ] Personalizzazione del tema
- [ ] Ottimizzazione delle performance

### 📋 Da Implementare
- [ ] Form specifici per il contesto sanitario
- [ ] Integrazione con il sistema di notifiche
- [ ] Backup e restore dei form
- [ ] Analytics sui form

---

*Ultimo aggiornamento: Dicembre 2024*
*Versione: 1.0*
*Compatibilità: Laravel 12.x, Filament 4.x, Larazeus Bolt v3*
