<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Pages;

use Modules\Media\Filament\Resources\TemporaryUploadResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListTemporaryUploads extends XotBaseListRecords
{
    protected static string $resource = TemporaryUploadResource::class;
}
