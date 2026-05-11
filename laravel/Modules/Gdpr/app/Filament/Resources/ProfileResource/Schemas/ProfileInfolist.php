<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ProfileResource\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ProfileInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'type' => TextEntry::make('type'),
            'full_name' => TextEntry::make('full_name'),
            'email' => TextEntry::make('email'),
            'user_id' => TextEntry::make('user_id'),
            'is_active' => IconEntry::make('is_active')->boolean(),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
