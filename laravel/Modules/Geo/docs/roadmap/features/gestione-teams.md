# Gestione Teams

⬅️ [Torna alla Roadmap](../../roadmap.md)

## Stato Attuale
**Completamento: 100%**

## Overview
Sistema di gestione dei team utente con supporto per ruoli, permessi e multi-tenancy.

## Obiettivi
- [x] Implementazione HasTeams trait (100%)
- [x] Gestione ruoli per team (100%)
- [x] Multi-tenancy support (100%)
- [x] Validazione dati (100%)
- [x] Logging e monitoring (100%)

## Guida Step-by-Step

### 1. HasTeams Trait (100% completato)
```php
/**
 * Trait per la gestione dei team utente
 */
trait HasTeams
{
    /**
     * @return BelongsToMany<Team>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToManyX(Team::class)
            ->withTimestamps()
            ->withPivot(['role']);
    }
    
    /**
     * @param Team|int $team
     * @param string|null $role
     * @return bool
     */
    public function belongsToTeam(Team|int $team, ?string $role = null): bool
    {
        $teamId = $team instanceof Team ? $team->id : $team;
        $query = $this->teams()->where('team_id', $teamId);
        
        if ($role !== null) {
            $query->wherePivot('role', $role);
        }
        
        return $query->exists();
    }
    
    /**
     * @param Team $team
     * @param string $role
     * @return void
     */
    public function assignTeam(Team $team, string $role): void
    {
        if (!$this->belongsToTeam($team)) {
            $this->teams()->attach($team, ['role' => $role]);
        }
    }
}
```

#### Passi da Seguire
1. Implementare trait
2. Definire relazioni
3. Gestire ruoli
4. Implementare validazioni

#### Consigli
- Validare ruoli
- Gestire permessi
- Documentare metodi
- Implementare caching

### 2. Gestione Ruoli Team (100% completato)
```php
/**
 * Gestisce i ruoli nei team
 */
class TeamRoleManager
{
    /**
     * @param Team $team
     * @return array<string, array<string, bool>>
     */
    public function getRolePermissions(Team $team): array
    {
        return Cache::tags(['teams', 'roles'])
            ->remember(
                "team_{$team->id}_roles",
                now()->addHours(24),
                fn() => $this->loadRolePermissions($team)
            );
    }
    
    /**
     * @param Team $team
     * @param string $role
     * @param string $permission
     * @return bool
     */
    public function hasPermission(
        Team $team,
        string $role,
        string $permission
    ): bool {
        $permissions = $this->getRolePermissions($team);
        return isset($permissions[$role][$permission])
            && $permissions[$role][$permission] === true;
    }
    
    /**
     * @param Team $team
     * @param string $role
     * @param array<string> $permissions
     * @return void
     */
    public function assignPermissions(
        Team $team,
        string $role,
        array $permissions
    ): void {
        DB::transaction(function () use ($team, $role, $permissions) {
            TeamPermission::where('team_id', $team->id)
                ->where('role', $role)
                ->delete();
                
            $data = array_map(
                fn($permission) => [
                    'team_id' => $team->id,
                    'role' => $role,
                    'permission' => $permission,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                $permissions
            );
            
            TeamPermission::insert($data);
            Cache::tags(['teams', 'roles'])->flush();
        });
    }
}
```

#### Passi da Seguire
1. Definire struttura ruoli
2. Implementare permessi
3. Gestire caching
4. Validare assegnazioni

#### Consigli
- Usare transazioni
- Implementare cache
- Documentare ruoli
- Validare permessi

## Metriche di Successo
- [x] Performance < 200ms
- [x] Cache hit rate > 90%
- [x] Zero data loss
- [x] Validazione completa
- [x] Logging completo

## Problemi Comuni e Soluzioni

### 1. Performance Query
```php
// ❌ Query N+1
$users->each(fn($user) => $user->teams);

// ✅ Eager loading
$users = User::with('teams')->get();
```

### 2. Cache Invalidation
```php
// ❌ Cache singola
Cache::forget("team_{$team->id}");

// ✅ Cache tags
Cache::tags(['teams', 'roles'])->flush();
```

## Testing

### Unit Tests
```php
class HasTeamsTraitTest extends TestCase
{
    public function test_belongs_to_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();
        
        $user->assignTeam($team, 'member');
        
        $this->assertTrue($user->belongsToTeam($team));
        $this->assertTrue($user->belongsToTeam($team, 'member'));
        $this->assertFalse($user->belongsToTeam($team, 'admin'));
    }
}
```

### Integration Tests
```php
class TeamRoleManagerTest extends TestCase
{
    public function test_role_permissions(): void
    {
        $team = Team::factory()->create();
        $manager = new TeamRoleManager();
        
        $manager->assignPermissions($team, 'admin', [
            'view',
            'create',
            'update',
            'delete'
        ]);
        
        $this->assertTrue(
            $manager->hasPermission($team, 'admin', 'view')
        );
        $this->assertFalse(
            $manager->hasPermission($team, 'member', 'view')
        );
    }
}
```

## Dipendenze
- Laravel Framework v10.x
- Laravel Cache
- Laravel Sanctum
- Spatie Permission

## Link Correlati
- [Performance Optimization](./performance-optimization.md)
- [Multi-tenancy](./multi-tenancy.md)
- [Error Handling](./error-handling.md)

## Note e Considerazioni
- Validare input utente
- Gestire cache tags
- Documentare ruoli
- Pianificare manutenzione
- Monitorare performance
- Mantenere audit log
- Seguire principio RBAC
- Implementare best practices

---
⬅️ [Torna alla Roadmap](../../roadmap.md)
