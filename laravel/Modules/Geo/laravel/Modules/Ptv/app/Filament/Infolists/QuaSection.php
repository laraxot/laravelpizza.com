<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Ptv\Filament\Infolists;

use Filament\Infolists\Components;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class QuaSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'qua';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Grid::make(4)->schema([
                TextEntry::make('propro'),
                TextEntry::make('posfun'),

                TextEntry::make('categoria_eco'),
                TextEntry::make('posiz'),
                TextEntry::make('posiz_txt'),
                TextEntry::make('disci1'),
                TextEntry::make('disci1_txt'),
                // Components\TextEntry::make('categoria_ecoval'),
                // Components\TextEntry::make('posfunval'),
            ]),
        ]);
    }
}
