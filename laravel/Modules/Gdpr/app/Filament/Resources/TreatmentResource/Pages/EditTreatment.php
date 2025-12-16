<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Pages;

use Modules\Gdpr\Filament\Resources\TreatmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditTreatment extends XotBaseEditRecord
{
    protected static string $resource = TreatmentResource::class;
}
