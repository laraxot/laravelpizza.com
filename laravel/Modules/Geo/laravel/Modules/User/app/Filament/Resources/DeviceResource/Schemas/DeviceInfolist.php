<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\DeviceResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class DeviceInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model Device.php -> id, uuid, mobile_id, name, type, device, platform, browser, version, is_robot, robot, is_desktop, is_mobile, is_tablet, is_phone, languages
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'uuid' => TextEntry::make('uuid'),
            'mobile_id' => TextEntry::make('mobile_id'),
            'name' => TextEntry::make('name'),
            'type' => TextEntry::make('type'),
            'device' => TextEntry::make('device'),
            'platform' => TextEntry::make('platform'),
            'browser' => TextEntry::make('browser'),
            'version' => TextEntry::make('version'),
            'is_robot' => TextEntry::make('is_robot')
                ->badge(),
            'robot' => TextEntry::make('robot'),
            'is_desktop' => TextEntry::make('is_desktop')
                ->badge(),
            'is_mobile' => TextEntry::make('is_mobile')
                ->badge(),
            'is_tablet' => TextEntry::make('is_tablet')
                ->badge(),
            'is_phone' => TextEntry::make('is_phone')
                ->badge(),
            'languages' => TextEntry::make('languages'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
