<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\OptionResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OptionInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'option_type' => TextEntry::make('option_type'),
            'option_id' => TextEntry::make('option_id'),
            'parent_id' => TextEntry::make('parent_id'),
            'pos' => TextEntry::make('pos'),
            'name' => TextEntry::make('name'),
            'value' => TextEntry::make('value'),
            'txt' => TextEntry::make('txt'),
            'txt1' => TextEntry::make('txt1'),
            'year' => TextEntry::make('year'),
            'id' => TextEntry::make('id'),
        ];
    }
}
