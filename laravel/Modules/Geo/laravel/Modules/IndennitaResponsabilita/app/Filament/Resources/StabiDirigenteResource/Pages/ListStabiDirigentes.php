<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Modules\IndennitaResponsabilita\Filament\Resources\StabiDirigenteResource;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\StabiDirigente;
use Modules\Ptv\Filament\Actions\Header\ImportValutatoriAction;
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
        $actions = parent::getHeaderActions();
        $actions['import_valutatori_'] = ImportValutatoriAction::make('import_valutatori_')
            ->addFields([
                'anno' => TextInput::make('anno'),
                // 'quadrimestre' => TextInput::make('quadrimestre'),
            ])->setStabiDirigenteModel(StabiDirigente::class)
            ->setSchedaModel(IndennitaResponsabilita::class);

        return $actions;
    }
}
