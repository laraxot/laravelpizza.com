<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Job\Tests\TestCase::class);

test('default database connection is configured', function () {
    Assert::assertNotEmpty(config('database.default'));
});

test('database configuration has required connections', function () {
    $connections = config('database.connections');

    Assert::assertIsArray($connections);
    Assert::assertArrayHasKey('mysql', $connections);
});
