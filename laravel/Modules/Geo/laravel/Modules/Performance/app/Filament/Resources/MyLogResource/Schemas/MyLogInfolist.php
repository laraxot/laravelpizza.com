<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\MyLogResource\Schemas;

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
            'id_tbl' => TextEntry::make('id_tbl')
                ->dateTime(),
            'tbl' => TextEntry::make('tbl')
                ->dateTime(),
            'id_approvaz' => TextEntry::make('id_approvaz')
                ->dateTime(),
            'note' => TextEntry::make('note')
                ->dateTime(),
            'data' => TextEntry::make('data')
                ->dateTime(),
            'datemod' => TextEntry::make('datemod')
                ->dateTime(),
            'handle' => TextEntry::make('handle')
                ->dateTime(),
            'created_by' => TextEntry::make('created_by'),
            'updated_by' => TextEntry::make('updated_by'),
            'id' => TextEntry::make('id')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
            'value' => TextEntry::make('value'),
        ];
    }
}
