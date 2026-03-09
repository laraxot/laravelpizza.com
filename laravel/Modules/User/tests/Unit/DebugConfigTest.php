<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Illuminate\Support\Facades\DB;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('verify database connections config', function () {
    $mysql = config('database.connections.mysql.database');
    $user = config('database.connections.user.database');
    $media = config('database.connections.media.database');

    echo "\nMYSQL DB: ".$mysql;
    echo "\nUSER DB: ".$user;
    echo "\nMEDIA DB: ".$media;

    expect($user)->toBe($mysql);
    expect($media)->toBe($mysql);

    $resolvedUser = DB::connection('user')->getDatabaseName();
    echo "\nRESOLVED USER DB: ".$resolvedUser;

    expect($resolvedUser)->toBe($mysql);

    $profilesExists = DB::connection('user')->getSchemaBuilder()->hasTable('profiles');
    echo "\nPROFILES TABLE EXISTS: ".($profilesExists ? 'YES' : 'NO');

    $tenantsExists = DB::connection('user')->getSchemaBuilder()->hasTable('tenants');
    echo "\nTENANTS TABLE EXISTS: ".($tenantsExists ? 'YES' : 'NO');

    $migrations = DB::connection('user')->table('migrations')->get();
    echo "\nTOTAL MIGRATIONS IN DB: ".$migrations->count();
    foreach ($migrations as $m) {
        echo "\nRUN MIGRATION: ".$m->migration;
    }

    expect($profilesExists)->toBeTrue();
    expect($tenantsExists)->toBeTrue();
});
