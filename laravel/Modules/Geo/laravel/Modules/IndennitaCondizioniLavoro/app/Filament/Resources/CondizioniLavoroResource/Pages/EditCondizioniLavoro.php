<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource\Pages;

use Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCondizioniLavoro extends XotBaseEditRecord
{
    protected static string $resource = CondizioniLavoroResource::class;
}
