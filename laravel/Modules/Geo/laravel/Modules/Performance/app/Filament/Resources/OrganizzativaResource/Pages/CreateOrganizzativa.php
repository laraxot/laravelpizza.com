<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Pages;

use Modules\Performance\Filament\Resources\OrganizzativaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateOrganizzativa extends XotBaseCreateRecord
{
    protected static string $resource = OrganizzativaResource::class;
}
