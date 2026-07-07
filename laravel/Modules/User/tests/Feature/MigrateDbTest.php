<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Tests\TestCase;

uses(TestCase::class);

<<<<<<< HEAD
it('migrates the test database', function () {
    $this->artisan('migrate:fresh', [
        '--force' => true,
        '--env' => 'testing',
        '--path' => [
            'database/migrations',
            'Modules/Xot/database/migrations',
            'Modules/User/database/migrations',
        ],
    ])->assertExitCode(0);
=======
describe('Migrate Db', function (): void {
    test('it migrates the test database', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Destructive migrate:fresh is not run in module tests — use forward-only migrate externally.');
    });
>>>>>>> 9fa499be (.)
});
