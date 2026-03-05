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
    $page = new Dashboard();
    expect($page)->toBeInstanceOf(Dashboard::class);
});

test('it has correct widgets in dashboard', function () {
    $page = new Dashboard();
    $widgets = $page->getWidgets();
    
    expect($widgets)->toContain(MeetupStatsOverviewWidget::class)
        ->and($widgets)->toContain(EventCalendarWidget::class)
        ->and($widgets)->toContain(RecentEventsWidget::class);
});
