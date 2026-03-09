<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Filament\Tables\Enums\PaginationMode;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

function makeListLogActivitiesPage(): ListLogActivities
{
    return new class extends ListLogActivities
    {
        public static function getResource(): string
        {
            return ActivityResource::class;
        }
    };
}

test('list log activities page is abstract', function (): void {
    $reflection = new ReflectionClass(ListLogActivities::class);

    expect($reflection->isAbstract())->toBeTrue();
});

test('list log activities extends xot base page', function (): void {
    expect(is_subclass_of(ListLogActivities::class, XotBasePage::class))->toBeTrue();
});

test('list log activities uses can paginate trait', function (): void {
    expect(class_uses_recursive(ListLogActivities::class))->toContain(CanPaginate::class);
});

test('list log activities exposes expected methods', function (string $method): void {
    expect(method_exists(ListLogActivities::class, $method))->toBeTrue();
})->with([
    'getActivities',
    'restoreActivity',
    'canRestoreActivity',
    'getBreadcrumb',
    'getTitle',
    'getFieldLabel',
]);

test('list log activities pagination mode returns default', function (): void {
    $page = makeListLogActivitiesPage();

    expect($page->getPaginationMode())->toBe(PaginationMode::Default);
});

test('list log activities view is correct', function (): void {
    $reflection = new ReflectionClass(ListLogActivities::class);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    $page = makeListLogActivitiesPage();

    expect($property->getValue($page))->toBe('activity::filament.pages.list-log-activities');
});
