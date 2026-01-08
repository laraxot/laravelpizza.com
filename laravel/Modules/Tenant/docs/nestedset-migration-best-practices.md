# NestedSet Migration Best Practices - Tenant Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Tenant utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Struttura Tenant

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\Tenant::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi tenant
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->unique();
            
            // NestedSet per gerarchia tenant
            NestedSet::columns($table);
            
            // Configurazioni
            $table->json('settings')->nullable();
            $table->json('features')->nullable(); // Funzionalità abilitate
            $table->json('limits')->nullable(); // Limiti risorse
            
            // Stato
            $table->boolean('is_active')->default(true);
            $table->timestamp('trial_ends_at')->nullable();
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Sottodomini Tenant

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\TenantSubdomain::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi sottodominio
            $table->string('subdomain')->unique();
            $table->string('domain');
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia sottodomini
            NestedSet::columns($table);
            
            // Configurazioni
            $table->unsignedBigInteger('tenant_id');
            $table->string('type')->default('subdomain'); // subdomain, custom_domain
            $table->boolean('is_primary')->default(false);
            
            // DNS e SSL
            $table->json('dns_records')->nullable();
            $table->string('ssl_status')->default('none'); // none, pending, active, expired
            $table->date('ssl_expires_at')->nullable();
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }
};
```

## Pattern per Piani Subscription

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\SubscriptionPlan::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi piano
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia piani
            NestedSet::columns($table);
            
            // Prezzi e fatturazione
            $table->decimal('monthly_price', 10, 2)->nullable();
            $table->decimal('yearly_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('EUR');
            
            // Limiti e funzionalità
            $table->json('limits')->nullable(); // utenti, storage, api_calls
            $table->json('features')->nullable(); // Funzionalità incluse
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Team Tenant

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\TenantTeam::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi team
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia team
            NestedSet::columns($table);
            
            // Tenant associato
            $table->unsignedBigInteger('tenant_id');
            
            // Gestione team
            $table->unsignedBigInteger('owner_id');
            $table->json('members')->nullable(); // Membri e ruoli
            
            // Permessi
            $table->json('permissions')->nullable();
            $table->json('settings')->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
```

## Pattern per Risorse Condivise

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\SharedResource::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi risorsa
            $table->string('name');
            $table->string('type'); // storage, bandwidth, users, api_calls
            
            // NestedSet per gerarchia risorse
            NestedSet::columns($table);
            
            // Configurazioni
            $table->json('allocation')->nullable(); // Allocazione per tenant
            $table->json('usage')->nullable(); // Utilizzo corrente
            $table->json('limits')->nullable(); // Limiti globali
            
            // Monitoring
            $table->json('metrics')->nullable(); // Metriche di utilizzo
            $table->timestamp('last_calculated')->nullable();
            
            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli Tenant

```php
<?php

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Tenant extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        'name',
        'slug',
        'domain',
        'settings',
        'features',
        'limits',
        'is_active',
        'trial_ends_at',
    ];
    
    protected $casts = [
        'settings' => 'array',
        'features' => 'array',
        'limits' => 'array',
        'is_active' => 'boolean',
        'trial_ends_at' => 'datetime',
    ];
    
    // Relazioni
    public function subdomains()
    {
        return $this->hasMany(TenantSubdomain::class);
    }
    
    public function teams()
    {
        return $this->hasMany(TenantTeam::class);
    }
    
    // Scopes specifici Tenant
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOnTrial($query)
    {
        return $query->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '>', now());
    }
    
    // Metodi helper
    public function getEffectiveLimits(): array
    {
        $limits = $this->limits ?? [];
        
        foreach ($this->ancestors as $ancestor) {
            $limits = array_merge($limits, $ancestor->limits ?? []);
        }
        
        return $limits;
    }
    
    public function hasFeature(string $feature): bool
    {
        $features = $this->features ?? [];
        
        foreach ($this->ancestors as $ancestor) {
            $features = array_merge($features, $ancestor->features ?? []);
        }
        
        return in_array($feature, $features);
    }
}
```

## Best Practices Specifiche per Tenant

### 1. Nomenclatura Coerente

- `Tenant`: Struttura tenant principale
- `TenantSubdomain`: Sottodomini gerarchici
- `SubscriptionPlan`: Piani con funzionalità ereditate
- `TenantTeam`: Team multi-livello
- `SharedResource`: Risorse condivise con allocazione

### 2. Gestione Limiti Ereditati

```php
// Limiti effettivi combinati
public function getEffectiveLimits(): array
{
    $limits = $this->limits ?? [];
    
    foreach ($this->ancestors as $ancestor) {
        $limits = array_merge($limits, $ancestor->limits ?? []);
    }
    
    return $limits;
}
```

### 3. Validazioni Dominio

```php
// Validazione dominio univoco nella gerarchia
public function setDomainAttribute($value)
{
    if ($value) {
        $exists = static::where('domain', $value)
            ->where(function ($query) {
                $query->whereNull('parent_id')
                    ->orWhereIn('parent_id', $this->ancestors()->pluck('id'));
            })
            ->exists();
            
        if ($exists) {
            throw new \Exception("Domain '{$value}' already exists in hierarchy");
        }
    }
    
    $this->attributes['domain'] = $value;
}
```

### 4. Indici per Performance Tenant

```php
// Indici ottimizzati per query Tenant
$table->index(['parent_id', 'is_active']);
$table->index('slug');
$table->index('domain');
$table->index('type');
$table->index(['tenant_id', 'is_primary']);
```

## Pattern per Tenant con AddressItemEnum

Integrazione con AddressItemEnum per tenant con location:

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\LocationTenant::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi tenant
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->unique();
            
            // Campi geografici usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Contatti
            $table->string('contact_email')->nullable();
            $table->string(\Modules\Geo\Enums\AddressItemEnum::PHONE->value)->nullable();
            
            // Configurazioni
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Billing Gerarchico

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\BillingAccount::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi billing
            $table->string('name');
            $table->string('code')->unique();
            
            // NestedSet per gerarchia billing
            NestedSet::columns($table);
            
            // Tenant associato
            $table->unsignedBigInteger('tenant_id');
            
            // Fatturazione
            $table->string('billing_email');
            $table->json('address')->nullable(); // Indirizzo fatturazione
            $table->string('vat_number')->nullable();
            $table->string('tax_code')->nullable();
            
            // Metodi pagamento
            $table->json('payment_methods')->nullable();
            $table->string('default_payment_method')->nullable();
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Tenant Module Architecture](/docs/architecture/tenant-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)