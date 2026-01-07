<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SsoProviderResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Resources\SsoProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewSsoProvider extends XotBaseViewRecord
{
    protected static string $resource = SsoProviderResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'main' => Section::make()->schema([
                'name' => TextEntry::make('name'),
                'display_name' => TextEntry::make('display_name'),
                'type' => TextEntry::make('type'),
                'entity_id' => TextEntry::make('entity_id'),
                'client_id' => TextEntry::make('client_id'),
                'redirect_url' => TextEntry::make('redirect_url'),
                'metadata_url' => TextEntry::make('metadata_url'),
                'is_active' => TextEntry::make('is_active'),
                'created_at' => TextEntry::make('created_at')->dateTime(),
                'updated_at' => TextEntry::make('updated_at')->dateTime(),
            ]),
        ];
    }
}
