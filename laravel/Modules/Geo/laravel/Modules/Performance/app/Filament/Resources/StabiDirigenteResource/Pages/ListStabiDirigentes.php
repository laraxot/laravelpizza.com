<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Modules\Performance\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\BaseListStabiDirigentes;
use Override;

class ListStabiDirigentes extends BaseListStabiDirigentes
{
    protected static string $resource = StabiDirigenteResource::class;


     /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return parent::getHeaderActions();
    }
}
