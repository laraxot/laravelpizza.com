<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

test('verify database connections config', function () {
    $sqlitePath = database_path('fixcity_data.sqlite');
    $user = config('database.connections.user.database');
    $media = config('database.connections.media.database');

    Assert::assertSame($sqlitePath, $user);
    Assert::assertSame($sqlitePath, $media);
    $resolvedUser = DB::connection('user')->getDatabaseName();
    Assert::assertSame($sqlitePath, $resolvedUser);
    $profilesExists = DB::connection('user')->getSchemaBuilder()->hasTable('profiles');
    $tenantsExists = DB::connection('user')->getSchemaBuilder()->hasTable('tenants');

    Assert::assertTrue($profilesExists);
    Assert::assertTrue($tenantsExists);
});
