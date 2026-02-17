# Analisi Corretta del Trait HasTeams - Filosofia Laraxot

## Comprensione della Filosofia `belongsToManyX`

### **Religione Laraxot**: Convention over Configuration
- **Auto-Discovery**: Il sistema "indovina" le configurazioni corrette
- **Zero Boilerplate**: Eliminare codice ripetitivo
- **Smart Defaults**: Convenzioni intelligenti automatiche

### **Logica di `belongsToManyX`**:
1. **`guessPivot()`**: Indovina automaticamente il modello pivot dai nomi delle classi
2. **Cross-Database**: Gestisce automaticamente tabelle pivot su database diversi
3. **Auto-Wiring**: Configura automaticamente `withPivot()`, `withTimestamps()`, `using()`

**`belongsToManyX` è CORRETTO e preferito** - non è un errore!

---

## VERI Errori nel Trait HasTeams

### 1. **Tipizzazione Incompleta e Mancanza di PHPDoc**

```php
// ❌ ERRATO - Parametri non tipizzati
public function addTeamMember($user, $role = null)
public function hasTeamMember($user)
public function removeTeamMember($user)
```

**✅ CORRETTO**:
```php
/**
 * @property-read Collection<int, TeamContract> $teams
 * @property-read Collection<int, TeamContract> $ownedTeams
 * @property-read TeamContract|null $currentTeam
 * @property int|null $current_team_id
 */
trait HasTeams
{
    public function addTeamMember(UserContract $user, ?Role $role = null): Model
    public function hasTeamMember(UserContract $user): bool
    public function removeTeamMember(UserContract $user): void
}
```

### 2. **Gestione Null Non Sicura in `switchTeam`**

```php
// ❌ PROBLEMA: Non gestisce correttamente il null
public function switchTeam(?TeamContract $team): bool
{
    if (! $this->belongsToTeam($team)) { // $team può essere null!
        return false;
    }

    $this->current_team_id = (string) $team->id; // Null pointer se $team è null
}
```

**✅ CORRETTO**:
```php
public function switchTeam(?TeamContract $team): bool
{
    if ($team === null) {
        $this->current_team_id = null;
        $this->save();
        return true;
    }

    if (! $this->belongsToTeam($team)) {
        return false;
    }

    $this->current_team_id = (string) $team->id;
    $this->save();
    return true;
}
```

### 3. **Uso dell'Helper `app()` - Anti-pattern Laraxot**

```php
// ❌ ANTI-PATTERN
return $this->hasMany(app('team_invitation_model'), 'team_id');
return $this->hasMany(app('team_user_model'), 'team_id');
```

**✅ CORRETTO** (secondo filosofia Laraxot):
```php
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\TeamUser;

public function teamInvitations(): HasMany
{
    return $this->hasMany(TeamInvitation::class, 'team_id');
}

public function teamUsers(): HasMany
{
    return $this->hasMany(TeamUser::class, 'team_id');
}
```

### 4. **Proprietà `owner` Inesistente**

```php
// ❌ ERRORE: $this->owner non è definita
public function getAllTeamUsersAttribute()
{
    return $this->teamUsers->merge([$this->owner]); // owner da dove viene?
}
```

**✅ CORRETTO**:
```php
public function getAllTeamUsersAttribute(): Collection
{
    $owner = $this->ownedTeams->first()?->owner ?? $this;
    return $this->teamUsers->merge([$owner]);
}
```

### 5. **Confusione di Responsabilità - Metodi che Dovrebbero Essere nel Team**

```php
// ❌ ERRORE: Questi metodi dovrebbero essere nel modello Team, non User
public function addTeamMember($user, $role = null)      // Team responsibility
public function removeTeamMember($user)                 // Team responsibility
public function teamUsers()                             // Team responsibility
public function teamInvitations()                       // Team responsibility
```

**✅ CORRETTO** - Spostare nel modello Team:
```php
// Nel modello Team
public function addMember(UserContract $user, ?Role $role = null): Model
public function removeMember(UserContract $user): void
public function users(): HasMany
public function invitations(): HasMany
```

### 6. **Metodi Duplicati**

```php
// ❌ DUPLICAZIONE
public function ownsTeam(TeamContract $team): bool
public function checkTeamOwnership(TeamContract $team): bool // Stesso comportamento!
```

