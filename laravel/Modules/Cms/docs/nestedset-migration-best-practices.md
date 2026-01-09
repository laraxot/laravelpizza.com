# NestedSet Migration Best Practices - CMS Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo CMS utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Menu di Navigazione

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Cms\Models\Menu::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi navigazione
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('target')->default('_self'); // _self, _blank, _parent

            // NestedSet per gerarchia menu
            NestedSet::columns($table);

            // Campi specifici CMS
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('role')->nullable()->comment('Ruolo richiesto per visualizzare');

            $table->timestamps();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (!$this->hasColumn('parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable();
            }

            $this->updateTimestamps($table, true);
        });
    }
};
```

## Pattern per Pagine Gerarchiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Cms\Models\Page::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi pagina
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();

            // NestedSet per gerarchia pagine
            NestedSet::columns($table);

            // Metadati SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Campi CMS
            $table->string('template')->default('default');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }
};
```

## Pattern per Categorie Contenuti

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Cms\Models\Category::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi categoria
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia categorie
            NestedSet::columns($table);

            // Campi specifici CMS
            $table->string('color')->default('#6b7280');
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Sito

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Cms\Models\SiteStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi struttura
            $table->string('name');
            $table->string('type'); // page, category, link, section
            $table->string('reference_id')->nullable(); // ID del riferimento
            $table->string('reference_type')->nullable(); // Tipo del riferimento

            // NestedSet per gerarchia sito
            NestedSet::columns($table);

            // Configurazioni
            $table->json('settings')->nullable();
            $table->boolean('is_navigable')->default(true);

            $table->timestamps();
        });
    }
};
```

## Integrazione con BaseTreeModel

```php
<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Xot\Models\Traits\TypedHasRecursiveRelationships;

class Menu extends BaseTreeModel
{
    use NodeTrait;

    protected $fillable = [
        'title',
        'url',
        'icon',
        'target',
        'order',
        'is_active',
        'role',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scopes specifici CMS
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('title');
    }

    public function scopeByRole($query, $role = null)
    {
        if ($role) {
            return $query->where('role', $role);
        }
        return $query->whereNull('role');
    }
}
```

## Best Practices Specifiche per CMS

### 1. Nomenclatura Coerente

- `Menu`: Struttura di navigazione principale
- `Page`: Pagine gerarchiche del sito
- `Category`: Categorizzazione contenuti
- `SiteStructure`: Struttura generale del sito

### 2. Gestione URL Slug

```php
// Esempio di generazione slug gerarchico
public function getFullSlugAttribute(): string
{
    $slugs = $this->ancestors()->pluck('slug')->push($this->slug);
    return implode('/', $slugs->toArray());
}

public function getFullPathAttribute(): string
{
    return '/'.$this->full_slug;
}
```

### 3. Template System

```php
// Ereditarietà template da parent
public function getEffectiveTemplateAttribute(): string
{
    if ($this->template !== 'default') {
        return $this->template;
    }

    return $this->parent?->effective_template ?? 'default';
}
```

### 4. Indici per Performance CMS

```php
// Indici ottimizzati per query CMS
$table->index(['parent_id', 'is_active']);
$table->index(['slug', 'is_published']);
$table->index('order');
$table->index('type');
$table->index(['reference_type', 'reference_id']);
```

## Pattern per Multi-sito

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Cms\Models\SiteMenu::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Multi-sito support
            $table->string('site_id');
            $table->string('title');
            $table->string('url')->nullable();

            // NestedSet per gerarchia menu per sito
            NestedSet::columns($table);

            // Campi specifici
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indici per multi-sito
            $table->index(['site_id', 'parent_id', 'is_active']);
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [CMS Module Architecture](/docs/architecture/cms-module.md)
- [BaseTreeModel Documentation](/docs/models/base-tree-model.md)
