<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class EsclusiExtraInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'ente' => TextEntry::make('ente')
                ->dateTime(),
            'matr' => TextEntry::make('matr')
                ->dateTime(),
            'cognome' => TextEntry::make('cognome')
                ->dateTime(),
            'nome' => TextEntry::make('nome')
                ->dateTime(),
            'motivo' => TextEntry::make('motivo')
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