**✅ CORRETTO**:
```php
public function ownsTeam(TeamContract $team): bool
{
    return $this->ownedTeams()->where('teams.id', $team->id)->exists();
}

// Rimuovere checkTeamOwnership() oppure farlo chiamare ownsTeam()
public function checkTeamOwnership(TeamContract $team): bool
{
    return $this->ownsTeam($team);
}
```

### 7. **Inconsistenza nelle Query delle Relazioni**

```php
// ❌ INCONSISTENTE: Mix di approcci diversi
$found = $this->teams()->where('teams.id', $team->id)->first();        // Approach 1
$found = $this->ownedTeams()->where('teams.id', $team->id)->first();   // Approach 2
```

**✅ CORRETTO** - Usare approccio uniforme:
```php
public function belongsToTeam(?TeamContract $team): bool
{
    if ($team === null) {
        return false;
    }

    return $this->teams()->where($this->teams()->getTable().'.id', $team->id)->exists();
}

public function ownsTeam(TeamContract $team): bool
{
    return $this->ownedTeams()->where($this->ownedTeams()->getTable().'.id', $team->id)->exists();
}
```

### 8. **Mancanza di Controlli di Sicurezza**

```php
// ❌ MANCANO CONTROLLI
public function teamRole(TeamContract $team): ?Role
{
    $teamUser = $this->teamUsers()->where('team_id', $team->id)->first();
    return $teamUser?->role; // Assume che role esista sempre
}
```

**✅ CORRETTO**:
```php
public function teamRole(TeamContract $team): ?Role
{
    $teamUser = $this->teamUsers()
        ->where('team_id', $team->id)
        ->with('role')
        ->first();

    return $teamUser?->role instanceof Role ? $teamUser->role : null;
}
```

### 9. **Return Type Incompleti**

```php
// ❌ MANCANO RETURN TYPES
public function teamInvitations()     // Missing return type
public function teamUsers()           // Missing return type
public function getAllTeamUsersAttribute() // Missing return type
```

**✅ CORRETTO**:
```php
public function teamInvitations(): HasMany
public function teamUsers(): HasMany
public function getAllTeamUsersAttribute(): Collection
```

### 10. **Logica Confusa in `currentTeam()`**

```php
// ❌ LOGICA COMPLESSA E CONFUSA
public function currentTeam(): BelongsTo
{
    $xot = XotData::make();
    if ($this->current_team_id === null && $this->id) {
        $this->switchTeam($this->personalTeam()); // Side effect in getter!
    }

    if ($this->allTeams()->isEmpty() && $this->getKey() !== null) {
        $this->current_team_id = null;
        $this->save(); // Side effect in getter!
    }
    // ...
}
```

**✅ CORRETTO** - Separare logica:
```php
public function currentTeam(): BelongsTo
{
    $xot = XotData::make();
    $teamClass = $xot->getTeamClass();

    return $this->belongsTo($teamClass, 'current_team_id');
}

// Metodo separato per l'inizializzazione
public function ensureCurrentTeam(): void
{
    if ($this->current_team_id === null && $this->id) {
        $this->switchTeam($this->personalTeam());
    }

    if ($this->allTeams()->isEmpty() && $this->getKey() !== null) {
        $this->current_team_id = null;
        $this->save();
    }
}
```

---

## Refactoring Completo Raccomandato

### Trait HasTeams Corretto (Solo responsabilità User)
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Traits\RelationX;

/**
 * Trait HasTeams.
 *
 * @property-read Collection<int, TeamContract> $teams
 * @property-read Collection<int, TeamContract> $ownedTeams
 * @property-read TeamContract|null $currentTeam
 * @property int|null $current_team_id
 */
trait HasTeams
{
    use RelationX;

    /**
     * Get all teams the user belongs to.
     *
     * @return Collection<int, TeamContract>
     */
    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    /**
     * Check if the user belongs to a specific team.
     */
    public function belongsToTeam(?TeamContract $team): bool
    {
        if ($team === null) {
            return false;
        }

        return $this->teams()->where($this->teams()->getTable().'.id', $team->id)->exists();
    }

