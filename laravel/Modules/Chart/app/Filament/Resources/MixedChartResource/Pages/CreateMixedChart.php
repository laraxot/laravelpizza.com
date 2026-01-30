<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\MixedChartResource\Pages;

use Modules\Chart\Filament\Resources\MixedChartResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateMixedChart extends XotBaseCreateRecord
{
    protected static string $resource = MixedChartResource::class;
}
