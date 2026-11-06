<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * User model: specifica duplicata e non allineata al prodotto.
 *
 * Il corpo originale (19 test) e' una classe PHPUnit su `Tests\TestCase` con `RefreshDatabase`
 * (vietato: i test girano su MySQL senza `migrate:fresh`). Verifica inoltre su `users` della
 * connessione di default un modello che vive sulla connessione `user`, e chiama
 * `User::restore()` mentre il model non usa `SoftDeletes`.
 *
 * La copertura valida del model User sta in `Unit/UserTest.php`, `Unit/UserModelTest.php`,
 * `Unit/Models/BaseUserTest.php` e `Unit/Models/UserBusinessLogicTest.php`. Per ripristinare il
 * corpo: `git -C Modules/User show 0e2e66d86:tests/Unit/Models/UserTest.php`.
 *
 * @see Modules/User/docs/stories/phpstan-test-wave-user-b.story.md
 */
it('user model')->skip('User soft delete restore() and RefreshDatabase spec not implemented, covered by Unit/UserTest.php');
