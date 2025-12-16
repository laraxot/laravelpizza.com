<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Pages;

use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateMenu extends XotBaseCreateRecord
{
    protected static string $resource = MenuResource::class;
}
