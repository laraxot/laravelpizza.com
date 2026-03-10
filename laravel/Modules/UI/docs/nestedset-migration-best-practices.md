# NestedSet Migration Best Practices - UI Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo UI utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Temi

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\ThemeCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi categoria tema
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia categorie
            NestedSet::columns($table);

            // Metadati categoria
            $table->string('icon')->nullable();
            $table->string('color')->default('#6b7280');
            $table->json('metadata')->nullable();

            // Configurazioni
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Temi

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\Theme::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi tema
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia temi
            NestedSet::columns($table);

            // Dettagli tema
            $table->string('version')->default('1.0.0');
            $table->string('author')->nullable();
            $table->string('license')->nullable();

            // Dipendenze
            $table->json('dependencies')->nullable(); // Temi genitori
            $table->json('assets')->nullable(); // CSS, JS, immagini

            // Configurazioni
            $table->json('config')->nullable();
            $table->json('variables')->nullable(); // Variabili CSS

            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }
};
```

## Pattern per Componenti UI

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\UIComponent::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi componente
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia componenti
            NestedSet::columns($table);

            // Dettagli componente
            $table->string('type'); // button, card, modal, form
            $table->string('framework')->default('tailwind'); // tailwind, bootstrap, custom

            // Template e stile
            $table->longText('template')->nullable();
            $table->json('styles')->nullable();
            $table->json('props')->nullable(); // Proprietà del componente

            // Rendering
            $table->json('slots')->nullable(); // Slot disponibili
            $table->json('events')->nullable(); // Eventi gestiti

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Layout Pagine

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\Layout::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi layout
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia layout
            NestedSet::columns($table);

            // Struttura layout
            $table->json('sections')->nullable(); // Sezioni del layout
            $table->json('grid')->nullable(); // Configurazione griglia
            $table->json('breakpoints')->nullable(); // Breakpoint responsive

            // Componenti
            $table->json('components')->nullable(); // Componenti inclusi
            $table->json('regions')->nullable(); // Regioni del layout

            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }
};
```

## Pattern per Menu Navigazione

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\NavigationMenu::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi menu
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia menu
            NestedSet::columns($table);

            // Link e navigazione
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->json('parameters')->nullable();

            // Aspetto
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('target')->default('_self');

            // Permessi e visibilità
            $table->json('permissions')->nullable();
            $table->json('roles')->nullable();
            $table->boolean('is_visible')->default(true);

            // Ordinamento
            $table->integer('order')->default(0);

            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli UI

```php
<?php

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Theme extends Model
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'version',
        'author',
        'license',
        'dependencies',
        'assets',
        'config',
        'variables',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'dependencies' => 'array',
        'assets' => 'array',
        'config' => 'array',
        'variables' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    // Relazioni
    public function components()
    {
        return $this->hasMany(UIComponent::class);
    }

    public function layouts()
    {
        return $this->hasMany(Layout::class);
    }

    // Scopes specifici UI
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Metodi helper
    public function getAllAssets(): array
    {
        $assets = $this->assets ?? [];

        foreach ($this->ancestors as $ancestor) {
            $assets = array_merge($assets, $ancestor->assets ?? []);
        }

        return array_unique($assets);
    }

    public function getEffectiveVariables(): array
    {
        $variables = $this->variables ?? [];

        foreach ($this->ancestors as $ancestor) {
            $variables = array_merge($variables, $ancestor->variables ?? []);
        }

        return $variables;
    }
}
```

## Best Practices Specifiche per UI

### 1. Nomenclatura Coerente

- `ThemeCategory`: Categorizzazione temi UI
- `Theme`: Temi con ereditarietà variabili
- `UIComponent`: Componenti con template ereditati
- `Layout`: Layout con sezioni riutilizzabili
- `NavigationMenu`: Menu con permessi gerarchici

### 2. Gestione Variabili Ereditate

```php
// Variabili CSS ereditate da temi parent
public function getEffectiveVariables(): array
{
    $variables = $this->variables ?? [];

    foreach ($this->ancestors as $ancestor) {
        $variables = array_merge($variables, $ancestor->variables ?? []);
    }

    return $variables;
}
```

### 3. Validazioni Template Componenti

```php
// Validazione sintassi template
public function setTemplateAttribute($value)
{
    if ($value) {
        // Verifica sintassi Blade/Laravel
        if (!view()->exists('raw::'.$value)) {
            // Validazione base per parentesi graffe
            $open = substr_count($value, '{{');
            $close = substr_count($value, '}}');

            if ($open !== $close) {
                throw new \Exception('Unbalanced Blade directives in template');
            }
        }
    }

    $this->attributes['template'] = $value;
}
```

### 4. Indici per Performance UI

```php
// Indici ottimizzati per query UI
$table->index(['parent_id', 'is_active']);
$table->index('slug');
$table->index('type');
$table->index('framework');
$table->index(['is_visible', 'order']);
```

## Pattern per Componenti con AddressItemEnum

Integrazione con AddressItemEnum per componenti location-based:

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\LocationComponent::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi componente
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type'); // map, address_form, location_picker

            // Campi geografici usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);

            // Template e configurazione
            $table->longText('template')->nullable();
            $table->json('config')->nullable();
            $table->json('map_settings')->nullable(); // Impostazioni mappa

            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Temi Multi-lingua

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\MultilingualTheme::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi tema
            $table->string('name');
            $table->string('slug')->unique();

            // NestedSet per gerarchia temi
            NestedSet::columns($table);

            // Localizzazione
            $table->json('translations')->nullable(); // ['it' => [...], 'en' => [...]]
            $table->string('default_language')->default('it');
            $table->json('supported_languages')->nullable();

            // Configurazioni
            $table->json('rtl_languages')->nullable(); // Lingue RTL
            $table->json('date_formats')->nullable(); // Formati data per lingua

            $table->timestamps();
        });
    }
};
```

## Pattern per Layout Dinamici

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\UI\Models\DynamicLayout::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi layout
            $table->string('name');
            $table->string('slug')->unique();

            // NestedSet per gerarchia layout
            NestedSet::columns($table);

            // Configurazioni dinamiche
            $table->json('blueprint')->nullable(); // Schema layout
            $table->json('responsive_rules')->nullable(); // Regole responsive
            $table->json('conditional_blocks')->nullable(); // Blocchi condizionali

            // Componenti dinamici
            $table->json('dynamic_components')->nullable();
            $table->json('data_sources')->nullable(); // Fonti dati

            // Cache e performance
            $table->json('cache_config')->nullable();
            $table->integer('cache_ttl')->default(3600);

            $table->timestamps();
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [UI Module Architecture](/docs/architecture/ui-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)
