# Architettura Avanzata del Framework Xot basata sui Principi Filament

## Introduzione

Basandoci sui principi architetturali osservati nel pacchetto `filament-spatie-laravel-database-mail-templates`, questo documento illustra come applicare questi concetti al modulo Xot, che funge da infrastruttura centrale per tutti gli altri moduli del progetto <nome progetto>.

## Sistema di Plugin Centralizzato

### Architettura Plugin per il Framework

Come nel pacchetto studiato, possiamo implementare un'architettura plugin centralizzata nel modulo Xot:

```php
<?php

namespace Modules\Xot\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Xot\Filament\Resources\ModuleResource;
use Modules\Xot\Filament\Resources\ThemeResource;

class XotPlugin implements Plugin
{
    public function getId(): string
    {
        return 'xot';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            ModuleResource::class,
            ThemeResource::class,
            // Altre risorse centrali
        ]);

        // Registrazione di componenti e servizi globali
        $this->registerGlobalComponents($panel);
    }

    public function boot(Panel $panel): void
    {
        // Inizializzazione del framework
        $this->initializeFramework($panel);
    }

    private function registerGlobalComponents(Panel $panel): void
    {
        // Registrazione di componenti globali
    }

    private function initializeFramework(Panel $panel): void
    {
        // Logica di inizializzazione del framework
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
```

## Sistema di Gestione Moduli

### Modello Avanzato per Moduli

```php
<?php

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'version',
        'author',
        'license',
        'enabled',
        'dependencies',
        'config',
        'metadata',
    ];

    public array $translatable = [
        'description',
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'dependencies' => 'array',
            'config' => 'array',
            'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function migrations(): HasMany
    {
        return $this->hasMany(ModuleMigration::class, 'module_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(ModulePermission::class, 'module_id');
    }

    public function getInstalledVersionAttribute(): ?string
    {
        $latestMigration = $this->migrations()->latest('batch')->first();
        return $latestMigration ? $latestMigration->migration : null;
    }

    public function isEnabled(): bool
    {
        return $this->enabled && $this->getInstalledVersionAttribute() === $this->version;
    }
}
```

## Sistema di Template Globale

### Template di Sistema

Come nel pacchetto studiato per i template email, possiamo implementare un sistema di template globale per il framework:

```php
<?php

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SystemTemplate extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'type', // email, view, component, etc.
        'content',
        'variables',
        'is_active',
        'module',
    ];

    public array $translatable = [
        'content',
    ];

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function scopeForType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForModule($query, string $module)
    {
        return $query->where('module', $module);
    }

    public const TEMPLATE_TYPES = [
        'email' => 'Email Template',
        'view' => 'View Template',
        'component' => 'Component Template',
        'notification' => 'Notification Template',
        'form' => 'Form Template',
        'table' => 'Table Template',
    ];
}
```

## Componenti UI Avanzati per il Framework

### Componenti Riutilizzabili

Come nel pacchetto studiato, possiamo creare componenti specializzati per il framework:

```php
<?php

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class ModuleConfigEditor extends Field
{
    protected string $view = 'xot::filament.components.module-config-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public static function make(string $name = 'module-config-editor'): static
    {
        return parent::make($name)
            ->view('xot::filament.components.module-config-editor');
    }
}
```

## Sistema di Configurazione Modulare

### Modello per Configurazioni di Sistema

```php
<?php

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SystemConfig extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'module',
        'section',
        'is_public',
        'configurable_type',
        'configurable_id',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
            'is_public' => 'boolean',
        ];
    }

    public function configurable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeForKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    public function scopeForModule($query, string $module)
    {
        return $query->where('module', $module);
    }

    public function scopeForSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    public static function getValue(string $key, string $module, $default = null)
    {
        $config = static::where('key', $key)
            ->where('module', $module)
            ->first();

        return $config ? $config->value : $default;
    }

    public static function setValue(string $key, string $module, $value, string $section = 'general'): void
    {
        static::updateOrCreate(
            [
                'key' => $key,
                'module' => $module,
            ],
            [
                'value' => $value,
                'section' => $section,
            ]
        );
    }
}
```

## Sistema di Temi Avanzato

### Modello per la Gestione Temi

