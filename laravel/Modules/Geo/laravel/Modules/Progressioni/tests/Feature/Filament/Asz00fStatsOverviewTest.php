<?php

declare(strict_types=1);

use Modules\Progressioni\Actions\GetAsz00fActiveStatsAction;
use Modules\Progressioni\Datas\Asz00fActiveStatsData;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Widgets\Asz00fStatsOverview;
use Modules\Progressioni\Tests\TestCase;

uses(TestCase::class);

test('Asz00fStatsOverview exposes three stat cards from action', function () {
    $mock = Mockery::mock(GetAsz00fActiveStatsAction::class);
    $mock->shouldReceive('execute')->once()->andReturn(new Asz00fActiveStatsData(
        activeCount: 100,
        lowestAsz2kd: [20200101, 20200201],
        highestAsz2ka: [20251231, 20251130],
    ));
    app()->instance(GetAsz00fActiveStatsAction::class, $mock);

    $widget = new Asz00fStatsOverview;
    $method = new ReflectionMethod(Asz00fStatsOverview::class, 'getStats');
    $stats = $method->invoke($widget);

    expect($stats)->toHaveCount(3);
});
