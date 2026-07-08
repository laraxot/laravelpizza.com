<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Pages\CreateCriteriMaggiorazione;
use Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Pages\EditCriteriMaggiorazione;
use Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Pages\ListCriteriMaggioraziones;
use Modules\Performance\Models\CriteriMaggiorazione;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class CriteriMaggiorazioneResource extends XotBaseResource
{
    protected static ?string $model = CriteriMaggiorazione::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'anno' => TextInput::make('anno')

                ->required()
                ->numeric()
                ->default(date('Y')),
            'min_valutaz_perf_ind' => TextInput::make('min_valutaz_perf_ind')

                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->step(0.01),
            'maggiorazione_perc' => TextInput::make('maggiorazione_perc')

                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->step(0.01)
                ->suffix('%'),
            'created_by' => TextInput::make('created_by')

                ->maxLength(50)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriMaggioraziones::route('/'),
            'create' => CreateCriteriMaggiorazione::route('/create'),
            'edit' => EditCriteriMaggiorazione::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'anno' => TextColumn::make('anno')

                ->sortable()
                ->searchable(),
            'min_valutaz_perf_ind' => TextColumn::make('min_valutaz_perf_ind')

                ->numeric()
                ->sortable(),
            'maggiorazione_perc' => TextColumn::make('maggiorazione_perc')

                ->numeric()
                ->sortable()
                ->suffix('%'),
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
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
