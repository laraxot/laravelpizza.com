---
title: "Team, membership e tenant"
type: concept
module: User
tags: [teams, membership, tenant, hasteams, current-team, team_user]
qmd: "user team membership tenant HasTeams currentTeam team_user pivot Membership TeamContract TenantScope switchTeam"
---

# Team, membership e tenant

## Modelli e tabelle

| Concetto | Modello | Tabella | Note |
|---|---|---|---|
| Team | `Team` (estende `BaseTeam`, implementa `TeamContract`) | `teams` | `owner_id`/`user_id` del proprietario; `purge()`, `allUsers()`, `userHasPermission()` |
| Membership | `Membership` (pivot, `BasePivot`) / `TeamUser` | `team_user` | `id` intero auto-increment, `role`, `permissions` (JSON), `joined_at`, `team_id`, `user_id` |
| Invito | `TeamInvitation` | `team_invitations` | colonna `user_id` aggiunta dalla migrazione `2026_11_10_000000` |
| Permessi di team | `TeamPermission` | `team_permissions` | |
| Tenant | `Tenant` (`BaseTenant`) | `tenants` + pivot `tenant_user` | isolamento multi-tenant, vedi sotto |
| Profilo-team | `ProfileTeam` | `profile_team` | |

Spatie Permission e' configurato in modalita' team: `config('permission.teams')` e' vero e i modelli di `Role`, `Permission` e `Team`
sono quelli del modulo (verificato da `tests/Unit/SpatiePermissionTeamConfigTest.php`); Role e Permission sono sulla connessione `user`.

## Il trait `HasTeams`

Aggiunto a `BaseUser`; lavora **solo con `TeamContract`**, mai con `Team` (testabilita', sostituibilita' del modello, coerenza con la regola
"contratti e non classi concrete"). La classe del team si risolve con `XotData::make()->getTeamClass()`.

| Area | Metodi |
|---|---|
| Relazioni | `currentTeam()` (`belongsTo(current_team_id)`), `ownedTeams()` (`hasMany(user_id)`), `teamUsers()`, `teams()` (BelongsToMany), `allTeams()`, `personalTeam()` |
| Appartenenza | `belongsToTeam`, `belongsToTeams`, `hasTeams`, `hasTeamMember`, `ownsTeam`, `isOwnerOrMember`, `isCurrentTeam` |
| Contesto | `initializeCurrentTeam()` (se manca `current_team_id` usa il team personale, altrimenti il primo disponibile), `switchTeam($team)` (rifiuta con `false` se l'utente non appartiene al team) |
| Autorizzazione | `hasTeamRole`, `hasTeamPermission`, `teamRole`, `teamRoleName`, `teamPermissions`, `canAddTeamMember/canCreateTeam/canDeleteTeam/canLeaveTeam/canManageTeam/canRemoveTeamMember/canUpdateTeam/canUpdateTeamMember/canViewTeam` |
| Amministrazione | `inviteToTeam`, `removeFromTeam`, `promoteToAdmin`, `demoteFromAdmin`, `getTeamAdmins`, `getTeamMembers`, `addTeamMember`, `removeTeamMember` |

Regole di autorizzazione per team (verificate nel codice):

- il **proprietario** ha ogni permesso (`teamPermissions()` restituisce `['*']`) e conta come avente qualsiasi ruolo (`hasTeamRole`);
- per un membro, i permessi sono l'unione dei permessi del **ruolo** (pivot `role`) e di quelli veri nella colonna JSON `permissions`
  del pivot (chiavi con valore vero);
- `teamRole()` del proprietario e' il ruolo `owner`; per un membro il pivot puo' contenere un `Role` o il nome del ruolo.

### Decisioni storiche

- **Una sola `currentTeam()`**: il trait ne aveva due; resta la versione che usa la classe team dinamica (`XotData`) e `TeamContract`.
  Il test `tests/Unit/CurrentTeamInfiniteLoopFixTest.php` protegge da un ciclo infinito nella risoluzione del team corrente.
- **Pivot con chiave intera**: la chiave UUID senza generazione faceva fallire `AttachAction` (`Duplicate entry ''`): vedi
  [migration-consolidation.md](migration-consolidation.md).
- **Binding dei modelli team** (`registerTeamModelBindings`) e' commentato in `UserServiceProvider`: i modelli si risolvono da `XotData`.
- **Chiave primaria composta** di `team_user`: scartata a favore dell'`id` intero per compatibilita' con Filament (relation manager).
- Problemi di metodi duplicati nel trait (`hasteams-trait-duplicate-methods`) sono stati risolti tenendo un'unica definizione per metodo;
  l'analisi completa e' in [dry-kiss-redundancy.md](dry-kiss-redundancy.md).

## Eventi e contratti

Eventi di team in `app/Events`: `AddingTeam`, `TeamCreated`, `TeamUpdated`, `TeamDeleted`, `TeamSwitched`, `AddingTeamMember`,
`TeamMemberAdded`, `TeamMemberUpdated`, `RemovingTeamMember`, `TeamMemberRemoved`, `InvitingTeamMember`.
Contratti in `app/Contracts`: `TeamContract`, `TeamInvitationContract`, `HasTeamsContract`, `HasTeamsAndUserContract`, `AddsTeamMembers`,
`CreatesTeams`, `DeletesTeams`, `InvitesTeamMembers`, `RemovesTeamMembers`, `UpdatesTeamNames` (stile Jetstream, senza dipendere da Jetstream).

## Interfaccia

- Risorse Filament: `TeamResource`, `TeamUserResource`, `TeamInvitationResource`, `TeamPermissionResource`, `TenantResource`,
  `TenantUserResource`.
- Widget `Team\TeamChangeWidget` (menu utente: cambio del team corrente, vista `user::filament.widgets.team.change`; sostituisce il
  Livewire `Team\Change`).
- Pagine di tenancy: `Pages/Tenancy/{RegisterTeam,EditTeamProfile,RegisterTenant,EditTenantProfile}`.
- Comandi artisan: `user:team-create`, `user:tenant-create`, `user:tenant-list`, e i comandi di assegnazione `AssignTeamCommand`,
  `AssignTenantCommand`, `SetCurrentTeamCommand`.

## Tenant e isolamento

- `HasTenants` implementa `canAccessTenant()` (appartenenza via `tenants()`) e `getTenants(Panel)` per il tenancy di Filament.
- `Models\Scopes\TenantScope` limita le query al tenant corrente: quello Filament, altrimenti il primo tenant dell'utente autenticato
  (`Infrastructure\Tenant\AuthenticatedTenantKey`, memoizzato in `Context` per richiesta). **Senza utente autenticato (console, code,
  guest) non filtra.** La colonna e' qualificata con il nome della tabella per evitare ambiguita' nelle join. `Support\AuthenticatedTenantKey`
  e' un duplicato `@deprecated` della versione in `Infrastructure`.
- Un utente con piu' tenant richiede una scelta esplicita del tenant corrente: oggi si prende il primo.

## Verifica

`tests/Feature/TeamManagement*Test.php`, `tests/Feature/TenantScopeConsoleTest.php`, `tests/Unit/HasTeamsTrait*Test.php`,
`tests/Unit/TenantTest.php`, `tests/Unit/CurrentTeamInfiniteLoopFixTest.php`.
