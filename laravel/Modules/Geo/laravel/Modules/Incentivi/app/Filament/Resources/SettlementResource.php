<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Modules\Incentivi\Filament\Resources\SettlementResource\Pages\CreateSettlement;
use Modules\Incentivi\Filament\Resources\SettlementResource\Pages\EditSettlement;
use Modules\Incentivi\Filament\Resources\SettlementResource\Pages\ListSettlements;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class SettlementResource extends XotBaseResource
{
    protected static ?int $navigationSort = 4;

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'informazioni_section' => Section::make('Informazioni')
                ->schema([
                    TextInput::make('denominazione')
                        ->label('Denominazione')
                        ->required()
                        ->maxLength(255),
                    // Forms\Components\Select::make('tipologia')
                    //     ->label('Tipo di liquidazione')
                    //     ->options([
                    //         '1-fase' => '1° fase',
                    //         '2-fase' => '2° fase',
                    //         'unica' => 'Unica',
                    //     ])
                    //     ->required()
                    //     ->default('unica'),
                    TextInput::make('importo'),
                ])->columnSpan(1),
        ];
        // )->columns(3);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            // EmployeesRelationManager::class
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSettlements::route('/'),
            'create' => CreateSettlement::route('/create'),
            'edit' => EditSettlement::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
