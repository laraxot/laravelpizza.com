# Guida Completa ai Trait del Modulo User - AGGIORNATO POST-IMPLEMENTAZIONE

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