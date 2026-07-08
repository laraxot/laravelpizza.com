<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

use function Safe\date;

class IndividualeAssenzeForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'tipo' => TextInput::make('tipo')
                ->numeric(),
            'codice' => TextInput::make('codice')
                ->numeric(),
            'descr' => Textarea::make('descr')
                ->columnSpanFull(),
            'anno' => TextInput::make('anno')
                ->numeric()
                ->default(date('Y')),
            'created_by' => TextInput::make('created_by')
                ->maxLength(255)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),
            'updated_by' => TextInput::make('updated_by')
                ->maxLength(255)
                ->disabled()
                ->dehydrated(false),
            'deleted_by' => TextInput::make('deleted_by')
                ->maxLength(255)
                ->disabled()
                ->dehydrated(false),

        ];
    }
}
