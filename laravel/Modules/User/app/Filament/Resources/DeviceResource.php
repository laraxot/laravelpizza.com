<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\User\Models\Device;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DeviceResource extends XotBaseResource
{
    protected static ?string $model = Device::class;

    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'uuid' => TextInput::make('uuid')->maxLength(255),
            'mobile_id' => TextInput::make('mobile_id')
                ->maxLength(255),
            'languages' => TagsInput::make('languages')
                ->suggestions([
                    'it' => 'Italiano',
                    'en' => 'English',
                    'es' => 'Español',
                    'fr' => 'Français',
                    'de' => 'Deutsch',
                ])
                ->separator(',')
                ->reorderable(),
            'device' => TextInput::make('device')->maxLength(255),
            'platform' => TextInput::make('platform')->maxLength(255),
            'browser' => TextInput::make('browser')->maxLength(255),
            'version' => TextInput::make('version')->maxLength(255),
            'is_robot' => Toggle::make('is_robot'),
            'robot' => TextInput::make('robot')
                ->maxLength(255)
                ->visible(fn (callable $get) => $get('is_robot')),
            'is_desktop' => Toggle::make('is_desktop'),
            'is_mobile' => Toggle::make('is_mobile'),
            'is_tablet' => Toggle::make('is_tablet'),
            'is_phone' => Toggle::make('is_phone'),
        ];
    }
}
