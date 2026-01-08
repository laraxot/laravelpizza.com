# NestedSet Migration Best Practices - Activity Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Activity utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Activity Categories

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Activity\Models\ActivityCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi specifici per Activity
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->default('#6b7280');
            
            // NestedSet per gerarchia categorie
            NestedSet::columns($table);
            
            // Campi specifici del modulo
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (!$this->hasColumn('metadata')) {
                $table->json('metadata')->nullable()->comment('Dati aggiuntivi per la categoria');
            }
            
            $this->updateTimestamps($table, true);
        });
    }
};
```

## Pattern per Activity Types

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Activity\Models\ActivityType::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi per tipi di attività
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia tipi
            NestedSet::columns($table);
            
            // Configurazioni per tipi
            $table->json('settings')->nullable();
            $table->boolean('requires_approval')->default(false);
            $table->boolean('is_system')->default(false);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Workflow States

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Activity\Models\WorkflowState::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi per stati workflow
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia stati
            NestedSet::columns($table);
            
            // Configurazioni workflow
            $table->json('transitions')->nullable()->comment('Transizioni possibili da questo stato');
            $table->boolean('is_final')->default(false);
            $table->boolean('is_initial')->default(false);
            
            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli Activity

```php
<?php

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ActivityCategory extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'is_active',
        'sort_order',
        'metadata',
    ];
    
    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
    
    // Scopes specifici per Activity
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
```

## Best Practices Specifiche per Activity

### 1. Nomenclatura Coerente

- `ActivityCategory`: Categorizzazione gerarchica delle attività
- `ActivityType`: Tipi di attività con ereditarietà
- `WorkflowState`: Stati workflow con transizioni

### 2. Metadata Flessibili

```php
// Esempio di metadata per ActivityCategory
$metadata = [
    'default_duration' => 60, // minuti
    'required_skills' => ['skill1', 'skill2'],
    'notification_settings' => [
        'email' => true,
        'sms' => false
    ]
];
```

### 3. Indici per Performance

```php
// Indici specifici per query Activity
$table->index(['parent_id', 'is_active']);
$table->index(['slug', 'is_active']);
$table->index('sort_order');
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Activity Module Architecture](/docs/architecture/activity-module.md)