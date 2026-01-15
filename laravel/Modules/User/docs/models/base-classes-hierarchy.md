# Gerarchia delle Classi Base - Modulo User

**Data:** 15 Ottobre 2025  
**Tipo:** Documentazione Architetturale  
**Stato:** ✅ Aggiornato

## Principio Fondamentale

> **REGOLA CRITICA LARAXOT**: Nessun modello all'interno dei moduli deve estendere direttamente `Illuminate\Database\Eloquent\Model`. Tutti i modelli devono estendere le classi base appropriate del modulo.

## Gerarchia delle Classi

```
┌─────────────────────────────────────────────────────────────┐
│         Illuminate\Database\Eloquent\Model                   │
│         (Framework Laravel - NEVER extend directly)          │
└──────────────────────────────┬──────────────────────────────┘
                               │
          ┌────────────────────┴────────────────────┐
          │                                         │
┌─────────▼──────────┐                 ┌───────────▼─────────┐
│  XotBaseModel      │                 │   XotBasePivot      │
│  (Modules/Xot)     │                 │   (Modules/Xot)     │
└─────────┬──────────┘                 └───────────┬─────────┘
          │                                        │
┌─────────▼──────────┐                 ┌───────────▼─────────┐
│  BaseModel         │                 │   BasePivot         │
│  (Modules/User)    │                 │   (Modules/User)    │
│  connection='user' │                 │   connection='user' │
└─────────┬──────────┘                 └───────────┬─────────┘
          │                                        │
          │                                        │
┌─────────▼──────────┐                 ┌───────────▼─────────┐
│  Modelli Concreti  │                 │  Pivot Concreti     │
│  - User            │                 │  - TeamUser         │
│  - Team            │                 │  - TeamPermission   │
│  - Tenant          │                 │  - DeviceUser       │
│  - Profile         │                 │  - RoleHasPermission│
│  - SsoProvider     │                 │  - etc.             │
│  - Authentication  │                 │                     │
│  - etc.            │                 │                     │
└────────────────────┘                 └─────────────────────┘

┌─────────────────────────────────────┐
│   XotBaseMorphPivot                 │
│   (Modules/Xot)                     │
└───────────┬─────────────────────────┘
            │
┌───────────▼─────────────────────────┐
│   BaseMorphPivot                    │
│   (Modules/User)                    │
│   connection='user'                 │
└───────────┬─────────────────────────┘
            │
┌───────────▼─────────────────────────┐
│  Morph Pivot Concreti               │
│  - ModelHasRole                     │
│  - ModelHasPermission               │
└─────────────────────────────────────┘
```

## Tipi di Classi Base

### 1. **BaseModel** - Per Modelli Normali

**Quando usare:**
- Modelli che rappresentano entità con tabelle proprie
- Modelli con relazioni HasMany, BelongsTo, HasOne
- Modelli che NON sono tabelle pivot

**Esempio:**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * User Model
 */
class User extends BaseModel
{
    protected $fillable = ['name', 'email'];
    
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
}
```

**Modelli che estendono BaseModel nel modulo User:**
- `User` - Modello principale degli utenti
- `Team` - Modello dei team
- `Profile` - Profili utente
- `Tenant` - Multi-tenancy ✅
- `Role` - Ruoli
- `Permission` - Permessi
- `Device` - Dispositivi
- `SsoProvider` - Provider SSO ✅
- `TeamInvitation` - Inviti team ✅
- `Authentication` - Log autenticazioni ✅
- `OauthClient` - Client OAuth
- `OauthAccessToken` - Token di accesso OAuth
- `Notification` - Notifiche

### 2. **BasePivot** - Per Tabelle Pivot

**Quando usare:**
- Tabelle intermedie per relazioni many-to-many
- Tabelle con due foreign keys principali
- Tabelle senza logica polymorphic

**Caratteristiche:**
- Estende `Modules\Xot\Models\XotBasePivot`
- Connection automatica: `'user'`
- Timestam

ps: `true` di default
- `$incrementing`: `true` di default

**Esempio:**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * TeamUser Pivot Model
 * 
 * Tabella pivot per la relazione many-to-many tra Team e User.
 */
class TeamUser extends BasePivot
{
    protected $table = 'team_user';
    
    protected $fillable = [
        'team_id',
        'user_id',
        'role',
    ];
    
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

**Pivot che estendono BasePivot nel modulo User:**
- `TeamUser` - Team <-> User ✅
- `TeamPermission` - Team <-> User <-> Permission ✅
- `DeviceUser` - Device <-> User
- `RoleHasPermission` - Role <-> Permission
- `PermissionRole` - Permission <-> Role
- `Membership` - Membership avanzata

### 3. **BaseMorphPivot** - Per Tabelle Pivot Polymorphic

**Quando usare:**
- Tabelle pivot con relazioni polymorphic
- Tabelle con `model_type` e `model_id`
- Quando un'entità può essere collegata a più tipi di modelli

**Caratteristiche:**
- Estende `Modules\Xot\Models\XotBaseMorphPivot`
- Supporta relazioni polymorphic
- Connection automatica: `'user'`
- Casts per `model_id` e `model_type`

**Esempio:**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * ModelHasRole Morph Pivot
 * 
 * Tabella pivot polymorphic: qualsiasi modello può avere ruoli.
 */
class ModelHasRole extends BaseMorphPivot
{
    protected $table = 'model_has_role';
    
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
        'team_id',
    ];
}
```

**Morph Pivot che estendono BaseMorphPivot nel modulo User:**
- `ModelHasRole` - Qualsiasi modello <-> Role ✅
- `ModelHasPermission` - Qualsiasi modello <-> Permission

