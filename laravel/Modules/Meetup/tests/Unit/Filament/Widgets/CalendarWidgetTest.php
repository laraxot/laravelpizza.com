<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Widgets;

use Modules\Meetup\Filament\Widgets\CalendarWidget;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate calendar widget', function () {
    $widget = new CalendarWidget();
    expect($widget)->toBeInstanceOf(CalendarWidget::class);
});

test('it can fetch events', function () {
    $event = Event::factory()->create([
        'start_date' => now()->startOfMonth(),
        'end_date' => now()->startOfMonth()->addHour(),
    ]);
    
    $widget = new CalendarWidget();
    $events = $widget->fetchEvents([
        'start' => now()->startOfMonth()->toDateTimeString(),
        'end' => now()->endOfMonth()->toDateTimeString(),
    ]);
    
    expect($events)->toBeArray()
        ->and(count($events))->toBeGreaterThan(0);
});
