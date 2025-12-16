<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialProviderResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Resources\SocialProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

use function Safe\json_encode;

class ViewSocialProvider extends XotBaseViewRecord
{
    protected static string $resource = SocialProviderResource::class;

    /**
     * @return array<Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            Section::make()->schema([
                TextEntry::make('id'),
                TextEntry::make('name'),
                TextEntry::make('scopes')->formatStateUsing(function ($state): string {
                    if (is_array($state)) {
                        return json_encode($state);
                    }

                    return is_string($state) ? $state : ((string) $state);
                }),
                TextEntry::make('parameters')->formatStateUsing(function ($state): string {
                    if (is_array($state)) {
                        return json_encode($state);
                    }

                    return is_string($state) ? $state : ((string) $state);
                }),
                TextEntry::make('stateless')->badge()->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                TextEntry::make('active')->badge()->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                TextEntry::make('socialite')->badge()->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                TextEntry::make('svg')->html(),
                TextEntry::make('created_at'),
                TextEntry::make('updated_at'),
            ]),
        ];
    }
}
