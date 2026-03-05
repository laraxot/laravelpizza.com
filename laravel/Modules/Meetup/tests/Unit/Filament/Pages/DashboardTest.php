<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Pages;

use Modules\Meetup\Filament\Pages\MeetupDashboard;
use Modules\Meetup\Filament\Widgets\EventCalendarWidget;
use Modules\Meetup\Filament\Widgets\MeetupStatsOverviewWidget;
use Modules\Meetup\Filament\Widgets\RecentEventsWidget;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate meetup dashboard', function () {
    $page = new MeetupDashboard();
    expect($page)->toBeInstanceOf(MeetupDashboard::class);
});

test('it has correct widgets', function () {
    $page = new MeetupDashboard();
    $widgets = $page->getWidgets();
    
    expect($widgets)->toContain(MeetupStatsOverviewWidget::class)
        ->and($widgets)->toContain(EventCalendarWidget::class)
        ->and($widgets)->toContain(RecentEventsWidget::class);
});

test('it has correct columns', function () {
    $page = new MeetupDashboard();
    expect($page->getColumns())->toBe(1);
});
