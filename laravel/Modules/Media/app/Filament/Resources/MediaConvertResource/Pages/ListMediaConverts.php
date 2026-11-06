<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaConvertResource\Pages;

use Modules\Job\Filament\Widgets\ClockWidget;
use Modules\Media\Filament\Resources\MediaConvertResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMediaConverts extends XotBaseListRecords
{
    protected static string $resource = MediaConvertResource::class;

    /**
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
