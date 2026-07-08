<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class UploadInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'path' => TextEntry::make('path')
                ->dateTime(),
            'quadrimestre' => TextEntry::make('quadrimestre')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'note' => TextEntry::make('note')
                ->dateTime(),
            'id' => TextEntry::make('id')
                ->dateTime(),
            'user_id' => TextEntry::make('user_id')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'created_by' => TextEntry::make('created_by'),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
