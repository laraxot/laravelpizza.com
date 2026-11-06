<?php

declare(strict_types=1);

use Modules\Xot\Tests\Support\TestDatabaseGuard;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('accepts a testing environment with _test databases, sqlite and the documented exceptions', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('testing', [
        'mariadb' => ['driver' => 'mariadb', 'database' => 'fixcity_data_test'],
        'sqlite' => ['driver' => 'sqlite', 'database' => ':memory:'],
        'liveuser_general' => ['driver' => 'mariadb', 'database' => 'forge13'],
    ]);

    expect($assert)->not->toThrow(RuntimeException::class);
});

it('refuses an environment that is not testing', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('local', []);

    expect($assert)->toThrow(RuntimeException::class);
});

it('refuses a connection whose database does not end with _test', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('testing', [
        'mariadb' => ['driver' => 'mariadb', 'database' => 'quaeris_data'],
    ]);

    expect($assert)->toThrow(RuntimeException::class);
});

it('reads driver and database from the connection url, like the runtime does', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('testing', [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'url' => 'mysql://user:secret@localhost/quaeris_data',
        ],
    ]);

    expect($assert)->toThrow(RuntimeException::class);
});
