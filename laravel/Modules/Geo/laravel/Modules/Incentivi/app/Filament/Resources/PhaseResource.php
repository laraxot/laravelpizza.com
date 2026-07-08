<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\Incentivi\Filament\Resources\PhaseResource\Pages;
use Modules\Incentivi\Filament\Resources\PhaseResource\Pages\CreatePhase;
use Modules\Incentivi\Filament\Resources\PhaseResource\Pages\EditPhase;
use Modules\Incentivi\Filament\Resources\PhaseResource\Pages\ListPhases;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class PhaseResource extends XotBaseResource
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Fasi';

    #[Override]
    public static function getFormSchema(): array
    {
        // Form schema types are inferred by Filament v4
        return [
            'informazioni_section' => Section::make('Informazioni')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    TextInput::make('description')
                        ->label('Descrizione')
                        ->required()
                        ->columnSpan(2),
                    DatePicker::make('start_date')
                        ->label('Data di inizio')
                        ->required(),
                    DatePicker::make('end_date')
                        ->label('Data di fine')
                        ->required(),

                ])->columns(4),
            'liquidazione_section' => Section::make('Liquidazione')
                ->relationship('settlement')
                ->schema([
                    TextInput::make('denominazione'),
                    TextInput::make('importo')
                        ->required()
                        ->numeric()
                        ->suffix('€'),
                ])->columns(2),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPhases::route('/'),
            'create' => CreatePhase::route('/create'),
            'edit' => EditPhase::route('/{record}/edit'),
            // 'settlement' => Pages\ManagePhaseSettlements::route('/{record}/settlement'),
        ];
    }
}
