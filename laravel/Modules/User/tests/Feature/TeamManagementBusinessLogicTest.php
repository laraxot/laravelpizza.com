<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * Team Management Business Logic: specifica non implementata.
 *
 * Il corpo originale (27 test) e' una classe PHPUnit su `Tests\TestCase` con `RefreshDatabase`
 * (vietato: i test girano su MySQL senza `migrate:fresh`) e chiama su `Team` metodi che il
 * modello non ha: `invitations()` (esiste `teamInvitations()`), `memberships()`, `roles()`,
 * `userHasRole()`, `getUserRole()`, `hasUserWithPermission()` (esiste `userHasPermission()`),
 * `restore()` (il model non usa `SoftDeletes`). Ogni `Team::factory()->create()` letto come
 * `mixed` nascondeva queste chiamate.
 *
 * La parte valida (creazione team, membri, ruoli e permessi sul pivot `team_user`,
 * inviti, impostazioni) e' coperta da `TeamManagementTest.php`,
 * `TeamManagementInvitationsTest.php` e `TeamManagementBusinessLogicInvitationsTest.php`.
 * Se Team guadagna un'API di ruoli/membership dedicata, ripristinare il corpo da git:
 * `git -C Modules/User show 0e2e66d86:tests/Feature/TeamManagementBusinessLogicTest.php`.
 *
 * @see Modules/User/docs/stories/phpstan-test-wave-user-b.story.md
 */
it('team management business logic')->skip('Team memberships(), roles(), invitations(), userHasRole() and restore() not implemented');
