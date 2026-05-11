<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialProviderResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class SocialProviderInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model SocialProvider.php -> id, name, scopes, parameters, stateless, active, socialite, svg
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'name' => TextEntry::make('name'),
            'scopes' => TextEntry::make('scopes'),
            'parameters' => TextEntry::make('parameters'),
            'stateless' => TextEntry::make('stateless')
                ->badge(),
            'active' => TextEntry::make('active')
                ->badge(),
            'socialite' => TextEntry::make('socialite')
                ->badge(),
            'svg' => TextEntry::make('svg'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
