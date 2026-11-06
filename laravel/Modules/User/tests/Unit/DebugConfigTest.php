<?php

declare(strict_types=1);
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('verify database connections config', function () {
    // Verify that the database config is loaded and valid
    $config = config('database.connections');
    expect($config)->toBeArray()
        ->and($config)->not->toBeEmpty();
});
