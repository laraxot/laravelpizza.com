<?php

/**
 * --.
 */
declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Resources\TenantResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewTenant extends XotBaseViewRecord
{
    protected static string $resource = TenantResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public function getInfolistSchema(): array
    {
        return [
            'tenant_info' => Section::make()->schema([
                'id' => TextEntry::make('id'),
                'name' => TextEntry::make('name'),
                'slug' => TextEntry::make('slug'),
                'created_at' => TextEntry::make('created_at')->dateTime(),
                'updated_at' => TextEntry::make('updated_at')->dateTime(),
            ]),
        ];
    }
}
