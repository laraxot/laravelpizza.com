<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * Role model: specifica duplicata e non allineata al prodotto.
 *
 * Il corpo originale (18 test) e' una classe PHPUnit su `Tests\TestCase` con `RefreshDatabase`
 * (vietato: i test girano su MySQL senza `migrate:fresh`). Legge `$connection` e `$keyType`,
 * che sono `protected`, e usa le costanti `Role::ROLE_ADMINISTRATOR`, `ROLE_OWNER`, `ROLE_USER`,
 * che il model non dichiara (gli id di default stanno nell'enum `DefaultRoleId`).
 *
 * La copertura valida del model Role sta in `Unit/RoleTest.php`. Per ripristinare il corpo:
 * `git -C Modules/User show 0e2e66d86:tests/Unit/Models/RoleTest.php`.
 *
 * @see Modules/User/docs/stories/phpstan-test-wave-user-b.story.md
 */
it('role model')->skip('Role::ROLE_* constants and RefreshDatabase spec not implemented, covered by Unit/RoleTest.php');
