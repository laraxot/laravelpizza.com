<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Pages;

use Modules\Rating\Filament\Resources\RatingResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

abstract class BaseListRatings extends XotBaseListRecords
{
    protected static string $resource = RatingResource::class;
}
