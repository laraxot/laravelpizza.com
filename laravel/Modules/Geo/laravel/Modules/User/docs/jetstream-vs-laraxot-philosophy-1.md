# Jetstream vs Laraxot: Filosofia, Religione e Politica dei Team

## 🌟 **LA RELIGIONE JETSTREAM**

### Principi Fondamentali di Jetstream
1. **Semplicità Elegante**: "Convention over Configuration" al massimo livello
2. **Ownership Chiaro**: Ogni team ha un proprietario (`owner`) e membri (`users`)
3. **Context Switching**: L'utente può cambiare contesto tra team (`current_team_id`)
4. **Personal Team**: Ogni utente ha automaticamente un team personale
5. **Role-Based Access**: Sistema di ruoli e permessi granulare
6. **Action-Driven**: Logica business separata in Actions dedicate

### Architettura Jetstream
```php
// JETSTREAM PHILOSOPHY: Semplice ed Elegante
public function teams()
{
    return $this->belongsToMany(Jetstream::teamModel(), Jetstream::membershipModel())
                ->withPivot('role')
                ->withTimestamps()
                ->as('membership');
}
```

### Caratteristiche Jetstream
- **Modello Pivot Implicito**: Usa `membership` come alias per il pivot
- **Configurazione Centralizzata**: `Jetstream::teamModel()` e `Jetstream::membershipModel()`
- **Validazione nelle Actions**: Logica di business separata dal modello
- **Eventi Integrati**: `AddingTeamMember`, `TeamMemberAdded`
- **Autorizzazione con Gate**: `Gate::forUser($user)->authorize('addTeamMember', $team)`

## 🚀 **LA FILOSOFIA LARAXOT**

### Evoluzione Intelligente di Jetstream
Laraxot prende Jetstream e lo **EVOLVE** con:

1. **belongsToManyX**: Auto-discovery intelligente vs configurazione manuale
2. **Modelli Pivot Espliciti**: `TeamUser` vs `membership` alias
3. **Cross-Database Support**: Gestione automatica database multipli
4. **Tipizzazione Rigorosa**: PHPStan Level 9+ compliance
5. **Validazione Rigorosa**: `Assert` per controlli runtime
6. **Modularità**: Ogni modulo ha la sua logica isolata

### Architettura Laraxot
```php
// LARAXOT PHILOSOPHY: Intelligente e Automatica
public function teams(): BelongsToMany
{
    $teamClass = XotData::make()->getTeamClass();
    return $this->belongsToManyX($teamClass);
    // Automaticamente:
    // - Trova TeamUser come modello pivot
    // - Configura team_user come tabella
    // - Include tutti i $fillable del pivot
    // - Gestisce cross-database
    // - Aggiunge timestamps
}
```

## ⚔️ **CONFRONTO FILOSOFICO**

### 1. **Configurazione**
```php
// 🟡 JETSTREAM: Configurazione Esplicita
return $this->belongsToMany(Jetstream::teamModel(), Jetstream::membershipModel())
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');

// 🟢 LARAXOT: Auto-Discovery Intelligente
return $this->belongsToManyX($teamClass);
```

### 2. **Modello Pivot**
```php
// 🟡 JETSTREAM: Alias Implicito
$user->teams()->first()->membership->role

// 🟢 LARAXOT: Modello Esplicito
$user->teams()->first()->pivot // TeamUser instance
```

### 3. **Tipizzazione**
```php
// 🟡 JETSTREAM: Tipizzazione Debole
public function addTeamMember($user, $role = null)

// 🟢 LARAXOT: Tipizzazione Rigorosa
public function addTeamMember(UserContract $user, ?string $role = null): TeamUser
```

### 4. **Validazione**
```php
// 🟡 JETSTREAM: Validazione nelle Actions
protected function validate(Team $team, string $email, ?string $role): void

// 🟢 LARAXOT: Validazione Runtime + Actions
Assert::notNull($user, 'User cannot be null');
Assert::isInstanceOf($user, UserContract::class);
```

## 🎯 **LA SINTESI PERFETTA**

### Cosa Manteniamo da Jetstream
1. **Concetti Architetturali**: Owner, Members, Current Team, Personal Team
2. **Logica di Business**: Context switching, role management
3. **Pattern di Autorizzazione**: Gate-based permissions
4. **Eventi**: Team member lifecycle events

### Cosa Miglioriamo con Laraxot
1. **belongsToManyX**: Automazione intelligente
2. **Tipizzazione Completa**: PHPStan compliance
3. **Modularità**: Isolamento per modulo
4. **Cross-Database**: Supporto multi-database
5. **Contratti**: Interface-based design

## 🔥 **ERRORI CRITICI NEL TRAIT ATTUALE**

### 1. **VIOLAZIONE FILOSOFICA**: Metodi Duplicati
```php
// ❌ DUPLICAZIONE INUTILE - Jetstream ha solo teams()
public function teamUsers(): HasMany // QUESTO NON ESISTE IN JETSTREAM!
public function teams(): BelongsToMany

// ✅ JETSTREAM PURO - Un solo metodo
public function teams(): BelongsToMany
```

