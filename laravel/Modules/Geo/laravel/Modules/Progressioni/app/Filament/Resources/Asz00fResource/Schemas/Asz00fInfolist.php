<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\Asz00fResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class Asz00fInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'ente' => TextEntry::make('ente'),
            'matr' => TextEntry::make('matr'),
            'asztip' => TextEntry::make('asztip'),
            'aszcod' => TextEntry::make('aszcod'),
            'aszdal' => TextEntry::make('aszdal'),
            'aszal' => TextEntry::make('aszal'),
            'aszumi' => TextEntry::make('aszumi'),
            'aszdur' => TextEntry::make('aszdur'),
            'aszpes' => TextEntry::make('aszpes'),
            'asz2kd' => TextEntry::make('asz2kd'),
            'asz2ka' => TextEntry::make('asz2ka'),
            'aszann' => TextEntry::make('aszann'),
        ];
    }
}
