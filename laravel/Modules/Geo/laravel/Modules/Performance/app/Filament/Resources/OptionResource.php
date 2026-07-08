<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Performance\Models\Option;
use Modules\Ptv\Filament\Resources\BaseOptionResource;

class OptionResource extends BaseOptionResource
{
    protected static ?string $model = Option::class;
}
