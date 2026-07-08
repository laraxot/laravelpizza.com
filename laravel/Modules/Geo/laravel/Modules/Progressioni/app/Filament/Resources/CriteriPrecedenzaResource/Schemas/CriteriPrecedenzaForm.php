<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CriteriPrecedenzaForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'parent_id' => TextInput::make('parent_id')->numeric(),
            'name' => TextInput::make('name')->required(),
            'order_direction' => Select::make('order_direction')
                ->options([
                    'asc' => 'Ascendente',
                    'desc' => 'Discendente',
                ])
                ->required(),
            'label' => TextInput::make('label'),
            'descr' => TextInput::make('descr'),
            'post_type' => TextInput::make('post_type'),
            'posizione' => TextInput::make('posizione')->numeric(),
            'anno' => TextInput::make('anno')->numeric(),
        ];
    }
}
