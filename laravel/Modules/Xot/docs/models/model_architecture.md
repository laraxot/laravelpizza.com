# Model Architecture - Guida Completa

**Data**: 2025-10-16
**Modulo**: Xot (Base Module)
**Autore**: Claude Code Analysis

## Indice

1. [Panoramica](#panoramica)
2. [Gerarchia a Tre Livelli](#gerarchia-a-tre-livelli)
3. [Quando Usare Quale Base Class](#quando-usare-quale-base-class)
4. [Auto-Discovery delle Connection](#auto-discovery-delle-connection)
5. [Traits Standard](#traits-standard)
6. [Esempi Pratici](#esempi-pratici)
7. [Convenzioni e Best Practices](#convenzioni-e-best-practices)
8. [Testing](#testing)

---

## Panoramica

L'architettura dei modelli in questa applicazione Laravel segue un **pattern a tre livelli** che garantisce:

- ✅ **Consistenza** tra tutti i moduli
- ✅ **Riutilizzo del codice** tramite ereditarietà
- ✅ **Separazione delle connection** per ogni modulo
- ✅ **Centralizzazione** di traits e funzionalità comuni

### Regola Fondamentale

> **CRITICO**: Nessun modello dentro i moduli deve estendere `Illuminate\Database\Eloquent\Model` direttamente.

Tutti i modelli devono estendere una delle classi base appropriate:
- `BaseModel` per modelli standard
- `BasePivot` per tabelle pivot
- `BaseMorphPivot` per tabelle pivot polimorfe

---

## Gerarchia a Tre Livelli

```
┌─────────────────────────────────────────────────────────────┐
│ Livello 1: Xot Base Classes (Modules/Xot/app/Models/)      │
│ - XotBaseModel                                              │
│ - XotBasePivot                                              │
│ - XotBaseMorphPivot                                         │
│                                                             │
│ Forniscono: Traits standard, Casts, Auto-discovery         │
└─────────────────────────────────────────────────────────────┘
                          ▲
                          │ extends
                          │
┌─────────────────────────────────────────────────────────────┐
│ Livello 2: Module Base Classes (per modulo)                │
│ - Modules/{ModuleName}/Models/BaseModel                     │
│ - Modules/{ModuleName}/Models/BasePivot                     │
│ - Modules/{ModuleName}/Models/BaseMorphPivot                │
│                                                             │
│ Forniscono: Connection specifica, Traits specifici modulo  │
└─────────────────────────────────────────────────────────────┘
                          ▲
                          │ extends
                          │
┌─────────────────────────────────────────────────────────────┐
│ Livello 3: Concrete Models                                 │
│ - Modules/User/Models/Tenant                                │
│ - Modules/User/Models/TeamUser                              │
│ - Modules/<nome progetto>/Models/Contact                            │
│                                                             │
│ Implementano: Business logic, Relationships, Scopes         │
└─────────────────────────────────────────────────────────────┘
```

### Livello 1: Xot Base Classes

**File**: `Modules/Xot/app/Models/XotBaseModel.php`

```php
abstract class XotBaseModel extends Model
{
    use HasXotFactory;
    use RelationX;
    use Updater;

    protected $snakeAttributes = true;
    protected $incrementing = true;
    protected $timestamps = true;
    protected $perPage = 50;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
```

**Fornisce**:
- Traits standard: `HasXotFactory`, `RelationX`, `Updater`
- Configurazione predefinita: `$snakeAttributes`, `$incrementing`, `$timestamps`, `$perPage`
- Casts standard: id, uuid, date fields, audit fields

**File**: `Modules/Xot/app/Models/XotBasePivot.php`

```php
abstract class XotBasePivot extends Pivot
{
    use HasXotFactory;
    use RelationX;
    use Updater;

    protected $snakeAttributes = true;
    protected $incrementing = true;

    public function getConnectionName(): ?string
    {
        if (isset($this->connection)) {
            return $this->connection;
        }

        // Auto-discovery: Modules\User\Models\... → 'user'
        $namespace = static::class;
        if (preg_match('/Modules\\\\(\w+)\\\\/', $namespace, $matches)) {
            return strtolower($matches[1]);
        }

        return parent::getConnectionName();
    }
}
```

**Fornisce**:
- Auto-discovery della connection dal namespace
- Traits standard per pivot tables

**File**: `Modules/Xot/app/Models/XotBaseMorphPivot.php`

Stessa struttura di XotBasePivot, ma estende `MorphPivot` per relazioni polimorfe.

### Livello 2: Module Base Classes

Ogni modulo ha le sue classi base in `Modules/{ModuleName}/app/Models/`:

```php
// Modules/User/app/Models/BaseModel.php
namespace Modules\User\Models;

use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'user';
}
```

```php
// Modules/User/app/Models/BasePivot.php
namespace Modules\User\Models;

use Modules\Xot\Models\XotBasePivot;

abstract class BasePivot extends XotBasePivot
{
    protected $connection = 'user';
}
```

```php
// Modules/User/app/Models/BaseMorphPivot.php
namespace Modules\User\Models;

use Modules\Xot\Models\XotBaseMorphPivot;

abstract class BaseMorphPivot extends XotBaseMorphPivot
{
    protected $connection = 'user';
}
```

**Scopo**:
- Definire la connection specifica del modulo
- Aggiungere traits specifici del modulo (es: `InteractsWithMedia` in <nome progetto>)
- Configurare casts specifici del modulo
- Configurare eager loading predefinito (`$with`)

### Livello 3: Concrete Models

I modelli concreti implementano la business logic:

```php
// Modules/User/app/Models/Tenant.php
namespace Modules\User\Models;

class Tenant extends BaseModel
{
    protected $fillable = ['name', 'domain', 'active'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
```

---

## Quando Usare Quale Base Class

### Usa `BaseModel` quando:

✅ **Modello standard con tabella propria**
- Rappresenta un'entità business (User, Product, Order, Contact)
- Ha una tabella dedicata nel database
- Non è una tabella pivot

**Esempi**:
- `Modules/User/Models/Tenant.php`
- `Modules/<nome progetto>/Models/Contact.php`
- `Modules/Cms/Models/Page.php`
- `Modules/Geo/Models/GeoNamesCap.php`

```php
namespace Modules\User\Models;

class Tenant extends BaseModel
{
    protected $fillable = ['name', 'domain'];
}
```

### Usa `BasePivot` quando:

✅ **Tabella pivot per relazione many-to-many**
- Collega due entità in una relazione molti-a-molti
- Ha colonne aggiuntive oltre alle foreign keys
- Non è polimorfa

**Esempi**:
- `Modules/User/Models/TeamUser.php` (collega Team e User)
- `Modules/Blog/Models/PostTag.php` (collega Post e Tag)

**Caratteristiche tabella pivot**:
- Ha almeno 2 foreign keys
- Può avere colonne aggiuntive (es: `role`, `permissions`, `created_at`)

```php
namespace Modules\User\Models;

class TeamUser extends BasePivot
{
    protected $table = 'team_user';

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'role' => 'string',
            'joined_at' => 'datetime',
        ]);
    }
}
```

**Definizione nella relazione**:
```php
// Team.php
public function users()
{
    return $this->belongsToMany(User::class, 'team_user')
        ->using(TeamUser::class)  // ← Usa il pivot model custom
        ->withPivot(['role', 'joined_at']);
}
```

### Usa `BaseMorphPivot` quando:

✅ **Tabella pivot polimorfa**
- Collega entità in relazione many-to-many **polimorfa**
- Ha colonne `{name}_type` e `{name}_id` per il lato polimorfo

**Esempi**:
- `Modules/User/Models/ModelHasRole.php` (da Spatie Permission)
- Qualsiasi pivot che collega modelli diversi tramite morph

**Caratteristiche tabella morph pivot**:
- Colonne: `model_type`, `model_id`, `role_id` (esempio)
- Permette di collegare Role a User, Team, Organization, etc.

```php
namespace Modules\User\Models;

class ModelHasRole extends BaseMorphPivot
{
    protected $table = 'model_has_roles';

    // Gestisce relazioni polimorfe automaticamente
}
```

---

## Auto-Discovery delle Connection

### Funzionamento

Le classi `XotBasePivot` e `XotBaseMorphPivot` implementano già l'auto-discovery:

```php
public function getConnectionName(): ?string
{
    if (isset($this->connection)) {
        return $this->connection;  // Se definito manualmente, usa quello
    }

    // Estrai il nome del modulo dal namespace
    // Modules\User\Models\TeamUser → 'user'
    $namespace = static::class;
    if (preg_match('/Modules\\\\(\w+)\\\\/', $namespace, $matches)) {
        return strtolower($matches[1]);
    }

    return parent::getConnectionName();
}
```

### Vantaggi

1. **DRY**: Elimina la necessità di `protected $connection = 'module_name';` in ogni BaseModel
2. **Consistenza**: Il nome della connection deriva sempre dal namespace
3. **Manutenibilità**: Modifiche alla struttura richiedono aggiornamenti in un solo punto

### Convenzione

- Namespace: `Modules\User\Models\*` → Connection: `user`
- Namespace: `Modules\<nome progetto>\Models\*` → Connection: `<nome progetto>`
- Namespace: `Modules\Cms\Models\*` → Connection: `cms`

**Nota**: Attualmente `XotBaseModel` NON ha auto-discovery (vedi [DRY-KISS-ANALYSIS.md](./DRY-KISS-ANALYSIS.md) per proposta di implementazione).

---

## Traits Standard

Tutti i modelli ereditano questi traits da `XotBaseModel`:

### 1. `HasXotFactory`

**Scopo**: Supporto per Laravel factories con pattern modulare

```php
// Uso in test o seeder
$tenant = Tenant::factory()->create([
    'name' => 'Acme Corp',
]);
```

**Factory Location**: `Modules/{ModuleName}/database/factories/{ModelName}Factory.php`

### 2. `RelationX`

**Scopo**: Funzionalità estese per le relazioni Eloquent

Fornisce metodi helper per gestire relazioni complesse.

### 3. `Updater`

**Scopo**: Tracciamento automatico di chi crea/aggiorna/elimina i record

**Campi gestiti**:
- `created_by` - User ID che ha creato il record
- `updated_by` - User ID che ha aggiornato il record
- `deleted_by` - User ID che ha eliminato il record (soft delete)

**Funzionamento automatico**:
```php
// Quando un utente autenticato crea un record:
$contact = Contact::create(['name' => 'John Doe']);
// → $contact->created_by viene impostato automaticamente

// Quando aggiorna:
$contact->update(['name' => 'Jane Doe']);
// → $contact->updated_by viene impostato automaticamente
```

---

## Esempi Pratici

### Esempio 1: Modello Standard (User Module - Tenant)

```php
namespace Modules\User\Models;

/**
 * Tenant Model.
 *
 * Rappresenta un'organizzazione/tenant nel sistema multi-tenant.
 *
 * @property string $id
 * @property string $name
 * @property string $domain
 * @property bool $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Tenant extends BaseModel
{
    protected $fillable = [
        'name',
        'domain',
        'active',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'active' => 'boolean',
        ]);
    }

    // Relationships
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user')
            ->using(TeamUser::class)
            ->withPivot(['role', 'joined_at']);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Business Logic
    public function activate(): void
    {
        $this->update(['active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['active' => false]);
    }
}
```

### Esempio 2: Pivot Model (User Module - TeamUser)

```php
namespace Modules\User\Models;

/**
 * TeamUser Pivot Model.
 *
 * Gestisce la relazione many-to-many tra Team e User
 * con metadati aggiuntivi come role e joined_at.
 *
 * @property int $team_id
 * @property int $user_id
 * @property string $role
 * @property \Carbon\Carbon $joined_at
 */
class TeamUser extends BasePivot
{
    protected $table = 'team_user';

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'role' => 'string',
            'joined_at' => 'datetime',
        ]);
    }

    // Relationships verso le entità collegate
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Business Logic
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function promoteToAdmin(): void
    {
        $this->update(['role' => 'admin']);
    }
}
```

### Esempio 3: Morph Pivot (User Module - ModelHasRole)

```php
namespace Modules\User\Models;

/**
 * ModelHasRole Morph Pivot.
 *
 * Gestisce la relazione polimorfa many-to-many tra
 * qualsiasi modello (User, Team, Organization) e Role.
 *
 * @property string $role_id
 * @property string $model_type
 * @property string $model_id
 */
class ModelHasRole extends BaseMorphPivot
{
    protected $table = 'model_has_roles';

    public $timestamps = false;

    // Relazione verso Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relazione polimorfa verso il modello
    public function model()
    {
        return $this->morphTo();
    }
}
```

### Esempio 4: BaseModel con Traits Specifici (<nome progetto> Module)

```php
namespace Modules\<nome progetto>\Models;

use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Contracts\ModelContract;
use Modules\Xot\Models\Traits\HasExtraTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * Base Model per <nome progetto> module.
 *
 * Aggiunge supporto per:
 * - Media Library (Spatie)
 * - Extra fields dinamici
 * - Model caching
 */
abstract class BaseModel extends XotBaseModel implements HasMedia, ModelContract
{
    use Cachable;
    use HasExtraTrait;
    use InteractsWithMedia;

    protected $connection = '<nome progetto>';

    // Eager load sempre la relazione extra
    protected $with = ['extra'];
}
```

Poi i modelli concreti ereditano tutto:

```php
namespace Modules\<nome progetto>\Models;

class Contact extends BaseModel
{
    protected $fillable = ['first_name', 'last_name', 'email'];

    // Eredita automaticamente:
    // - InteractsWithMedia (->addMedia(), ->getMedia())
    // - HasExtraTrait (->extra, campi dinamici)
    // - Cachable (query caching automatico)
}
```

---

## Convenzioni e Best Practices

### 1. Namespace

```php
// ✅ CORRETTO
namespace Modules\User\Models;

// ❌ ERRATO
namespace App\Models\User;
namespace Modules\User\App\Models;
```

### 2. Estensione Base Class

```php
// ✅ CORRETTO - Modello standard
class Tenant extends BaseModel { }

// ✅ CORRETTO - Pivot
class TeamUser extends BasePivot { }

// ✅ CORRETTO - Morph Pivot
class ModelHasRole extends BaseMorphPivot { }

// ❌ ERRATO - Mai estendere Model direttamente
class Tenant extends Model { }
```

### 3. Connection

```php
// ✅ CORRETTO - Definita in BaseModel del modulo
// Modules/User/Models/BaseModel.php
protected $connection = 'user';

// ❌ ERRATO - Non ridefinire in ogni modello concreto
// Modules/User/Models/Tenant.php
protected $connection = 'user';  // ← Già ereditato da BaseModel
```

### 4. Traits

```php
// ✅ CORRETTO - Aggiungere traits specifici in BaseModel
// Modules/<nome progetto>/Models/BaseModel.php
use InteractsWithMedia;
use HasExtraTrait;

// ❌ ERRATO - Non duplicare traits già in XotBaseModel
use HasXotFactory;  // ← Già in XotBaseModel
use Updater;        // ← Già in XotBaseModel
```

### 5. Casts

```php
// ✅ CORRETTO - Solo casts specifici del modello/modulo
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'verified_at' => 'datetime',  // ← Specifico per User
        'settings' => 'array',        // ← Specifico per questo modello
    ]);
}

// ❌ ERRATO - Non ridichiarare casts già in parent
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'id' => 'string',           // ← Già in XotBaseModel
        'created_at' => 'datetime', // ← Già in XotBaseModel
    ]);
}
```

### 6. Factory

```php
// ✅ CORRETTO - Usa HasXotFactory (già incluso)
$tenant = Tenant::factory()->create();

// Factory location:
// Modules/User/database/factories/TenantFactory.php
```

### 7. DocBlocks

```php
// ✅ CORRETTO - Documentare proprietà e relazioni
/**
 * Tenant Model.
 *
 * @property string $id
 * @property string $name
 * @property string $domain
 * @property bool $active
 * @property \Carbon\Carbon $created_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\User\Models\User[] $users
 */
class Tenant extends BaseModel
{
    // ...
}
```

---

## Testing

### Test Factory

```php
use Modules\User\Models\Tenant;

it('creates a tenant', function () {
    $tenant = Tenant::factory()->create([
        'name' => 'Acme Corp',
    ]);

    expect($tenant)
        ->name->toBe('Acme Corp')
        ->active->toBeTrue();
});
```

### Test Relationships

```php
it('tenant has many users', function () {
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create();

    $tenant->users()->attach($user, [
        'role' => 'admin',
        'joined_at' => now(),
    ]);

    expect($tenant->users)
        ->toHaveCount(1)
        ->first()->id->toBe($user->id);
});
```

### Test Connection

```php
it('uses correct database connection', function () {
    $tenant = new Tenant();

    expect($tenant->getConnectionName())->toBe('user');
});
```

### Test Updater Trait

```php
it('tracks who created the record', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $tenant = Tenant::factory()->create(['name' => 'Test']);

    expect($tenant->created_by)->toBe($user->id);
});
```

---

## Riferimenti

- [XotBaseModel.php](../../app/Models/XotBaseModel.php) - Base class per modelli standard
- [XotBasePivot.php](../../app/Models/XotBasePivot.php) - Base class per pivot tables
- [XotBaseMorphPivot.php](../../app/Models/XotBaseMorphPivot.php) - Base class per morph pivots
- [DRY-KISS-ANALYSIS.md](./DRY-KISS-ANALYSIS.md) - Analisi duplicazioni e proposte miglioramento
- [CLAUDE.md](../../../CLAUDE.md) - Convenzioni generali del progetto

---

## Domande Frequenti

**Q: Posso creare un modello senza BaseModel nel modulo?**
A: No. Ogni modulo deve avere almeno BaseModel, BasePivot, BaseMorphPivot anche se minimali.

**Q: Quando devo usare BasePivot invece di BaseModel?**
A: Usa BasePivot quando la tabella ha principalmente 2 foreign keys e serve a collegare due entità (many-to-many).

**Q: Devo sempre definire `$connection` in BaseModel?**
A: Attualmente sì. In futuro potrebbe essere implementato auto-discovery (vedi DRY-KISS-ANALYSIS.md).

**Q: Posso estendere Model direttamente in casi speciali?**
A: Solo nelle classi Xot base (XotBaseModel, XotBasePivot, XotBaseMorphPivot). Mai nei moduli.

**Q: Come gestisco modelli con tabelle dinamiche (es: Limesurvey)?**
A: Estendi comunque BaseModel, ma usa `setTable()` nel costruttore o in metodi factory.

---

**Ultima revisione**: 2025-10-16
**Prossimo aggiornamento**: Dopo implementazione auto-discovery in XotBaseModel
