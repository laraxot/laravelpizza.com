<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;

use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewActivity extends XotBaseViewRecord
{
    protected static string $resource = ActivityResource::class;
}
