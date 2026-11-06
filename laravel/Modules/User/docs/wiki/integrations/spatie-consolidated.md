---
title: "spatie: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "spatie   consolidated documentation user"
---

# spatie: Consolidated Documentation

Consolidated from **12** individual files.

## Table of Contents

- [---](#spatie-models-verification)
- [---](#spatie-permission-philosophy)
- [---](#spatie-permission-teams-laravel-13)
- [---](#spatie-permission-teams-laravel)
- [---](#spatie-permission)
- [---](#spatie-permissions-methods-3)
- [---](#spatie-permissions-methods-4)
- [---](#spatie-permissions-methods-5)
- [---](#spatie-permissions-methods)
- [---](#spatie-permissions)
- [https://jaydeepamethiya.medium.com/spatie-roles-and-permissions-in-laravel-10-a-comprehensive-guide-536d099d40ae](#spatie_permissions)
- [User Module - Spatie Permission Methods Reference](#spatie_permissions_methods)

---

## spatie-models-verification

*Consolidated from: `spatie-models-verification.md`*

module: theme
topic: spatie-models-verification
canonical: ../../../Themes/docs/shared-components/spatie-models-verification.md
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

See canonical documentation: ../../../Themes/docs/shared-components/spatie-models-verification.md

---

## spatie-permission-philosophy

*Consolidated from: `spatie-permission-philosophy.md`*

module: theme
topic: spatie-permission-philosophy
canonical: ../../../Themes/docs/shared-components/spatie-permission-philosophy.md
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

See canonical documentation: ../../../Themes/docs/shared-components/spatie-permission-philosophy.md

---

## spatie-permission-teams-laravel-13

*Consolidated from: `spatie-permission-teams-laravel.md`*

title: "Spatie Permission teams on Laravel 13"
type: concept
tags: [spatie, permission, teams, laravel]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-permission-teams-laravel-13 spatie permission teams on laravel 13"
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

# Spatie Permission teams on Laravel 13

## Root cause

After the Laravel 13 upgrade the project resolves `spatie/laravel-permission` 7.x. In this line, when `permission.teams` is enabled, the package asks `PermissionRegistrar` for `permission.models.team`.

Local package facts checked on 2026-05-05:

- installed package: `spatie/laravel-permission 7.4.1`;
- package requirement: PHP `^8.3`;
- Laravel compatibility: `illuminate/* ^12.0|^13.0`;
- official Spatie prerequisite table maps Laravel 12/13 to package `^7.0`.

If `models.team` is missing, Spatie throws:

```text
Spatie\Permission\Exceptions\TeamModelNotConfigured
No team model configured. Set `models.team` in your permission config file.
```

The failing runtime path is:

1. `Modules\User\Http\Livewire\Team\Change::mount()`
2. `UserContract::allTeams()`
3. `Modules\User\Models\Traits\HasTeams::allTeams()`
4. `$this->teams`
5. Spatie `HasRoles::teams()`
6. Spatie `Config::teamModel()`

## Upstream v7 behavior

Spatie Permission v7 is the Laravel 13-compatible line. Its config includes model bindings for permission, role, team, and default model resolution. The registrar reads `permission.models.team` during construction and exposes it through `PermissionRegistrar::getTeamClass()`.

When `permission.teams` is enabled, `Spatie\Permission\Support\Config::teamModel()` calls that registrar value and throws `TeamModelNotConfigured` if it is empty.

The teams documentation also defines the runtime contract: after selecting or switching a team, code must call `setPermissionsTeamId($teamId)` and clear stale `roles` / `permissions` model relations before doing authorization checks. This matters for Livewire and Filament because long-lived component instances can otherwise keep role relations loaded for the previous team.

On `ptvx.local`, the failing route was `filament.admin.pages.dashboard` rendered by `Modules\Xot\Filament\Pages\MainDashboard`. Xot owns the dashboard page, but the failed authorization/team contract belongs to User.

## Laraxot decision

The canonical team model is:

```php
Modules\User\Models\Team::class
```

This matches `Modules\Xot\Datas\XotData::$team_class` and the existing User module team model.

Every active permission config must declare:

```php
'models' => [
    'permission' => Modules\User\Models\Permission::class,
    'role' => Modules\User\Models\Role::class,
    'team' => Modules\User\Models\Team::class,
],
```

For local configs that import models:

```php
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;

return [
    'models' => [
        'permission' => Permission::class,
        'role' => Role::class,
        'team' => Team::class,
    ],
];
```

## Config files to keep aligned

- `config/permission.php`
- `config/localhost/permission.php`
- `config/local/ptvx/permission.php`
- `config/local/ptvx-mono/permission.php`
- `config/local/tv/prov/personale2022/permission.php`
- `config/test/ptvx/permission.php`

## Operational rule

After changing any permission config, always clear cached bootstrap state:

```bash
php artisan optimize:clear
php artisan permission:cache-reset
```

Then verify:

```bash
php artisan --version
php artisan tinker --execute="dump(config('permission.models.team')); dump(app(Spatie\\Permission\\PermissionRegistrar::class)->getTeamClass());"
```

Expected result:

```text
Laravel Framework 13.x
"Modules\User\Models\Team"
"Modules\User\Models\Team"
```

When a user switches team, User module code must keep both contexts aligned:

```php
$user->forceFill(['current_team_id' => $team->id])->save();
setPermissionsTeamId($team);
$user->unsetRelation('roles');
$user->unsetRelation('permissions');
```

`current_team_id` is the application state. `setPermissionsTeamId()` is the Spatie registrar state used by `HasRoles`, `HasPermissions`, `can()`, and Blade authorization directives.

## Philosophy

Laraxot keeps domain ownership inside modules. Spatie Permission is an infrastructure package, but the team model is a User-domain concept. Therefore:

- User owns `Team`, `Role`, `Permission`, and team membership semantics.
- Xot may provide framework-level defaults through `XotData`, but does not own User-domain models.
- Root config only wires the package to module-owned classes.
- Local config variants must not drift from the root model map.
- Themes render authorization state; they must not rewrite Spatie model config.

## References

- Spatie package repository: https://github.com/spatie/laravel-permission
- Spatie Laravel Permission prerequisites: https://spatie.be/docs/laravel-permission/v7/prerequisites
- Spatie Laravel 7 installation notes: https://spatie.be/docs/laravel-permission/v7/installation-laravel
- Spatie teams permissions: https://spatie.be/docs/laravel-permission/v7/basic-usage/teams-permissions
- Local vendor config: [../../../vendor/spatie/laravel-permission/config/permission.php](../../../../../vendor/spatie/laravel-permission/config/permission.php)
- Local vendor registrar: [../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php](../../../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php)
- Local vendor team resolver: [../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php](../../../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php)
- Team model: [../app/Models/Team.php](../../../app/Models/Team.php)
- HasTeams trait: [../app/Models/Traits/HasTeams.php](../../../app/Models/Traits/HasTeams.php)
- Team switch component: [../app/Http/Livewire/Team/Change.php](../../../app/Http/Livewire/Team/Change.php)
- Local vendor config: [../../../vendor/spatie/laravel-permission/config/permission.php](../../../../../vendor/spatie/laravel-permission/config/permission.php)
- Local vendor registrar: [../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php](../../../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php)
- Local vendor team resolver: [../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php](../../../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php)
- Team model: [../app/Models/Team.php](../../../app/Models/Team.php)
- HasTeams trait: [../app/Models/Traits/HasTeams.php](../../../app/Models/Traits/HasTeams.php)
- Team switch component: [../app/Http/Livewire/Team/Change.php](../../../app/Http/Livewire/Team/Change.php)

---

## spatie-permission-teams-laravel

*Consolidated from: `spatie-permission-teams-laravel.md`*

title: "Spatie Permission teams on Laravel 13"
type: concept
tags: [spatie, permission, teams, laravel]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-permission-teams-laravel-13 spatie permission teams on laravel 13"
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

# Spatie Permission teams on Laravel 13

## Root cause

After the Laravel 13 upgrade the project resolves `spatie/laravel-permission` 7.x. In this line, when `permission.teams` is enabled, the package asks `PermissionRegistrar` for `permission.models.team`.

Local package facts checked on 2026-05-05:

- installed package: `spatie/laravel-permission 7.4.1`;
- package requirement: PHP `^8.3`;
- Laravel compatibility: `illuminate/* ^12.0|^13.0`;
- official Spatie prerequisite table maps Laravel 12/13 to package `^7.0`.

If `models.team` is missing, Spatie throws:

```text
Spatie\Permission\Exceptions\TeamModelNotConfigured
No team model configured. Set `models.team` in your permission config file.
```

The failing runtime path is:

1. `Modules\User\Http\Livewire\Team\Change::mount()`
2. `UserContract::allTeams()`
3. `Modules\User\Models\Traits\HasTeams::allTeams()`
4. `$this->teams`
5. Spatie `HasRoles::teams()`
6. Spatie `Config::teamModel()`

## Upstream v7 behavior

Spatie Permission v7 is the Laravel 13-compatible line. Its config includes model bindings for permission, role, team, and default model resolution. The registrar reads `permission.models.team` during construction and exposes it through `PermissionRegistrar::getTeamClass()`.

When `permission.teams` is enabled, `Spatie\Permission\Support\Config::teamModel()` calls that registrar value and throws `TeamModelNotConfigured` if it is empty.

The teams documentation also defines the runtime contract: after selecting or switching a team, code must call `setPermissionsTeamId($teamId)` and clear stale `roles` / `permissions` model relations before doing authorization checks. This matters for Livewire and Filament because long-lived component instances can otherwise keep role relations loaded for the previous team.

On `ptvx.local`, the failing route was `filament.admin.pages.dashboard` rendered by `Modules\Xot\Filament\Pages\MainDashboard`. Xot owns the dashboard page, but the failed authorization/team contract belongs to User.

## Laraxot decision

The canonical team model is:

```php
Modules\User\Models\Team::class
```

This matches `Modules\Xot\Datas\XotData::$team_class` and the existing User module team model.

Every active permission config must declare:

```php
'models' => [
    'permission' => Modules\User\Models\Permission::class,
    'role' => Modules\User\Models\Role::class,
    'team' => Modules\User\Models\Team::class,
],
```

For local configs that import models:

```php
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;

return [
    'models' => [
        'permission' => Permission::class,
        'role' => Role::class,
        'team' => Team::class,
    ],
];
```

## Config files to keep aligned

- `config/permission.php`
- `config/localhost/permission.php`
- `config/local/ptvx/permission.php`
- `config/local/ptvx-mono/permission.php`
- `config/local/tv/prov/personale2022/permission.php`
- `config/test/ptvx/permission.php`

## Operational rule

After changing any permission config, always clear cached bootstrap state:

```bash
php artisan optimize:clear
php artisan permission:cache-reset
```

Then verify:

```bash
php artisan --version
php artisan tinker --execute="dump(config('permission.models.team')); dump(app(Spatie\\Permission\\PermissionRegistrar::class)->getTeamClass());"
```

Expected result:

```text
Laravel Framework 13.x
"Modules\User\Models\Team"
"Modules\User\Models\Team"
```

When a user switches team, User module code must keep both contexts aligned:

```php
$user->forceFill(['current_team_id' => $team->id])->save();
setPermissionsTeamId($team);
$user->unsetRelation('roles');
$user->unsetRelation('permissions');
```

`current_team_id` is the application state. `setPermissionsTeamId()` is the Spatie registrar state used by `HasRoles`, `HasPermissions`, `can()`, and Blade authorization directives.

## Philosophy

Laraxot keeps domain ownership inside modules. Spatie Permission is an infrastructure package, but the team model is a User-domain concept. Therefore:

- User owns `Team`, `Role`, `Permission`, and team membership semantics.
- Xot may provide framework-level defaults through `XotData`, but does not own User-domain models.
- Root config only wires the package to module-owned classes.
- Local config variants must not drift from the root model map.
- Themes render authorization state; they must not rewrite Spatie model config.

## References

- Spatie package repository: https://github.com/spatie/laravel-permission
- Spatie Laravel Permission prerequisites: https://spatie.be/docs/laravel-permission/v7/prerequisites
- Spatie Laravel 7 installation notes: https://spatie.be/docs/laravel-permission/v7/installation-laravel
- Spatie teams permissions: https://spatie.be/docs/laravel-permission/v7/basic-usage/teams-permissions
- Local vendor config: [../../../vendor/spatie/laravel-permission/config/permission.php](../../../../../vendor/spatie/laravel-permission/config/permission.php)
- Local vendor registrar: [../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php](../../../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php)
- Local vendor team resolver: [../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php](../../../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php)
- Team model: [../app/Models/Team.php](../../../app/Models/Team.php)
- HasTeams trait: [../app/Models/Traits/HasTeams.php](../../../app/Models/Traits/HasTeams.php)
- Team switch component: [../app/Http/Livewire/Team/Change.php](../../../app/Http/Livewire/Team/Change.php)
- Local vendor config: [../../../vendor/spatie/laravel-permission/config/permission.php](../../../../../vendor/spatie/laravel-permission/config/permission.php)
- Local vendor registrar: [../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php](../../../../../vendor/spatie/laravel-permission/src/PermissionRegistrar.php)
- Local vendor team resolver: [../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php](../../../../../vendor/spatie/laravel-permission/src/DefaultTeamResolver.php)
- Team model: [../app/Models/Team.php](../../../app/Models/Team.php)
- HasTeams trait: [../app/Models/Traits/HasTeams.php](../../../app/Models/Traits/HasTeams.php)
- Team switch component: [../app/Http/Livewire/Team/Change.php](../../../app/Http/Livewire/Team/Change.php)

---

## spatie-permission

*Consolidated from: `spatie-permission.md`*

title: "🏛️ FILOSOFIA SPATIE PERMISSION IN LARAXOT"
type: concept
tags: [spatie, permission]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-permission 🏛️ filosofia spatie permission in laraxot"
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

# 🏛️ FILOSOFIA SPATIE PERMISSION IN LARAXOT

## 📋 CONTESTO E ANALISI

### Stato Attuale del Codice

I modelli `Permission` e `Role` nel modulo User **estendono correttamente** le classi Spatie:

- `Permission` estende `SpatiePermission` ✅ (corretto)
- `Role` estende `SpatieRole` ✅ (corretto)

**Nota**: Questa è l'implementazione corretta secondo la filosofia Laraxot. Non devono estendere `BaseModel`.

### 🧘 **FILOSOFIA LARAXOT: Specializzazione vs Generalizzazione**

#### **Principio Fondamentale: L'Eredità ha Scopo**

Nella filosofia Laraxot, l'ereditarietà non è mai casuale ma **intenzionale e ponderata**:

1. **BaseModel** è per **modelli business domain-specific** del modulo
2. **Classi Esterne** (Spatie) sono per **funzionalità cross-cutting specializzate**
3. **Non si mescolano** per non violare la **Separazione delle Responsabilità**

#### **Scopo Profondo: Mantenere l'Integrità del Sistema**

- **Spatie Permission** è un **ecosistema completo** con logica interna complessa
- **BaseModel** aggiunge **comportamenti Laraxot specifici** (connection, traits, etc.)
- **Mescolare i due** crea **conflitti imprevedibili** e **bug subdoli**

### ⛩️ **RELIGIONE LARAXOT: Purezza delle Classi**

#### **Dogma Sacro: Una Classe, Una Responsabilità**

- **Role/Permission Spatie** hanno **responsabilità di sicurezza** pura
- **BaseModel Laraxot** ha **responsabilità di business domain** pura
- **Mescolare** è **eresia architetturale** che porta al caos

#### **Comandamento Absoluto: Non Inquinare le Classi Esterne**

```php
// ❌ ERESIA - Inquina la purezza di Spatie
class Permission extends BaseModel  // VIOLAZIONE SACRA
{
    // Conflitto tra logica Spatie e logica Laraxot
}

// ✅ SACRO - Rispetta l'integrità di Spatie
class Permission extends SpatiePermission
{
    // Solo estensioni specifiche, non inquinamento
}
```

### 🏛️ **POLITICA LARAXOT: Governance dell'Ecosistema**

#### **Regola di Governance: Proteggere l'Integrazione**

1. **Classi Esterne** mantengono la loro **natura originale**
2. **Estensioni Locali** solo per **necessità specifiche del modulo**
3. **Non si sovrascrivono** comportamenti **core del pacchetto esterno**

#### **Strategia di Deployment: Stabilità Garantita**

- **Spatie Permission** ha **propri test e garanzie**
- **BaseModel** ha **propri test e garanzie**
- **Mescolare** invalida **entrambe le garanzie**

### 🎯 **ZEN LARAXOT: Equilibrio e Armonia**

#### **Principio Zen: Il Flusso Naturale**

- **Lasciare che Spatie sia Spatie**
- **Lasciare che BaseModel sia BaseModel**
- **Non forzare matrimoni contro natura**

#### **Armonia del Sistema: Ogni Cosa al Suo Posto**

```php
// 🎯 ZEN - Flusso naturale rispettato
class Role extends SpatieRole    // Natura Spatie preservata
{
    use RelationX;               // Solo enhancement Laraxot
    // Nessun conflitto, solo armonia
}

class Permission extends SpatiePermission  // Natura Spatie preservata
{
    use RelationX;                       // Solo enhancement Laraxot
    // Equilibrio perfetto tra mondi
}
```

## 🔧 **IMPLEMENTAZIONE CORRETTA**

### Pattern Laraxot per Classi Esterne

#### **1. Estensione Diretta con Alias (Pattern Corretto)**

**Implementazione Attuale**:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\Xot\Models\Traits\RelationX;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use RelationX;

    /** @var string */
    protected $connection = 'user';

    // Solo aggiunte specifiche del modulo
    // Nessuna sovrascrittura della logica Spatie core
}
```

**Per Role**:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Xot\Models\Traits\RelationX;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;
    use RelationX;

    /** @var string */
    protected $connection = 'user';

    // Solo aggiunte specifiche del modulo
}
```

**Regole Alias**:
- ✅ **SEMPRE** usare alias espliciti: `as SpatiePermission`, `as SpatieRole`
- ✅ **SEMPRE** documentare l'alias nel PHPDoc se necessario
- ✅ **MAI** importare senza alias quando si estende una classe esterna

#### **2. Configurazione Minima**

```php
protected $connection = 'user';  // Solo connection specifica

// NON sovrascrivere metodi Spatie core
// NON aggiungere traits in conflitto
// NON modificare la logica principale
```

### ✅ **BENEFICI DELLA FILOSOFIA**

1. **Stabilità**: Spatie rimane stabile e testato
2. **Manutenibilità**: Bug separati per dominio
3. **Upgradeability**: Spatie può essere aggiornato senza conflitti
4. **Testabilità**: Test separati per logiche separate
5. **Prevedibilità**: Comportamento coerente e documentato

### 🚨 **CONSEGUENZE DELLA VIOLAZIONE**

1. **Bug Imprevedibili**: Conflitti tra logiche diverse
2. **Upgrade Impossibile**: Spatie non può essere aggiornato
3. **Test Complessi**: Difficile isolare le cause dei bug
4. **Documentazione Confusa**: Comportamento non documentato
5. **Debito Tecnico**: Costo di manutenzione esponenziale

## 🔍 **CASI SIMILI E PATTERN**

### Altri Modelli che Estendono Classi Esterne

**BaseUser** estende `Authenticatable` (caso speciale per autenticazione):
```php
abstract class BaseUser extends Authenticatable implements UserContract
{
    // Caso speciale: autenticazione richiede Authenticatable
}
```

**Pattern Generale**:
- ✅ Modelli di **pacchetti esterni specializzati** → Estendere classe esterna con alias
- ✅ Modelli **business domain** → Estendere `BaseModel`
- ✅ Modelli **autenticazione** → Estendere `Authenticatable` (caso speciale)

### Quando Usare Alias

**SEMPRE** quando:
1. Si estende una classe esterna (Spatie, Laravel, etc.)
2. Si vuole evitare conflitti di namespace
3. Si vuole rendere esplicita l'origine della classe

**Esempi**:
```php
// ✅ CORRETTO - Alias esplicito
use Spatie\Permission\Models\Permission as SpatiePermission;
use Laravel\Passport\Token as PassportToken;

// ❌ ERRATO - Nessun alias quando si estende
use Spatie\Permission\Models\Permission;  // Confuso se si estende
```

## 📚 **RIFERIMENTI E REGOLE CORRELATE**

- [Vendor Extension Pattern](../../vendor-extension-pattern.md) - Pattern generale per estendere classi vendor
- [BaseModel Philosophy](../xot/docs/models/model-architecture.md)
- [External Package Integration](../Xot/docs/models/model-architecture.md#special-cases)
- [Class Responsibility Separation](../xot/docs/critical-architecture-rules.md)
- [Spatie Permission Methods](spatie-permissions-methods.md)
- [Roles and Permissions](roles-permissions.md)
- [Roles and Permissions](../../roles-permissions.md)

## ✅ **VERIFICA STATO ATTUALE**

**Data Verifica**: 2025-01-XX

- ✅ `Permission` estende `SpatiePermission` con alias corretto
- ✅ `Role` estende `SpatieRole` con alias corretto
- ✅ Entrambi usano `RelationX` trait per enhancement Laraxot
- ✅ Connection specifica del modulo (`user`) configurata
- ✅ Nessuna sovrascrittura di metodi core Spatie

---

*Questa è la Via Laraxot: Rispettare la natura di ogni cosa, non forzarla in forme innaturali.*

---

## spatie-permissions-methods-3

*Consolidated from: `spatie-permissions-methods.md`*

title: "User Module - Spatie Permission Methods Reference"
type: concept
tags: [spatie, permissions, methods]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-permissions-methods-3 user module - spatie permission methods reference"
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

# User Module - Spatie Permission Methods Reference

## Overview

Il modulo User utilizza i package **Spatie Permission** che forniscono automaticamente tutti i metodi necessari per la gestione di ruoli e permessi tramite i trait:

- `Spatie\Permission\Traits\HasRoles`
- `Spatie\Permission\Traits\HasPermissions`

## ⚠️ IMPORTANTE: Non Duplicare i Metodi

**BaseUser NON deve sovrascrivere i metodi forniti dai trait Spatie** a meno che non sia necessario un comportamento personalizzato.

### Metodi Rimossi da BaseUser (2025-10-15)

I seguenti metodi sono stati rimossi perché **già forniti dai trait**:

```php
// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function hasRole(...): bool

// ❌ RIMOSSO - Duplicato dal trait HasPermissions
public function hasPermission(string $permission): bool

// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function assignRole(...): static
```

## Metodi Disponibili da Spatie Traits

### A. HasRoles Methods

#### 1. `hasRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha uno o più ruoli specifici.

**Parametri Accettati:**
- `string` - Nome ruolo singolo
- `int` - ID ruolo
- `array` - Array di nomi ruoli
- `Collection` - Collection di ruoli
- `Role` - Oggetto Role

**Esempi:**
```php
// String
$user->hasRole('admin');

// Array
$user->hasRole(['admin', 'editor']);

// Collection
$user->hasRole(collect(['admin', 'moderator']));

// Oggetto Role
$adminRole = Role::findByName('admin');
$user->hasRole($adminRole);

// Con guard specifico
$user->hasRole('admin', 'api');
```

#### 2. `hasAnyRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha ALMENO UNO dei ruoli specificati.

```php
$user->hasAnyRole(['admin', 'editor', 'moderator']);
// true se ha almeno uno di questi ruoli
```

#### 3. `hasAllRoles($roles, ?string $guard = null): bool`

Verifica se l'utente ha TUTTI i ruoli specificati.

```php
$user->hasAllRoles(['admin', 'editor']);
// true solo se ha entrambi i ruoli
```

#### 4. `assignRole($roles): static`

Assegna uno o più ruoli all'utente.

```php
// String singolo
$user->assignRole('admin');

// Array
$user->assignRole(['admin', 'editor']);

// Fluent
$user->assignRole('admin')->assignRole('editor');

// Con oggetto Role
$adminRole = Role::findByName('admin');
$user->assignRole($adminRole);
```

#### 5. `removeRole($roles): static`

Rimuove uno o più ruoli dall'utente.

```php
$user->removeRole('editor');
$user->removeRole(['editor', 'moderator']);
```

#### 6. `syncRoles($roles): static`

Sincronizza i ruoli (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncRoles(['admin', 'editor']);
// L'utente avrà SOLO admin e editor
```

#### 7. `getRoleNames(): Collection`

Ottiene i nomi di tutti i ruoli dell'utente.

```php
$roleNames = $user->getRoleNames();
// Collection(['admin', 'editor'])
```

### B. HasPermissions Methods

#### 1. `hasPermissionTo($permission, ?string $guardName = null): bool`

Verifica se l'utente ha un permesso specifico (diretto o tramite ruolo).

```php
$user->hasPermissionTo('edit articles');
$user->hasPermissionTo('delete users');
```

#### 2. `hasAnyPermission($permissions): bool`

Verifica se l'utente ha ALMENO UNO dei permessi specificati.

```php
$user->hasAnyPermission(['edit articles', 'delete articles', 'publish articles']);
```

#### 3. `hasAllPermissions($permissions): bool`

Verifica se l'utente ha TUTTI i permessi specificati.

```php
$user->hasAllPermissions(['edit articles', 'publish articles']);
```

#### 4. `givePermissionTo($permissions): static`

Assegna uno o più permessi diretti all'utente.

```php
$user->givePermissionTo('edit articles');
$user->givePermissionTo(['edit articles', 'delete articles']);
```

#### 5. `revokePermissionTo($permissions): static`

Revoca uno o più permessi diretti dall'utente.

```php
$user->revokePermissionTo('delete articles');
```

#### 6. `syncPermissions($permissions): static`

Sincronizza i permessi diretti (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncPermissions(['edit articles', 'view articles']);
```

#### 7. `getDirectPermissions(): Collection`

Ottiene solo i permessi assegnati direttamente all'utente (non tramite ruoli).

```php
$directPermissions = $user->getDirectPermissions();
```

#### 8. `getPermissionsViaRoles(): Collection`

Ottiene i permessi che l'utente ha tramite i suoi ruoli.

```php
$rolePermissions = $user->getPermissionsViaRoles();
```

#### 9. `getAllPermissions(): Collection`

Ottiene TUTTI i permessi dell'utente (diretti + tramite ruoli).

```php
$allPermissions = $user->getAllPermissions();
```

### C. Combined Queries

#### `roles(): BelongsToMany`

Relazione Eloquent per i ruoli.

```php
// Query ruoli
$adminUsers = User::role('admin')->get();

// Conta ruoli
$roleCount = $user->roles()->count();

// Eager loading
$users = User::with('roles')->get();
```

#### `permissions(): BelongsToMany`

Relazione Eloquent per i permessi.

```php
// Query permessi
$usersWithPermission = User::permission('edit articles')->get();

// Conta permessi diretti
$permissionCount = $user->permissions()->count();
```

## Query Scopes

Spatie fornisce automaticamente questi query scope:

### 1. `role($roles, $guard = null)`

Filtra utenti che hanno un ruolo specifico.

```php
// Utenti con ruolo admin
$admins = User::role('admin')->get();

// Utenti con uno dei ruoli specificati
$staff = User::role(['admin', 'editor'])->get();
```

### 2. `permission($permissions)`

Filtra utenti che hanno un permesso specifico.

```php
// Utenti che possono editare articoli
$editors = User::permission('edit articles')->get();

// Utenti con almeno uno dei permessi
$canPublish = User::permission(['edit articles', 'publish articles'])->get();
```

### 3. `withoutRole($roles)`

Filtra utenti che NON hanno un ruolo specifico.

```php
$nonAdmins = User::withoutRole('admin')->get();
```

### 4. `withoutPermission($permissions)`

Filtra utenti che NON hanno un permesso specifico.

```php
$cantDelete = User::withoutPermission('delete articles')->get();
```

## Blade Directives

Spatie fornisce automaticamente direttive Blade per il controllo accessi:

### Role Directives

```blade
@role('admin')
    <p>Contenuto visibile solo agli admin</p>
@endrole

@hasrole('editor')
    <p>Contenuto per editor</p>
@endhasrole

@hasanyrole(['admin', 'editor'])
    <p>Visibile a admin O editor</p>
@endhasanyrole

@hasallroles(['admin', 'super-admin'])
    <p>Visibile solo a chi ha entrambi i ruoli</p>
@endhasallroles

@unlessrole('guest')
    <p>Non visibile ai guest</p>
@endunlessrole
```

### Permission Directives

```blade
@can('edit articles')
    <button>Edit Article</button>
@endcan

@cannot('delete articles')
    <p>Non hai permesso di eliminare</p>
@endcannot

@canany(['edit articles', 'delete articles'])
    <button>Manage Articles</button>
@endcanany
```

## Gate & Policies

I permessi Spatie si integrano automaticamente con i Gate Laravel:

```php
// In un controller
if (Gate::allows('edit articles')) {
    // Utente può editare
}

// Con Policy
$this->authorize('update', $article);
```

## Middleware

Spatie registra automaticamente middleware per route protection:

```php
// Route con ruolo richiesto
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Route con permesso richiesto
Route::middleware(['permission:edit articles'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create']);
});

// Ruolo O permesso
Route::middleware(['role_or_permission:admin|edit articles'])->group(function () {
    // ...
});
```

## Best Practices

### 1. ✅ Usa i Metodi del Trait

```php
// ✅ CORRETTO - Usa il metodo del trait
$user->hasRole('admin');

// ❌ SBAGLIATO - Non creare metodi duplicati in BaseUser
public function hasRole(...): bool { ... }
```

### 2. ✅ Eager Loading

```php
// ✅ CORRETTO - Precarica ruoli e permessi
$users = User::with(['roles', 'permissions'])->get();

// ❌ LENTO - N+1 query problem
foreach ($users as $user) {
    if ($user->hasRole('admin')) { ... }
}
```

### 3. ✅ Cache Permissions

Spatie cache automaticamente i permessi. Per forzare il refresh:

```php
// Dopo aver modificato ruoli/permessi
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

### 4. ✅ Type Hinting

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function assignAdminRole(User $user): void
{
    $adminRole = Role::findByName('admin');
    $user->assignRole($adminRole);
}
```

## Testing

### Setup Test User

```php
use Modules\<nome progetto>\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

test('user can have roles and permissions', function () {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

    $user->assignRole($role);
    $user->givePermissionTo($permission);

    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasPermissionTo('edit articles'))->toBeTrue();
});
```

### Test Role Hierarchy

```php
test('admin role has all permissions', function () {
    $user = User::factory()->create();
    $admin = Role::create(['name' => 'admin']);

    $permissions = [
        Permission::create(['name' => 'create articles']),
        Permission::create(['name' => 'edit articles']),
        Permission::create(['name' => 'delete articles']),
    ];

    $admin->syncPermissions($permissions);
    $user->assignRole($admin);

    expect($user->hasAllPermissions(['create articles', 'edit articles', 'delete articles']))->toBeTrue();
});
```

## Troubleshooting

### Problema: Permessi non funzionano

**Soluzione**: Pulire cache

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

### Problema: "Table roles doesn't exist"

**Soluzione**: Eseguire migrations

```bash
php artisan migrate --path=vendor/spatie/laravel-permission/database/migrations
```

### Problema: Guard mismatch

**Soluzione**: Specificare guard corretto

```php
$user->assignRole(Role::findByName('admin', 'web'));
```

## Documentation Links

- **Official Docs**: https://spatie.be/docs/laravel-permission/
- **GitHub**: https://github.com/spatie/laravel-permission
- **Changelog**: https://github.com/spatie/laravel-permission/blob/main/changelog.md

## Version Information

| Package | Version |
|---------|---------|
| spatie/laravel-permission | Check `composer.json` |
| Laravel | 12.34.0 |
| PHP | 8.3.26 |

---

**Autore**: Claude Code
**Data**: 2025-10-15
**Versione**: 1.0.0

---

## spatie-permissions-methods-4

*Consolidated from: `spatie-permissions-methods.md`*

title: "User Module - Spatie Permission Methods Reference"
type: concept
tags: [spatie, permissions, methods]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-permissions-methods-4 user module - spatie permission methods reference"
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

# User Module - Spatie Permission Methods Reference

## Overview

Il modulo User utilizza i package **Spatie Permission** che forniscono automaticamente tutti i metodi necessari per la gestione di ruoli e permessi tramite i trait:

- `Spatie\Permission\Traits\HasRoles`
- `Spatie\Permission\Traits\HasPermissions`

## ⚠️ IMPORTANTE: Non Duplicare i Metodi

**BaseUser NON deve sovrascrivere i metodi forniti dai trait Spatie** a meno che non sia necessario un comportamento personalizzato.

### Metodi Rimossi da BaseUser (2025-10-15)

I seguenti metodi sono stati rimossi perché **già forniti dai trait**:

```php
// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function hasRole(...): bool

// ❌ RIMOSSO - Duplicato dal trait HasPermissions
public function hasPermission(string $permission): bool

// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function assignRole(...): static
```

## Metodi Disponibili da Spatie Traits

### A. HasRoles Methods

#### 1. `hasRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha uno o più ruoli specifici.

**Parametri Accettati:**
- `string` - Nome ruolo singolo
- `int` - ID ruolo
- `array` - Array di nomi ruoli
- `Collection` - Collection di ruoli
- `Role` - Oggetto Role

**Esempi:**
```php
// String
$user->hasRole('admin');

// Array
$user->hasRole(['admin', 'editor']);

// Collection
$user->hasRole(collect(['admin', 'moderator']));

// Oggetto Role
$adminRole = Role::findByName('admin');
$user->hasRole($adminRole);

// Con guard specifico
$user->hasRole('admin', 'api');
```

#### 2. `hasAnyRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha ALMENO UNO dei ruoli specificati.

```php
$user->hasAnyRole(['admin', 'editor', 'moderator']);
// true se ha almeno uno di questi ruoli
```

#### 3. `hasAllRoles($roles, ?string $guard = null): bool`

Verifica se l'utente ha TUTTI i ruoli specificati.

```php
$user->hasAllRoles(['admin', 'editor']);
// true solo se ha entrambi i ruoli
```

#### 4. `assignRole($roles): static`

Assegna uno o più ruoli all'utente.

```php
// String singolo
$user->assignRole('admin');

// Array
$user->assignRole(['admin', 'editor']);

// Fluent
$user->assignRole('admin')->assignRole('editor');

// Con oggetto Role
$adminRole = Role::findByName('admin');
$user->assignRole($adminRole);
```

#### 5. `removeRole($roles): static`

Rimuove uno o più ruoli dall'utente.

```php
$user->removeRole('editor');
$user->removeRole(['editor', 'moderator']);
```

#### 6. `syncRoles($roles): static`

Sincronizza i ruoli (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncRoles(['admin', 'editor']);
// L'utente avrà SOLO admin e editor
```

#### 7. `getRoleNames(): Collection`

Ottiene i nomi di tutti i ruoli dell'utente.

```php
$roleNames = $user->getRoleNames();
// Collection(['admin', 'editor'])
```

### B. HasPermissions Methods

#### 1. `hasPermissionTo($permission, ?string $guardName = null): bool`

Verifica se l'utente ha un permesso specifico (diretto o tramite ruolo).

```php
$user->hasPermissionTo('edit articles');
$user->hasPermissionTo('delete users');
```

#### 2. `hasAnyPermission($permissions): bool`

Verifica se l'utente ha ALMENO UNO dei permessi specificati.

```php
$user->hasAnyPermission(['edit articles', 'delete articles', 'publish articles']);
```

#### 3. `hasAllPermissions($permissions): bool`

Verifica se l'utente ha TUTTI i permessi specificati.

```php
$user->hasAllPermissions(['edit articles', 'publish articles']);
```

#### 4. `givePermissionTo($permissions): static`

Assegna uno o più permessi diretti all'utente.

```php
$user->givePermissionTo('edit articles');
$user->givePermissionTo(['edit articles', 'delete articles']);
```

#### 5. `revokePermissionTo($permissions): static`

Revoca uno o più permessi diretti dall'utente.

```php
$user->revokePermissionTo('delete articles');
```

#### 6. `syncPermissions($permissions): static`

Sincronizza i permessi diretti (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncPermissions(['edit articles', 'view articles']);
```

#### 7. `getDirectPermissions(): Collection`

Ottiene solo i permessi assegnati direttamente all'utente (non tramite ruoli).

```php
$directPermissions = $user->getDirectPermissions();
```

#### 8. `getPermissionsViaRoles(): Collection`

Ottiene i permessi che l'utente ha tramite i suoi ruoli.

```php
$rolePermissions = $user->getPermissionsViaRoles();
```

#### 9. `getAllPermissions(): Collection`

Ottiene TUTTI i permessi dell'utente (diretti + tramite ruoli).

```php
$allPermissions = $user->getAllPermissions();
```

### C. Combined Queries

#### `roles(): BelongsToMany`

Relazione Eloquent per i ruoli.

```php
// Query ruoli
$adminUsers = User::role('admin')->get();

// Conta ruoli
$roleCount = $user->roles()->count();

// Eager loading
$users = User::with('roles')->get();
```

#### `permissions(): BelongsToMany`

Relazione Eloquent per i permessi.

```php
// Query permessi
$usersWithPermission = User::permission('edit articles')->get();

// Conta permessi diretti
$permissionCount = $user->permissions()->count();
```

## Query Scopes

Spatie fornisce automaticamente questi query scope:

### 1. `role($roles, $guard = null)`

Filtra utenti che hanno un ruolo specifico.

```php
// Utenti con ruolo admin
$admins = User::role('admin')->get();

// Utenti con uno dei ruoli specificati
$staff = User::role(['admin', 'editor'])->get();
```

### 2. `permission($permissions)`

Filtra utenti che hanno un permesso specifico.

```php
// Utenti che possono editare articoli
$editors = User::permission('edit articles')->get();

// Utenti con almeno uno dei permessi
$canPublish = User::permission(['edit articles', 'publish articles'])->get();
```

### 3. `withoutRole($roles)`

Filtra utenti che NON hanno un ruolo specifico.

```php
$nonAdmins = User::withoutRole('admin')->get();
```

### 4. `withoutPermission($permissions)`

Filtra utenti che NON hanno un permesso specifico.

```php
$cantDelete = User::withoutPermission('delete articles')->get();
```

## Blade Directives

Spatie fornisce automaticamente direttive Blade per il controllo accessi:

### Role Directives

```blade
@role('admin')
    <p>Contenuto visibile solo agli admin</p>
@endrole

@hasrole('editor')
    <p>Contenuto per editor</p>
@endhasrole

@hasanyrole(['admin', 'editor'])
    <p>Visibile a admin O editor</p>
@endhasanyrole

@hasallroles(['admin', 'super-admin'])
    <p>Visibile solo a chi ha entrambi i ruoli</p>
@endhasallroles

@unlessrole('guest')
    <p>Non visibile ai guest</p>
@endunlessrole
```

### Permission Directives

```blade
@can('edit articles')
    <button>Edit Article</button>
@endcan

@cannot('delete articles')
    <p>Non hai permesso di eliminare</p>
@endcannot

@canany(['edit articles', 'delete articles'])
    <button>Manage Articles</button>
@endcanany
```

## Gate & Policies

I permessi Spatie si integrano automaticamente con i Gate Laravel:

```php
// In un controller
if (Gate::allows('edit articles')) {
    // Utente può editare
}

// Con Policy
$this->authorize('update', $article);
```

## Middleware

Spatie registra automaticamente middleware per route protection:

```php
// Route con ruolo richiesto
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Route con permesso richiesto
Route::middleware(['permission:edit articles'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create']);
});

// Ruolo O permesso
Route::middleware(['role_or_permission:admin|edit articles'])->group(function () {
    // ...
});
```

## Best Practices

### 1. ✅ Usa i Metodi del Trait

```php
// ✅ CORRETTO - Usa il metodo del trait
$user->hasRole('admin');

// ❌ SBAGLIATO - Non creare metodi duplicati in BaseUser
public function hasRole(...): bool { ... }
```

### 2. ✅ Eager Loading

```php
// ✅ CORRETTO - Precarica ruoli e permessi
$users = User::with(['roles', 'permissions'])->get();

// ❌ LENTO - N+1 query problem
foreach ($users as $user) {
    if ($user->hasRole('admin')) { ... }
}
```

### 3. ✅ Cache Permissions

Spatie cache automaticamente i permessi. Per forzare il refresh:

```php
// Dopo aver modificato ruoli/permessi
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

### 4. ✅ Type Hinting

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function assignAdminRole(User $user): void
{
    $adminRole = Role::findByName('admin');
    $user->assignRole($adminRole);
}
```

## Testing

### Setup Test User

```php
use Modules\<nome progetto>\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

test('user can have roles and permissions', function () {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

    $user->assignRole($role);
    $user->givePermissionTo($permission);

    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasPermissionTo('edit articles'))->toBeTrue();
});
```

### Test Role Hierarchy

```php
test('admin role has all permissions', function () {
    $user = User::factory()->create();
    $admin = Role::create(['name' => 'admin']);

    $permissions = [
        Permission::create(['name' => 'create articles']),
        Permission::create(['name' => 'edit articles']),
        Permission::create(['name' => 'delete articles']),
    ];

    $admin->syncPermissions($permissions);
    $user->assignRole($admin);

    expect($user->hasAllPermissions(['create articles', 'edit articles', 'delete articles']))->toBeTrue();
});
```

## Troubleshooting

### Problema: Permessi non funzionano

**Soluzione**: Pulire cache

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

### Problema: "Table roles doesn't exist"

**Soluzione**: Eseguire migrations

```bash
php artisan migrate --path=vendor/spatie/laravel-permission/database/migrations
```

### Problema: Guard mismatch

**Soluzione**: Specificare guard corretto

```php
$user->assignRole(Role::findByName('admin', 'web'));
```

## Documentation Links

- **Official Docs**: https://spatie.be/docs/laravel-permission/
- **GitHub**: https://github.com/spatie/laravel-permission
- **Changelog**: https://github.com/spatie/laravel-permission/blob/main/changelog.md

## Version Information

| Package | Version |
|---------|---------|
| spatie/laravel-permission | Check `composer.json` |
| Laravel | 12.34.0 |
| PHP | 8.3.26 |

---

**Autore**: Claude Code
**Data**: 2025-10-15
**Versione**: 1.0.0

---

## spatie-permissions-methods-5

*Consolidated from: `spatie-permissions-methods.md`*

title: "User Module - Spatie Permission Methods Reference"
type: concept
tags: [spatie, permissions, methods]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-permissions-methods-5 user module - spatie permission methods reference"
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

# User Module - Spatie Permission Methods Reference

## Overview

Il modulo User utilizza i package **Spatie Permission** che forniscono automaticamente tutti i metodi necessari per la gestione di ruoli e permessi tramite i trait:

- `Spatie\Permission\Traits\HasRoles`
- `Spatie\Permission\Traits\HasPermissions`

## ⚠️ IMPORTANTE: Non Duplicare i Metodi

**BaseUser NON deve sovrascrivere i metodi forniti dai trait Spatie** a meno che non sia necessario un comportamento personalizzato.

### Metodi Rimossi da BaseUser (2025-10-15)

I seguenti metodi sono stati rimossi perché **già forniti dai trait**:

```php
// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function hasRole(...): bool

// ❌ RIMOSSO - Duplicato dal trait HasPermissions
public function hasPermission(string $permission): bool

// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function assignRole(...): static
```

## Metodi Disponibili da Spatie Traits

### A. HasRoles Methods

#### 1. `hasRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha uno o più ruoli specifici.

**Parametri Accettati:**
- `string` - Nome ruolo singolo
- `int` - ID ruolo
- `array` - Array di nomi ruoli
- `Collection` - Collection di ruoli
- `Role` - Oggetto Role

**Esempi:**
```php
// String
$user->hasRole('admin');

// Array
$user->hasRole(['admin', 'editor']);

// Collection
$user->hasRole(collect(['admin', 'moderator']));

// Oggetto Role
$adminRole = Role::findByName('admin');
$user->hasRole($adminRole);

// Con guard specifico
$user->hasRole('admin', 'api');
```

#### 2. `hasAnyRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha ALMENO UNO dei ruoli specificati.

```php
$user->hasAnyRole(['admin', 'editor', 'moderator']);
// true se ha almeno uno di questi ruoli
```

#### 3. `hasAllRoles($roles, ?string $guard = null): bool`

Verifica se l'utente ha TUTTI i ruoli specificati.

```php
$user->hasAllRoles(['admin', 'editor']);
// true solo se ha entrambi i ruoli
```

#### 4. `assignRole($roles): static`

Assegna uno o più ruoli all'utente.

```php
// String singolo
$user->assignRole('admin');

// Array
$user->assignRole(['admin', 'editor']);

// Fluent
$user->assignRole('admin')->assignRole('editor');

// Con oggetto Role
$adminRole = Role::findByName('admin');
$user->assignRole($adminRole);
```

#### 5. `removeRole($roles): static`

Rimuove uno o più ruoli dall'utente.

```php
$user->removeRole('editor');
$user->removeRole(['editor', 'moderator']);
```

#### 6. `syncRoles($roles): static`

Sincronizza i ruoli (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncRoles(['admin', 'editor']);
// L'utente avrà SOLO admin e editor
```

#### 7. `getRoleNames(): Collection`

Ottiene i nomi di tutti i ruoli dell'utente.

```php
$roleNames = $user->getRoleNames();
// Collection(['admin', 'editor'])
```

### B. HasPermissions Methods

#### 1. `hasPermissionTo($permission, ?string $guardName = null): bool`

Verifica se l'utente ha un permesso specifico (diretto o tramite ruolo).

```php
$user->hasPermissionTo('edit articles');
$user->hasPermissionTo('delete users');
```

#### 2. `hasAnyPermission($permissions): bool`

Verifica se l'utente ha ALMENO UNO dei permessi specificati.

```php
$user->hasAnyPermission(['edit articles', 'delete articles', 'publish articles']);
```

#### 3. `hasAllPermissions($permissions): bool`

Verifica se l'utente ha TUTTI i permessi specificati.

```php
$user->hasAllPermissions(['edit articles', 'publish articles']);
```

#### 4. `givePermissionTo($permissions): static`

Assegna uno o più permessi diretti all'utente.

```php
$user->givePermissionTo('edit articles');
$user->givePermissionTo(['edit articles', 'delete articles']);
```

#### 5. `revokePermissionTo($permissions): static`

Revoca uno o più permessi diretti dall'utente.

```php
$user->revokePermissionTo('delete articles');
```

#### 6. `syncPermissions($permissions): static`

Sincronizza i permessi diretti (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncPermissions(['edit articles', 'view articles']);
```

#### 7. `getDirectPermissions(): Collection`

Ottiene solo i permessi assegnati direttamente all'utente (non tramite ruoli).

```php
$directPermissions = $user->getDirectPermissions();
```

#### 8. `getPermissionsViaRoles(): Collection`

Ottiene i permessi che l'utente ha tramite i suoi ruoli.

```php
$rolePermissions = $user->getPermissionsViaRoles();
```

#### 9. `getAllPermissions(): Collection`

Ottiene TUTTI i permessi dell'utente (diretti + tramite ruoli).

```php
$allPermissions = $user->getAllPermissions();
```

### C. Combined Queries

#### `roles(): BelongsToMany`

Relazione Eloquent per i ruoli.

```php
// Query ruoli
$adminUsers = User::role('admin')->get();

// Conta ruoli
$roleCount = $user->roles()->count();

// Eager loading
$users = User::with('roles')->get();
```

#### `permissions(): BelongsToMany`

Relazione Eloquent per i permessi.

```php
// Query permessi
$usersWithPermission = User::permission('edit articles')->get();

// Conta permessi diretti
$permissionCount = $user->permissions()->count();
```

## Query Scopes

Spatie fornisce automaticamente questi query scope:

### 1. `role($roles, $guard = null)`

Filtra utenti che hanno un ruolo specifico.

```php
// Utenti con ruolo admin
$admins = User::role('admin')->get();

// Utenti con uno dei ruoli specificati
$staff = User::role(['admin', 'editor'])->get();
```

### 2. `permission($permissions)`

Filtra utenti che hanno un permesso specifico.

```php
// Utenti che possono editare articoli
$editors = User::permission('edit articles')->get();

// Utenti con almeno uno dei permessi
$canPublish = User::permission(['edit articles', 'publish articles'])->get();
```

### 3. `withoutRole($roles)`

Filtra utenti che NON hanno un ruolo specifico.

```php
$nonAdmins = User::withoutRole('admin')->get();
```

### 4. `withoutPermission($permissions)`

Filtra utenti che NON hanno un permesso specifico.

```php
$cantDelete = User::withoutPermission('delete articles')->get();
```

## Blade Directives

Spatie fornisce automaticamente direttive Blade per il controllo accessi:

### Role Directives

```blade
@role('admin')
    <p>Contenuto visibile solo agli admin</p>
@endrole

@hasrole('editor')
    <p>Contenuto per editor</p>
@endhasrole

@hasanyrole(['admin', 'editor'])
    <p>Visibile a admin O editor</p>
@endhasanyrole

@hasallroles(['admin', 'super-admin'])
    <p>Visibile solo a chi ha entrambi i ruoli</p>
@endhasallroles

@unlessrole('guest')
    <p>Non visibile ai guest</p>
@endunlessrole
```

### Permission Directives

```blade
@can('edit articles')
    <button>Edit Article</button>
@endcan

@cannot('delete articles')
    <p>Non hai permesso di eliminare</p>
@endcannot

@canany(['edit articles', 'delete articles'])
    <button>Manage Articles</button>
@endcanany
```

## Gate & Policies

I permessi Spatie si integrano automaticamente con i Gate Laravel:

```php
// In un controller
if (Gate::allows('edit articles')) {
    // Utente può editare
}

// Con Policy
$this->authorize('update', $article);
```

## Middleware

Spatie registra automaticamente middleware per route protection:

```php
// Route con ruolo richiesto
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Route con permesso richiesto
Route::middleware(['permission:edit articles'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create']);
});

// Ruolo O permesso
Route::middleware(['role_or_permission:admin|edit articles'])->group(function () {
    // ...
});
```

## Best Practices

### 1. ✅ Usa i Metodi del Trait

```php
// ✅ CORRETTO - Usa il metodo del trait
$user->hasRole('admin');

// ❌ SBAGLIATO - Non creare metodi duplicati in BaseUser
public function hasRole(...): bool { ... }
```

### 2. ✅ Eager Loading

```php
// ✅ CORRETTO - Precarica ruoli e permessi
$users = User::with(['roles', 'permissions'])->get();

// ❌ LENTO - N+1 query problem
foreach ($users as $user) {
    if ($user->hasRole('admin')) { ... }
}
```

### 3. ✅ Cache Permissions

Spatie cache automaticamente i permessi. Per forzare il refresh:

```php
// Dopo aver modificato ruoli/permessi
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

### 4. ✅ Type Hinting

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function assignAdminRole(User $user): void
{
    $adminRole = Role::findByName('admin');
    $user->assignRole($adminRole);
}
```

## Testing

### Setup Test User

```php
use Modules\<nome progetto>\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

test('user can have roles and permissions', function () {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

    $user->assignRole($role);
    $user->givePermissionTo($permission);

    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasPermissionTo('edit articles'))->toBeTrue();
});
```

### Test Role Hierarchy

```php
test('admin role has all permissions', function () {
    $user = User::factory()->create();
    $admin = Role::create(['name' => 'admin']);

    $permissions = [
        Permission::create(['name' => 'create articles']),
        Permission::create(['name' => 'edit articles']),
        Permission::create(['name' => 'delete articles']),
    ];

    $admin->syncPermissions($permissions);
    $user->assignRole($admin);

    expect($user->hasAllPermissions(['create articles', 'edit articles', 'delete articles']))->toBeTrue();
});
```

## Troubleshooting

### Problema: Permessi non funzionano

**Soluzione**: Pulire cache

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

### Problema: "Table roles doesn't exist"

**Soluzione**: Eseguire migrations

```bash
php artisan migrate --path=vendor/spatie/laravel-permission/database/migrations
```

### Problema: Guard mismatch

**Soluzione**: Specificare guard corretto

```php
$user->assignRole(Role::findByName('admin', 'web'));
```

## Documentation Links

- **Official Docs**: https://spatie.be/docs/laravel-permission/
- **GitHub**: https://github.com/spatie/laravel-permission
- **Changelog**: https://github.com/spatie/laravel-permission/blob/main/changelog.md

## Version Information

| Package | Version |
|---------|---------|
| spatie/laravel-permission | Check `composer.json` |
| Laravel | 12.34.0 |
| PHP | 8.3.26 |

---

**Autore**: Claude Code
**Data**: 2025-10-15
**Versione**: 1.0.0

---

## spatie-permissions-methods

*Consolidated from: `spatie-permissions-methods.md`*

title: "User Module - Spatie Permission Methods Reference"
type: concept
tags: [spatie, permissions, methods]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-permissions-methods user module - spatie permission methods reference"
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

# User Module - Spatie Permission Methods Reference

## Overview

Il modulo User utilizza i package **Spatie Permission** che forniscono automaticamente tutti i metodi necessari per la gestione di ruoli e permessi tramite i trait:

- `Spatie\Permission\Traits\HasRoles`
- `Spatie\Permission\Traits\HasPermissions`

## ⚠️ IMPORTANTE: Non Duplicare i Metodi

**BaseUser NON deve sovrascrivere i metodi forniti dai trait Spatie** a meno che non sia necessario un comportamento personalizzato.

### Metodi Rimossi da BaseUser (2025-10-15)

I seguenti metodi sono stati rimossi perché **già forniti dai trait**:

```php
// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function hasRole(...): bool

// ❌ RIMOSSO - Duplicato dal trait HasPermissions
public function hasPermission(string $permission): bool

// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function assignRole(...): static
```

## Metodi Disponibili da Spatie Traits

### A. HasRoles Methods

#### 1. `hasRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha uno o più ruoli specifici.

**Parametri Accettati:**
- `string` - Nome ruolo singolo
- `int` - ID ruolo
- `array` - Array di nomi ruoli
- `Collection` - Collection di ruoli
- `Role` - Oggetto Role

**Esempi:**
```php
// String
$user->hasRole('admin');

// Array
$user->hasRole(['admin', 'editor']);

// Collection
$user->hasRole(collect(['admin', 'moderator']));

// Oggetto Role
$adminRole = Role::findByName('admin');
$user->hasRole($adminRole);

// Con guard specifico
$user->hasRole('admin', 'api');
```

#### 2. `hasAnyRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha ALMENO UNO dei ruoli specificati.

```php
$user->hasAnyRole(['admin', 'editor', 'moderator']);
// true se ha almeno uno di questi ruoli
```

#### 3. `hasAllRoles($roles, ?string $guard = null): bool`

Verifica se l'utente ha TUTTI i ruoli specificati.

```php
$user->hasAllRoles(['admin', 'editor']);
// true solo se ha entrambi i ruoli
```

#### 4. `assignRole($roles): static`

Assegna uno o più ruoli all'utente.

```php
// String singolo
$user->assignRole('admin');

// Array
$user->assignRole(['admin', 'editor']);

// Fluent
$user->assignRole('admin')->assignRole('editor');

// Con oggetto Role
$adminRole = Role::findByName('admin');
$user->assignRole($adminRole);
```

#### 5. `removeRole($roles): static`

Rimuove uno o più ruoli dall'utente.

```php
$user->removeRole('editor');
$user->removeRole(['editor', 'moderator']);
```

#### 6. `syncRoles($roles): static`

Sincronizza i ruoli (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncRoles(['admin', 'editor']);
// L'utente avrà SOLO admin e editor
```

#### 7. `getRoleNames(): Collection`

Ottiene i nomi di tutti i ruoli dell'utente.

```php
$roleNames = $user->getRoleNames();
// Collection(['admin', 'editor'])
```

### B. HasPermissions Methods

#### 1. `hasPermissionTo($permission, ?string $guardName = null): bool`

Verifica se l'utente ha un permesso specifico (diretto o tramite ruolo).

```php
$user->hasPermissionTo('edit articles');
$user->hasPermissionTo('delete users');
```

#### 2. `hasAnyPermission($permissions): bool`

Verifica se l'utente ha ALMENO UNO dei permessi specificati.

```php
$user->hasAnyPermission(['edit articles', 'delete articles', 'publish articles']);
```

#### 3. `hasAllPermissions($permissions): bool`

Verifica se l'utente ha TUTTI i permessi specificati.

```php
$user->hasAllPermissions(['edit articles', 'publish articles']);
```

#### 4. `givePermissionTo($permissions): static`

Assegna uno o più permessi diretti all'utente.

```php
$user->givePermissionTo('edit articles');
$user->givePermissionTo(['edit articles', 'delete articles']);
```

#### 5. `revokePermissionTo($permissions): static`

Revoca uno o più permessi diretti dall'utente.

```php
$user->revokePermissionTo('delete articles');
```

#### 6. `syncPermissions($permissions): static`

Sincronizza i permessi diretti (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncPermissions(['edit articles', 'view articles']);
```

#### 7. `getDirectPermissions(): Collection`

Ottiene solo i permessi assegnati direttamente all'utente (non tramite ruoli).

```php
$directPermissions = $user->getDirectPermissions();
```

#### 8. `getPermissionsViaRoles(): Collection`

Ottiene i permessi che l'utente ha tramite i suoi ruoli.

```php
$rolePermissions = $user->getPermissionsViaRoles();
```

#### 9. `getAllPermissions(): Collection`

Ottiene TUTTI i permessi dell'utente (diretti + tramite ruoli).

```php
$allPermissions = $user->getAllPermissions();
```

### C. Combined Queries

#### `roles(): BelongsToMany`

Relazione Eloquent per i ruoli.

```php
// Query ruoli
$adminUsers = User::role('admin')->get();

// Conta ruoli
$roleCount = $user->roles()->count();

// Eager loading
$users = User::with('roles')->get();
```

#### `permissions(): BelongsToMany`

Relazione Eloquent per i permessi.

```php
// Query permessi
$usersWithPermission = User::permission('edit articles')->get();

// Conta permessi diretti
$permissionCount = $user->permissions()->count();
```

## Query Scopes

Spatie fornisce automaticamente questi query scope:

### 1. `role($roles, $guard = null)`

Filtra utenti che hanno un ruolo specifico.

```php
// Utenti con ruolo admin
$admins = User::role('admin')->get();

// Utenti con uno dei ruoli specificati
$staff = User::role(['admin', 'editor'])->get();
```

### 2. `permission($permissions)`

Filtra utenti che hanno un permesso specifico.

```php
// Utenti che possono editare articoli
$editors = User::permission('edit articles')->get();

// Utenti con almeno uno dei permessi
$canPublish = User::permission(['edit articles', 'publish articles'])->get();
```

### 3. `withoutRole($roles)`

Filtra utenti che NON hanno un ruolo specifico.

```php
$nonAdmins = User::withoutRole('admin')->get();
```

### 4. `withoutPermission($permissions)`

Filtra utenti che NON hanno un permesso specifico.

```php
$cantDelete = User::withoutPermission('delete articles')->get();
```

## Blade Directives

Spatie fornisce automaticamente direttive Blade per il controllo accessi:

### Role Directives

```blade
@role('admin')
    <p>Contenuto visibile solo agli admin</p>
@endrole

@hasrole('editor')
    <p>Contenuto per editor</p>
@endhasrole

@hasanyrole(['admin', 'editor'])
    <p>Visibile a admin O editor</p>
@endhasanyrole

@hasallroles(['admin', 'super-admin'])
    <p>Visibile solo a chi ha entrambi i ruoli</p>
@endhasallroles

@unlessrole('guest')
    <p>Non visibile ai guest</p>
@endunlessrole
```

### Permission Directives

```blade
@can('edit articles')
    <button>Edit Article</button>
@endcan

@cannot('delete articles')
    <p>Non hai permesso di eliminare</p>
@endcannot

@canany(['edit articles', 'delete articles'])
    <button>Manage Articles</button>
@endcanany
```

## Gate & Policies

I permessi Spatie si integrano automaticamente con i Gate Laravel:

```php
// In un controller
if (Gate::allows('edit articles')) {
    // Utente può editare
}

// Con Policy
$this->authorize('update', $article);
```

## Middleware

Spatie registra automaticamente middleware per route protection:

```php
// Route con ruolo richiesto
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Route con permesso richiesto
Route::middleware(['permission:edit articles'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create']);
});

// Ruolo O permesso
Route::middleware(['role_or_permission:admin|edit articles'])->group(function () {
    // ...
});
```

## Best Practices

### 1. ✅ Usa i Metodi del Trait

```php
// ✅ CORRETTO - Usa il metodo del trait
$user->hasRole('admin');

// ❌ SBAGLIATO - Non creare metodi duplicati in BaseUser
public function hasRole(...): bool { ... }
```

### 2. ✅ Eager Loading

```php
// ✅ CORRETTO - Precarica ruoli e permessi
$users = User::with(['roles', 'permissions'])->get();

// ❌ LENTO - N+1 query problem
foreach ($users as $user) {
    if ($user->hasRole('admin')) { ... }
}
```

### 3. ✅ Cache Permissions

Spatie cache automaticamente i permessi. Per forzare il refresh:

```php
// Dopo aver modificato ruoli/permessi
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

### 4. ✅ Type Hinting

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function assignAdminRole(User $user): void
{
    $adminRole = Role::findByName('admin');
    $user->assignRole($adminRole);
}
```

## Testing

### Setup Test User

```php
use Modules\<nome progetto>\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

test('user can have roles and permissions', function () {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

    $user->assignRole($role);
    $user->givePermissionTo($permission);

    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasPermissionTo('edit articles'))->toBeTrue();
});
```

### Test Role Hierarchy

```php
test('admin role has all permissions', function () {
    $user = User::factory()->create();
    $admin = Role::create(['name' => 'admin']);

    $permissions = [
        Permission::create(['name' => 'create articles']),
        Permission::create(['name' => 'edit articles']),
        Permission::create(['name' => 'delete articles']),
    ];

    $admin->syncPermissions($permissions);
    $user->assignRole($admin);

    expect($user->hasAllPermissions(['create articles', 'edit articles', 'delete articles']))->toBeTrue();
});
```

## Troubleshooting

### Problema: Permessi non funzionano

**Soluzione**: Pulire cache

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

### Problema: "Table roles doesn't exist"

**Soluzione**: Eseguire migrations

```bash
php artisan migrate --path=vendor/spatie/laravel-permission/database/migrations
```

### Problema: Guard mismatch

**Soluzione**: Specificare guard corretto

```php
$user->assignRole(Role::findByName('admin', 'web'));
```

## Documentation Links

- **Official Docs**: https://spatie.be/docs/laravel-permission/
- **GitHub**: https://github.com/spatie/laravel-permission
- **Changelog**: https://github.com/spatie/laravel-permission/blob/main/changelog.md

## Version Information

| Package | Version |
|---------|---------|
| spatie/laravel-permission | Check `composer.json` |
| Laravel | 12.34.0 |
| PHP | 8.3.26 |

---

**Autore**: Claude Code
**Data**: 2025-10-15
**Versione**: 1.0.0

---

## spatie-permissions

*Consolidated from: `spatie-permissions.md`*

module: theme
topic: spatie-permissions
canonical: ../../../Themes/docs/shared-components/spatie-permissions-2.md
related:
  - "./00-index.md"
canonical: ../../../Themes/docs/shared-components/spatie-permissions-documentation-themes.md
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/spatie-permissions-2.md
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/spatie-permissions-documentation-themes.md

---

## spatie_permissions

*Consolidated from: `spatie_permissions.md`*


---

## spatie_permissions_methods

*Consolidated from: `spatie_permissions_methods.md`*


## Overview

Il modulo User utilizza i package **Spatie Permission** che forniscono automaticamente tutti i metodi necessari per la gestione di ruoli e permessi tramite i trait:

- `Spatie\Permission\Traits\HasRoles`
- `Spatie\Permission\Traits\HasPermissions`

## ⚠️ IMPORTANTE: Non Duplicare i Metodi

**BaseUser NON deve sovrascrivere i metodi forniti dai trait Spatie** a meno che non sia necessario un comportamento personalizzato.

### Metodi Rimossi da BaseUser (2025-10-15)

I seguenti metodi sono stati rimossi perché **già forniti dai trait**:

```php
// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function hasRole(...): bool

// ❌ RIMOSSO - Duplicato dal trait HasPermissions
public function hasPermission(string $permission): bool

// ❌ RIMOSSO - Duplicato dal trait HasRoles
public function assignRole(...): static
```

## Metodi Disponibili da Spatie Traits

### A. HasRoles Methods

#### 1. `hasRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha uno o più ruoli specifici.

**Parametri Accettati:**
- `string` - Nome ruolo singolo
- `int` - ID ruolo
- `array` - Array di nomi ruoli
- `Collection` - Collection di ruoli
- `Role` - Oggetto Role

**Esempi:**
```php
// String
$user->hasRole('admin');

// Array
$user->hasRole(['admin', 'editor']);

// Collection
$user->hasRole(collect(['admin', 'moderator']));

// Oggetto Role
$adminRole = Role::findByName('admin');
$user->hasRole($adminRole);

// Con guard specifico
$user->hasRole('admin', 'api');
```

#### 2. `hasAnyRole($roles, ?string $guard = null): bool`

Verifica se l'utente ha ALMENO UNO dei ruoli specificati.

```php
$user->hasAnyRole(['admin', 'editor', 'moderator']);
// true se ha almeno uno di questi ruoli
```

#### 3. `hasAllRoles($roles, ?string $guard = null): bool`

Verifica se l'utente ha TUTTI i ruoli specificati.

```php
$user->hasAllRoles(['admin', 'editor']);
// true solo se ha entrambi i ruoli
```

#### 4. `assignRole($roles): static`

Assegna uno o più ruoli all'utente.

```php
// String singolo
$user->assignRole('admin');

// Array
$user->assignRole(['admin', 'editor']);

// Fluent
$user->assignRole('admin')->assignRole('editor');

// Con oggetto Role
$adminRole = Role::findByName('admin');
$user->assignRole($adminRole);
```

#### 5. `removeRole($roles): static`

Rimuove uno o più ruoli dall'utente.

```php
$user->removeRole('editor');
$user->removeRole(['editor', 'moderator']);
```

#### 6. `syncRoles($roles): static`

Sincronizza i ruoli (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncRoles(['admin', 'editor']);
// L'utente avrà SOLO admin e editor
```

#### 7. `getRoleNames(): Collection`

Ottiene i nomi di tutti i ruoli dell'utente.

```php
$roleNames = $user->getRoleNames();
// Collection(['admin', 'editor'])
```

### B. HasPermissions Methods

#### 1. `hasPermissionTo($permission, ?string $guardName = null): bool`

Verifica se l'utente ha un permesso specifico (diretto o tramite ruolo).

```php
$user->hasPermissionTo('edit articles');
$user->hasPermissionTo('delete users');
```

#### 2. `hasAnyPermission($permissions): bool`

Verifica se l'utente ha ALMENO UNO dei permessi specificati.

```php
$user->hasAnyPermission(['edit articles', 'delete articles', 'publish articles']);
```

#### 3. `hasAllPermissions($permissions): bool`

Verifica se l'utente ha TUTTI i permessi specificati.

```php
$user->hasAllPermissions(['edit articles', 'publish articles']);
```

#### 4. `givePermissionTo($permissions): static`

Assegna uno o più permessi diretti all'utente.

```php
$user->givePermissionTo('edit articles');
$user->givePermissionTo(['edit articles', 'delete articles']);
```

#### 5. `revokePermissionTo($permissions): static`

Revoca uno o più permessi diretti dall'utente.

```php
$user->revokePermissionTo('delete articles');
```

#### 6. `syncPermissions($permissions): static`

Sincronizza i permessi diretti (rimuove tutti e assegna solo quelli specificati).

```php
$user->syncPermissions(['edit articles', 'view articles']);
```

#### 7. `getDirectPermissions(): Collection`

Ottiene solo i permessi assegnati direttamente all'utente (non tramite ruoli).

```php
$directPermissions = $user->getDirectPermissions();
```

#### 8. `getPermissionsViaRoles(): Collection`

Ottiene i permessi che l'utente ha tramite i suoi ruoli.

```php
$rolePermissions = $user->getPermissionsViaRoles();
```

#### 9. `getAllPermissions(): Collection`

Ottiene TUTTI i permessi dell'utente (diretti + tramite ruoli).

```php
$allPermissions = $user->getAllPermissions();
```

### C. Combined Queries

#### `roles(): BelongsToMany`

Relazione Eloquent per i ruoli.

```php
// Query ruoli
$adminUsers = User::role('admin')->get();

// Conta ruoli
$roleCount = $user->roles()->count();

// Eager loading
$users = User::with('roles')->get();
```

#### `permissions(): BelongsToMany`

Relazione Eloquent per i permessi.

```php
// Query permessi
$usersWithPermission = User::permission('edit articles')->get();

// Conta permessi diretti
$permissionCount = $user->permissions()->count();
```

## Query Scopes

Spatie fornisce automaticamente questi query scope:

### 1. `role($roles, $guard = null)`

Filtra utenti che hanno un ruolo specifico.

```php
// Utenti con ruolo admin
$admins = User::role('admin')->get();

// Utenti con uno dei ruoli specificati
$staff = User::role(['admin', 'editor'])->get();
```

### 2. `permission($permissions)`

Filtra utenti che hanno un permesso specifico.

```php
// Utenti che possono editare articoli
$editors = User::permission('edit articles')->get();

// Utenti con almeno uno dei permessi
$canPublish = User::permission(['edit articles', 'publish articles'])->get();
```

### 3. `withoutRole($roles)`

Filtra utenti che NON hanno un ruolo specifico.

```php
$nonAdmins = User::withoutRole('admin')->get();
```

### 4. `withoutPermission($permissions)`

Filtra utenti che NON hanno un permesso specifico.

```php
$cantDelete = User::withoutPermission('delete articles')->get();
```

## Blade Directives

Spatie fornisce automaticamente direttive Blade per il controllo accessi:

### Role Directives

```blade
@role('admin')
    <p>Contenuto visibile solo agli admin</p>
@endrole

@hasrole('editor')
    <p>Contenuto per editor</p>
@endhasrole

@hasanyrole(['admin', 'editor'])
    <p>Visibile a admin O editor</p>
@endhasanyrole

@hasallroles(['admin', 'super-admin'])
    <p>Visibile solo a chi ha entrambi i ruoli</p>
@endhasallroles

@unlessrole('guest')
    <p>Non visibile ai guest</p>
@endunlessrole
```

### Permission Directives

```blade
@can('edit articles')
    <button>Edit Article</button>
@endcan

@cannot('delete articles')
    <p>Non hai permesso di eliminare</p>
@endcannot

@canany(['edit articles', 'delete articles'])
    <button>Manage Articles</button>
@endcanany
```

## Gate & Policies

I permessi Spatie si integrano automaticamente con i Gate Laravel:

```php
// In un controller
if (Gate::allows('edit articles')) {
    // Utente può editare
}

// Con Policy
$this->authorize('update', $article);
```

## Middleware

Spatie registra automaticamente middleware per route protection:

```php
// Route con ruolo richiesto
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Route con permesso richiesto
Route::middleware(['permission:edit articles'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create']);
});

// Ruolo O permesso
Route::middleware(['role_or_permission:admin|edit articles'])->group(function () {
    // ...
});
```

## Best Practices

### 1. ✅ Usa i Metodi del Trait

```php
// ✅ CORRETTO - Usa il metodo del trait
$user->hasRole('admin');

// ❌ SBAGLIATO - Non creare metodi duplicati in BaseUser
public function hasRole(...): bool { ... }
```

### 2. ✅ Eager Loading

```php
// ✅ CORRETTO - Precarica ruoli e permessi
$users = User::with(['roles', 'permissions'])->get();

// ❌ LENTO - N+1 query problem
foreach ($users as $user) {
    if ($user->hasRole('admin')) { ... }
}
```

### 3. ✅ Cache Permissions

Spatie cache automaticamente i permessi. Per forzare il refresh:

```php
// Dopo aver modificato ruoli/permessi
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

### 4. ✅ Type Hinting

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function assignAdminRole(User $user): void
{
    $adminRole = Role::findByName('admin');
    $user->assignRole($adminRole);
}
```

## Testing

### Setup Test User

```php
use Modules\<nome progetto>\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

test('user can have roles and permissions', function () {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

    $user->assignRole($role);
    $user->givePermissionTo($permission);

    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasPermissionTo('edit articles'))->toBeTrue();
});
```

### Test Role Hierarchy

```php
test('admin role has all permissions', function () {
    $user = User::factory()->create();
    $admin = Role::create(['name' => 'admin']);

    $permissions = [
        Permission::create(['name' => 'create articles']),
        Permission::create(['name' => 'edit articles']),
        Permission::create(['name' => 'delete articles']),
    ];

    $admin->syncPermissions($permissions);
    $user->assignRole($admin);

    expect($user->hasAllPermissions(['create articles', 'edit articles', 'delete articles']))->toBeTrue();
});
```

## Troubleshooting

### Problema: Permessi non funzionano

**Soluzione**: Pulire cache

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

### Problema: "Table roles doesn't exist"

**Soluzione**: Eseguire migrations

```bash
php artisan migrate --path=vendor/spatie/laravel-permission/database/migrations
```

### Problema: Guard mismatch

**Soluzione**: Specificare guard corretto

```php
$user->assignRole(Role::findByName('admin', 'web'));
```

## Documentation Links

- **Official Docs**: https://spatie.be/docs/laravel-permission/
- **GitHub**: https://github.com/spatie/laravel-permission
- **Changelog**: https://github.com/spatie/laravel-permission/blob/main/changelog.md

## Version Information

| Package | Version |
|---------|---------|
| spatie/laravel-permission | Check `composer.json` |
| Laravel | 12.34.0 |
| PHP | 8.3.26 |

---

**Autore**: Claude Code
**Data**: 2025-10-15
**Versione**: 1.0.0

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04