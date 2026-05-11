<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ActivityForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'log_name' => TextInput::make('log_name')
                ->required()
                ->maxLength(255),
            'description' => TextInput::make('description')
                ->required()
                ->maxLength(255),
            'subject_type' => TextInput::make('subject_type')
                ->required()
                ->maxLength(255),
            'subject_id' => TextInput::make('subject_id')
                ->numeric()
                ->required(),
            'causer_type' => TextInput::make('causer_type')
                ->maxLength(255),
            'causer_id' => TextInput::make('causer_id')
                ->numeric(),
            'properties' => KeyValue::make('properties')
                ->columnSpanFull(),
            'batch_uuid' => TextInput::make('batch_uuid')
                ->maxLength(36),
        ];
    }
}
