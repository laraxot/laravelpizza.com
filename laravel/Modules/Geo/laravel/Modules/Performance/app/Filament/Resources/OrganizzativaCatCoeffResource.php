<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages\CreateOrganizzativaCatCoeff;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages\EditOrganizzativaCatCoeff;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages\ListOrganizzativaCatCoeffs;
use Modules\Performance\Models\OrganizzativaCatCoeff;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class OrganizzativaCatCoeffResource extends XotBaseResource
{
    protected static ?string $model = OrganizzativaCatCoeff::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'lista_propro' => TextInput::make('lista_propro')
                ->maxLength(250),
            'coeff' => TextInput::make('coeff')
                ->numeric(),
            'descr' => Textarea::make('descr')
                ->columnSpanFull(),
            'tot_giorni' => TextInput::make('tot_giorni')
                ->numeric(),
            'tot_giorni_pt' => TextInput::make('tot_giorni_pt')
                ->numeric(),
            'tot_giorni_pt_coeff' => TextInput::make('tot_giorni_pt_coeff')
                ->numeric(),
            'quota_teorica' => TextInput::make('quota_teorica')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'lista_propro' => TextColumn::make('lista_propro')
                ->searchable(),
            'coeff' => TextColumn::make('coeff')
                ->numeric()
                ->sortable(),
            'tot_giorni' => TextColumn::make('tot_giorni')
                ->numeric()
                ->sortable(),
            'tot_giorni_pt' => TextColumn::make('tot_giorni_pt')
                ->numeric()
                ->sortable(),
            'tot_giorni_pt_coeff' => TextColumn::make('tot_giorni_pt_coeff')
                ->numeric()
                ->sortable(),
            'quota_teorica' => TextColumn::make('quota_teorica')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
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
            'index' => ListOrganizzativaCatCoeffs::route('/'),
            'create' => CreateOrganizzativaCatCoeff::route('/create'),
            'edit' => EditOrganizzativaCatCoeff::route('/{record}/edit'),
        ];
    }
}
