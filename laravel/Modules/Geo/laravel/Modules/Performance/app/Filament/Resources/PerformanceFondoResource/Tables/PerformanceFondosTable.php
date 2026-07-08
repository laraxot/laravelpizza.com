<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Actions\Table\IndividualeSpreadMoneyAction;
use Modules\Performance\Filament\Actions\Table\OrganizzativaSpreadMoneyAction;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class PerformanceFondosTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'quota_individuale' => TextColumn::make('quota_individuale')
                ->label('Quota Individuale')
                ->numeric()
                ->sortable(),
            'quota_organizzativa' => TextColumn::make('quota_organizzativa')
                ->label('Quota Organizzativa')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->label('Anno')
                ->numeric()
                ->sortable(),
            'note' => TextColumn::make('note')
                ->label('Note')
                ->searchable()
                ->sortable()
                ->wrap(),
            'created_at' => TextColumn::make('created_at')
                ->label('Data Creazione')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->label('Ultima Modifica')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_by' => TextColumn::make('created_by')
                ->label('Creato da')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_by' => TextColumn::make('updated_by')
                ->label('Modificato da')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }

    /**
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            ...parent::getTableActions(),
            'organizzativa' => OrganizzativaSpreadMoneyAction::make(),
            'individuale' => IndividualeSpreadMoneyAction::make(),
        ];
    }
}
