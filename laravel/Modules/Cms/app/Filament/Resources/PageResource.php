<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Modules\Cms\Models\Page;
use Modules\Lang\Filament\Resources\LangBaseResource;

class PageResource extends LangBaseResource
{
    protected static ?string $model = Page::class;
}
