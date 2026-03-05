<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Widgets;

use Modules\Meetup\Filament\Widgets\EventsStats;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate events stats widget', function () {
    $widget = new EventsStats();
    expect($widget)->toBeInstanceOf(EventsStats::class);
});

test('it returns stats array', function () {
    $widget = new class extends EventsStats {
        public function getStatsForTest(): array
        {
            return $this->getStats();
        }
    };
    
    $stats = $widget->getStatsForTest();
    expect($stats)->toBeArray()
        ->and(count($stats))->toBe(3);
});
