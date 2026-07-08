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

class AssenzeSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'Assenze';
    }

    protected function setUp(): void
    {
        parent::setUp();

        // dddx([
        // 'getRecord'=>$this->getRecord(),
        // 'state'=>$this->getState(),
        // 'state' => $this->formatStateUsing(),
        //    'methods'=>get_class_methods($this),
        // ]);

        $this->schema([
            RepeatableEntry::make('assenze')->schema([
                // Components\TextEntry::make('id'),
                TextEntry::make('tipo'),
                TextEntry::make('codice'),
                TextEntry::make('descr'),
                // Components\TextEntry::make('anno'),
                TextEntry::make('umi'),
                // Components\TextEntry::make('dur'),
            ])
            // ->formatStateUsing(fn($record)=>dddx($record))
                ->columns(11),
        ]);
    }
}
