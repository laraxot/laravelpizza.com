<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Modules\Cms\Filament\Resources\PageResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;

class EditPage extends LangBaseEditRecord
{
    protected static string $resource = PageResource::class;
}
