<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('Migrate Db', function (): void {
    test('it migrates the test database', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Destructive migrate:fresh is not run in module tests — use forward-only migrate externally.');
    });
});
