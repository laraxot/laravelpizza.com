<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Ptv\Filament\Infolists;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class RepSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'rep';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Grid::make(4)->schema([
                TextEntry::make('stabi'),
                TextEntry::make('stabi_txt'),
                TextEntry::make('repar'),
                TextEntry::make('repar_txt'),
            ]),
        ]);
    }
}
