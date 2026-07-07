<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PersonalAccessTokenResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OauthAccessTokenInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name')
                ->dateTime(),
            'id' => TextEntry::make('id')
                ->dateTime(),
            'uuid' => TextEntry::make('uuid')
                ->dateTime(),
            'tokenable_type' => TextEntry::make('tokenable_type')
                ->dateTime(),
            'tokenable_id' => TextEntry::make('tokenable_id')
                ->dateTime(),
            'token' => TextEntry::make('token')
                ->dateTime(),
            'abilities' => TextEntry::make('abilities')
                ->dateTime(),
            'last_used_at' => TextEntry::make('last_used_at')
                ->dateTime(),
            'expires_at' => TextEntry::make('expires_at')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
            'deleted_at' => TextEntry::make('deleted_at')
                ->dateTime(),
            'updated_by' => TextEntry::make('updated_by'),
            'created_by' => TextEntry::make('created_by'),
            'deleted_by' => TextEntry::make('deleted_by'),
        ];
    }
}
