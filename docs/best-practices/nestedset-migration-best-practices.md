# NestedSet Migration Best Practices - XOT Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo XOT utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Struttura Moduli XOT

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\ModuleStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi struttura modulo
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia moduli
            NestedSet::columns($table);
            
            // Dettagli modulo
            $table->string('version')->default('1.0.0');
            $table->string('namespace')->nullable();
            $table->string('path')->nullable(); // Percorso fisico
            
            // Dipendenze
            $table->json('dependencies')->nullable(); // Moduli dipendenti
            $table->json('providers')->nullable(); // Service providers
            
            // Configurazioni
            $table->json('config')->nullable();
            $table->json('routes')->nullable();
            $table->json('middleware')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->boolean('is_core')->default(false); // Moduli core non disabilitabili
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Alberi di Modelli

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\ModelTree::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi albero modelli
            $table->string('name');
            $table->string('class_name')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia modelli
            NestedSet::columns($table);
            
            // Dettagli modello
            $table->string('module')->nullable(); // Modulo di appartenenza
            $table->string('table_name')->nullable(); // Tabella database
            $table->json('relationships')->nullable(); // Relazioni con altri modelli
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->json('schema')->nullable(); // Schema del modello
            $table->json('validation_rules')->nullable(); // Regole validazione
            
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Controller

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\ControllerTree::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi struttura controller
            $table->string('name');
            $table->string('class_name')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia controller
            NestedSet::columns($table);
            
            // Dettagli controller
            $table->string('module')->nullable();
            $table->json('methods')->nullable(); // Metodi del controller
            $table->json('routes')->nullable(); // Routes gestite
            
            // Middleware e permessi
            $table->json('middleware')->nullable();
            $table->json('permissions')->nullable();
            $table->json('policies')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura API

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\APIStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi struttura API
            $table->string('name');
            $table->string('endpoint')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia API
            NestedSet::columns($table);
            
            // Dettagli API
            $table->string('method')->default('GET'); // GET, POST, PUT, DELETE
            $table->string('version')->default('v1');
            $table->json('parameters')->nullable(); // Parametri API
            $table->json('responses')->nullable(); // Risposte possibili
            
            // Sicurezza
            $table->json('authentication')->nullable(); // Metodi autenticazione
            $table->json('authorization')->nullable(); // Permessi richiesti
            $table->json('rate_limiting')->nullable(); // Limiti rate
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(false);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Database

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\DatabaseStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi struttura database
            $table->string('name');
            $table->string('table_name')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia tabelle
            NestedSet::columns($table);
            
            // Dettagli tabella
            $table->string('engine')->default('InnoDB');
            $table->string('charset')->default('utf8mb4');
            $table->string('collation')->default('utf8mb4_unicode_ci');
            
            // Colonne
            $table->json('columns')->nullable(); // Definizione colonne
            $table->json('indexes')->nullable(); // Indici della tabella
            $table->json('foreign_keys')->nullable(); // Chiavi esterne
            
            // Relazioni
            $table->json('relationships')->nullable(); // Relazioni Eloquent
            $table->json('constraints')->nullable(); // Vincoli database
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli XOT

```php
<?php

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ModuleStructure extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'version',
        'namespace',
        'path',
        'dependencies',
        'providers',
        'config',
        'routes',
        'middleware',
        'is_active',
        'is_core',
    ];
    
    protected $casts = [
        'dependencies' => 'array',
        'providers' => 'array',
        'config' => 'array',
        'routes' => 'array',
        'middleware' => 'array',
        'is_active' => 'boolean',
        'is_core' => 'boolean',
    ];
    
    // Relazioni
    public function models()
    {
        return $this->hasMany(ModelTree::class, 'module_id');
    }
    
    public function controllers()
    {
        return $this->hasMany(ControllerTree::class, 'module_id');
    }
    
    // Scopes specifici XOT
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeCore($query)
    {
        return $query->where('is_core', true);
    }
    
    // Metodi helper
    public function getAllDependencies(): array
    {
        $dependencies = $this->dependencies ?? [];
        
        foreach ($this->ancestors as $ancestor) {
            $dependencies = array_merge($dependencies, $ancestor->dependencies ?? []);
        }
        
        return array_unique($dependencies);
    }
    
    public function getAllProviders(): array
    {
        $providers = $this->providers ?? [];
        
        foreach ($this->ancestors as $ancestor) {
            $providers = array_merge($providers, $ancestor->providers ?? []);
        }
        
        return array_unique($providers);
    }
}
```

## Best Practices Specifiche per XOT

### 1. Nomenclatura Coerente

- `ModuleStructure`: Struttura gerarchica moduli
- `ModelTree`: Albero di modelli Eloquent
- `ControllerTree`: Gerarchia controller
- `APIStructure`: Struttura API endpoint
- `DatabaseStructure`: Schema database gerarchico

### 2. Gestione Dipendenze Moduli

```php
// Dipendenze ricorsive
public function getAllDependencies(): array
{
    $dependencies = $this->dependencies ?? [];
    
    foreach ($this->ancestors as $ancestor) {
        $dependencies = array_merge($dependencies, $ancestor->dependencies ?? []);
    }
    
    return array_unique($dependencies);
}
```

### 3. Validazioni Namespace

```php
// Validazione namespace PHP
public function setNamespaceAttribute($value)
{
    if ($value && !preg_match('/^[A-Za-z0-9\\\\]+$/', $value)) {
        throw new \Exception('Invalid namespace format');
    }
    
    $this->attributes['namespace'] = $value;
}
```

### 4. Indici per Performance XOT

```php
// Indici ottimizzati per query XOT
$table->index(['parent_id', 'is_active']);
$table->index('slug');
$table->index('class_name');
$table->index('module');
$table->index('endpoint');
```

## Pattern per Modelli con AddressItemEnum

Integrazione con AddressItemEnum per modelli con location:

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\LocationModel::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi modello
            $table->string('name');
            $table->string('class_name')->unique();
            $table->text('description')->nullable();
            
            // Campi geografici usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Dettagli modello
            $table->string('module')->nullable();
            $table->string('table_name')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Configurazione

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\ConfigStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi configurazione
            $table->string('key')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia configurazione
            NestedSet::columns($table);
            
            // Valori
            $table->json('values')->nullable(); // Valori per ambiente
            $table->json('validation')->nullable(); // Regole validazione
            $table->json('defaults')->nullable(); // Valori default
            
            // Ambiente
            $table->string('environment')->nullable(); // local, testing, production
            $table->boolean('is_encrypted')->default(false);
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Comandi

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Xot\Models\CommandStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi comando
            $table->string('name');
            $table->string('signature')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia comandi
            NestedSet::columns($table);
            
            // Dettagli comando
            $table->string('class_name');
            $table->string('module')->nullable();
            $table->json('arguments')->nullable(); // Argomenti comando
            $table->json('options')->nullable(); // Opzioni disponibili
            
            // Esecuzione
            $table->json('prerequisites')->nullable(); // Prerequisiti
            $table->json('dependencies')->nullable(); // Dipendenze
            
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
- [XOT Module Architecture](/docs/architecture/xot-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)