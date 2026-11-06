<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Pages;

use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListAttachments extends LangBaseListRecords
{
    public static string $resource = AttachmentResource::class;
}
