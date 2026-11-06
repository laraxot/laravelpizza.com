<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Modules\Cms\Models\Section;
use Modules\Lang\Filament\Resources\LangBaseResource;

class SectionResource extends LangBaseResource
{
    protected static ?string $model = Section::class;
}
