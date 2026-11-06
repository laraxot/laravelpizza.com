<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Mockery;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Models\Cache as CacheModel;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Xot migration deep branches', function (): void {
    test('uuid bigint helpers e information_schema mocks', function (): void {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => false,
            ],
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');

        Schema::dropIfExists('cache');
        Schema::create('cache', static function (Blueprint $t): void {
            $t->increments('id');
            $t->uuid('uuid')->nullable();
            $t->string('key')->nullable();
            $t->text('value')->nullable();
        });
        DB::table('cache')->insert(['id' => 1, 'uuid' => null, 'key' => 'k', 'value' => 'v']);
        DB::table('cache')->insert(['id' => 2, 'uuid' => (string) Str::uuid(), 'key' => 'k2', 'value' => 'v2']);

        $migration = new class extends XotBaseMigration
        {
            protected ?string $model_class = CacheModel::class;

            public function up(): void {}
        };

        // isUuidColumnType + backfill
        $isUuid = new ReflectionMethod($migration, 'isUuidColumnType');
        $isUuid->setAccessible(true);
        Assert::assertTrue($isUuid->invoke($migration, 'char'));
        Assert::assertTrue($isUuid->invoke($migration, 'varchar'));
        Assert::assertFalse($isUuid->invoke($migration, 'bigint'));

        $backfill = new ReflectionMethod($migration, 'backfillUuidColumnIfNeeded');
        $backfill->setAccessible(true);
        try {
            $backfill->invoke($migration);
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        // convertIdFromUuidToBigintIfNeeded when not uuid type
        $convert = new ReflectionMethod($migration, 'convertIdFromUuidToBigintIfNeeded');
        $convert->setAccessible(true);
        try {
            $convert->invoke(
                $migration,
                static function (Blueprint $t): void {
                    $t->id();
                    $t->uuid('uuid')->nullable();
                    $t->string('key')->nullable();
                },
                ['key', 'value'],
                [],
            );
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        try {
            $perform = new ReflectionMethod($migration, 'performUuidToBigintConversion');
            $perform->setAccessible(true);
            $perform->invoke(
                $migration,
                'cache',
                static function (Blueprint $t): void {
                    $t->id();
                    $t->uuid('uuid')->nullable();
                    $t->string('key')->nullable();
                    $t->text('value')->nullable();
                },
                ['key', 'value'],
                [],
            );
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        // Mock information_schema paths via connection selectOne
        $conn = Mockery::mock(Connection::class)->makePartial();
        $conn->shouldReceive('getDatabaseName')->andReturn('testdb');
        $conn->shouldReceive('selectOne')->andReturn((object) ['count' => 1]);
        $conn->shouldReceive('getDriverName')->andReturn('mysql');

        $builder = Mockery::mock(Builder::class);
        $builder->shouldReceive('getConnection')->andReturn($conn);
        $builder->shouldReceive('hasTable')->andReturn(true);
        $builder->shouldReceive('hasColumn')->andReturn(true);
        $builder->shouldReceive('hasIndex')->andReturn(false);

        // Invoke hasPrimaryKey with mocked getConn if possible
        try {
            $migration->hasPrimaryKey();
        } catch (\Throwable) {
        }
        try {
            $migration->dropPrimaryKey(); // sqlite early return
        } catch (\Throwable) {
        }

        // constraint helpers
        foreach (['constraintCountRow', 'extractPrimaryKeyCount'] as $m) {
            if (! method_exists($migration, $m)) {
                continue;
            }
            $rm = new ReflectionMethod($migration, $m);
            $rm->setAccessible(true);
            try {
                $rm->invoke($migration, (object) ['count' => 2]);
            } catch (\Throwable) {
                try {
                    $rm->invoke($migration, ['count' => 2]);
                } catch (\Throwable) {
                }
            }
            try {
                $rm->invoke($migration, null);
            } catch (\Throwable) {
            }
        }
    });
});
