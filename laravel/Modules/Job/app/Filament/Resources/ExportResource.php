<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Modules\Job\Models\Export;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ExportResource extends XotBaseResource
{
    protected static ?string $model = Export::class;
}
