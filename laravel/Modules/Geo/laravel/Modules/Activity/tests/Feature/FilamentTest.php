<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;
use Filament\Actions\Action;
use Modules\Activity\Events\ActivityEvent;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\EditActivity;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\ListActivities;
use Modules\Activity\Filament\Resources\SnapshotResource;
use Modules\Activity\Filament\Resources\SnapshotResource\Pages\ListSnapshots;
use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Activity\Filament\Resources\StoredEventResource\Pages\ListStoredEvents;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use PHPUnit\Framework\Assert;
use function Safe\class_uses;

uses(\Modules\Activity\Tests\TestCase::class);

describe('ActivityEvent', function (): void {
    test('can be instantiated', function (): void {
        $event = new ActivityEvent;
        Assert::assertInstanceOf(ActivityEvent::class, $event);
    });

    test('uses correct traits', function (): void {
        $event = new ActivityEvent;

        // Verify the event has the traits
        $traits = class_uses($event);
        Assert::assertArrayHasKey('Illuminate\Broadcasting\InteractsWithSockets', $traits);
        Assert::assertArrayHasKey('Illuminate\Foundation\Events\Dispatchable', $traits);
        Assert::assertArrayHasKey('Illuminate\Queue\SerializesModels', $traits);
    });
});

describe('ListLogActivitiesAction', function (): void {
    test('extends XotBaseAction', function (): void {
        $action = new class('list_log_activities') extends XotBaseAction
        {
            protected function setUp(): void
            {
                parent::setUp();
            }
        };
        Assert::assertInstanceOf(XotBaseAction::class, $action);
    });

    test('has getDefaultName method that returns list_log_activities', function (): void {
        // Use reflection to check the static method
        $reflection = new \ReflectionClass(ListLogActivitiesAction::class);
        $method = $reflection->getMethod('getDefaultName');

        $result = $method->invoke(null);
        Assert::assertSame('list_log_activities', $result);
    });

    test('is a Filament action', function (): void {
        $action = new class('list_log_activities') extends XotBaseAction
        {
            protected function setUp(): void
            {
                parent::setUp();
            }
        };

        Assert::assertInstanceOf(Action::class, $action);
    });
});

describe('CanPaginate trait', function (): void {
    test('has required methods from trait', function (): void {
        // Check the trait exists and has the expected methods
        $trait = new \ReflectionClass(CanPaginate::class);

        Assert::assertTrue($trait->hasMethod('getRecordsPerPage'));
        Assert::assertTrue($trait->hasMethod('getPaginationPageName'));
        Assert::assertTrue($trait->hasMethod('getPerPageSessionKey'));
        Assert::assertTrue($trait->hasMethod('getDefaultRecordsPerPageSelectOption'));
        Assert::assertTrue($trait->hasMethod('updatedRecordsPerPage'));
        Assert::assertTrue($trait->hasMethod('getTablePage'));
        Assert::assertTrue($trait->hasMethod('paginateQuery'));
        Assert::assertTrue($trait->hasMethod('getRecordsPerPageSelectOptions'));
    });

    test('trait has recordsPerPage property', function (): void {
        $trait = new \ReflectionClass(CanPaginate::class);

        Assert::assertTrue($trait->hasProperty('recordsPerPage'));
    });

    test('trait has defaultRecordsPerPageSelectOption property', function (): void {
        $trait = new \ReflectionClass(CanPaginate::class);

        Assert::assertTrue($trait->hasProperty('defaultRecordsPerPageSelectOption'));
    });

    test('trait has getRecordsPerPageSelectOptions method', function (): void {
        $trait = new \ReflectionClass(CanPaginate::class);

        Assert::assertTrue($trait->hasMethod('getRecordsPerPageSelectOptions'));
    });
});

describe('ActivityResource', function (): void {
    test('can be instantiated', function (): void {
        $resource = new ActivityResource;
        Assert::assertInstanceOf(ActivityResource::class, $resource);
    });

    test('has correct model', function (): void {
        Assert::assertSame(Activity::class, ActivityResource::getModel());
    });

    test('has required form schema fields', function (): void {
        $schema = ActivityResource::getFormSchema();

        Assert::assertArrayHasKey('log_name', $schema);
        Assert::assertArrayHasKey('description', $schema);
        Assert::assertArrayHasKey('subject_type', $schema);
        Assert::assertArrayHasKey('subject_id', $schema);
        Assert::assertArrayHasKey('causer_type', $schema);
        Assert::assertArrayHasKey('causer_id', $schema);
        Assert::assertArrayHasKey('properties', $schema);
        Assert::assertArrayHasKey('batch_uuid', $schema);
    });
});

describe('EditActivity page', function (): void {
    test('can be instantiated', function (): void {
        $page = new EditActivity;
        Assert::assertInstanceOf(EditActivity::class, $page);
    });

    test('uses correct resource via getResource', function (): void {
        // Use reflection to access protected static $resource
        $reflection = new \ReflectionClass(EditActivity::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);

        $resource = $property->getValue();
        Assert::assertSame(ActivityResource::class, $resource);
    });

    test('extends XotBaseEditRecord', function (): void {
        $page = new EditActivity;
        Assert::assertInstanceOf(XotBaseEditRecord::class, $page);
    });
});

