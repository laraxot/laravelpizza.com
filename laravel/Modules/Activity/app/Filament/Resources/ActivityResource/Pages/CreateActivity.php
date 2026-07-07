<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;

use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateActivity extends XotBaseCreateRecord
{
    protected static string $resource = ActivityResource::class;
}
