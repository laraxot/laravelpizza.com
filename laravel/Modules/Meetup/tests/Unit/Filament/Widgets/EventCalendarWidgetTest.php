<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Widgets;

use Modules\Meetup\Filament\Widgets\EventCalendarWidget;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(TestCase::class, DatabaseTransactions::class);

test('it can instantiate event calendar widget', function () {
    $widget = new EventCalendarWidget();
    expect($widget)->toBeInstanceOf(EventCalendarWidget::class);
});

test('it can fetch events for calendar', function () {
    $title = 'Calendar Event '.uniqid();
    $event = Event::factory()->create([
        'title' => $title,
        'status' => 'published',
        'start_date' => now()->startOfMonth()->addDays(5),
    ]);
    
    $widget = new EventCalendarWidget();
    $events = $widget->fetchEvents([
        'start' => now()->startOfMonth()->toDateTimeString(),
        'end' => now()->endOfMonth()->toDateTimeString(),
    ]);
    $titles = array_column($events, 'title');
    
    expect($events)->toBeArray()
        ->and(count($events))->toBeGreaterThan(0)
        ->and(in_array($title, $titles, true))->toBeTrue();
});

test('it can handle date selection', function () {
    $widget = new EventCalendarWidget();
    $widget->onDateSelect(now()->toDateTimeString(), now()->addHour()->toDateTimeString(), false, [], []);
    
    $reflection = new \ReflectionClass($widget);
    $property = $reflection->getProperty('lastDateSelection');
    $property->setAccessible(true);
    
    $selection = $property->getValue($widget);
    expect($selection['allDay'])->toBeFalse();
});
