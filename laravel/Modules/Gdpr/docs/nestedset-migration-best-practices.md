# NestedSet Migration Best Practices - GDPR Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo GDPR utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie di Trattamento

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Gdpr\Models\TreatmentCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi categoria trattamento
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia categorie
            NestedSet::columns($table);

            // Campi GDPR specifici
            $table->string('legal_basis'); // consent, contract, legal_obligation, vital_interests, public_task, legitimate_interests
            $table->string('purpose')->nullable();
            $table->text('retention_policy')->nullable();
            $table->integer('retention_days')->nullable();

            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Tipi di Dati Personali

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Gdpr\Models\PersonalDataType::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi tipo dato personale
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia tipi
            NestedSet::columns($table);

            // Classificazione sensibilità
            $table->string('sensitivity_level'); // low, medium, high, special
            $table->boolean('is_special_category')->default(false);

            // Regole di trattamento
            $table->json('processing_rules')->nullable();
            $table->json('storage_requirements')->nullable();
            $table->json('encryption_requirements')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Organizzativa GDPR

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Gdpr\Models\GdprOrganizationalUnit::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi unità organizzativa
            $table->string('name');
            $table->string('type'); // controller, processor, dpo, data_protection_officer
            $table->string('contact_email');

            // NestedSet per gerarchia organizzativa GDPR
            NestedSet::columns($table);

            // Responsabilità
            $table->text('responsibilities')->nullable();
            $table->json('data_categories_processed')->nullable();
            $table->json('subprocessors')->nullable();

            // Certificazioni
            $table->string('certification')->nullable();
            $table->date('certification_expiry')->nullable();

            // Contatti
            $table->string('dpo_name')->nullable();
            $table->string('dpo_email')->nullable();

            $table->timestamps();
        });
    }
};
```

## Pattern per Policy Privacy Gerarchiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Gdpr\Models\PrivacyPolicy::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi policy
            $table->string('title');
            $table->string('version');
            $table->text('summary')->nullable();

            // NestedSet per gerarchia policy
            NestedSet::columns($table);

            // Contenuto
            $table->longText('content')->nullable();
            $table->json('sections')->nullable();

            // Metadati
            $table->string('language', 5)->default('it');
            $table->date('effective_date');
            $table->boolean('is_current')->default(false);

            $table->timestamps();
        });
    }
};
```

## Integrazione con AddressItemEnum per Dati di Contatto

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Gdpr\Models\DataSubject::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Identificazione soggetto
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();

            // Dati di contatto usando AddressItemEnum::columns()
            AddressItemEnum::columns($table, withLegacy: false);

            // Dati GDPR specifici
            $table->string('tax_code')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('birth_date')->nullable();

            // Preferenze privacy
            $table->json('privacy_preferences')->nullable();
            $table->json('consents')->nullable();
            $table->timestamp('consent_updated_at')->nullable();

            // Stato
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_activity_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
```

## Pattern per Data Processing Activities

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Gdpr\Models\DataProcessingActivity::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi attività
            $table->string('name');
            $table->text('description')->nullable();

            // NestedSet per gerarchia attività
            NestedSet::columns($table);

            // Dettagli trattamento
            $table->string('purpose');
            $table->string('legal_basis');
            $table->text('data_subjects')->nullable();
            $table->json('data_categories')->nullable();

            // Sicurezza
            $table->json('security_measures')->nullable();
            $table->string('risk_level')->nullable();

            // Controller/Processor
            $table->unsignedBigInteger('controller_id')->nullable();
            $table->unsignedBigInteger('processor_id')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('controller_id')->references('id')->on('gdpr_organizational_units');
            $table->foreign('processor_id')->references('id')->on('gdpr_organizational_units');
        });
    }
};
```

## Integrazione con Modelli GDPR

```php
<?php

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class TreatmentCategory extends Model
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'code',
        'description',
        'legal_basis',
        'purpose',
        'retention_policy',
        'retention_days',
        'metadata',
        'is_active',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'retention_days' => 'integer',
    ];

    // Relazioni
    public function treatments()
    {
        return $this->hasMany(DataProcessingActivity::class, 'category_id');
    }

    // Scopes specifici GDPR
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLegalBasis($query, $basis)
    {
        return $query->where('legal_basis', $basis);
    }

    // Metodi helper
    public function getAllTreatments()
    {
        return $this->descendants()->with('treatments')
            ->get()
            ->pluck('treatments')
            ->flatten();
    }

    public function getRetentionPeriodDays(): ?int
    {
        if ($this->retention_days) {
            return $this->retention_days;
        }

        return $this->ancestors()
            ->whereNotNull('retention_days')
            ->first()
            ?->retention_days;
    }
}
```

## Best Practices Specifiche per GDPR

### 1. Nomenclatura Coerente

- `TreatmentCategory`: Categorie gerarchiche di trattamenti
- `PersonalDataType`: Tipi di dati personali con sensibilità
- `GdprOrganizationalUnit`: Struttura responsabilità GDPR
- `PrivacyPolicy`: Policy gerarchiche per area

### 2. Validazioni Compliance

```php
// Validazione base giuridica
public function setLegalBasisAttribute($value)
{
    $validBases = [
        'consent',
        'contract',
        'legal_obligation',
        'vital_interests',
        'public_task',
        'legitimate_interests'
    ];

    if (!in_array($value, $validBases)) {
        throw new \Exception('Invalid legal basis');
    }

    $this->attributes['legal_basis'] = $value;
}
```

### 3. Audit Trail Automatico

```php
// Tracciamento modifiche categorie
protected static function boot()
{
    parent::boot();

    static::updated(function ($category) {
        AuditLog::create([
            'model_type' => static::class,
            'model_id' => $category->id,
            'action' => 'updated',
            'changes' => $category->getDirty(),
            'user_id' => auth()->id(),
        ]);
    });
}
```

### 4. Indici per Performance GDPR

```php
// Indici ottimizzati per query GDPR
$table->index(['parent_id', 'is_active']);
$table->index('legal_basis');
$table->index('code');
$table->index(['sensitivity_level', 'is_special_category']);
$table->index('effective_date');
```

## Pattern per Report GDPR

```php
// Query ottimizzate per report compliance
public function getComplianceReport()
{
    return $this->with(['treatments', 'ancestors'])
        ->active()
        ->get()
        ->map(function ($category) {
            return [
                'category' => $category->name,
                'treatments_count' => $category->treatments->count(),
                'legal_basis' => $category->legal_basis,
                'retention_days' => $category->getRetentionPeriodDays(),
                'risk_level' => $category->calculateRiskLevel(),
            ];
        });
}
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [GDPR Module Architecture](/docs/architecture/gdpr-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)
