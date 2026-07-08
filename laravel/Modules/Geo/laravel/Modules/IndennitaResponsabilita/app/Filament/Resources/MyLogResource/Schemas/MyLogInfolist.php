<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MyLogResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MyLogInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'Dettagli Log' => TextEntry::make('Dettagli Log'),
            'id_tbl' => TextEntry::make('id_tbl')
                ->dateTime(),
            'tbl' => TextEntry::make('tbl')
                ->dateTime(),
            'obj' => TextEntry::make('obj')
                ->dateTime(),
            'act' => TextEntry::make('act')
                ->dateTime(),
            'note' => TextEntry::make('note')
                ->dateTime(),
            'data' => TextEntry::make('data'),
            'created_by' => TextEntry::make('created_by'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'id' => TextEntry::make('id')
                ->dateTime(),
        ];
    }
}