    /**
     * Get the current team of the user's context.
     *
     * @return BelongsTo<TeamContract, static>
     */
    public function currentTeam(): BelongsTo
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->belongsTo($teamClass, 'current_team_id');
    }

    /**
     * Get the teams owned by the user.
     *
     * @return HasMany<TeamContract>
     */
    public function ownedTeams(): HasMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();
        return $this->hasMany($teamClass, 'user_id');
    }

    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsToMany<TeamContract, static>
     */
    public function teams(): BelongsToMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->belongsToManyX($teamClass, null, null, 'team_id');
    }

    /**
     * Get the user's personal team.
     */
    public function personalTeam(): ?TeamContract
    {
        return $this->ownedTeams->where('personal_team', true)->first();
    }

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(?TeamContract $team): bool
    {
        if ($team === null) {
            $this->current_team_id = null;
            $this->save();
            return true;
        }

        if (! $this->belongsToTeam($team)) {
            return false;
        }

        $this->current_team_id = (string) $team->id;
        $this->save();

        return true;
    }

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(TeamContract $team): bool
    {
        return $this->ownedTeams()->where($this->ownedTeams()->getTable().'.id', $team->id)->exists();
    }

    /**
     * Check if the user has a specific permission in a team.
     */
    public function hasTeamPermission(TeamContract $team, string $permission): bool
    {
        return $this->ownsTeam($team) || in_array($permission, $this->teamPermissions($team));
    }

    /**
     * Check if the user has a specific role in a team.
     */
    public function hasTeamRole(TeamContract $team, string $role): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        $teamRole = $this->teamRole($team);
        return $teamRole !== null && $teamRole->name === $role;
    }

    /**
     * Get the role for a specific team.
     */
    public function teamRole(TeamContract $team): ?Role
    {
        // Questa logica dovrebbe essere nel modello Team
        // Ma temporaneamente la teniamo qui per compatibilità
        $teamUser = $team->users()
            ->where('user_id', $this->id)
            ->with('role')
            ->first();

        return $teamUser?->role instanceof Role ? $teamUser->role : null;
    }

    /**
     * Get permissions for a specific team.
     *
     * @return array<int, string>
     */
    public function teamPermissions(TeamContract $team): array
    {
        $role = $this->teamRole($team);

        if ($role === null || !$role->permissions) {
            return [];
        }

        return $role->permissions->pluck('name')->values()->toArray();
    }

    /**
     * Ensure the user has a current team.
     */
    public function ensureCurrentTeam(): void
    {
        if ($this->current_team_id === null && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        if ($this->allTeams()->isEmpty() && $this->getKey() !== null) {
            $this->current_team_id = null;
            $this->save();
        }
    }

    // Permission checking methods
    public function canCreateTeam(): bool
    {
        return $this->hasPermissionTo('create team');
    }

    public function canDeleteTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    public function canLeaveTeam(TeamContract $team): bool
    {
        return $this->belongsToTeam($team) && ! $this->ownsTeam($team);
    }

    public function canManageTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    public function canViewTeam(TeamContract $team): bool
    {
        return $this->belongsToTeam($team) || $this->hasTeamPermission($team, 'view team');
    }

    public function isCurrentTeam(TeamContract $team): bool
    {
        if ($this->currentTeam === null) {
            return false;
        }

        return $team->getKey() == $this->currentTeam->getKey();
    }
}
```

## Compliance PHPStan Livello 9+

1. ✅ **`declare(strict_types=1);`** (già presente)
2. ✅ **Tipizzazione completa** di tutti i metodi
3. ✅ **PHPDoc completi** con generics
4. ✅ **Gestione sicura dei nullable**
5. ✅ **Uso di classi concrete** invece di helper dinamici
6. ✅ **Separazione delle responsabilità**

## Best Practice Laraxot Rispettate

1. ✅ **`belongsToManyX`** utilizzato correttamente
2. ✅ **Convention over Configuration**
3. ✅ **Auto-Discovery** delle relazioni
4. ✅ **Dependency Injection** invece di helper `app()`
5. ✅ **Tipizzazione rigorosa** per PHPStan livello 9+

---

## Backlink e Riferimenti

- [docs/USER_MODULE.md](../../../docs/USER_MODULE.md)
- [Modules/User/docs/traits.md](traits.md)
- [docs/phpstan_fixes.md](../../../docs/phpstan_fixes.md)
- [Modules/Xot/docs/RELATION_X.md](../../Xot/docs/RELATION_X.md)

*Ultimo aggiornamento: gennaio 2025*
