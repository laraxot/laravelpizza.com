<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CategoriaProproResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CategoriaProproInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'categoria' => TextEntry::make('categoria')
                ->dateTime(),
            'lista_propro' => TextEntry::make('lista_propro')
                ->dateTime(),
            'lista_propro_sup' => TextEntry::make('lista_propro_sup')
                ->dateTime(),
            'posti' => TextEntry::make('posti')
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
