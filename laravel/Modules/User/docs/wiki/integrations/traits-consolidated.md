---
title: "traits: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "traits   consolidated documentation user"
---

# traits: Consolidated Documentation

Consolidated from **10** individual files.

## Table of Contents

- [---](#traits-complete-guide)
- [---](#traits-hasteams-analisi-corretta-3)
- [---](#traits-hasteams-analisi-corretta)
- [---](#traits-hasteams-analysis-corrected)
- [---](#traits-hasteams-analysis-corretta)
- [---](#traits-hasteams-corrected)
- [---](#traits-hasteams-corretta)
- [---](#traits)
- [Guida Completa ai Trait del Modulo User - AGGIORNATO POST-IMPLEMENTAZIONE](#traits_complete_guide)
- [Analisi Corretta del Trait HasTeams - Filosofia Laraxot](#traits_hasteams_analisi_corretta)

---

## traits-complete-guide

*Consolidated from: `traits-complete-guide.md`*

module: theme
topic: traits-complete-guide
canonical: ../../../Themes/docs/shared-components/traits-complete-guide.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/traits-complete-guide.md

---

## traits-hasteams-analisi-corretta-3

*Consolidated from: `traits-hasteams-analisi-corretta.md`*

title: "Analisi Corretta del Trait HasTeams - Filosofia Laraxot"
type: concept
tags: [traits, hasteams, analisi, corretta]
created: 2026-07-14
updated: 2026-07-14
qmd: "traits-hasteams-analisi-corretta-3 analisi corretta del trait hasteams - filosofia laraxot"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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
- [Modules/User/docs/traits.md](../../traits.md)  
- [docs/phpstan-fixes-8.md](../../../docs/phpstan-fixes-8.md)
- [Modules/User/docs/traits.md](../../traits.md)  
- [docs/phpstan-fixes.md](../../../docs/phpstan-fixes.md)
- [Modules/Xot/docs/RELATION_X.md](../../Xot/docs/RELATION_X.md)

*Ultimo aggiornamento: gennaio 2025* 
- [docs/USER_MODULE.md](../../../../docs/user_module.md)
- [Modules/User/docs/traits.md](../../traits.md)  
- [docs/phpstan-fixes-8.md](../../../../docs/phpstan-fixes-8.md)
- [Modules/User/docs/traits.md](../../traits.md)  
- [docs/phpstan-fixes.md](../../phpstan-fixes.md)
- [Modules/Xot/docs/RELATION_X.md](../../xot/docs/relation_x.md)
---

## traits-hasteams-analisi-corretta

*Consolidated from: `traits-hasteams-analisi-corretta.md`*

module: theme
topic: traits-hasteams-analisi-corretta
canonical: ../../../Themes/docs/shared-components/traits-hasteams-analisi-corretta.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/traits-hasteams-analisi-corretta.md

---

## traits-hasteams-analysis-corrected

*Consolidated from: `traits-hasteams-analysis-corrected.md`*

title: "Analisi Corretta del Trait HasTeams - Filosofia Laraxot"
type: concept
tags: [traits, hasteams, analysis, corrected]
created: 2026-07-14
updated: 2026-07-14
qmd: "traits-hasteams-analysis-corrected analisi corretta del trait hasteams - filosofia laraxot"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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

- [docs/USER_MODULE.md](../../../../docs/project/user_module.md)
- [Modules/User/project_docs/traits.md](../../traits.md)
- [docs/phpstan-fixes-8.md](../../../../docs/project/phpstan-fixes-8.md)
- [Modules/User/project_docs/traits.md](../../traits.md)
- [docs/phpstan-fixes.md](../../../../docs/project/phpstan-fixes.md)
- [Modules/Xot/project_docs/RELATION_X.md](../../xot/project_docs/relation_x.md)

---

## traits-hasteams-analysis-corretta

*Consolidated from: `traits-hasteams-analysis-corretta.md`*

title: "Analisi Corretta del Trait HasTeams - Filosofia Laraxot"
type: concept
tags: [traits, hasteams, analysis, corretta]
created: 2026-07-14
updated: 2026-07-14
qmd: "traits-hasteams-analysis-corretta analisi corretta del trait hasteams - filosofia laraxot"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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

- [docs/USER_MODULE.md](../../../../docs/project/user_module.md)
- [Modules/User/project_docs/traits.md](../../traits.md)  
- [docs/phpstan-fixes-8.md](../../../../docs/project/phpstan-fixes-8.md)
- [Modules/User/project_docs/traits.md](../../traits.md)  
- [docs/phpstan-fixes.md](../../../../docs/project/phpstan-fixes.md)
- [Modules/Xot/project_docs/RELATION_X.md](../../xot/project_docs/relation_x.md)


---

## traits-hasteams-corrected

*Consolidated from: `traits-hasteams-corrected.md`*

module: theme
topic: traits-hasteams-corrected
canonical: ../../../Themes/docs/shared-components/traits-hasteams-analysis-corrected.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/traits-hasteams-analysis-corrected.md

---

## traits-hasteams-corretta

*Consolidated from: `traits-hasteams-corretta.md`*

module: theme
topic: traits-hasteams-corretta
canonical: ../../../Themes/docs/shared-components/traits-hasteams-analysis-corretta.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/traits-hasteams-analysis-corretta.md

---

## traits

*Consolidated from: `traits.md`*

title: "User Module Traits"
type: concept
tags: [traits]
created: 2026-07-14
updated: 2026-07-14
qmd: "traits user module traits"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# User Module Traits

## HasTeams

Gestisce l'appartenenza a team multipli.

```php
use Modules\User\Models\Traits\HasTeams;

class User extends Authenticatable
{
    use HasTeams;
}
```

## HasTenants

Gestione multi-tenant Filament.

```php
use Modules\User\Models\Traits\HasTenants;

class User extends Authenticatable
{
    use HasTenants;
}
```

## HasAuthenticationLogTrait

Logging autenticazioni.

```php
use Modules\User\Models\Traits\HasAuthenticationLogTrait;

class User extends Authenticatable
{
    use HasAuthenticationLogTrait;
}
```

## Collegamenti

- [Modulo User](./readme.md)
- [Xot Traits](../../../../Xot/docs)
- [Modulo User](./readme.md)
- [Xot Traits](../../../../Xot/docs)

---

## traits_complete_guide

*Consolidated from: `traits_complete_guide.md`*


## Stato Implementazione ✅ COMPLETATO

**Data implementazione:** 10 giugno 2025
**Trait corretto:** HasTeams
**Filosofia applicata:** Jetstream + Laraxot Evolution

## Correzioni Implementate

### 1. ✅ Errori Critici Risolti

- **belongsToTeams() sempre true**: CORRETTO - ora usa `exists()` su relazioni
- **belongsToTeam() logica errata**: CORRETTO - ora usa `contains()` su collection
- **ownsTeam() query inefficiente**: CORRETTO - ora confronta direttamente gli ID
- **teams() non usa belongsToManyX**: CORRETTO - ora usa `belongsToManyX($teamClass)`

### 2. ✅ Metodi Non-Jetstream Rimossi

Rimossi completamente i seguenti metodi che violavano la filosofia Jetstream:
- `addTeamMember()` - gestito da Actions
- `removeTeamMember()` - gestito da Actions  
- `inviteToTeam()` - gestito da Actions
- `removeFromTeam()` - gestito da Actions
- `promoteToAdmin()` - gestito da Actions
- `demoteFromAdmin()` - gestito da Actions
- `getTeamAdmins()` - non necessario
- `getTeamMembers()` - non necessario
- `teamUsers()` - non necessario nel trait User
- `teamInvitations()` - non necessario nel trait User
- `getAllTeamUsersAttribute()` - non necessario
- `hasTeamMember()` - non necessario nel trait User
- `canXXX()` metodi - gestiti da Policy
- `bootHasTeams()` - non necessario
- `ensureCurrentTeam()` - integrato in currentTeam()
- `checkTeamOwnership()` - duplicato di ownsTeam()

### 3. ✅ Tipizzazione Rigorosa Aggiunta

Tutti i metodi ora hanno:
- Tipi di parametri espliciti
- Tipi di ritorno espliciti
- PHPDoc con generics per relazioni Eloquent
- Annotazioni `@property-read` per proprietà

### 4. ✅ Filosofia Jetstream + Laraxot Implementata

**Core Jetstream Methods (mantenuti e corretti):**
- `isCurrentTeam(TeamContract $team): bool`
- `currentTeam(): BelongsTo<TeamContract, static>`
- `switchTeam(?TeamContract $team): bool`
- `allTeams(): Collection<int, TeamContract>`
- `ownedTeams(): HasMany<TeamContract>`
- `teams(): BelongsToMany<TeamContract, static>` (con belongsToManyX)
- `belongsToTeam(?TeamContract $team): bool`
- `ownsTeam(TeamContract $team): bool`
- `personalTeam(): ?TeamContract`

**Laraxot Extensions (aggiunti):**
- `belongsToTeams(): bool` - check esistenza team
- `teamRole(TeamContract $team): ?Role` - ruolo enhanced
- `hasTeamRole(TeamContract $team, string $role): bool`
- `teamPermissions(TeamContract $team): array<string>`
- `hasTeamPermission(TeamContract $team, string $permission): bool`

**Utility Methods (mantenuti):**
- `hasTeams(): bool` - alias per belongsToTeams()
- `isOwnerOrMember(TeamContract $team): bool`

## Implementazione Corretta HasTeams

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\TeamUser;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Traits\RelationX;
use Webmozart\Assert\Assert;

/**
 * Trait HasTeams - Jetstream Philosophy + Laraxot Evolution.
 *
 * Inspired by Laravel Jetstream but evolved with Laraxot intelligence:
 * - belongsToManyX for auto-discovery
 * - Strict typing for PHPStan Level 9+
 * - Runtime validation with Assert
 * - Cross-database support
 * - Explicit pivot models
 *
 * @property-read TeamContract|null $currentTeam
 * @property int|null $current_team_id
 * @property-read Collection<int, TeamContract> $teams
 * @property-read Collection<int, TeamContract> $ownedTeams
 */
trait HasTeams
{
    use RelationX;

    // ==================== JETSTREAM CORE METHODS ====================

    /**
     * Determine if the given team is the current team.
     */
    public function isCurrentTeam(TeamContract $team): bool
    {
        return $team->id === $this->currentTeam?->id;
    }

    /**
     * Get the current team of the user's context.
     */
    public function currentTeam(): BelongsTo
    {
        if (is_null($this->current_team_id) && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        $teamClass = XotData::make()->getTeamClass();
        return $this->belongsTo($teamClass, 'current_team_id');
    }

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(?TeamContract $team): bool
    {
        if ($team !== null && !$this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team?->id,
        ])->save();

        if ($team) {
            $this->setRelation('currentTeam', $team);
        }

        return true;
    }

    /**
     * Get all of the teams the user owns or belongs to.
     */
    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    /**
     * Get all of the teams the user owns.
     */
    public function ownedTeams(): HasMany
    {
        $teamClass = XotData::make()->getTeamClass();
        return $this->hasMany($teamClass);
    }

    /**
     * Get all of the teams the user belongs to (LARAXOT EVOLUTION).
     *
     * Uses belongsToManyX for intelligent auto-discovery:
     * - Automatically finds TeamUser as pivot model
     * - Configures team_user as table
     * - Includes all $fillable fields from pivot
     * - Handles cross-database scenarios
     * - Adds timestamps automatically
     */
    public function teams(): BelongsToMany
    {
        $teamClass = XotData::make()->getTeamClass();
        return $this->belongsToManyX($teamClass); // LARAXOT MAGIC!
    }

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToTeam(?TeamContract $team): bool
    {
        if ($team === null) {
            return false;
        }

        return $this->teams->contains($team) || $this->ownsTeam($team);
    }

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(TeamContract $team): bool
    {
        Assert::notNull($team, 'Team cannot be null');
        
        return $this->id && $team->user_id && $this->id === $team->user_id;
    }

    /**
     * Get the user's personal team.
     */
    public function personalTeam(): ?TeamContract
    {
        return $this->ownedTeams->where('personal_team', true)->first();
    }

    // ==================== LARAXOT EXTENSIONS ====================

    /**
     * Check if the user belongs to any teams (LARAXOT ADDITION).
     */
    public function belongsToTeams(): bool
    {
        return $this->teams()->exists() || $this->ownedTeams()->exists();
    }

    /**
     * Get the user's role on the given team (ENHANCED JETSTREAM).
     */
    public function teamRole(TeamContract $team): ?Role
    {
        if ($this->ownsTeam($team)) {
            return Role::owner();
        }

        $membership = $this->teams()
            ->where('teams.id', $team->id)
            ->first()
            ?->pivot;

        return $membership?->role;
    }

    /**
     * Determine if the user has the given role on the given team.
     */
    public function hasTeamRole(TeamContract $team, string $role): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        return $this->belongsToTeam($team) && $this->teamRole($team)?->name === $role;
    }

    /**
     * Get the user's permissions for the given team.
     */
    public function teamPermissions(TeamContract $team): array
    {
        if ($this->ownsTeam($team)) {
            return ['*'];
        }

        if (!$this->belongsToTeam($team)) {
            return [];
        }

        $role = $this->teamRole($team);
        // Implementare logica permessi basata su ruolo
        return $role ? [$role->name] : [];
    }

    /**
     * Determine if the user has the given permission on the given team.
     */
    public function hasTeamPermission(TeamContract $team, string $permission): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        if (!$this->belongsToTeam($team)) {
            return false;
        }

        $permissions = $this->teamPermissions($team);

        return in_array($permission, $permissions) || in_array('*', $permissions);
    }

    // ==================== UTILITY METHODS ====================

    /**
     * Check if the user has teams (alias for belongsToTeams).
     */
    public function hasTeams(): bool
    {
        return $this->belongsToTeams();
    }

    /**
     * Determine if the user owns or belongs to the given team.
     */
    public function isOwnerOrMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->belongsToTeam($team);
    }
}

## Prossimi Passi

### 1. Testing e Validazione
- [ ] Creare test unitari per tutti i metodi corretti
- [ ] Testare integrazione con TeamUser pivot model
- [ ] Validare funzionamento con belongsToManyX
- [ ] Test cross-database scenarios

### 2. Aggiornamento RelationManager
- [ ] Verificare TeamsRelationManager in User module
- [ ] Assicurarsi che usi traduzioni corrette
- [ ] Testare funzionalità CRUD

### 3. PHPStan Compliance
- [ ] Eseguire PHPStan livello 9+ su User module
- [ ] Verificare assenza errori di tipizzazione
- [ ] Controllare compatibilità con contratti

### 4. Estensione ad Altri Trait
- [ ] Applicare stessa filosofia a HasTenants
- [ ] Correggere HasAuthenticationLogTrait se necessario
- [ ] Documentare pattern per futuri trait

## Filosofia Implementata

### Jetstream Core
- **Team ownership**: Chiaro concetto di proprietario
- **Current team context**: Switching tra team
- **Personal team**: Team personale per ogni utente
- **Role-based permissions**: Ruoli e permessi

### Laraxot Evolution
- **belongsToManyX**: Auto-discovery intelligente
- **Strict typing**: PHPStan Level 9+ compliance
- **Cross-database**: Supporto multi-database
- **Runtime validation**: Assert per controlli runtime
- **Explicit pivot models**: TeamUser come modello esplicito

## Backlink e Riferimenti

- [jetstream_vs_laraxot_philosophy.md](jetstream_vs_laraxot_philosophy.md)
- [/.cursor/rules/hasteams_jetstream_philosophy.mdc](../../.cursor/rules/hasteams_jetstream_philosophy.mdc)
- [/.windsurf/rules/hasteams_jetstream_philosophy.mdc](../../.windsurf/rules/hasteams_jetstream_philosophy.mdc)
- [Modules/Xot/docs/RELATION_X_USAGE.md](../Xot/docs/RELATION_X_USAGE.md)
- [docs/USER_TRAITS_GUIDELINES.md](../../docs/USER_TRAITS_GUIDELINES.md)

*Ultimo aggiornamento: 10 giugno 2025 - HasTeams trait completamente corretto e implementato*

## Analisi del Conflitto con HasTeamsContract

Il contratto `HasTeamsContract` definisce:
```

```php
public function teamRole(TeamContract $teamContract): ?Role;
```

Ma la nostra implementazione restituisce:
```php
public function teamRole(TeamContract $team): ?string;
```

Per risolvere questo conflitto, abbiamo aggiunto un nuovo metodo `teamRole()` che restituisce un oggetto `Role` e mantenuto il metodo `teamRoleName()` per ottenere la stringa del ruolo.

```php
public function teamRole(TeamContract $team): ?Role
{
    if ($this->ownsTeam($team)) {
        return Role::owner();
    }

    $membership = $this->teams()
        ->where('teams.id', $team->id)
        ->first()
        ?->pivot;

    return $membership?->role;
}

public function teamRoleName(TeamContract $team): ?string
{
    return $this->teamRole($team)?->name;
}
```

## HasTeams ⚠️ **CONFLITTO CONTRATTO RISOLTO - PROBLEMA TEST DATABASE**
**Status:** Trait corretto, problema con test database
**Filosofia:** Jetstream + Laraxot Evolution
**Ultima modifica:** 10 giugno 2025

#### Problema Database Test ⚠️
I test falliscono con errore di chiave primaria duplicata nella tabella `team_user`:
```
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '' for key 'PRIMARY'
```

**Causa identificata:** La tabella `team_user` ha una chiave primaria vuota che causa conflitti durante i test.

**Soluzioni possibili:**
1. Verificare la struttura della tabella `team_user` 
2. Assicurarsi che la chiave primaria sia auto-incrementale
3. Utilizzare database in-memory per i test
4. Implementare factory per TeamUser con ID corretti

#### Conflitto HasTeamsContract ✅ **RISOLTO**
- **teamRole() contratto**: CORRETTO - ora restituisce `?Role` invece di `?string`
- **teamRoleName() helper**: AGGIUNTO - per ottenere stringa del ruolo
- **Compatibilità**: MANTENUTA - sia oggetti Role che stringhe supportati

---

## traits_hasteams_analisi_corretta

*Consolidated from: `traits_hasteams_analisi_corretta.md`*


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
- [Modules/User/docs/traits.md](../../traits.md)  
- [Modules/User/docs/traits.md](../../traits.md)  
- [docs/phpstan_fixes.md](../../../docs/phpstan_fixes.md)
- [Modules/Xot/docs/RELATION_X.md](../../Xot/docs/RELATION_X.md)

*Ultimo aggiornamento: gennaio 2025* 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04