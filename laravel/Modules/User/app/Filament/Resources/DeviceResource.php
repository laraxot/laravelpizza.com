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
            'uuid' => TextInput::make('uuid')->label(__('user::device.fields.uuid.label'))->maxLength(255),
            'mobile_id' => TextInput::make('mobile_id')
                ->label(__('user::device.fields.mobile_id.label'))
                ->maxLength(255),
            'languages' => TagsInput::make('languages')
                ->label(__('user::device.fields.languages.label'))
                ->suggestions([
                    'it' => 'Italiano',
                    'en' => 'English',
                    'es' => 'Español',
                    'fr' => 'Français',
                    'de' => 'Deutsch',
                ])
                ->placeholder(__('user::device.fields.languages.placeholder'))
                ->helperText(__('user::device.fields.languages.help'))
                ->separator(',')
                ->reorderable(),
            'device' => TextInput::make('device')->label(__('user::device.fields.device.label'))->maxLength(255),
            'platform' => TextInput::make('platform')->label(__('user::device.fields.platform.label'))->maxLength(255),
            'browser' => TextInput::make('browser')->label(__('user::device.fields.browser.label'))->maxLength(255),
            'version' => TextInput::make('version')->label(__('user::device.fields.version.label'))->maxLength(255),
            'is_robot' => Toggle::make('is_robot')->label(__('user::device.fields.is_robot.label')),
            'robot' => TextInput::make('robot')
                ->label(__('user::device.fields.robot.label'))
                ->maxLength(255)
                ->visible(fn (callable $get) => $get('is_robot')),
            'is_desktop' => Toggle::make('is_desktop')->label(__('user::device.fields.is_desktop.label')),
            'is_mobile' => Toggle::make('is_mobile')->label(__('user::device.fields.is_mobile.label')),
            'is_tablet' => Toggle::make('is_tablet')->label(__('user::device.fields.is_tablet.label')),
            'is_phone' => Toggle::make('is_phone')->label(__('user::device.fields.is_phone.label')),
        ];
    }
}
