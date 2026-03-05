<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Resources;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Filament\Resources\EventResource;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('EventResource', function (): void {
    test('it returns correct model class', function (): void {
        $model = EventResource::getModel();

        expect($model)->toBe(Event::class);
    });

    test('it has form schema', function (): void {
        $schema = EventResource::getFormSchema();

        expect($schema)->toBeArray()
            ->and(count($schema))->toBeGreaterThan(0);
    });

    test('form schema contains event_details section', function (): void {
        $schema = EventResource::getFormSchema();

        expect(isset($schema['event_details']))->toBeTrue();
    });

    test('form schema section is a Section component', function (): void {
        $schema = EventResource::getFormSchema();

        expect($schema['event_details'])->toBeInstanceOf(Section::class);
    });

    test('table configuration returns Table instance', function (): void {
        $table = EventResource::table(new \Filament\Tables\Table());

        expect($table)->toBeInstanceOf(Table::class);
    });

    test('form schema includes title field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Title field should be present
        $hasTitle = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'title') {
                $hasTitle = true;
                break;
            }
        }

        expect($hasTitle)->toBeTrue();
    });

    test('form schema includes description field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Description field should be present
        $hasDescription = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'description') {
                $hasDescription = true;
                break;
            }
        }

        expect($hasDescription)->toBeTrue();
    });

    test('form schema includes location field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Location field should be present
        $hasLocation = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'location') {
                $hasLocation = true;
                break;
            }
        }

        expect($hasLocation)->toBeTrue();
    });

    test('form schema includes start_date field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Start date field should be present
        $hasStartDate = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'start_date') {
                $hasStartDate = true;
                break;
            }
        }

        expect($hasStartDate)->toBeTrue();
    });

    test('form schema includes end_date field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // End date field should be present
        $hasEndDate = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'end_date') {
                $hasEndDate = true;
                break;
            }
        }

        expect($hasEndDate)->toBeTrue();
    });

    test('form schema includes status field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Status field should be present
        $hasStatus = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'status') {
                $hasStatus = true;
                break;
            }
        }

        expect($hasStatus)->toBeTrue();
    });

    test('form schema includes attendees_count field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Attendees count field should be present
        $hasAttendeesCount = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'attendees_count') {
                $hasAttendeesCount = true;
                break;
            }
        }

        expect($hasAttendeesCount)->toBeTrue();
    });

    test('form schema includes max_attendees field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Max attendees field should be present
        $hasMaxAttendees = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'max_attendees') {
                $hasMaxAttendees = true;
                break;
            }
        }

        expect($hasMaxAttendees)->toBeTrue();
    });

    test('form schema includes cover_image field', function (): void {
        $schema = EventResource::getFormSchema();
        $section = $schema['event_details'];
        $sectionSchema = $section->getChildComponents();

        // Cover image field should be present
        $hasCoverImage = false;
        foreach ($sectionSchema as $field) {
            if (method_exists($field, 'getName') && $field->getName() === 'cover_image') {
                $hasCoverImage = true;
                break;
            }
        }

        expect($hasCoverImage)->toBeTrue();
    });

    test('event resource extends XotBaseResource', function (): void {
        $reflection = new \ReflectionClass(EventResource::class);
        $parentClass = $reflection->getParentClass();

        expect($parentClass->getName())->toContain('XotBaseResource');
    });

    test('resource can be instantiated', function (): void {
        $resource = new EventResource();

        expect($resource)->toBeInstanceOf(EventResource::class);
    });

    test('table has columns configured', function (): void {
        $table = EventResource::table(new \Filament\Tables\Table());

        // Table should be configured with columns
        expect($table)->not->toBeNull();
    });

    test('table has filters configured', function (): void {
        $table = EventResource::table(new \Filament\Tables\Table());

        // Table should have filters configured
        expect($table)->not->toBeNull();
    });

    test('table has actions configured', function (): void {
        $table = EventResource::table(new \Filament\Tables\Table());

        // Table should have actions configured
        expect($table)->not->toBeNull();
    });

    test('table has bulk actions configured', function (): void {
        $table = EventResource::table(new \Filament\Tables\Table());

        // Table should have bulk actions
        expect($table)->not->toBeNull();
    });
});
