<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaCriteriResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class SchedaCriteriInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'criterio' => TextEntry::make('criterio'),
            'peso' => TextEntry::make('peso'),
            'descr' => TextEntry::make('descr')
                ->dateTime(),
            'is_editable' => TextEntry::make('is_editable'),
            'field_name' => TextEntry::make('field_name'),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'pos' => TextEntry::make('pos'),
            'converted_in' => TextEntry::make('converted_in'),
            'name' => TextEntry::make('name')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
