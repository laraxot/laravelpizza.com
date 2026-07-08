# Policy Inheritance Boundary

> Quando estendere `UserBasePolicy` vs `XotBasePolicy` - Decisione architetturale documentata

---

## Contesto Decisionale

**Data**: 2026-04-27  
**Trigger**: Discussione architetturale su policy inheritance  
**Moduli Interessati**: User, Xot, tutti i moduli domain-specific

---

## Domanda Architetturale

> "Le policy devono estendere `UserBasePolicy` o `XotBasePolicy`? Meglio tenerle separate? Quando usare una e quando usare l'altra?"

---

## Analisi delle Due Basi

### XotBasePolicy (Foundation Layer)

**Path**: `laravel/Modules/Xot/app/Models/Policies/XotBasePolicy.php`

**Caratteristiche**:
- Zero dipendenze esterne
- Usa `UserContract` (tipo base)
- Solo `before()` per super-admin check
- `viewAny()` returns `false` di default
- Nessuna integrazione con Spatie Permission

**Casi d'uso**:
- ✅ Entità di sistema (senza contesto user)
- ✅ API token-based (Sanctum/Passport)
- ✅ Job schedulati, queue worker
- ✅ Processi cron, system daemon
- ✅ Moduli framework-independent

**Esempio**:
```php
namespace Modules\Job\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;

class JobSchedulePolicy extends XotBasePolicy
{
    public function execute(?UserContract $user = null): bool
    {
        // System process - no user required
        return $user === null || $user->hasRole('system');
    }
}
```

### UserBasePolicy (Application Layer)

**Path**: `laravel/Modules/User/app/Models/Policies/UserBasePolicy.php`

**Caratteristiche**:
- Estende `XotBasePolicy`
- Dipende da `spatie/laravel-permission`
- Usa `UserContract` con ruolo/permissioni
- `before()` check per super-admin
- Integrazione completa RBAC

**Casi d'uso**:
- ✅ Resource user-authenticated (95% dei casi)
- ✅ Authorization basata su permessi
- ✅ Multi-tenant con ruoli
- ✅ Backoffice Filament
- ✅ Moduli business domain

**Esempio**:
```php
namespace Modules\Activity\Models\Policies;

use Modules\User\Models\Policies\UserBasePolicy;
use Modules\Xot\Contracts\UserContract;

class ActivityPolicy extends UserBasePolicy
{
    public function view(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.view');
    }
    
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.create');
    }
}
```

---

## Decisione Architetturale

### Separazione Mantenuta ✅

**Razionale**:

1. **Dependency Isolation**
   - `UserBasePolicy` → dipende da Spatie Permission
   - `XotBasePolicy` → zero dipendenze esterne
   - Xot rimane modulo lightweight e riutilizzabile

2. **Contract Clarity**
   - `UserBasePolicy` → implica contesto user obbligatorio
   - `XotBasePolicy` → permette user opzionale (system processes)

3. **Module Boundaries**
   - Xot = Foundation (no business logic)
   - User = Application layer (business rules, RBAC)

4. **Testing Flexibility**
   - Xot policy tests → non richiedono User module
   - User policy tests → setup permessi completo

5. **Future-Proofing**
   - Nuovi moduli possono scegliere base appropriata
   - Nessuno coupling forzato
   - Evoluzione indipendente

---

## Matrice Decisionale

| Scenario | Estendi | Rationale |
|----------|---------|-----------|
| Resource user-authenticated | `UserBasePolicy` | Default choice (95% casi) |
| Entità di sistema | `XotBasePolicy` | Nessun contesto user |
| API-only (token) | `XotBasePolicy` | Sanctum/Passport, no user model |
| Multi-tenant + ruoli | `UserBasePolicy` | Spatie permissions + tenant scoping |
| Job schedulato | `XotBasePolicy` | System cron, no user |
| Queue worker | `XotBasePolicy` | Background process |
| Backoffice Filament | `UserBasePolicy` | RBAC required |
| Modulo business domain | `UserBasePolicy` | Permission-based authorization |

---

## Cosa Aggiungere alle Policy Base

### XotBasePolicy Enhancements

```php
abstract class XotBasePolicy
{
    use HandlesAuthorization;

    // ✅ Existing: before() hook
    public function before(UserContract $user, string $_ability): ?bool
    {
        return once(function () use ($user) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });
    }

    // 🔧 Proposed: scope() per query scoping
    public function scope(UserContract $user, Builder $query): Builder
    {
        // Default: no scoping
        return $query;
    }

    // 🔧 Proposed: after() per audit logging
    public function after(UserContract $user, string $ability, bool $result): void
    {
        // Optional audit log hook
    }
}
```

