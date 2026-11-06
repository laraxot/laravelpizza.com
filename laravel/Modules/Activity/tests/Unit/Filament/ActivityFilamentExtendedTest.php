<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Filament;

use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\Column;
use Mockery;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\EditActivity;
use Modules\Activity\Filament\Resources\ActivityResource\Schemas\ActivityInfolist;
use Modules\Activity\Filament\Resources\ActivityResource\Tables\ActivitiesTable;
use Modules\Activity\Filament\Resources\SnapshotResource\Schemas\SnapshotForm;
use Modules\Activity\Filament\Resources\SnapshotResource\Schemas\SnapshotInfolist;
use Modules\Activity\Filament\Resources\SnapshotResource\Tables\SnapshotsTable;
use Modules\Activity\Filament\Resources\StoredEventResource\Schemas\StoredEventForm;
use Modules\Activity\Filament\Resources\StoredEventResource\Schemas\StoredEventInfolist;
use Modules\Activity\Filament\Resources\StoredEventResource\Tables\StoredEventsTable;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

test('EditActivity espone DeleteAction in header', function (): void {
    $method = new ReflectionMethod(EditActivity::class, 'getHeaderActions');
    $method->setAccessible(true);

    /** @var array<string, DeleteAction> $actions */
    $actions = $method->invoke(new EditActivity);

    Assert::assertArrayHasKey('delete', $actions);
    Assert::assertInstanceOf(DeleteAction::class, $actions['delete']);
});

test('ActivitiesTable espone colonne complete', function (): void {
    $tabella = new ActivitiesTable;

    Assert::assertSame(
        [
            'id', 'log_name', 'description', 'event', 'subject_type', 'subject_id',
            'causer_type', 'causer_id', 'properties', 'batch_uuid', 'created_at', 'updated_at',
        ],
        array_keys($tabella->getTableColumns()),
    );
    Assert::assertContainsOnlyInstancesOf(Column::class, $tabella->getTableColumns());
});

test('ActivityInfolist espone schema infolist', function (): void {
    $instance = app(ActivityInfolist::class);
    $schema = $instance->getInfolistSchema();

    Assert::assertSame(
        [
            'id', 'log_name', 'description', 'event', 'subject_type', 'subject_id',
            'causer_type', 'causer_id', 'batch_uuid', 'created_at',
        ],
        array_keys($schema),
    );
});

test('SnapshotsTable espone colonne attese', function (): void {
    $tabella = new SnapshotsTable;

    Assert::assertSame(
        ['id', 'aggregate_uuid', 'aggregate_version', 'state', 'created_at', 'updated_at'],
        array_keys($tabella->getTableColumns()),
    );
});

test('SnapshotForm e SnapshotInfolist espongono schema', function (): void {
    Assert::assertSame(['aggregate_uuid', 'aggregate_version', 'state'], array_keys(app(SnapshotForm::class)->getFormSchema()));
    Assert::assertSame(
        ['id', 'model_type', 'model_id', 'created_by_type', 'created_by_id', 'created_at'],
        array_keys(app(SnapshotInfolist::class)->getInfolistSchema()),
    );
});

test('StoredEventsTable StoredEventForm StoredEventInfolist espongono schema', function (): void {
    $tabella = new StoredEventsTable;
    Assert::assertSame(
        ['id', 'event_class', 'properties', 'created_at', 'updated_at'],
        array_keys($tabella->getTableColumns()),
    );

    Assert::assertSame(
        ['event_class', 'event_properties', 'aggregate_uuid', 'aggregate_version', 'meta_data', 'created_at'],
        array_keys(app(StoredEventForm::class)->getFormSchema()),
    );

    Assert::assertSame(
        ['id', 'event_class', 'aggregate_uuid', 'aggregate_version', 'created_at'],
        array_keys(app(StoredEventInfolist::class)->getInfolistSchema()),
    );
});
