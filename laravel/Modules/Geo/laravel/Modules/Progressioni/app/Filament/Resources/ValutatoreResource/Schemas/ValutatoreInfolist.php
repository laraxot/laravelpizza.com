<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ValutatoreResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ValutatoreInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'stabi' => TextEntry::make('stabi')
                ->dateTime(),
            'repar' => TextEntry::make('repar')
                ->dateTime(),
            'nome_stabi' => TextEntry::make('nome_stabi')
                ->dateTime(),
            'stabi_txt' => TextEntry::make('stabi_txt')
                ->dateTime(),
            'repar_txt' => TextEntry::make('repar_txt')
                ->dateTime(),
            'ente' => TextEntry::make('ente')
                ->dateTime(),
            'matr' => TextEntry::make('matr')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'nome_diri' => TextEntry::make('nome_diri')
                ->dateTime(),
            'nome_diri_plus' => TextEntry::make('nome_diri_plus')
                ->dateTime(),
            'budget' => TextEntry::make('budget')
                ->dateTime(),
            'valutatore_id' => TextEntry::make('valutatore_id')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
