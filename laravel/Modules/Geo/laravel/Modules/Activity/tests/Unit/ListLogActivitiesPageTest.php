<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;
use Filament\Tables\Enums\PaginationMode;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use PHPUnit\Framework\Assert;

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
    $reflection = new \ReflectionClass(ListLogActivities::class);

    Assert::assertTrue($reflection->isAbstract());
});

test('list log activities extends xot base page', function (): void {
    $page = makeListLogActivitiesPage();

    Assert::assertInstanceOf(XotBasePage::class, $page);
});

test('list log activities uses can paginate trait', function (): void {
    $traits = class_uses_recursive(ListLogActivities::class);

    Assert::assertContains(CanPaginate::class, $traits);
});

test('list log activities exposes expected methods', function (): void {
    $reflection = new \ReflectionClass(ListLogActivities::class);
    $expectedMethods = [
        'getActivities',
        'restoreActivity',
        'canRestoreActivity',
        'getBreadcrumb',
        'getTitle',
        'getFieldLabel',
    ];

    foreach ($expectedMethods as $method) {
        Assert::assertTrue($reflection->hasMethod($method), "Missing method: {$method}");
    }
});

test('list log activities pagination mode returns default', function (): void {
    $page = makeListLogActivitiesPage();

    Assert::assertSame(PaginationMode::Default, $page->getPaginationMode());
});

test('list log activities view is correct', function (): void {
    $reflection = new \ReflectionClass(ListLogActivities::class);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    $page = makeListLogActivitiesPage();

    Assert::assertSame('activity::filament.pages.list-log-activities', $property->getValue($page));
});
