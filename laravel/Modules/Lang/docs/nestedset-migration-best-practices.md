# NestedSet Migration Best Practices - Lang Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Lang utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Linguistiche

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\LanguageCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi categoria linguistica
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia categorie
            NestedSet::columns($table);
            
            // Dettagli linguistici
            $table->string('iso_639_1', 2)->nullable(); // es. 'en'
            $table->string('iso_639_2', 3)->nullable(); // es. 'eng'
            $table->string('locale', 10)->nullable(); // es. 'en_US'
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Gruppi di Traduzioni

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\TranslationGroup::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi gruppo traduzioni
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia gruppi
            NestedSet::columns($table);
            
            // Configurazioni
            $table->string('module')->nullable(); // Nome modulo associato
            $table->string('context')->nullable(); // Contesto specifico
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura File di Traduzione

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\TranslationFile::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi file traduzione
            $table->string('name');
            $table->string('path');
            $table->string('extension', 10)->default('php');
            
            // NestedSet per gerarchia file
            NestedSet::columns($table);
            
            // Dettagli file
            $table->string('module')->nullable();
            $table->string('language', 10);
            $table->integer('lines_count')->default(0);
            
            // Stato
            $table->boolean('is_loaded')->default(false);
            $table->timestamp('last_modified')->nullable();
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Namespace di Traduzioni

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\TranslationNamespace::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi namespace
            $table->string('name');
            $table->string('prefix')->nullable();
            
            // NestedSet per gerarchia namespace
            NestedSet::columns($table);
            
            // Configurazioni
            $table->json('supported_languages')->nullable();
            $table->string('default_language')->default('en');
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Chiavi di Traduzione Gerarchiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\TranslationKey::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi chiave traduzione
            $table->string('key');
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia chiavi
            NestedSet::columns($table);
            
            // Metadati chiave
            $table->string('group')->nullable();
            $table->string('module')->nullable();
            $table->json('parameters')->nullable(); // Parametri richiesti
            
            // Stato
            $table->boolean('is_active')->default(true);
            $table->boolean('is_translated')->default(false);
            
            $table->timestamps();
            
            // Indice unico
            $table->unique(['key', 'group', 'module']);
        });
    }
};
```

## Integrazione con Modelli Lang

```php
<?php

namespace Modules\Lang\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class TranslationGroup extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'module',
        'context',
        'metadata',
        'is_active',
    ];
    
    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];
    
    // Relazioni
    public function translations()
    {
        return $this->hasMany(LanguageLine::class, 'group_id');
    }
    
    public function keys()
    {
        return $this->hasMany(TranslationKey::class, 'group_id');
    }
    
    // Scopes specifici Lang
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }
    
    // Metodi helper
    public function getAllTranslationsCount(): int
    {
        return $this->descendants()->withCount('translations')->get()->sum('translations_count');
    }
    
    public function getFullKey(string $key): string
    {
        $path = $this->ancestors()->pluck('slug')->push($this->slug)->implode('.');
        return "{$path}.{$key}";
    }
}
```

## Best Practices Specifiche per Lang

### 1. Nomenclatura Coerente

- `LanguageCategory`: Categorie gerarchiche di lingue
- `TranslationGroup`: Gruppi di traduzioni organizzati
- `TranslationFile`: Struttura file di traduzione
- `TranslationNamespace`: Namespace gerarchici per traduzioni
- `TranslationKey`: Chiavi di traduzione gerarchiche

### 2. Gestione Cache Traduzioni

```php
// Cache gerarchica traduzioni
public function getTranslationCacheKey(): string
{
    $path = $this->ancestors()->pluck('slug')->push($this->slug)->implode('.');
    return "translations.{$path}";
}
```

### 3. Validazioni Linguistiche

```php
// Validazione codici ISO
public function setIso6391Attribute($value)
{
    if ($value && !preg_match('/^[a-z]{2}$/', $value)) {
        throw new \Exception('ISO 639-1 must be 2 lowercase letters');
    }
    $this->attributes['iso_639_1'] = $value;
}
```

### 4. Indici per Performance Lang

```php
// Indici ottimizzati per query Lang
$table->index(['parent_id', 'is_active']);
$table->index('code');
$table->index('slug');
$table->index(['module', 'language']);
$table->index('locale');
```

## Pattern per Traduzioni Localizzate con AddressItemEnum

Integrazione con AddressItemEnum per traduzioni geografiche:

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\LocalizedTranslation::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi traduzione
            $table->string('key');
            $table->text('value');
            $table->string('language', 10);
            
            // Campi geografici usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Contesto
            $table->string('group')->nullable();
            $table->string('module')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            
            // Indici unici
            $table->unique(['key', 'language', 'country', 'administrative_area_level_2']);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Multi-Lingua

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\MultilingualStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi struttura
            $table->string('entity_type'); // Model type
            $table->unsignedBigInteger('entity_id');
            
            // NestedSet per gerarchia traduzioni entità
            NestedSet::columns($table);
            
            // Dati traduzione
            $table->string('language', 10);
            $table->json('translated_fields');
            
            // Stato
            $table->boolean('is_complete')->default(false);
            $table->timestamp('last_sync')->nullable();
            
            $table->timestamps();
            
            // Indici
            $table->index(['entity_type', 'entity_id']);
            $table->index('language');
        });
    }
};
```

## Pattern per Gerarchia File di Linguaggio

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Lang\Models\LanguageFile::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi file linguaggio
            $table->string('name');
            $table->string('path');
            $table->string('language', 10);
            
            // NestedSet per gerarchia file
            NestedSet::columns($table);
            
            // Dettagli file
            $table->string('module')->nullable();
            $table->string('type')->default('php'); // php, json, yaml
            
            // Statistiche
            $table->integer('keys_count')->default(0);
            $table->integer('translated_count')->default(0);
            $table->integer('percentage')->default(0);
            
            // Stato
            $table->boolean('is_published')->default(false);
            $table->timestamp('last_import')->nullable();
            
            $table->timestamps();
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Lang Module Architecture](/docs/architecture/lang-module.md)
- [Laravel Localization](https://laravel.com/docs/localization)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)