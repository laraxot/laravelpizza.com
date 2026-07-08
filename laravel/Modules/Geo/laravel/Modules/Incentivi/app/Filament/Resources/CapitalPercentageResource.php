<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Incentivi\Enums\AmbitoIncentivo;
use Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Pages;
use Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Pages\ListCapitalPercentages;
use Modules\Incentivi\Models\CapitalPercentage;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class CapitalPercentageResource extends XotBaseResource
{
    protected static ?string $model = CapitalPercentage::class;

    protected static ?int $navigationSort = 6;

    /**
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'form' => Section::make('')
                ->schema([
                    'nome' => TextInput::make('nome')
                        ->required()
                        ->maxLength(255),
                    'descrizione' => TextInput::make('descrizione')
                        ->required()
                        ->maxLength(255),
                    'tipologia' => Select::make('tipologia')
                        ->options(AmbitoIncentivo::class)
                        ->required(),
                    'da' => TextInput::make('da')
                        ->required()
                        ->numeric(),
                    'a' => TextInput::make('a')
                        ->required()
                        ->numeric(),
                    'valore' => TextInput::make('valore')
                        ->required()
                        ->numeric()
                        ->suffix('%'),
                ])->columns(3),
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
            'index' => ListCapitalPercentages::route('/'),
            // 'create' => Pages\CreateCapitalPercentage::route('/create'),
            // 'edit' => Pages\EditCapitalPercentage::route('/{record}/edit'),
        ];
    }

    // public static function canView(): bool
    // {
    //    return auth()->user()->is_admin;
    // }
}
