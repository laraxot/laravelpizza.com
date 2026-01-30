<?php

declare(strict_types=1);

uses(\Modules\Chart\Tests\TestCase::class);

use Modules\Chart\Models\Chart;

test('chart model can be instantiated', function () {
    $chart = new Chart();
    expect($chart)->toBeInstanceOf(Chart::class);
});