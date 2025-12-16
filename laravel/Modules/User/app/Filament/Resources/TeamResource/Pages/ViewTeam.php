<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Resources\TeamResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewTeam extends XotBaseViewRecord
{
    // //
    protected static string $resource = TeamResource::class;

    /**
     * @return array<Component>
     */
    #[\Override]
    public function getInfolistSchema(): array
    {
        return [
            Section::make()->schema([
                TextEntry::make('id'),
                TextEntry::make('name'),
                TextEntry::make('display_name'),
                TextEntry::make('description'),
                TextEntry::make('created_at'),
                TextEntry::make('updated_at'),
            ]),
        ];
    }
}
