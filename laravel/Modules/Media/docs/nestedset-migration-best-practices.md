# NestedSet Migration Best Practices - Media Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Media utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Media

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\MediaCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi categoria media
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

## Pattern per Cartelle Virtuali

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\VirtualFolder::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi cartella virtuale
            $table->string('name');
            $table->string('path')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia cartelle virtuali
            NestedSet::columns($table);
            
            // Dettagli cartella
            $table->string('disk')->default('public');
            $table->json('filters')->nullable(); // Filtri automatici
            $table->json('sorting')->nullable(); // Regole ordinamento
            
            // Permessi
            $table->json('permissions')->nullable();
            $table->boolean('is_public')->default(true);
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Album Fotografici

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\PhotoAlbum::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi album
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia album
            NestedSet::columns($table);
            
            // Dettagli album
            $table->string('cover_image')->nullable();
            $table->date('date')->nullable();
            $table->string('location')->nullable();
            $table->string('event_type')->nullable(); // wedding, concert, exhibition
            
            // Impostazioni
            $table->boolean('is_public')->default(true);
            $table->boolean('allow_comments')->default(false);
            $table->boolean('allow_download')->default(true);
            $table->boolean('allow_sharing')->default(true);
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Raccolte Tematiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\MediaCollection::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi collezione
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia collezioni
            NestedSet::columns($table);
            
            // Tema e stile
            $table->string('theme')->nullable(); // nature, urban, abstract
            $table->string('style')->nullable(); // modern, vintage, artistic
            
            // Layout
            $table->string('layout')->default('grid'); // grid, masonry, list, carousel
            $table->json('layout_settings')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Asset Temi

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\ThemeAsset::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi asset tema
            $table->string('theme_name'); // sixteen, admin, custom
            $table->string('section'); // css, js, images, fonts, icons
            
            // NestedSet per gerarchia asset tema
            NestedSet::columns($table);
            
            // Dettagli asset
            $table->string('name');
            $table->string('file_path');
            $table->string('url')->nullable();
            
            // Tipologia
            $table->string('type'); // css, js, image, font, icon
            $table->string('variant')->nullable(); // minified, compressed, debug
            $table->string('version')->nullable();
            
            // Dipendenze
            $table->json('dependencies')->nullable(); // Asset richiesti
            $table->json('load_order')->nullable(); // Ordine caricamento
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli Media

```php
<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class MediaCategory extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'metadata',
        'is_active',
        'sort_order',
    ];
    
    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
    
    // Relazioni
    public function media()
    {
        return $this->hasMany(Media::class);
    }
    
    // Scopes specifici Media
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
    
    // Metodi helper
    public function getAllMediaCount(): int
    {
        return $this->descendants()
            ->withCount('media')
            ->get()
            ->sum('media_count');
    }
    
    public function getFullSlug(): string
    {
        $slugs = $this->ancestors()->pluck('slug')->push($this->slug);
        return implode('/', $slugs->toArray());
    }
}
```

## Best Practices Specifiche per Media

### 1. Nomenclatura Coerente

- `MediaCategory`: Categorizzazione gerarchica media
- `VirtualFolder`: Cartelle virtuali con filtri
- `PhotoAlbum`: Album fotografici gerarchici
- `MediaCollection`: Raccolte tematiche organizzate
- `ThemeAsset`: Asset temi con dipendenze

### 2. Gestione Percorsi Virtuali

```php
// Percorso virtuale cartella
public function getVirtualPath(): string
{
    if ($this->isRoot()) {
        return '/';
    }
    
    $parentPath = $this->parent?->getVirtualPath() ?? '';
    return $parentPath === '/' ? "/{$this->name}" : "{$parentPath}/{$this->name}";
}
```

### 3. Gestione Dipendenze Asset

```php
// Risoluzione dipendenze ricorsive
public function getAllDependencies(): array
{
    $dependencies = $this->dependencies ?? [];
    
    foreach ($this->ancestors as $ancestor) {
        $dependencies = array_merge($dependencies, $ancestor->dependencies ?? []);
    }
    
    return array_unique($dependencies);
}
```

### 4. Indici per Performance Media

```php
// Indici ottimizzati per query Media
$table->index(['parent_id', 'is_active']);
$table->index('slug');
$table->index('theme_name');
$table->index(['theme_name', 'section', 'type']);
$table->index('file_path');
```

## Pattern per Media Geolocalizzati con AddressItemEnum

Integrazione con AddressItemEnum per media con posizione geografica:

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\LocationMedia::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi media
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // photo, video, document, audio
            
            // Campi geografici usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Dettagli media
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->json('exif_data')->nullable(); // Dati EXIF per foto
            $table->json('metadata')->nullable();
            
            // Date e orari
            $table->timestamp('taken_at')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            
            // Metadati aggiuntivi
            $table->string('camera_make')->nullable();
            $table->string('camera_model')->nullable();
            $table->decimal('gps_accuracy', 8, 4)->nullable();
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Raccolte Multi-lingua

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\MultilingualCollection::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi collezione
            $table->string('name');
            $table->string('slug')->unique();
            
            // NestedSet per gerarchia collezioni
            NestedSet::columns($table);
            
            // Traduzioni
            $table->json('translations')->nullable(); // ['it' => [...], 'en' => [...]]
            
            // Configurazioni
            $table->string('default_language')->default('it');
            $table->json('supported_languages')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Gallery Dinamiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Media\Models\DynamicGallery::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi galleria
            $table->string('name');
            $table->string('slug')->unique();
            
            // NestedSet per gerarchia gallerie
            NestedSet::columns($table);
            
            // Configurazioni dinamiche
            $table->json('query_filters')->nullable(); // Filtri dinamici
            $table->json('display_rules')->nullable(); // Regole visualizzazione
            $table->json('layout_config')->nullable(); // Configurazione layout
            
            // Cache e performance
            $table->json('cache_config')->nullable();
            $table->integer('cache_ttl')->default(3600);
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Media Module Architecture](/docs/architecture/media-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)