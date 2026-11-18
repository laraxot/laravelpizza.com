<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Verifica il contratto pubblico del model Activity (connessione, mass assignment, query scopes).
 */
final class ActivityBusinessLogicTest extends TestCase
{
    public function test_uses_dedicated_activity_database_connection(): void
    {
        Assert::assertSame('activity', (new Activity)->getConnectionName());
    }

    public function test_exposes_expected_fillable_attributes_for_audit_log(): void
    {
        $expected = [
            'id',
            'log_name',
            'description',
            'subject_type',
            'event',
            'subject_id',
            'causer_type',
            'causer_id',
            'properties',
            'attribute_changes',
            'batch_uuid',
        ];

        Assert::assertSame($expected, (new Activity)->getFillable());
    }

    public function test_can_filter_activities_by_log_name(): void
    {
        Assert::assertInstanceOf(Builder::class, Activity::inLog('default'));
    }

    public function test_can_filter_activities_by_event_name(): void
    {
        Assert::assertInstanceOf(Builder::class, Activity::forEvent('created'));
    }

    public function test_can_filter_activities_with_batch_uuid(): void
    {
        Assert::assertInstanceOf(Builder::class, Activity::hasBatch());
    }
}
