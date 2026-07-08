<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Pages\CreateIndividualeCatCoeff;
use Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Pages\EditIndividualeCatCoeff;
use Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Pages\ListIndividualeCatCoeffs;
use Modules\Performance\Models\IndividualeCatCoeff;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class IndividualeCatCoeffResource extends XotBaseResource
{
    protected static ?string $model = IndividualeCatCoeff::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    /**
     * @return array<string, \Filament\Support\Components\Component>
     */
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
                ->numeric()
                ->default(date('Y')),
            'created_by' => TextInput::make('created_by')
                ->maxLength(50)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),

        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListIndividualeCatCoeffs::route('/'),
            'create' => CreateIndividualeCatCoeff::route('/create'),
            'edit' => EditIndividualeCatCoeff::route('/{record}/edit'),
        ];
    }
}
