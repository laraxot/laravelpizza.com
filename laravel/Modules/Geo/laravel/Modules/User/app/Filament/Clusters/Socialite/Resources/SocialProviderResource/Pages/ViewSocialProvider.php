<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

use function Safe\json_encode;

class ViewSocialProvider extends XotBaseViewRecord
{
    protected static string $resource = SocialProviderResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'provider_info' => Section::make()->schema([
                'id' => TextEntry::make('id'),
                'name' => TextEntry::make('name'),
                'scopes' => TextEntry::make('scopes')->formatStateUsing(function ($state): string {
                    if (is_array($state)) {
                        return json_encode($state);
                    }

                    return is_string($state) ? $state : ((string) $state);
                }),
                'parameters' => TextEntry::make('parameters')->formatStateUsing(function ($state): string {
                    if (is_array($state)) {
                        return json_encode($state);
                    }

                    return is_string($state) ? $state : ((string) $state);
                }),
                'stateless' => TextEntry::make('stateless')->badge()->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                'active' => TextEntry::make('active')->badge()->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                'socialite' => TextEntry::make('socialite')->badge()->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                'svg' => TextEntry::make('svg')->html(),
                'created_at' => TextEntry::make('created_at'),
                'updated_at' => TextEntry::make('updated_at'),
            ]),
        ];
    }
}
