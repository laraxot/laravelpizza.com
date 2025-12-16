<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaConvertResource\Pages;

use Modules\Media\Filament\Resources\MediaConvertResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateMediaConvert extends XotBaseCreateRecord
{
    protected static string $resource = MediaConvertResource::class;
}
