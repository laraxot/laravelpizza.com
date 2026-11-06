<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Models\Cache as CacheModel;
use Modules\Xot\Tests\Fixtures\Stubs\XotCovManageRelated;
use Modules\Xot\Tests\Fixtures\Stubs\XotCovRelationHost;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-xot-db');

describe('Xot RelationX ManageRelated StatesChart', function (): void {
    test('RelationX belongsToManyX morphToManyX con pivot stub', function (): void {
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
            $t->string('key')->nullable();
            $t->text('value')->nullable();
        });
        Schema::dropIfExists('cache_cache');
        Schema::create('cache_cache', static function (Blueprint $t): void {
            $t->increments('id');
            $t->unsignedBigInteger('cache_id')->nullable();
            $t->unsignedBigInteger('related_id')->nullable();
            $t->string('extra')->nullable();
            $t->timestamps();
        });
        Schema::dropIfExists('cache_morph');
        Schema::create('cache_morph', static function (Blueprint $t): void {
            $t->increments('id');
            $t->unsignedBigInteger('cache_id')->nullable();
            $t->unsignedBigInteger('related_id')->nullable();
            $t->string('related_type')->nullable();
            $t->timestamps();
        });

        $host = new XotCovRelationHost;
        $host->forceFill(['id' => 1, 'key' => 'k', 'value' => 'v']);
        $host->exists = true;

        $relation = $host->belongsToManyX(CacheModel::class);
        Assert::assertSame('cache_cache', $relation->getTable());
        Assert::assertSame(
            ['cache_id', 'related_id', 'extra', 'created_at', 'updated_at'],
            $relation->getPivotColumns(),
        );

        $morphRelation = $host->morphToManyX(CacheModel::class, 'taggable');
        Assert::assertSame('cache_morph', $morphRelation->getTable());
        Assert::assertSame(
            ['cache_id', 'related_id', 'related_type', 'created_at', 'updated_at'],
            $morphRelation->getPivotColumns(),
        );
    });

    test('ManageRelatedRecords exposes its stable navigation contract', function (): void {
        Assert::assertSame('', XotCovManageRelated::getNavigationGroup());
    });
});
