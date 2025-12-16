<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Resources\RoleResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewRole extends XotBaseViewRecord
{
    protected static string $resource = RoleResource::class;

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
                TextEntry::make('guard_name'),
                TextEntry::make('team_id'),
                TextEntry::make('uuid'),
                TextEntry::make('created_at'),
                TextEntry::make('updated_at'),
            ]),
        ];
    }
}
