<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Modules\IndennitaResponsabilita\Models\MyLog;
use Modules\Ptv\Filament\Resources\BaseMyLogResource;

class MyLogResource extends BaseMyLogResource
{
    protected static ?string $model = MyLog::class;
}
