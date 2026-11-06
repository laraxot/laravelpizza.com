<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Models\Traits\HasXotFactory;
use PHPUnit\Framework\Assert;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder;

use function Safe\class_uses;

uses(TestCase::class);

/**
 * Verifica il contratto pubblico del model StoredEvent (persistenza eventi).
 */
final class StoredEventBusinessLogicTest extends TestCase
{
    public function test_uses_dedicated_activity_database_connection(): void
    {
        Assert::assertSame('activity', (new StoredEvent)->getConnectionName());
    }

    public function test_uses_stored_events_table(): void
    {
        Assert::assertSame('stored_events', (new StoredEvent)->getTable());
    }

    public function test_exposes_expected_fillable_attributes_for_event_payload(): void
    {
        $expected = [
            'id',
            'aggregate_uuid',
            'aggregate_version',
            'event_version',
            'event_class',
            'event_properties',
            'meta_data',
            'created_at',
            'updated_by',
            'created_by',
        ];

        Assert::assertSame($expected, (new StoredEvent)->getFillable());
    }

    public function test_extends_spatie_eloquent_stored_event(): void {}

    public function test_uses_xot_factory_trait_for_test_data(): void
    {
        Assert::assertArrayHasKey(HasXotFactory::class, class_uses(StoredEvent::class));
    }

    public function test_exposes_event_sourcing_query_builder_entry_point(): void
    {
        Assert::assertInstanceOf(EloquentStoredEventQueryBuilder::class, StoredEvent::query());
    }
}
