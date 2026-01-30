<?php

declare(strict_types=1);

uses(\Modules\Job\Tests\TestCase::class);

test('default database connection is configured', function () {
    expect(config('database.default'))->not->toBeEmpty();
});

test('database configuration has required connections', function () {
    $connections = config('database.connections');

    expect($connections)->toBeArray()
        ->and($connections)->toHaveKey('mysql');
});
