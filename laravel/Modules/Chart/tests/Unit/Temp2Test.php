<?php

declare(strict_types=1);

uses(\Modules\Chart\Tests\TestCase::class);

use Modules\Chart\Models\Chart;

test('chart model can be created with factory', function () {
    $chart = Chart::factory()->make([  // Using make() instead of create() to avoid DB
        'type' => 'bar1',
        'width' => 800,
        'height' => 600,
        'color' => '#ff0000',
        'bg_color' => '#ffffff',
    ]);
    expect($chart)->toBeInstanceOf(Chart::class)
        ->and($chart->type)->toBeString();
});