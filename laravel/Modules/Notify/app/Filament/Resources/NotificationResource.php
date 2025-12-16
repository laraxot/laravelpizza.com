<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Notify\Models\Notification;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class NotificationResource extends XotBaseResource
{
    protected static ?string $model = Notification::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'type' => TextInput::make('type')->required()->label('Notification Type'),
            'notifiable_type' => TextInput::make('notifiable_type')->required()->label('Notifiable Type'),
            'notifiable_id' => TextInput::make('notifiable_id')
                ->required()
                ->numeric()
                ->label('Notifiable ID'),
            'data' => Textarea::make('data')->label('Notification Data')->columnSpanFull(),
            'read_at' => DateTimePicker::make('read_at')->label('Read At')->nullable(),
            'created_by' => TextInput::make('created_by')->label('Created By')->disabled(),
            'updated_by' => TextInput::make('updated_by')->label('Updated By')->disabled(),
        ];
    }
}
