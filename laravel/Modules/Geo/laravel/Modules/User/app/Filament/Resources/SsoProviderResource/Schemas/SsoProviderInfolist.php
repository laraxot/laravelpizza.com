<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SsoProviderResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class SsoProviderInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model SsoProvider.php -> id, name, display_name, type, entity_id, client_id, redirect_url, metadata_url, scopes, is_active, settings
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'name' => TextEntry::make('name'),
            'display_name' => TextEntry::make('display_name'),
            'type' => TextEntry::make('type'),
            'entity_id' => TextEntry::make('entity_id'),
            'client_id' => TextEntry::make('client_id'),
            'redirect_url' => TextEntry::make('redirect_url'),
            'metadata_url' => TextEntry::make('metadata_url'),
            'scopes' => TextEntry::make('scopes'),
            'is_active' => TextEntry::make('is_active')
                ->badge(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
