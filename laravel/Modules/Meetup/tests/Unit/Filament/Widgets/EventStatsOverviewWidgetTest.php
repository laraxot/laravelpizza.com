<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Widgets;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Meetup\Filament\Widgets\EventStatsOverviewWidget;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate event stats overview widget', function () {
    $widget = new EventStatsOverviewWidget();
    expect($widget)->toBeInstanceOf(EventStatsOverviewWidget::class);
});

test('it returns stats array', function () {
    if (! Schema::connection('meetup')->hasTable('event_user')) {
        Schema::connection('meetup')->create('event_user', function (Blueprint $table): void {
            $table->id();
            $table->string('user_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->timestamps();
        });
    }

    $widget = new class extends EventStatsOverviewWidget {
        public function getStatsForTest(): array
        {
            return $this->getStats();
        }
    };
    
    $stats = $widget->getStatsForTest();
    expect($stats)->toBeArray()
        ->and(count($stats))->toBe(3);
});
