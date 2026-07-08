<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ImportiCategoriaInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'Informazioni Principali' => TextEntry::make('Informazioni Principali'),
            'ente' => TextEntry::make('ente')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'categoria' => TextEntry::make('categoria')
                ->dateTime(),
            'lista_propro' => TextEntry::make('lista_propro')
                ->dateTime(),
            'min' => TextEntry::make('min')
                ->dateTime(),
            'max' => TextEntry::make('max')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
        ];
    }
}
