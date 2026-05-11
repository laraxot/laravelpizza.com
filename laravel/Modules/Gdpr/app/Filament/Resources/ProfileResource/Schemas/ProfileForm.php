<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ProfileResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ProfileForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'type' => TextInput::make('type')->maxLength(255)->default(null),
            'first_name' => TextInput::make('first_name')->maxLength(191)->default(null),
            'last_name' => TextInput::make('last_name')->maxLength(191)->default(null),
            'full_name' => TextInput::make('full_name')->maxLength(191)->default(null),
            'email' => TextInput::make('email')
                ->email()
                ->maxLength(191)
                ->default(null),
            'user_id' => TextInput::make('user_id')->maxLength(36)->default(null),
            'updated_by' => TextInput::make('updated_by')->maxLength(36)->default(null),
            'created_by' => TextInput::make('created_by')->maxLength(36)->default(null),
            'deleted_by' => TextInput::make('deleted_by')->maxLength(36)->default(null),
            'is_active' => Toggle::make('is_active')->required(),
        ];
    }
}
