<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaCriteriResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Modules\Progressioni\Models\SchedaCriteri;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SchedaCriteriForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')
                ->disabled()
                ->dehydrated(false),

            'criterio' => Textarea::make('criterio')
                ->rows(3)
                ->maxLength(65535),

            'peso' => TextInput::make('peso')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->suffix('%')
                ->step(1),

            'descr' => Textarea::make('descr')
                ->rows(4)
                ->maxLength(65535),

            'is_editable' => Toggle::make('is_editable')
                ->default(true)
                ->inline(false),

            'field_name' => TextInput::make('field_name')
                ->maxLength(50),

            'anno' => TextInput::make('anno')
                ->numeric()
                ->minValue(2000)
                ->maxValue(2050)
                ->default(now()->year)
                ->step(1),

            'pos' => TextInput::make('pos')
                ->numeric()
                ->minValue(0)
                ->step(1)
                ->suffix('°'),

            'converted_in' => Select::make('converted_in')
                ->options(SchedaCriteri::$converted_in_opts)
                ->searchable()
                ->preload(),
        ];
    }
}
