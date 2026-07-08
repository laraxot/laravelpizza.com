<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\DefaultActivityResource\Pages;

use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Incentivi\Filament\Resources\DefaultActivityResource;
use Modules\Incentivi\Filament\Resources\DefaultActivityResource\Actions\DefaultActivitiesSeederAction;
use Modules\Incentivi\Models\DefaultActivity;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListDefaultActivities extends XotBaseListRecords
{
    protected static string $resource = DefaultActivityResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        // Multiple @var tags removed - types inferred by Filament v4
        $actions = parent::getHeaderActions();
        $actions['default_activities_seeder'] = DefaultActivitiesSeederAction::make();

        return $actions;
    }

    public function getTabs(): array
    {
        return [
            'Lavori' => Tab::make()
                ->badge(DefaultActivity::query()->where('tipo', 'Lavori')->count())
                ->query(fn (Builder $query) => $query->where('tipo', 'Lavori')),
            'Servizi' => Tab::make()
                ->badge(DefaultActivity::query()->where('tipo', 'Servizi')->count())
                ->query(fn (Builder $query) => $query->where('tipo', 'Servizi')),
            'Misti' => Tab::make()
                ->badge(DefaultActivity::query()->where('tipo', 'Misti')->count())
                ->query(fn (Builder $query) => $query->where('tipo', 'Misti')),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'nome' => TextColumn::make('nome')
                ->limit(50)
                ->searchable(),
            'tipo' => TextColumn::make('tipo')
                ->searchable(),
            'appartiene_a_liquidazione_a_fasi' => IconColumn::make('appartiene_a_liquidazione_a_fasi')
                // ->label('A fasi?')
                ->boolean(),
            'liquidazione_fasi' => TextColumn::make('liquidazione_fasi')
                // ->label('Fasi')
                ->searchable(),
            'quota_percentuale' => TextColumn::make('quota_percentuale')
                ->searchable(),
            'importo' => TextColumn::make('importo')
                ->money('EUR')
                ->placeholder('DA ASSEGNARE'),
            'anno_competenza' => TextColumn::make('anno_competenza')
                ->searchable(),
        ];
    }

    // public function table(Table $table): Table
    // {
    //     return parent::table($table)->paginated(false);
    // }
}
