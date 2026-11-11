<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;

use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * @see ActivityResource
 */
class ListActivities extends XotBaseListRecords
{
    protected static string $resource = ActivityResource::class;
}
