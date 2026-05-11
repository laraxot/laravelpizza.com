<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamPermissionResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TeamPermissionForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'section01' => Section::make([
                'team_id' => Select::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                'user_id' => Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                'permission' => TextInput::make('permission')
                    ->required()
                    ->maxLength(255),
            ]),
        ];
    }
}
