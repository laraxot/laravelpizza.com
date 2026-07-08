<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\UserResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class UserInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'email' => TextEntry::make('email'),
            'password' => TextEntry::make('password'),
            'id' => TextEntry::make('id'),
        ];
    }
}
