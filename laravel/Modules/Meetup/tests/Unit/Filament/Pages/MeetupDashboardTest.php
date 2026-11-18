<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Pages;

use Modules\Meetup\Filament\Pages\Dashboard;
use Modules\Meetup\Filament\Widgets\EventCalendarWidget;
use Modules\Meetup\Filament\Widgets\MeetupStatsOverviewWidget;
use Modules\Meetup\Filament\Widgets\RecentEventsWidget;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate dashboard', function () {
    $page = new Dashboard;
    expect($page)->toBeInstanceOf(Dashboard::class);
});

test('it has correct widgets in dashboard', function () {
    $page = new Dashboard;
    $widgets = $page->getWidgets();

    expect($widgets)->toContain(MeetupStatsOverviewWidget::class)
        ->and($widgets)->toContain(RecentEventsWidget::class)
        // Il calendario è ancora un segnaposto ("Event calendar will be displayed here"): fuori dalla dashboard finché non c'è.
        ->and($widgets)->not->toContain(EventCalendarWidget::class);
});

test('it returns the stats and the upcoming events, in this order', function () {
    $page = new Dashboard;

    expect($page->getWidgets())->toBe([
        MeetupStatsOverviewWidget::class,
        RecentEventsWidget::class,
    ]);
});
