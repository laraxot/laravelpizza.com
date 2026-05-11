<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Schemas;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ClientForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        $components = [
            'name' => TextInput::make('name')
                ->unique('clients', 'name')
                ->required()
                ->maxLength(255),
            'user_id' => XotBaseSelect::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
            'redirect' => TextInput::make('redirect')
                ->required()
                ->maxLength(255),
            'secret' => TextInput::make('secret')
                ->maxLength(100),
            'provider' => TextInput::make('provider'),
            'personal_access_client' => Toggle::make('personal_access_client'),
            'password_client' => Toggle::make('password_client'),
            'revoked' => Toggle::make('revoked'),
        ];

        /*
         * merge getResourceFormComponents if enabled
         */
        if (static::isResourceFormComponentsEnabled()) {
            $additionalComponents = static::getResourceFormComponents();
            /** @var array<string, Field> $additionalComponents */
            /** @var array<string, Field> $components */
            $components = array_merge($components, $additionalComponents);
        }

        /* @var array<string, Field> $components */
        return $components;
    }

    protected static function isResourceFormComponentsEnabled(): bool
    {
        return false;
    }

    protected static function getResourceFormComponents(): array
    {
        return [];
    }
}
