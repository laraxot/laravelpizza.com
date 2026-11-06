---
title: "Guida Completa ai Trait del Modulo User - AGGIORNATO POST-IMPLEMENTAZIONE"
type: note
status: draft
updated: 2026-10-08
tags: [docs, user]
qmd: "guida completa ai trait del modulo user - aggiornato post-implementazione user"
---
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

---
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