```php
<?php

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Theme extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'version',
        'author',
        'path',
        'config',
        'assets_path',
        'views_path',
        'is_active',
        'is_default',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public static function active(): ?self
    {
        return static::where('is_active', true)->first();
    }

    public static function default(): ?self
    {
        return static::where('is_default', true)->first();
    }

    public function getAssetUrl(string $path): string
    {
        return asset($this->assets_path . '/' . $path);
    }

    public function getViewPath(string $view): string
    {
        return $this->views_path . '.' . $view;
    }
}
```

## Servizi Centrali del Framework

### Servizio di Gestione Moduli

```php
<?php

namespace Modules\Xot\Services;

use Modules\Xot\Models\Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ModuleManagerService
{
    public function enable(Module $module): void
    {
        if ($module->isEnabled()) {
            throw new \Exception("Module {$module->name} is already enabled");
        }

        // Esegui le migrazioni del modulo
        Artisan::call('module:migrate', ['module' => $module->name]);

        // Aggiorna lo stato del modulo
        $module->update(['enabled' => true]);
    }

    public function disable(Module $module): void
    {
        if (!$module->isEnabled()) {
            throw new \Exception("Module {$module->name} is not enabled");
        }

        // Disabilita il modulo
        $module->update(['enabled' => false]);
    }

    public function install(Module $module): void
    {
        // Esegui le migrazioni iniziali
        Artisan::call('module:migrate', ['module' => $module->name]);

        // Pubblica asset e configurazioni
        Artisan::call('module:publish', [
            'module' => $module->name,
            '--tag' => ['config', 'assets', 'views']
        ]);

        // Aggiorna lo stato del modulo
        $module->update(['enabled' => true]);
    }

    public function uninstall(Module $module): void
    {
        // Rollback delle migrazioni
        Artisan::call('module:rollback', ['module' => $module->name]);

        // Rimuovi il modulo dal database
        $module->delete();
    }

    public function update(Module $module, string $newVersion): void
    {
        // Esegui le migrazioni per l'aggiornamento
        Artisan::call('module:migrate', [
            'module' => $module->name,
            '--force' => true
        ]);

        // Aggiorna la versione
        $module->update(['version' => $newVersion]);
    }

    public function getModuleDependencies(Module $module): array
    {
        $dependencies = [];
        foreach ($module->dependencies as $dependencyName) {
            $dependency = Module::where('name', $dependencyName)->first();
            if ($dependency) {
                $dependencies[] = $dependency;
            }
        }

        return $dependencies;
    }
}
```

## Sistema di Eventi e Hook

### Sistema di Hook del Framework

```php
<?php

namespace Modules\Xot\Services;

use Illuminate\Support\Facades\Event;

class HookService
{
    private array $hooks = [];

    public function add(string $hook, callable $callback, int $priority = 10): void
    {
        $this->hooks[$hook][$priority][] = $callback;
        ksort($this->hooks[$hook]);
    }

    public function apply(string $hook, mixed $value = null, array $params = []): mixed
    {
        if (!isset($this->hooks[$hook])) {
            return $value;
        }

        $result = $value;
        foreach ($this->hooks[$hook] as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                $result = call_user_func($callback, $result, ...$params);
            }
        }

        return $result;
    }

    public function fire(string $hook, array $params = []): void
    {
        Event::dispatch($hook, $params);
    }

    public function remove(string $hook, ?callable $callback = null): void
    {
        if ($callback === null) {
            unset($this->hooks[$hook]);
        } else {
            foreach ($this->hooks[$hook] as $priority => $callbacks) {
                $this->hooks[$hook][$priority] = array_filter(
                    $callbacks,
                    fn($cb) => $cb !== $callback
                );
            }
        }
    }
}
```

## Conclusione

Applicando i principi architetturali osservati nel pacchetto `filament-spatie-laravel-database-mail-templates` al modulo Xot, possiamo ottenere:

1. **Architettura modulare** basata sul pattern plugin
2. **Sistema di template flessibile** per tutti i tipi di contenuti
3. **Componenti UI specializzati** e riutilizzabili
4. **Sistema di configurazione centralizzato** e flessibile
5. **Gestione avanzata di moduli e temi** con versioning e dipendenze
6. **Framework estendibile** grazie al sistema di hook ed eventi
7. **Esperienza di sviluppo coerente** grazie ai principi architetturali standardizzati

Questa architettura permette al modulo Xot di fungere da base solida e flessibile per tutti gli altri moduli del sistema, mantenendo al contempo un'elevata qualità del codice e una buona esperienza di sviluppo.
