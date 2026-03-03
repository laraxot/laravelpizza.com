<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Illuminate\Support\Facades\DB;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('verify database connections config', function () {
    $mysqlDb = config('database.connections.mysql.database');
    $userDb = config('database.connections.user.database');
    $mediaDb = config('database.connections.media.database');

    // Log the actual values for diagnostic purposes
    // These connections may use different databases by design
    expect($mysqlDb)->toBeString()->not->toBeEmpty();
    expect($userDb)->toBeString()->not->toBeEmpty();

    $resolvedUser = DB::connection('user')->getDatabaseName();
    expect($resolvedUser)->toBeString()->not->toBeEmpty();

    // Verify the user connection can reach its database
    $profilesExists = DB::connection('user')->getSchemaBuilder()->hasTable('profiles');
    $tenantsExists = DB::connection('user')->getSchemaBuilder()->hasTable('tenants');

    // These tables should exist in the user_test database
    expect($profilesExists)->toBeTrue('profiles table should exist in user DB');
    expect($tenantsExists)->toBeTrue('tenants table should exist in user DB');
});
