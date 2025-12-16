<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;

    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            Section::make('Informazioni Location')
                ->schema([
                    TextEntry::make('name')->label('Nome'),
                    TextEntry::make('address')->label('Indirizzo'),
                    TextEntry::make('city')->label('Città'),
                    TextEntry::make('postal_code')->label('CAP'),
                    TextEntry::make('country')->label('Paese'),
                ])
                ->columns(2),
        ];
    }
}
