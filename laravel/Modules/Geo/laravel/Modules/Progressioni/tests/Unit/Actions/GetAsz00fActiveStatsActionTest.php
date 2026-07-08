<?php

declare(strict_types=1);

use Modules\Progressioni\Datas\Asz00fActiveStatsData;

test('Asz00fActiveStatsData holds count and date extremes', function () {
    $data = new Asz00fActiveStatsData(
        activeCount: 42,
        lowestAsz2kd: [20200101, 20200201, 20200301],
        highestAsz2ka: [20251231, 20251130],
    );

    expect($data->activeCount)->toBe(42)
        ->and($data->lowestAsz2kd)->toHaveCount(3)
        ->and($data->highestAsz2ka)->toHaveCount(2);
});
