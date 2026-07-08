<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Ptv\Filament\Infolists;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class WorkerSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'worker';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Grid::make(4)->schema([
                TextEntry::make('matr'),
                TextEntry::make('cognome'),
                TextEntry::make('nome'),
                TextEntry::make('email'),

            ]),
        ]);
    }
}
