# NestedSet Migration Best Practices - User Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo User utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Ruoli Utente

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\Role::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi ruolo
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia ruoli
            NestedSet::columns($table);
            
            // Permessi ereditati
            $table->json('permissions')->nullable();
            $table->json('metadata')->nullable();
            
            // Stato
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false); // Ruoli di sistema non modificabili
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Team Utente

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\Team::class;

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
            
            // Gestione team
            $table->unsignedBigInteger('owner_id');
            $table->json('settings')->nullable();
            
            // Campi indirizzo usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Contatti
            $table->string('contact_email')->nullable();
            $table->string(\Modules\Geo\Enums\AddressItemEnum::PHONE->value)->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
```

## Pattern per Permessi Gerarchici

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\Permission::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi permesso
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia permessi
            NestedSet::columns($table);
            
            // Gruppo e categoria
            $table->string('group')->nullable(); // users, content, system
            $table->string('category')->nullable(); // create, read, update, delete
            
            // Configurazioni
            $table->json('constraints')->nullable(); // Vincoli aggiuntivi
            $table->boolean('is_system')->default(false);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Organizzazione Utenti

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\UserOrganization::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi organizzazione
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia organizzativa
            NestedSet::columns($table);
            
            // Gestione
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('type'); // department, division, team
            
            // Campi indirizzo usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Contatti
            $table->string('email')->nullable();
            $table->string(\Modules\Geo\Enums\AddressItemEnum::PHONE->value)->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Gruppi di Accesso

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\AccessGroup::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi gruppo accesso
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia gruppi
            NestedSet::columns($table);
            
            // Configurazioni accesso
            $table->json('ip_whitelist')->nullable();
            $table->json('time_restrictions')->nullable(); // Orari accesso
            $table->json('location_restrictions')->nullable(); // Restrizioni geografiche
            
            // Sicurezza
            $table->boolean('require_2fa')->default(false);
            $table->integer('session_timeout')->default(480); // minuti
            
            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli User

```php
<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Role extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'permissions',
        'metadata',
        'is_active',
        'is_system',
    ];
    
    protected $casts = [
        'permissions' => 'array',
        'metadata' => 'array',
        'is_active' => 'boolean',
        'is_system' => 'boolean',
    ];
    
    // Relazioni
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    // Scopes specifici User
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }
    
    // Metodi helper
    public function getAllPermissions(): array
    {
        $permissions = $this->permissions ?? [];
        
        foreach ($this->ancestors as $ancestor) {
            $permissions = array_merge($permissions, $ancestor->permissions ?? []);
        }
        
        return array_unique($permissions);
    }
    
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->getAllPermissions());
    }
}
```

## Best Practices Specifiche per User

### 1. Nomenclatura Coerente

- `Role`: Ruoli con gerarchia e permessi ereditati
- `Team`: Team multi-livello con location
- `Permission`: Permessi con vincoli gerarchici
- `UserOrganization`: Struttura organizzativa utenti
- `AccessGroup`: Gruppi con restrizioni di accesso

### 2. Gestione Permessi Ereditati

```php
// Permessi effettivi combinati
public function getAllPermissions(): array
{
    $permissions = $this->permissions ?? [];
    
    foreach ($this->ancestors as $ancestor) {
        $permissions = array_merge($permissions, $ancestor->permissions ?? []);
    }
    
    return array_unique($permissions);
}
```

### 3. Validazioni Ruoli

```php
// Validazione ruoli di sistema
public function setIsSystemAttribute($value)
{
    if ($value && $this->exists && !$this->is_system) {
        throw new \Exception('Cannot convert existing role to system role');
    }
    
    $this->attributes['is_system'] = $value;
}
```

### 4. Indici per Performance User

```php
// Indici ottimizzati per query User
$table->index(['parent_id', 'is_active']);
$table->index('slug');
$table->index('code');
$table->index(['group', 'category']);
$table->index('owner_id');
```

## Pattern per Utenti con AddressItemEnum

Integrazione con AddressItemEnum per profili utente:

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\UserProfile::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Utente associato
            $table->unsignedBigInteger('user_id');
            
            // Campi profilo
            $table->string('title')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            
            // Campi indirizzo usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Contatti
            $table->string('contact_email')->nullable();
            $table->string(\Modules\Geo\Enums\AddressItemEnum::PHONE->value)->nullable();
            
            // Preferenze
            $table->json('preferences')->nullable();
            $table->string('timezone')->default('Europe/Rome');
            $table->string('language', 5)->default('it');
            
            // Social
            $table->json('social_links')->nullable();
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
```

## Pattern per Gruppi di Utenti Location-based

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\LocationUserGroup::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi gruppo
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia gruppi
            NestedSet::columns($table);
            
            // Campi geografici usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Configurazioni
            $table->json('settings')->nullable();
            $table->json('auto_assign_rules')->nullable();
            
            // Membership
            $table->json('members')->nullable(); // Utenti e ruoli
            $table->boolean('is_public')->default(false);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Organizzativa Aziendale

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\User\Models\CompanyStructure::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi struttura
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia aziendale
            NestedSet::columns($table);
            
            // Tipo e livello
            $table->string('type'); // company, division, department, team, unit
            $table->string('level'); // 1, 2, 3, 4, 5
            
            // Gestione
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->json('deputies')->nullable(); // Vice manager
            
            // Campi indirizzo usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);
            
            // Contatti
            $table->string('email')->nullable();
            $table->string(\Modules\Geo\Enums\AddressItemEnum::PHONE->value)->nullable();
            
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
- [User Module Architecture](/docs/architecture/user-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)