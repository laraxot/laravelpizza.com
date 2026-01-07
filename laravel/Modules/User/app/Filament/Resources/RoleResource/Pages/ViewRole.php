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
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'role_info' => Section::make()->schema([
                'id' => TextEntry::make('id'),
                'name' => TextEntry::make('name'),
                'guard_name' => TextEntry::make('guard_name'),
                'team_id' => TextEntry::make('team_id'),
                'uuid' => TextEntry::make('uuid'),
                'created_at' => TextEntry::make('created_at'),
                'updated_at' => TextEntry::make('updated_at'),
            ]),
        ];
    }
}
