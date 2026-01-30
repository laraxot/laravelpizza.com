<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\ChartResource\Pages;

use Modules\Chart\Filament\Resources\ChartResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateChart extends XotBaseCreateRecord
{
    protected static string $resource = ChartResource::class;
}
