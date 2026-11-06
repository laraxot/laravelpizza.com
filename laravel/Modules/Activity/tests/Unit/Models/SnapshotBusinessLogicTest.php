<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Models\Traits\HasXotFactory;
use PHPUnit\Framework\Assert;
use Spatie\EventSourcing\Snapshots\EloquentSnapshot as SpatieSnapshot;

use function Safe\class_uses;

uses(TestCase::class);

/**
 * Verifica il contratto pubblico del model Snapshot per event sourcing.
 */
final class SnapshotBusinessLogicTest extends TestCase
{
    public function test_uses_dedicated_activity_database_connection(): void
    {
        Assert::assertSame('activity', (new Snapshot)->getConnectionName());
    }

    public function test_exposes_expected_fillable_attributes_for_aggregate_state(): void
    {
        $expected = [
            'id',
            'aggregate_uuid',
            'aggregate_version',
            'state',
            'created_at',
            'updated_at',
        ];

        Assert::assertSame($expected, (new Snapshot)->getFillable());
    }

    public function test_extends_spatie_eloquent_snapshot(): void
    {
        Assert::assertTrue((new \ReflectionClass(Snapshot::class))->isSubclassOf(SpatieSnapshot::class));
    }

    public function test_uses_xot_factory_trait_for_test_data(): void
    {
        Assert::assertArrayHasKey(HasXotFactory::class, class_uses(Snapshot::class));
    }

    public function test_can_query_snapshots_by_aggregate_uuid(): void
    {
        Assert::assertInstanceOf(Builder::class, Snapshot::uuid('00000000-0000-0000-0000-000000000001'));
    }

    public function test_can_query_snapshots_by_aggregate_version(): void
    {
        Assert::assertInstanceOf(Builder::class, Snapshot::whereAggregateVersion(1));
    }
}
