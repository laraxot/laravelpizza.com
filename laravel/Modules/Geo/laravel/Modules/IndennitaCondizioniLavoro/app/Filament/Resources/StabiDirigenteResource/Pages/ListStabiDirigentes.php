<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource\Pages;

use Override;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\Ptv\Filament\Actions\Header\ImportValutatoriAction;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\BaseListStabiDirigentes;

class ListStabiDirigentes extends BaseListStabiDirigentes
{
    protected static string $resource = StabiDirigenteResource::class;

    #[Override]
    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        /** @var array<string, \Filament\Tables\Columns\Column> $columns */
        $columns = parent::getTableColumns();
        $columns['quadrimestre'] = TextColumn::make('quadrimestre');

        return $columns;
    }

    #[Override]
    public function getTableFilters(): array
    {
        $fiters = parent::getTableFilters();
        $fiters['quadrimestre'] = SelectFilter::make('quadrimestre')
            ->options([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ])->query(static fn (Builder $query, array $data): Builder => $query->when($data['value'], fn (Builder $query, $quadrimestre) => $query->where('quadrimestre', $quadrimestre)));

        return $fiters;
    }


    /**
     * @return array<string, \Filament\Actions\Action|\Filament\Actions\ActionGroup>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        $actions = parent::getHeaderActions();
        $actions['import_valutatori_'] = ImportValutatoriAction::make('import_valutatori_')
            ->addFields([
                'anno' => TextInput::make('anno'),
                'quadrimestre' => TextInput::make('quadrimestre'),
            ])->setStabiDirigenteModel(StabiDirigente::class)
            ->setSchedaModel(CondizioniLavoro::class);

        return $actions;
    }
}
