<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriValutazioneResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

use function Safe\date;

class CriteriValutazioneForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
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
}
