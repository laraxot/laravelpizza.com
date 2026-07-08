<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CriteriPrecedenzaInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'parent_id' => TextEntry::make('parent_id')
                ->dateTime(),
            'name' => TextEntry::make('name')
                ->dateTime(),
            'order_direction' => TextEntry::make('order_direction')
                ->dateTime(),
            'label' => TextEntry::make('label')
                ->dateTime(),
            'descr' => TextEntry::make('descr')
                ->dateTime(),
            'post_type' => TextEntry::make('post_type')
                ->dateTime(),
            'posizione' => TextEntry::make('posizione')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
