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
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'aggregate_uuid' => TextInput::make('aggregate_uuid')
                ->required()
                ->maxLength(36),
            'aggregate_version' => TextInput::make('aggregate_version')
                ->numeric()
                ->required(),
            'state' => KeyValue::make('state')
                ->columnSpanFull(),
        ];
    }
}
