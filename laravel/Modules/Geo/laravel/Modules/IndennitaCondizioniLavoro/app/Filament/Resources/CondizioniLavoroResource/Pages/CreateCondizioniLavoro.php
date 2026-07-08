<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource;

class CreateCondizioniLavoro extends CreateRecord
{
    protected static string $resource = CondizioniLavoroResource::class;
}
