<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Pages;

use Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateOrganizzativaAssenze extends XotBaseCreateRecord
{
    protected static string $resource = OrganizzativaAssenzeResource::class;
}
