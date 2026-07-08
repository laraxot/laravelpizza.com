<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages\CreateCriteriOption;
use Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages\EditCriteriOption;
use Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages\ListCriteriOptions;
use Modules\Ptv\Models\CriteriOption;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

abstract class BaseCriteriOptionResource extends XotBaseResource
{
    protected static ?string $model = CriteriOption::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->label('Nome')
                ->required()
                ->maxLength(50),
            'value' => TextInput::make('value')
                ->label('Valore')
                ->required()
                ->maxLength(50),
            'anno' => TextInput::make('anno')
                ->label('Anno')
                ->required()
                ->numeric()
                ->default(date('Y')),
            'created_by' => TextInput::make('created_by')
                ->label('Creato da')
                ->maxLength(50)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriOptions::route('/'),
            'create' => CreateCriteriOption::route('/create'),
            'edit' => EditCriteriOption::route('/{record}/edit'),
        ];
    }
}
