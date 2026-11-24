<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationLogResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Notify\Enums\ChannelEnum;
use Modules\Notify\Enums\NotificationLogStatusEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class NotificationLogForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'template_id' => Select::make('template_id')
                ->relationship('template', 'name')
                ->searchable()
                ->preload(),
            'notifiable_type' => TextInput::make('notifiable_type')
                ->maxLength(255),
            'notifiable_id' => TextInput::make('notifiable_id')
                ->maxLength(255),
            'channel' => Select::make('channel')
                ->options(ChannelEnum::class)
                ->required(),
            'status' => Select::make('status')
                ->options(NotificationLogStatusEnum::class)
                ->required(),
            'status_message' => Textarea::make('status_message')
                ->columnSpanFull(),
            'data' => KeyValue::make('data'),
            'metadata' => KeyValue::make('metadata'),
            'tenant_id' => TextInput::make('tenant_id')
                ->maxLength(255),
            'sent_at' => DateTimePicker::make('sent_at'),
            'delivered_at' => DateTimePicker::make('delivered_at'),
            'failed_at' => DateTimePicker::make('failed_at'),
            'opened_at' => DateTimePicker::make('opened_at'),
            'clicked_at' => DateTimePicker::make('clicked_at'),
        ];
    }
}
