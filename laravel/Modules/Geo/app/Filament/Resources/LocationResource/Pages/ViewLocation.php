<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    /**
     * @return array<int, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            Section::make('Informazioni Location')->schema([
                Grid::make(['default' => 2])->schema([
                    TextEntry::make('name'),
                    TextEntry::make('formatted_address'),
                    TextEntry::make('street'),
                    TextEntry::make('city'),
                    TextEntry::make('state'),
                    TextEntry::make('zip'),
                    TextEntry::make('lat'),
                    TextEntry::make('lng'),
                ]),
            ]),
        ];
    }
}
