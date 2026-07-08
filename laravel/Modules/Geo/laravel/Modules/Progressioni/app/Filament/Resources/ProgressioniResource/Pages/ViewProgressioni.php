<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Modules\Progressioni\Filament\Resources\ProgressioniResource;
use Modules\Progressioni\Filament\Resources\ProgressioniResource\RelationManagers;

class ViewProgressioni extends ViewRecord
{
    protected static string $resource = ProgressioniResource::class;

    /* va in progressioniResource
    public function getRelations():array {

        return [
            RelationManagers\Qua00fRelationManager::class,
        ];
    }
    */
}
