<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Illuminate\Support\Facades\Auth;
use Modules\Performance\Filament\Actions\Header\CopyFromOrganizzativaAction;
use Modules\Performance\Filament\Resources\IndividualeResource;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\ListScheda;

/**
 * ---.
 */
class ListIndividuales extends ListScheda
{
    protected static string $resource = IndividualeResource::class;

    // @var array<string, mixed> 
    //protected array $data = [];

    /**
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            'copy_from_organizzativa' => CopyFromOrganizzativaAction::make('copy_from_organizzativa')
            //->visible(fn (): bool => Auth::user()->isSuperAdmin()),
        ];
    }
}
