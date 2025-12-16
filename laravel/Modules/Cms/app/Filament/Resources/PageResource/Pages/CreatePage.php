<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Modules\Cms\Filament\Resources\PageResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

/**
 * Summary of CreatePage.
 */
class CreatePage extends LangBaseCreateRecord
{
    protected static string $resource = PageResource::class;
}
