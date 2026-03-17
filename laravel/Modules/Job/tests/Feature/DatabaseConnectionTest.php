<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Modules\Job\Tests\TestCase;

uses(TestCase::class);

test('default database connection is configured', function () {
    expect(config('database.default'))->not->toBeEmpty();
});

test('database configuration has required connections', function () {
    $connections = config('database.connections');

    expect($connections)->toBeArray()
        ->and($connections)->toHaveKey('mysql');
});
