# NestedSet Migration Best Practices - Job Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Job utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Lavoro

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\JobCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi categoria lavoro
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia categorie
            NestedSet::columns($table);

            // Metadati categoria
            $table->string('icon')->nullable();
            $table->string('color')->default('#6b7280');
            $table->json('skills')->nullable(); // Competenze richieste

            // Configurazioni
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }
};
```

## Pattern per Dipartimenti Aziendali

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\Department::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi dipartimento
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia dipartimenti
            NestedSet::columns($table);

            // Gestione
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Budget e risorse
            $table->decimal('budget', 15, 2)->nullable();
            $table->integer('employee_count')->default(0);

            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Foreign key
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('set null');
        });
    }
};
```

## Pattern per Posizioni Lavorative

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\Position::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi posizione
            $table->string('title');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia posizioni
            NestedSet::columns($table);

            // Livello e categoria
            $table->string('level'); // junior, senior, manager, director
            $table->string('category'); // technical, administrative, executive

            // Range salariale
            $table->decimal('min_salary', 10, 2)->nullable();
            $table->decimal('max_salary', 10, 2)->nullable();
            $table->string('currency', 3)->default('EUR');

            // Requisiti
            $table->json('requirements')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('benefits')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Organizzativa Job

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\OrganizationalUnit::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi unità
            $table->string('name');
            $table->string('type'); // department, division, team, section
            $table->string('code')->unique();

            // NestedSet per gerarchia organizzativa
            NestedSet::columns($table);

            // Gestione
            $table->unsignedBigInteger('head_id')->nullable();
            $table->unsignedBigInteger('deputy_head_id')->nullable();

            // Informazioni
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('cost_center')->nullable();

            // Configurazioni
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Workflow di Approvazione

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\ApprovalWorkflow::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi workflow
            $table->string('name');
            $table->string('type'); // job_approval, leave_request, expense_claim
            $table->text('description')->nullable();

            // NestedSet per gerarchia workflow
            NestedSet::columns($table);

            // Configurazioni
            $table->json('steps')->nullable(); // Sequenza passi approvazione
            $table->json('rules')->nullable(); // Regole condizionali
            $table->json('notifications')->nullable(); // Impostazioni notifiche

            // Limiti e soglie
            $table->decimal('amount_threshold', 10, 2)->nullable();
            $table->integer('days_limit')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Integrazione con AddressItemEnum per Sedi Lavoro

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\OfficeLocation::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi sede lavorativa
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type'); // headquarters, branch, remote

            // Campi indirizzo usando AddressItemEnum::columns()
            AddressItemEnum::columns($table, withLegacy: true);

            // Dettagli sede
            $table->integer('capacity')->nullable();
            $table->string('manager')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Orari
            $table->json('working_hours')->nullable();
            $table->string('timezone')->default('Europe/Rome');

            // Metadati
            $table->json('facilities')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli Job

```php
<?php

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class JobCategory extends Model
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'skills',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relazioni
    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class);
    }

    // Scopes specifici Job
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Metodi helper
    public function getAllJobPostingsCount(): int
    {
        return $this->descendants()
            ->withCount('jobPostings')
            ->get()
            ->sum('job_postings_count');
    }

    public function getRequiredSkills(): array
    {
        $skills = $this->skills ?? [];

        foreach ($this->descendants as $descendant) {
            $skills = array_merge($skills, $descendant->skills ?? []);
        }

        return array_unique($skills);
    }
}
```

## Best Practices Specifiche per Job

### 1. Nomenclatura Coerente

- `JobCategory`: Categorie gerarchiche di offerte lavoro
- `Department`: Struttura dipartimentale aziendale
- `Position`: Posizioni lavorative gerarchiche
- `OrganizationalUnit`: Unità organizzative flessibili
- `ApprovalWorkflow`: Workflow approvazione gerarchici

### 2. Validazioni Gerarchiche

```php
// Validazione manager appartiene al dipartimento
public function setManagerIdAttribute($value)
{
    if ($value && !Employee::where('id', $value)->where('department_id', $this->id)->exists()) {
        throw new \Exception('Manager must belong to this department');
    }
    $this->attributes['manager_id'] = $value;
}
```

### 3. Calcoli Automatici

```php
// Aggiornamento conteggio dipendenti
protected static function boot()
{
    parent::boot();

    static::saved(function ($department) {
        $department->updateEmployeeCount();
        $department->updateAncestorsEmployeeCount();
    });
}

public function updateEmployeeCount()
{
    $this->update(['employee_count' => $this->employees()->count()]);
}
```

### 4. Indici per Performance Job

```php
// Indici ottimizzati per query Job
$table->index(['parent_id', 'is_active']);
$table->index('manager_id');
$table->index('code');
$table->index('type');
$table->index(['level', 'category']);
```

## Pattern per Report Organizzativi

```php
// Query ottimizzate per report
public function getOrganizationChart()
{
    return $this->with(['manager', 'employees'])
        ->active()
        ->defaultOrder()
        ->get()
        ->toTree();
}

public function getDepartmentStatistics()
{
    return $this->withCount('employees')
        ->withSum('budget', 'budget')
        ->active()
        ->get();
}
```

## Pattern per Job Postings con Categorie

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Job\Models\JobPosting::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi offerta
            $table->string('title');
            $table->text('description');
            $table->string('employment_type'); // full-time, part-time, contract

            // Relazione categoria gerarchica
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('job_categories');

            // Location (con AddressItemEnum)
            AddressItemEnum::columns($table, withLegacy: true);

            // Dettagli
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();

            // Stato
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->date('published_at')->nullable();
            $table->date('expires_at')->nullable();

            $table->timestamps();
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Job Module Architecture](/docs/architecture/job-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)
