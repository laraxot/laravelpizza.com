<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class RoleForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'guard_name' => TextInput::make('guard_name')->required()->maxLength(255),
            'enabled' => Toggle::make('enabled')->required(),
        ];
    }
}