### 2. **LOGICA ERRATA**: belongsToTeams()
```php
// ❌ JETSTREAM NON HA QUESTO METODO - È INVENTATO!
public function belongsToTeams(): bool
{
    return true; // SEMPRE TRUE???
}

// ✅ LOGICA CORRETTA LARAXOT
public function belongsToTeams(): bool
{
    return $this->teams()->exists() || $this->ownedTeams()->exists();
}
```

### 3. **ANTI-PATTERN**: Metodi Ridondanti
```php
// ❌ JETSTREAM NON HA QUESTI METODI
public function inviteToTeam() // Duplica addTeamMember
public function removeFromTeam() // Duplica removeTeamMember
public function promoteToAdmin() // Non esiste in Jetstream
public function demoteFromAdmin() // Non esiste in Jetstream
```

## 🚀 **STRATEGIA DI CORREZIONE FILOSOFICA**

### FASE 1: Allineamento a Jetstream
1. **Rimuovere** metodi non-Jetstream (`teamUsers`, `inviteToTeam`, etc.)
2. **Mantenere** solo i metodi core di Jetstream
3. **Correggere** la logica di `belongsToTeams()`

### FASE 2: Evoluzione Laraxot
1. **Sostituire** `belongsToMany` con `belongsToManyX`
2. **Aggiungere** tipizzazione rigorosa
3. **Implementare** validazione con Assert
4. **Completare** PHPDoc per PHPStan

### FASE 3: Miglioramenti Laraxot
1. **Contratti**: UserContract, TeamContract
2. **Cross-Database**: Supporto multi-database
3. **Modularità**: Isolamento per modulo
4. **Performance**: Ottimizzazioni query

## 🏆 **IL TRAIT PERFETTO: Jetstream + Laraxot**

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
     *
     * @param TeamContract $team
     * @return bool
     */
    public function isCurrentTeam(TeamContract $team): bool
    {
        return $team->id === $this->currentTeam?->id;
    }

    /**
     * Get the current team of the user's context.
     *
     * @return BelongsTo<TeamContract, static>
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
     *
     * @param TeamContract|null $team
     * @return bool
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
     *
     * @return Collection<int, TeamContract>
     */
    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    /**
     * Get all of the teams the user owns.
     *
     * @return HasMany<TeamContract>
     */
    public function ownedTeams(): HasMany
    {
        $teamClass = XotData::make()->getTeamClass();
        return $this->hasMany($teamClass);
    }

    /**
     * Get all of the teams the user belongs to (LARAXOT EVOLUTION).
     *
     * @return BelongsToMany<TeamContract, static>
     */
    public function teams(): BelongsToMany
    {
        $teamClass = XotData::make()->getTeamClass();
        return $this->belongsToManyX($teamClass); // LARAXOT MAGIC!
    }

    /**
     * Determine if the user belongs to the given team.
     *
     * @param TeamContract|null $team
     * @return bool
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
     *
     * @param TeamContract $team
     * @return bool
     */
    public function ownsTeam(TeamContract $team): bool
    {
        Assert::notNull($team, 'Team cannot be null');

        return $this->id && $team->user_id && $this->id === $team->user_id;
    }

    /**
     * Get the user's personal team.
     *
     * @return TeamContract|null
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
     *
     * @param TeamContract $team
     * @return string|null
     */
    public function teamRole(TeamContract $team): ?string
    {
        if ($this->ownsTeam($team)) {
            return 'owner';
        }

        $membership = $this->teams()
            ->where('teams.id', $team->id)
            ->first()
            ?->pivot;

        return $membership?->role;
    }

    /**
     * Determine if the user has the given role on the given team.
     *
     * @param TeamContract $team
     * @param string $role
     * @return bool
     */
    public function hasTeamRole(TeamContract $team, string $role): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        return $this->belongsToTeam($team) && $this->teamRole($team) === $role;
    }

    /**
     * Get the user's permissions for the given team.
     *
     * @param TeamContract $team
     * @return array<string>
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
        return $role ? [$role] : [];
    }

    /**
     * Determine if the user has the given permission on the given team.
     *
     * @param TeamContract $team
     * @param string $permission
     * @return bool
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
}
```

## 🎖️ **CONCLUSIONE FILOSOFICA**

### La Sintesi Perfetta
**Laraxot HasTeams** = **Jetstream Philosophy** + **Laraxot Intelligence**

1. **Manteniamo** la semplicità e eleganza di Jetstream
2. **Aggiungiamo** l'automazione intelligente di Laraxot
3. **Evolviamo** con tipizzazione rigorosa e validazione
4. **Rimuoviamo** tutto ciò che non è allineato a Jetstream

### Il Risultato
Un trait che **rispetta la religione Jetstream** ma **evolve con la filosofia Laraxot**, creando la **sintesi perfetta** tra semplicità ed intelligenza.

---

**Data creazione**: 10 giugno 2025
**Conformità**: Laravel Jetstream 5.x + Laraxot PTVX Philosophy
**PHPStan**: Level 9+ Compliant
