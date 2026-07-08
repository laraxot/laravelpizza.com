<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Ptv\Filament\Infolists;

use Filament\Infolists\Components;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class Asz00fSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'asz00f';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            RepeatableEntry::make('asz00f')
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('matr'),
                    TextEntry::make('asztip'),
                    TextEntry::make('aszcod'),
                    TextEntry::make('aszini'),
                    TextEntry::make('aszfin'),
                    TextEntry::make('asz2kd'),
                    TextEntry::make('asz2ka'),
                    TextEntry::make('aszumi'),
                    TextEntry::make('aszdur'),
                    // Components\TextEntry::make('aszann'),
                    // Components\TextEntry::make('asz_txt')->,
                    // ->columnSpan(2),
                ])
                ->columns(11),
        ]);
    }
}
