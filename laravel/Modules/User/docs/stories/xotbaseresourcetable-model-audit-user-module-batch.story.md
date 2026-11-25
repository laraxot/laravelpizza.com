---
title: "XotBaseResourceTable: audit $model + verifica colonne (batch modulo User)"
type: story
module: User
epic: null
story_id: null
slug: xotbaseresourcetable-model-audit-user-module-batch
status: done
cold_gate: null
created: '2026-09-11'
updated: '2026-09-11'
repository: "https://github.com/laraxot/module_user_fila5.git"
github_issue: 91
github_discussion: null
estimated_effort: "2h"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "laravel/Modules/User/app/Filament/Resources/ProfileResource/Tables/ProfilesTable.php"
  - "laravel/Modules/User/app/Filament/Resources/RoleResource/Tables/RolesTable.php"
  - "laravel/Modules/User/app/Filament/Resources/SocialiteUserResource/Tables/SocialiteUsersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/SocialProviderResource/Tables/SocialProvidersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/SsoProviderResource/Tables/SsoProvidersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamInvitationResource/Tables/TeamInvitationsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamPermissionResource/Tables/TeamPermissionsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamResource/Tables/TeamsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamUserResource/Tables/TeamUsersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TenantResource/Tables/CustomersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TenantResource/Tables/TenantsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TenantUserResource/Tables/TenantUsersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/UserResource/Tables/UsersTable.php"
related: []
qmd: "xotbaseresourcetable model audit user batch story"
---

# XotBaseResourceTable: audit $model + verifica colonne (batch modulo User)

## Story

Come manutentore, voglio che ogni `*Table extends XotBaseResourceTable` del
modulo User dichiari esplicitamente `protected static string $model` (preso
dalla Resource sorella, mai indovinato dal nome file) e che `getTableColumns()`
sia verificato contro lo schema reale, così da eliminare ambiguità già
osservate altrove nel repo (es. `ActivitysTable` vs `ActivitiesTable`) e
intercettare colonne fantasma prima che arrivino in produzione.

## Contesto / Baseline

I 13 file avevano già `protected static string $model` popolato da una
sessione precedente (working tree condivisa, modifiche non committate — vedi
`git status` all'apertura di questo turno). Ho verificato ogni valore contro
la Resource sorella (property `$model` o `getModel()`, mai il filename) e
confermato che sono tutti corretti, incluso il caso non ovvio di
`TenantResource` che risolve dinamicamente `XotData::getTenantClass()` →
`config('xot.tenant_class')` → in questo progetto `Modules\Quaeris\Models\Customer`
`config('xot.tenant_class')` → in questo progetto `Modules\<nome progetto>\Models\Customer`
