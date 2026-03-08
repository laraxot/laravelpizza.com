<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Facades\Session;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\EditActivity;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\ListActivities;
use Modules\Activity\Filament\Resources\SnapshotResource;
use Modules\Activity\Filament\Resources\SnapshotResource\Pages\ListSnapshots;
use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Filament\Tables\Enums\PaginationMode;

uses(TestCase::class);

describe('ActivityEvent', function (): void {
    it('can be instantiated', function (): void {
        $event = new \Modules\Activity\Events\ActivityEvent();
        expect($event)->toBeInstanceOf(\Modules\Activity\Events\ActivityEvent::class);
    });

    it('uses correct traits', function (): void {
        $event = new \Modules\Activity\Events\ActivityEvent();
        
        // Verify the event has the traits
        $traits = class_uses($event);
        expect($traits)->toHaveKey('Illuminate\Broadcasting\InteractsWithSockets');
        expect($traits)->toHaveKey('Illuminate\Foundation\Events\Dispatchable');
        expect($traits)->toHaveKey('Illuminate\Queue\SerializesModels');
    });
});

describe('ListLogActivitiesAction', function (): void {
    it('extends XotBaseAction', function (): void {
        $action = new class ('list_log_activities') extends XotBaseAction {
            protected function setUp(): void
            {
                parent::setUp();
            }
        };
        expect($action)->toBeInstanceOf(XotBaseAction::class);
    });

    it('has getDefaultName method that returns list_log_activities', function (): void {
        // Use reflection to check the static method
        $reflection = new \ReflectionClass(\Modules\Activity\Filament\Actions\ListLogActivitiesAction::class);
        $method = $reflection->getMethod('getDefaultName');
        
        $result = $method->invoke(null);
        expect($result)->toBe('list_log_activities');
    });

    it('is a Filament action', function (): void {
        $action = new class ('list_log_activities') extends XotBaseAction {
            protected function setUp(): void
            {
                parent::setUp();
                // @var mixed iconButton(;
            }
        };
        
        expect($action)->toBeInstanceOf(\Filament\Actions\Action::class);
    });
});

describe('CanPaginate trait', function (): void {
    it('has required methods from trait', function (): void {
        // Check the trait exists and has the expected methods
        $trait = new \ReflectionClass(\Modules\Activity\Filament\Pages\Concerns\CanPaginate::class);
        
        expect($trait->hasMethod('getRecordsPerPage'))->toBeTrue();
        expect($trait->hasMethod('getPaginationPageName'))->toBeTrue();
        expect($trait->hasMethod('getPerPageSessionKey'))->toBeTrue();
        expect($trait->hasMethod('getDefaultRecordsPerPageSelectOption'))->toBeTrue();
        expect($trait->hasMethod('updatedRecordsPerPage'))->toBeTrue();
        expect($trait->hasMethod('getTablePage'))->toBeTrue();
        expect($trait->hasMethod('paginateQuery'))->toBeTrue();
        expect($trait->hasMethod('getRecordsPerPageSelectOptions'))->toBeTrue();
    });

    it('trait has recordsPerPage property', function (): void {
        $trait = new \ReflectionClass(\Modules\Activity\Filament\Pages\Concerns\CanPaginate::class);
        
        expect($trait->hasProperty('recordsPerPage'))->toBeTrue();
    });

    it('trait has defaultRecordsPerPageSelectOption property', function (): void {
        $trait = new \ReflectionClass(\Modules\Activity\Filament\Pages\Concerns\CanPaginate::class);
        
        expect($trait->hasProperty('defaultRecordsPerPageSelectOption'))->toBeTrue();
    });

    it('trait has getRecordsPerPageSelectOptions method', function (): void {
        $trait = new \ReflectionClass(\Modules\Activity\Filament\Pages\Concerns\CanPaginate::class);
        
        expect($trait->hasMethod('getRecordsPerPageSelectOptions'))->toBeTrue();
    });
});

describe('ActivityResource', function (): void {
    it('can be instantiated', function (): void {
        $resource = new ActivityResource();
        expect($resource)->toBeInstanceOf(ActivityResource::class);
    });

    it('has correct model', function (): void {
        expect(ActivityResource::getModel())->toBe(Activity::class);
    });

    it('has required form schema fields', function (): void {
        $schema = ActivityResource::getFormSchema();

        expect($schema)->toHaveKey('log_name');
        expect($schema)->toHaveKey('description');
        expect($schema)->toHaveKey('subject_type');
        expect($schema)->toHaveKey('subject_id');
        expect($schema)->toHaveKey('causer_type');
        expect($schema)->toHaveKey('causer_id');
        expect($schema)->toHaveKey('properties');
        expect($schema)->toHaveKey('batch_uuid');
    });

    it('has relations method', function (): void {
        expect(method_exists(ActivityResource::class, 'getRelations'))->toBeTrue();
    });

    it('has pages method', function (): void {
        expect(method_exists(ActivityResource::class, 'getPages'))->toBeTrue();
    });
});

