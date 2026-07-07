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
<<<<<<< HEAD
     * @return array<int|string, Component>
=======
     * @return array<string, Component>
>>>>>>> 40b96bcd6 (.)
     */
    public static function getFormSchema(): array
    {
        return [
<<<<<<< HEAD
            'model_type' => TextInput::make('model_type')
                ->required()
                ->maxLength(255),
            'model_id' => TextInput::make('model_id')
=======
            'aggregate_uuid' => TextInput::make('aggregate_uuid')
                ->required()
                ->maxLength(36),
            'aggregate_version' => TextInput::make('aggregate_version')
>>>>>>> 40b96bcd6 (.)
                ->numeric()
                ->required(),
            'state' => KeyValue::make('state')
                ->columnSpanFull(),
<<<<<<< HEAD
            'created_by_type' => TextInput::make('created_by_type')
                ->maxLength(255),
            'created_by_id' => TextInput::make('created_by_id')
                ->numeric(),
=======
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
