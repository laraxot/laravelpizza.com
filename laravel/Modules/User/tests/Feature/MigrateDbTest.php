<?php

declare(strict_types=1);

use Modules\User\Tests\TestCase;

uses(TestCase::class);

it('migrates the test database', function () {
    // Skip: migrate:fresh is destructive and drops all tables for other tests.
    // Per architecture: migrations must be run ONCE externally via
    // `php artisan migrate --env=testing` before running the test suite.
    $this->markTestSkipped('migrate:fresh is destructive to the shared test DB - run migrations externally.');
});
