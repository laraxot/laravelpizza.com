<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\SnapshotResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SnapshotForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'model_type' => TextInput::make('model_type')
                ->required()
                ->maxLength(255),
            'model_id' => TextInput::make('model_id')
                ->numeric()
                ->required(),
            'state' => KeyValue::make('state')
                ->columnSpanFull(),
            'created_by_type' => TextInput::make('created_by_type')
                ->maxLength(255),
            'created_by_id' => TextInput::make('created_by_id')
                ->numeric(),
        ];
    }
}
