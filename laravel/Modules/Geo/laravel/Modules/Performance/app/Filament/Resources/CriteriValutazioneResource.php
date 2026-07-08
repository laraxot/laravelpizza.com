<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\Performance\Filament\Resources\CriteriValutazioneResource\Pages\CreateCriteriValutazione;
use Modules\Performance\Filament\Resources\CriteriValutazioneResource\Pages\EditCriteriValutazione;
use Modules\Performance\Filament\Resources\CriteriValutazioneResource\Pages\ListCriteriValutaziones;
use Modules\Performance\Models\CriteriValutazione;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class CriteriValutazioneResource extends XotBaseResource
{
    protected static ?string $model = CriteriValutazione::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'id_padre' => TextInput::make('id_padre')
                ->required()
                ->numeric()
                ->default(0),
            'nome' => TextInput::make('nome')
                ->required()
                ->maxLength(50),
            'label' => TextInput::make('label')
                ->required()
                ->maxLength(255),
            'descr' => TextInput::make('descr')
                ->maxLength(50),
            'post_type' => TextInput::make('post_type')
                ->required()
                ->maxLength(50),
            'posizione' => TextInput::make('posizione')
                ->required()
                ->numeric()
                ->default(0),
            'anno' => TextInput::make('anno')
                ->required()
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
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriValutaziones::route('/'),
            'create' => CreateCriteriValutazione::route('/create'),
            'edit' => EditCriteriValutazione::route('/{record}/edit'),
        ];
    }
}