describe('ListActivities page', function (): void {
    test('can be instantiated', function (): void {
        $page = new ListActivities;
        Assert::assertInstanceOf(ListActivities::class, $page);
    });

    test('uses correct resource via getResource', function (): void {
        $reflection = new \ReflectionClass(ListActivities::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);

        $resource = $property->getValue();
        Assert::assertSame(ActivityResource::class, $resource);
    });

    test('has table columns', function (): void {
        $page = new ListActivities;
        $columns = $page->getTableColumns();

        Assert::assertArrayHasKey('id', $columns);
        Assert::assertArrayHasKey('description', $columns);
        Assert::assertArrayHasKey('subject_type', $columns);
        Assert::assertArrayHasKey('subject_id', $columns);
        Assert::assertArrayHasKey('causer_type', $columns);
        Assert::assertArrayHasKey('causer_id', $columns);
        Assert::assertArrayHasKey('created_at', $columns);
    });
});

describe('SnapshotResource', function (): void {
    test('can be instantiated', function (): void {
        $resource = new SnapshotResource;
        Assert::assertInstanceOf(SnapshotResource::class, $resource);
    });

    test('has correct model', function (): void {
        Assert::assertSame(Snapshot::class, SnapshotResource::getModel());
    });

    test('has required form schema fields', function (): void {
        $schema = SnapshotResource::getFormSchema();

        Assert::assertArrayHasKey('model_type', $schema);
        Assert::assertArrayHasKey('model_id', $schema);
        Assert::assertArrayHasKey('state', $schema);
        Assert::assertArrayHasKey('created_by_type', $schema);
        Assert::assertArrayHasKey('created_by_id', $schema);
    });
});

describe('ListSnapshots page', function (): void {
    test('can be instantiated', function (): void {
        $page = new ListSnapshots;
        Assert::assertInstanceOf(ListSnapshots::class, $page);
    });

    test('uses correct resource via getResource', function (): void {
        $reflection = new \ReflectionClass(ListSnapshots::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);

        $resource = $property->getValue();
        Assert::assertSame(SnapshotResource::class, $resource);
    });

    test('has table columns', function (): void {
        $page = new ListSnapshots;
        $columns = $page->getTableColumns();

        Assert::assertArrayHasKey('id', $columns);
        Assert::assertArrayHasKey('aggregate_uuid', $columns);
        Assert::assertArrayHasKey('aggregate_version', $columns);
        Assert::assertArrayHasKey('state', $columns);
        Assert::assertArrayHasKey('created_at', $columns);
        Assert::assertArrayHasKey('updated_at', $columns);
    });

    test('has table filters', function (): void {
        $page = new ListSnapshots;
        $filters = $page->getTableFilters();

        Assert::assertNotEmpty($filters);
    });

    test('has table actions', function (): void {
        $page = new ListSnapshots;
        $actions = $page->getTableActions();

        Assert::assertArrayHasKey('view', $actions);
        Assert::assertArrayHasKey('edit', $actions);
        Assert::assertArrayHasKey('delete', $actions);
    });

    test('has bulk actions', function (): void {
        $page = new ListSnapshots;
        $bulkActions = $page->getTableBulkActions();

        Assert::assertNotEmpty($bulkActions);
    });
});

describe('StoredEventResource', function (): void {
    test('can be instantiated', function (): void {
        $resource = new StoredEventResource;
        Assert::assertInstanceOf(StoredEventResource::class, $resource);
    });

    test('has correct model', function (): void {
        Assert::assertSame(StoredEvent::class, StoredEventResource::getModel());
    });

    test('has required form schema fields', function (): void {
        $schema = StoredEventResource::getFormSchema();

        Assert::assertArrayHasKey('event_class', $schema);
        Assert::assertArrayHasKey('event_properties', $schema);
        Assert::assertArrayHasKey('aggregate_uuid', $schema);
        Assert::assertArrayHasKey('aggregate_version', $schema);
        Assert::assertArrayHasKey('meta_data', $schema);
        Assert::assertArrayHasKey('created_at', $schema);
    });
});

describe('ListStoredEvents page', function (): void {
    test('can be instantiated', function (): void {
        $page = new ListStoredEvents;
        Assert::assertInstanceOf(ListStoredEvents::class, $page);
    });

    test('uses correct resource via getResource', function (): void {
        $reflection = new \ReflectionClass(ListStoredEvents::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);

        $resource = $property->getValue();
        Assert::assertSame(StoredEventResource::class, $resource);
    });

    test('has table columns', function (): void {
        $page = new ListStoredEvents;
        $columns = $page->getTableColumns();

        Assert::assertArrayHasKey('id', $columns);
        Assert::assertArrayHasKey('event_class', $columns);
        Assert::assertArrayHasKey('event_properties', $columns);
    });
});
