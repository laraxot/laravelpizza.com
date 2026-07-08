<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Pages\CreateIndividualeDecurtazioneAssenze;
use Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Pages\EditIndividualeDecurtazioneAssenze;
use Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Pages\ListIndividualeDecurtazioneAssenzes;
use Modules\Performance\Models\IndividualeDecurtazioneAssenze;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class IndividualeDecurtazioneAssenzeResource extends XotBaseResource
{
    protected static ?string $model = IndividualeDecurtazioneAssenze::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    /**
     * @return array<string, \Filament\Support\Components\Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'anno' => TextInput::make('anno')
                ->numeric(),
            'min_perc' => TextInput::make('min_perc')
                ->numeric(),
            'max_perc' => TextInput::make('max_perc')
                ->numeric(),
            'min_gg_365' => TextInput::make('min_gg_365')
                ->numeric(),
            'max_gg_365' => TextInput::make('max_gg_365')
                ->numeric(),
            'decurtazione_perc' => TextInput::make('decurtazione_perc')
                ->numeric(),

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'min_perc' => TextColumn::make('min_perc')
                ->numeric()
                ->sortable(),
            'max_perc' => TextColumn::make('max_perc')
                ->numeric()
                ->sortable(),
            'min_gg_365' => TextColumn::make('min_gg_365')
                ->numeric()
                ->sortable(),
            'max_gg_365' => TextColumn::make('max_gg_365')
                ->numeric()
                ->sortable(),
            'decurtazione_perc' => TextColumn::make('decurtazione_perc')
                ->numeric()
                ->sortable(),

        ];
    }

    /** @return array<int, \Filament\Tables\Filters\SelectFilter> */
    public function getTableFilters(): array
    {
        return [
            app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),

        ];
    }

    /** @return array<int, \Filament\Actions\EditAction> */
    public function getTableActions(): array
    {
        return [
            EditAction::make(),

        ];
    }

    /** @return array<int, \Filament\Actions\DeleteBulkAction> */
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
            'index' => ListIndividualeDecurtazioneAssenzes::route('/'),
            'create' => CreateIndividualeDecurtazioneAssenze::route('/create'),
            'edit' => EditIndividualeDecurtazioneAssenze::route('/{record}/edit'),
        ];
    }
}
