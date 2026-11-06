<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Modules\Cms\Models\Menu;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MenuResource extends XotBaseResource
{
    protected static ?string $model = Menu::class;
}