## Differenze Chiave

| Caratteristica | BaseModel | BasePivot | BaseMorphPivot |
|----------------|-----------|-----------|----------------|
| **Uso** | Entità normali | Pivot many-to-many | Pivot polymorphic |
| **Estende** | XotBaseModel | XotBasePivot | XotBaseMorphPivot |
| **Primary Key** | `id` (auto) | `id` (auto) | `id` (auto) |
| **Timestamps** | ✅ Opzionale | ✅ Di default | ✅ Di default |
| **Connection** | Auto da namespace | Auto da namespace | Auto da namespace |
| **Updater Trait** | ✅ | ✅ | ✅ |
| **Factory Support** | ✅ | ✅ | ✅ |
| **Colonne Speciali** | - | - | `model_type`, `model_id` |

## Pattern di Correzione

### ❌ SBAGLIATO

```php
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model  // ❌ NEVER DO THIS
{
    protected $connection = 'user';
}
```

### ✅ CORRETTO

```php
namespace Modules\User\Models;

class Tenant extends BaseModel  // ✅ ALWAYS DO THIS
{
    // connection è automatica da BaseModel
}
```

## Correzioni Effettuate

### File Corretti - 15 Ottobre 2025

| File | Prima | Dopo | Motivo |
|------|-------|------|--------|
| `Tenant.php` | `extends Model` | `extends BaseModel` | Modello normale |
| `TeamUser.php` | `extends Model` | `extends BasePivot` | Tabella pivot Team-User |
| `SsoProvider.php` | `extends Model` | `extends BaseModel` | Modello normale SSO |
| `TeamInvitation.php` | `extends Model` | `extends BaseModel` | Modello normale inviti |
| `TeamPermission.php` | `extends Model` | `extends BasePivot` | Pivot Team-User-Permission |
| `Authentication.php` | `extends Model` | `extends BaseModel` | Modello log auth |

### File Già Corretti

| File | Estende | Note |
|------|---------|------|
| `ModelHasRole.php` | `BaseMorphPivot` | ✅ Corretto - Pivot polymorphic |
| `OauthClient.php` | `BaseModel` | ✅ Corretto - Modello normale |

## Benefits dell'Architettura

### 1. **Centralizzazione**
- Configurazione della connection in un solo posto
- Traits condivisi (Updater, HasXotFactory)
- Casts comuni per tutti i modelli

### 2. **Consistenza**
- Tutti i modelli si comportano allo stesso modo
- Type hints uniformi
- PHPStan compliance automatica

### 3. **Manutenibilità**
- Modifiche in una classe base si propagano a tutti i modelli
- Bug fix centralizzati
- Più facile fare refactoring

### 4. **Estendibilità**
- Facile aggiungere funzionalità comuni
- Override selettivi quando necessario
- Pattern chiaro e prevedibile

## Regole di Implementazione

### ✅ DO - Pattern Raccomandati

```php
// 1. Modello normale
class Profile extends BaseModel
{
    // Business logic specifica
}

// 2. Pivot normale
class TeamUser extends BasePivot
{
    protected $table = 'team_user';
}

// 3. Pivot polymorphic
class ModelHasRole extends BaseMorphPivot
{
    protected $table = 'model_has_role';
}
```

### ❌ DON'T - Anti-pattern da Evitare

```php
// 1. NON estendere Model direttamente
class User extends \Illuminate\Database\Eloquent\Model { }  // ❌

// 2. NON duplicare la connection se già in BaseModel
class Profile extends BaseModel
{
    protected $connection = 'user';  // ❌ Ridondante
}

// 3. NON usare BaseModel per pivot
class TeamUser extends BaseModel { }  // ❌ Usare BasePivot

// 4. NON usare BasePivot per modelli normali
class User extends BasePivot { }  // ❌ Usare BaseModel
```

## Testing

### Verifica Gerarchia

```php
use Modules\User\Models\{User, TeamUser, ModelHasRole};
use Modules\User\Models\{BaseModel, BasePivot, BaseMorphPivot};

// Test gerarchia BaseModel
assertTrue(is_subclass_of(User::class, BaseModel::class));
assertEquals('user', (new User)->getConnectionName());

// Test gerarchia BasePivot
assertTrue(is_subclass_of(TeamUser::class, BasePivot::class));
assertEquals('team_user', (new TeamUser)->getTable());

// Test gerarchia BaseMorphPivot
assertTrue(is_subclass_of(ModelHasRole::class, BaseMorphPivot::class));
assertTrue((new ModelHasRole)->timestamps);
```

## Checklist per Nuovi Modelli

Quando crei un nuovo modello nel modulo User:

- [ ] È una tabella pivot (due FK)? → Usa `BasePivot`
- [ ] È una tabella pivot polymorphic (`model_type`, `model_id`)? → Usa `BaseMorphPivot`
- [ ] Altrimenti → Usa `BaseModel`
- [ ] Non specificare `$connection` (è automatica)
- [ ] Aggiungi PHPDoc completo
- [ ] Crea Factory se necessario
- [ ] Scrivi test per verificare la gerarchia

## Risorse

- [Architettura Core](../core/architecture.md)
- [XotBasePivot Migration Guide](./xotbasepivot-migration.md)
- [Best Practices](../best-practices/models.md)
- [PHPStan Compliance](../development/phpstan-guide.md)

---

**Ultimo aggiornamento:** 15 Ottobre 2025  
**Autore:** AI Assistant + Team Laraxot  
**Versione:** 2.0 - Correzione gerarchia modelli  
**Status:** ✅ Production Ready







