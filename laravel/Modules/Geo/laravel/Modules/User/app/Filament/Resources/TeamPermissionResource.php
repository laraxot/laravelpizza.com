<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Modules\User\Models\TeamPermission;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TeamPermissionResource extends XotBaseResource
{
    protected static ?string $model = TeamPermission::class;

    /**
     * Get the form schema for the resource (XotBaseResource pattern).
     *
     * @return array<string, Field|Section>
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
