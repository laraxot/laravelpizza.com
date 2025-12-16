<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewPageContent extends XotBaseViewRecord
{
    // use Translatable; // Temporaneamente commentato per compatibilità Filament 4.x

    protected static string $resource = PageContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            LocaleSwitcher::make(),
        ];
    }

    /**
     * @return array<int, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            Section::make('Informazioni Page Content')->schema([
                Grid::make(['default' => 2])->schema([
                    TextEntry::make('name'),
                    TextEntry::make('slug'),
                ]),
            ]),
        ];
    }
}
