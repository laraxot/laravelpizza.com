<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Modules\Cms\Models\PageContent;
use Modules\Lang\Filament\Resources\LangBaseResource;

class PageContentResource extends LangBaseResource
{
    protected static ?string $model = PageContent::class;
}
