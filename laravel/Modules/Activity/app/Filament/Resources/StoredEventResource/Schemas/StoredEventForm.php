<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class StoredEventForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'event_class' => TextInput::make('event_class')->required()->maxLength(255),
            'event_properties' => KeyValue::make('event_properties')->columnSpanFull(),
            'aggregate_uuid' => TextInput::make('aggregate_uuid')->maxLength(36),
            'aggregate_version' => TextInput::make('aggregate_version')->numeric(),
            'meta_data' => Textarea::make('meta_data')->columnSpanFull(),
            'created_at' => DateTimePicker::make('created_at')->required(),
        ];
    }
}
