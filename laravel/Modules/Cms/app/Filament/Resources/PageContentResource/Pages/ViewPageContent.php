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
            'edit' => EditAction::make(),
            'locale-switcher' => LocaleSwitcher::make(),
        ];
    }

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'page_content_info' => Section::make('Informazioni Page Content')->schema([
                'content_grid' => Grid::make(['default' => 2])->schema([
                    'name' => TextEntry::make('name'),
                    'slug' => TextEntry::make('slug'),
                ]),
            ]),
        ];
    }
}
