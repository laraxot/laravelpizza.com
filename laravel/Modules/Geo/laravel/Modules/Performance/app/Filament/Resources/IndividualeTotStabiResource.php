<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\IndividualeTotStabiResource\Pages\CreateIndividualeTotStabi;
use Modules\Performance\Filament\Resources\IndividualeTotStabiResource\Pages\EditIndividualeTotStabi;
use Modules\Performance\Filament\Resources\IndividualeTotStabiResource\Pages\ListIndividualeTotStabis;
use Modules\Performance\Models\IndividualeTotStabi;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class IndividualeTotStabiResource extends XotBaseResource
{
    protected static ?string $model = IndividualeTotStabi::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'stabi' => TextInput::make('stabi')
                ->numeric(),
            'tot_budget_assegnato' => TextInput::make('tot_budget_assegnato')
                ->numeric(),
            'tot_budget_assegnato_min_punteggio' => TextInput::make('tot_budget_assegnato_min_punteggio')
                ->numeric(),
            'tot_quota_effettiva' => TextInput::make('tot_quota_effettiva')
                ->numeric(),
            'tot_quota_effettiva_min_punteggio' => TextInput::make('tot_quota_effettiva_min_punteggio')
                ->numeric(),
            'tot_resti' => TextInput::make('tot_resti')
                ->numeric(),
            'tot_resti_min_punteggio' => TextInput::make('tot_resti_min_punteggio')
                ->numeric(),
            'delta' => TextInput::make('delta')
                ->numeric(),
            'delta_min_punteggio' => TextInput::make('delta_min_punteggio')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),
            'created_by' => TextInput::make('created_by')
                ->maxLength(191),
            'updated_by' => TextInput::make('updated_by')
                ->maxLength(191),
            'n_diritto' => TextInput::make('n_diritto')
                ->required()
                ->numeric(),
            'n_diritto_excellence' => TextInput::make('n_diritto_excellence')
                ->required()
                ->numeric(),

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'stabi' => TextColumn::make('stabi')
                ->numeric()
                ->sortable(),
            'tot_budget_assegnato' => TextColumn::make('tot_budget_assegnato')
                ->numeric()
                ->sortable(),
            'tot_budget_assegnato_min_punteggio' => TextColumn::make('tot_budget_assegnato_min_punteggio')
                ->numeric()
                ->sortable(),
            'tot_quota_effettiva' => TextColumn::make('tot_quota_effettiva')
                ->numeric()
                ->sortable(),
            'tot_quota_effettiva_min_punteggio' => TextColumn::make('tot_quota_effettiva_min_punteggio')
                ->numeric()
                ->sortable(),
            'tot_resti' => TextColumn::make('tot_resti')
                ->numeric()
                ->sortable(),
            'tot_resti_min_punteggio' => TextColumn::make('tot_resti_min_punteggio')
                ->numeric()
                ->sortable(),
            'delta' => TextColumn::make('delta')
                ->numeric()
                ->sortable(),
            'delta_min_punteggio' => TextColumn::make('delta_min_punteggio')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'n_diritto' => TextColumn::make('n_diritto')
                ->numeric()
                ->sortable(),
            'n_diritto_excellence' => TextColumn::make('n_diritto_excellence')
                ->numeric()
                ->sortable(),

        ];
    }

    /**
     * @return array<int, \Filament\Tables\Filters\SelectFilter>
     */
    public function getTableFilters(): array
    {
        return [
            app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),

        ];
    }

    /**
     * @return array<int, \Filament\Actions\EditAction>
     */
    public function getTableActions(): array
    {
        return [
            EditAction::make(),

        ];
    }

    /**
     * @return array<int, \Filament\Actions\DeleteBulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListIndividualeTotStabis::route('/'),
            'create' => CreateIndividualeTotStabi::route('/create'),
            'edit' => EditIndividualeTotStabi::route('/{record}/edit'),
        ];
    }
}
