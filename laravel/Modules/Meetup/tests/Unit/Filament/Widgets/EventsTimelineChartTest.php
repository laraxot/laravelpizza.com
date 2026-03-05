<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Widgets;

use Modules\Meetup\Filament\Widgets\EventsTimelineChart;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate events timeline chart widget', function () {
    $widget = new EventsTimelineChart();
    expect($widget)->toBeInstanceOf(EventsTimelineChart::class);
});

test('it has correct type', function () {
    $widget = new class extends EventsTimelineChart {
        public function getTypeForTest(): string
        {
            return $this->getType();
        }
    };
    
    expect($widget->getTypeForTest())->toBe('line');
});

test('it returns data array', function () {
    $widget = new class extends EventsTimelineChart {
        public function getDataForTest(): array
        {
            return $this->getData();
        }
    };
    
    $data = $widget->getDataForTest();
    expect($data)->toBeArray()
        ->and(isset($data['datasets']))->toBeTrue()
        ->and(isset($data['labels']))->toBeTrue();
});
