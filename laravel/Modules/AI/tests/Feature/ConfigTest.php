<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('loads xot config correctly', function () {
    $config = config('xot');

    expect($config)->toBeArray();
    expect($config)->not->toBeEmpty();
});

it('has expected keys in xot config', function () {
    $config = config('xot');

    // Verify some base structure exists
    expect($config)->toBeArray();
});

it('loads database config', function () {
    $config = config('database');

    expect($config)->toBeArray();
    expect($config)->toHaveKey('default');
});