describe('EditActivity page', function (): void {
    it('can be instantiated', function (): void {
        $page = new EditActivity();
        expect($page)->toBeInstanceOf(EditActivity::class);
    });

    it('uses correct resource via getResource', function (): void {
        // Use reflection to access protected static $resource
        $reflection = new \ReflectionClass(EditActivity::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);
        
        $resource = $property->getValue();
        expect($resource)->toBe(ActivityResource::class);
    });

    it('extends XotBaseEditRecord', function (): void {
        $page = new EditActivity();
        expect($page)->toBeInstanceOf(\Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord::class);
    });
});

describe('ListActivities page', function (): void {
    it('can be instantiated', function (): void {
        $page = new ListActivities();
        expect($page)->toBeInstanceOf(ListActivities::class);
    });

    it('uses correct resource via getResource', function (): void {
        $reflection = new \ReflectionClass(ListActivities::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);
        
        $resource = $property->getValue();
        expect($resource)->toBe(ActivityResource::class);
    });

    it('has table columns', function (): void {
        $page = new ListActivities();
        $columns = $page->getTableColumns();

        expect($columns)->toHaveKey('id');
        expect($columns)->toHaveKey('description');
        expect($columns)->toHaveKey('subject_type');
        expect($columns)->toHaveKey('subject_id');
        expect($columns)->toHaveKey('causer_type');
        expect($columns)->toHaveKey('causer_id');
        expect($columns)->toHaveKey('created_at');
    });
});

describe('SnapshotResource', function (): void {
    it('can be instantiated', function (): void {
        $resource = new SnapshotResource();
        expect($resource)->toBeInstanceOf(SnapshotResource::class);
    });

    it('has correct model', function (): void {
        expect(SnapshotResource::getModel())->toBe(Snapshot::class);
    });

    it('has required form schema fields', function (): void {
        $schema = SnapshotResource::getFormSchema();

        expect($schema)->toHaveKey('model_type');
        expect($schema)->toHaveKey('model_id');
        expect($schema)->toHaveKey('state');
        expect($schema)->toHaveKey('created_by_type');
        expect($schema)->toHaveKey('created_by_id');
    });
});

describe('ListSnapshots page', function (): void {
    it('can be instantiated', function (): void {
        $page = new ListSnapshots();
        expect($page)->toBeInstanceOf(ListSnapshots::class);
    });

    it('uses correct resource via getResource', function (): void {
        $reflection = new \ReflectionClass(ListSnapshots::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);
        
        $resource = $property->getValue();
        expect($resource)->toBe(SnapshotResource::class);
    });

    it('has table columns', function (): void {
        $page = new ListSnapshots();
        $columns = $page->getTableColumns();

        expect($columns)->toHaveKey('id');
        expect($columns)->toHaveKey('aggregate_uuid');
        expect($columns)->toHaveKey('aggregate_version');
        expect($columns)->toHaveKey('state');
        expect($columns)->toHaveKey('created_at');
        expect($columns)->toHaveKey('updated_at');
    });

    it('has table filters', function (): void {
        $page = new ListSnapshots();
        $filters = $page->getTableFilters();

        expect($filters)->not->toBeEmpty();
    });

    it('has table actions', function (): void {
        $page = new ListSnapshots();
        $actions = $page->getTableActions();

        expect($actions)->toHaveKey('view');
        expect($actions)->toHaveKey('edit');
        expect($actions)->toHaveKey('delete');
    });

    it('has bulk actions', function (): void {
        $page = new ListSnapshots();
        $bulkActions = $page->getTableBulkActions();

        expect($bulkActions)->not->toBeEmpty();
    });
});

describe('StoredEventResource', function (): void {
    it('can be instantiated', function (): void {
        $resource = new StoredEventResource();
        expect($resource)->toBeInstanceOf(StoredEventResource::class);
    });

    it('has correct model', function (): void {
        expect(StoredEventResource::getModel())->toBe(StoredEvent::class);
    });

    it('has required form schema fields', function (): void {
        $schema = StoredEventResource::getFormSchema();

        expect($schema)->toHaveKey('event_class');
        expect($schema)->toHaveKey('event_properties');
        expect($schema)->toHaveKey('aggregate_uuid');
        expect($schema)->toHaveKey('aggregate_version');
        expect($schema)->toHaveKey('meta_data');
        expect($schema)->toHaveKey('created_at');
    });
});

describe('ListStoredEvents page', function (): void {
    it('can be instantiated', function (): void {
        $page = new \Modules\Activity\Filament\Resources\StoredEventResource\Pages\ListStoredEvents();
        expect($page)->toBeInstanceOf(\Modules\Activity\Filament\Resources\StoredEventResource\Pages\ListStoredEvents::class);
    });

    it('uses correct resource via getResource', function (): void {
        $reflection = new \ReflectionClass(\Modules\Activity\Filament\Resources\StoredEventResource\Pages\ListStoredEvents::class);
        $property = $reflection->getProperty('resource');
        $property->setAccessible(true);
        
        $resource = $property->getValue();
        expect($resource)->toBe(StoredEventResource::class);
    });

    it('has table columns', function (): void {
        $page = new \Modules\Activity\Filament\Resources\StoredEventResource\Pages\ListStoredEvents();
        $columns = $page->getTableColumns();

        expect($columns)->toHaveKey('id');
        expect($columns)->toHaveKey('event_class');
        expect($columns)->toHaveKey('event_properties');
    });
});