### UserBasePolicy Enhancements

```php
abstract class UserBasePolicy extends XotBasePolicy
{
    // ✅ Existing: before() con super-admin check

    // 🔧 Proposed: canAny() helper
    protected function canAny(UserContract $user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($user->hasPermissionTo($permission)) {
                return true;
            }
        }
        return false;
    }

    // 🔧 Proposed: canAll() helper
    protected function canAll(UserContract $user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$user->hasPermissionTo($permission)) {
                return false;
            }
        }
        return true;
    }

    // 🔧 Proposed: tenant scoping
    protected function withTenant(UserContract $user, string $tenantId): bool
    {
        return $user->currentTenantId() === $tenantId;
    }
}
```

---

## Best Practices Documentate

### 1. Type-Hint UserContract

```php
// ✅ CORRETTO
public function view(UserContract $user): bool

// ❌ SBAGLIATO
public function view($user): bool
public function view(\App\Models\User $user): bool
```

### 2. Permission Dot Notation

```php
// ✅ CORRETTO: resource.action
'user.view'
'user.create'
'user.update'
'user.delete'

// ❌ SBAGLIATO: naming inconsistente
'view_user'
'userView'
'can_view_users'
```

### 3. Comment Unused Methods

```php
class ActivityPolicy extends UserBasePolicy
{
    public function view(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.view');
    }

    // public function viewAny(UserContract $user): bool
    // {
    //     return $user->hasPermissionTo('activity.viewAny');
    // }
    
    // public function create(UserContract $user): bool
    // {
    //     return $user->hasPermissionTo('activity.create');
    // }
}
```

### 4. Test con Permessi Reali

```php
// ✅ CORRETTO
public function test_view_requires_permission(): void
{
    $user = User::factory()->create();
    $user->givePermissionTo('activity.view');
    
    $policy = new ActivityPolicy();
    $this->assertTrue($policy->view($user));
}

// ❌ SBAGLIATO: test senza permessi
public function test_view(): void
{
    $user = User::factory()->create();
    // Missing: givePermissionTo
    $policy = new ActivityPolicy();
    $this->assertTrue($policy->view($user)); // Falso positivo!
}
```

---

## Conteggio Policy Attuali

**Totale policy nel progetto**: 124

**Distribuzione**:
- User module: ~40 policy (estendono UserBasePolicy)
- Xot module: ~10 policy (estendono XotBasePolicy)
- Altri moduli: ~74 policy (maggioranza UserBasePolicy)

**Convenzione attuale**:
- ✅ 95% delle policy domain-specific → `UserBasePolicy`
- ✅ Policy di sistema → `XotBasePolicy`
- ✅ Separazione chiara e consistente

---

## Miglioramenti Proposti

### 1. Documentazione

- [x] Questa pagina wiki decisionale
- [ ] Aggiungere esempi di testing in `testing-policies.md`
- [ ] Documentare naming conventions permessi
- [ ] Creare template per nuove policy

### 2. Code Quality

- [ ] Aggiungere `canAny()` helper in UserBasePolicy
- [ ] Aggiungere `canAll()` helper in UserBasePolicy
- [ ] Aggiungere `scope()` method in XotBasePolicy
- [ ] Aggiungere `after()` hook per audit

### 3. Tooling

- [ ] Creare command `make:policy` con scelta base
- [ ] Aggiungere PHPStan rule per type-hint UserContract
- [ ] Creare test baseline per policy inheritance

---

## Related Documentation

**User Module Wiki**:
- [[policy-hierarchy]] - Panoramica architettura policy
- [[policy-inheritance-strategy]] - Strategia ereditarietà
- [[policy-base-choice]] - Decisione scelta base
- [[spatie-permission-integration]] - Integrazione Spatie

**Xot Module Wiki**:
- [[policy-base-strategy]] - Strategia base policy
- [[policy-module-matrix]] - Matrice moduli

**Project Wiki**:
- [[../../docs/wiki/concepts/laraxot-architecture]] - Architettura Laraxot
- [[../../docs/wiki/concepts/module-boundaries]] - Confini modulari

---

**Status**: ✅ Decisione Documentata  
**Confidence**: high  
**Created**: 2026-04-27  
**Updated**: 2026-04-27  
**Tags**: authorization, policies, architecture, spatie-permission, decision-record
