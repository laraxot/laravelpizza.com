<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriValutazioneResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CriteriValutazioneInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id_padre' => TextEntry::make('id_padre')
                ->dateTime(),
            'nome' => TextEntry::make('nome')
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
            'created_by' => TextEntry::make('created_by'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
