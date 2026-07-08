<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Pages;

use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\Incentivi\Filament\Resources\CapitalPercentageResource;
use Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Actions\CapitalPercentageSeederAction;
use Modules\Incentivi\Models\CapitalPercentage;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListCapitalPercentages extends XotBaseListRecords
{
    protected static string $resource = CapitalPercentageResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        // Multiple @var tags removed - types inferred by Filament v4
        $parentActions = parent::getHeaderActions();
        $parentActions['capital_percentage_seeder'] = CapitalPercentageSeederAction::make('Carica Percentuali Fondo');

        return $parentActions;
    }

    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'nome' => TextColumn::make('nome')
                ->searchable(),
            'descrizione' => TextColumn::make('descrizione')
                ->searchable(),
            'tipologia' => TextColumn::make('tipologia')
                ->searchable(),
            'da' => TextColumn::make('da')
                ->money('EUR'),
            'a' => TextColumn::make('a')
                ->money('EUR'),
            'valore' => TextColumn::make('valore')
                ->numeric()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Lavori' => Tab::make()
                ->badge(CapitalPercentage::query()->where('tipologia', 'Lavori')->count())
                ->query(fn (Builder $query) => $query->where('tipologia', 'Lavori')),
            'Servizi' => Tab::make()
                ->badge(CapitalPercentage::query()->where('tipologia', 'Servizi')->count())
                ->query(fn (Builder $query) => $query->where('tipologia', 'Servizi')),
            'Misti' => Tab::make()
                ->badge(CapitalPercentage::query()->where('tipologia', 'Misti')->count())
                ->query(fn (Builder $query) => $query->where('tipologia', 'Misti')),
        ];
    }
}
