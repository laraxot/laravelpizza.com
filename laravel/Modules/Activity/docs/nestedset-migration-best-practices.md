---
title: "NestedSet Migration Best Practices - Activity Module"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "nestedset migration best practices - activity module activity"
---
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
};
```

## Pattern per Activity Types


    protected ?string $model_class = \Modules\Activity\Models\ActivityType::class;


            // Campi per tipi di attività
            $table->string('code')->unique();

            // NestedSet per gerarchia tipi

            // Configurazioni per tipi
            $table->json('settings')->nullable();
            $table->boolean('requires_approval')->default(false);
            $table->boolean('is_system')->default(false);


## Pattern per Workflow States


    protected ?string $model_class = \Modules\Activity\Models\WorkflowState::class;


            // Campi per stati workflow

            // NestedSet per gerarchia stati

            // Configurazioni workflow
            $table->json('transitions')->nullable()->comment('Transizioni possibili da questo stato');
            $table->boolean('is_final')->default(false);
            $table->boolean('is_initial')->default(false);


## Integrazione con Modelli Activity


namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ActivityCategory extends Model
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

    // Scopes specifici per Activity
    public function scopeActive($query)
        return $query->where('is_active', true);

    public function scopeOrdered($query)
        return $query->orderBy('sort_order')->orderBy('name');

## Best Practices Specifiche per Activity

### 1. Nomenclatura Coerente

- `ActivityCategory`: Categorizzazione gerarchica delle attività
- `ActivityType`: Tipi di attività con ereditarietà
- `WorkflowState`: Stati workflow con transizioni

### 2. Metadata Flessibili

// Esempio di metadata per ActivityCategory
$metadata = [
    'default_duration' => 60, // minuti
    'required_skills' => ['skill1', 'skill2'],
    'notification_settings' => [
        'email' => true,
        'sms' => false
    ]

### 3. Indici per Performance

// Indici specifici per query Activity
$table->index(['parent_id', 'is_active']);
$table->index(['slug', 'is_active']);
$table->index('sort_order');

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Activity Module Architecture](/docs/architecture/activity-module.md)
# NestedSet Migration Best Practices — DOCUMENTO LEGACY

> **ATTENZIONE**: Questo documento è **legacy**. Il progetto ha completato la migrazione
> da `kalnoy/nestedset` a `staudenmeir/laravel-adjacency-list` (marzo 2026).
>
> Il pacchetto `kalnoy/nestedset` è stato **rimosso** dal progetto.

## Documento Aggiornato

Per le best practices attuali sulle strutture ad albero, consultare:

- **[Adjacency List Migration — Filosofia Completa](../../Xot/docs/adjacency-list-migration.md)**
- **[Adjacency List Best Practices](../../Xot/docs/best-practices/adjacency-list-best-practices.md)**
- **[BaseTreeModel Documentation](../../Xot/docs/models/base-tree-model.md)**

## Regola Attuale

Per tutti i nuovi modelli ad albero:

use Modules\Xot\Models\BaseTreeModel;

class MyTreeModel extends BaseTreeModel
    // Tutto il tree functionality è ereditato automaticamente

**NON usare** `NodeTrait`, `NestedSet::columns()`, o colonne `_lft`/`_rgt`.

## Cronologia

- **Pre-2025**: Progetto usava `kalnoy/nestedset`
- **2025**: Migrazione progressiva a `staudenmeir/laravel-adjacency-list`
- **2026-03**: Rimozione completa di `kalnoy/nestedset`

*Ultimo aggiornamento: marzo 2026*
