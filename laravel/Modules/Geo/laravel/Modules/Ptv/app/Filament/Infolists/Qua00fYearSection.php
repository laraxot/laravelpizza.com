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

class Qua00fYearSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'qua00f_year';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            RepeatableEntry::make('qua00f_year')
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('matr'),
                    TextEntry::make('propro'),
                    TextEntry::make('posfun'),
                    TextEntry::make('posiz'),
                    TextEntry::make('qua2kd'),
                    TextEntry::make('qua2ka'),
                    // Components\TextEntry::make('quaann'),
                    // Components\TextEntry::make('gg'),
                    // Components\TextEntry::make('asz_txt')->,
                    // ->columnSpan(2),
                ])
                ->columns(11),
        ]);
    }
}
