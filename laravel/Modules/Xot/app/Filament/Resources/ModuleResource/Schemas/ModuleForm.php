<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ModuleResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ModuleForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required(),
            'description' => TextInput::make('description'),
            'icon' => Select::make('icon')->options([]),
            'priority' => TextInput::make('priority'),
            'status' => Toggle::make('status'),
        ];
    }
}
