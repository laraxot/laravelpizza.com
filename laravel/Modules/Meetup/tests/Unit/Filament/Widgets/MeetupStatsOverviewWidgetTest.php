<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Widgets;

use Modules\Meetup\Filament\Widgets\MeetupStatsOverviewWidget;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate meetup stats overview widget', function () {
    $widget = new MeetupStatsOverviewWidget();
    expect($widget)->toBeInstanceOf(MeetupStatsOverviewWidget::class);
});

test('it returns stats array', function () {
    $widget = new class extends MeetupStatsOverviewWidget {
        public function getStatsForTest(): array
        {
            return $this->getStats();
        }
    };
    
    $stats = $widget->getStatsForTest();
    expect($stats)->toBeArray()
        ->and(count($stats))->toBe(3);
});
