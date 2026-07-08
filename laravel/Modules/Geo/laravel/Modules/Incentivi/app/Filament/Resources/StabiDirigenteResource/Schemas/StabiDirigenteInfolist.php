<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\StabiDirigenteResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class StabiDirigenteInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'valutatore_id' => TextEntry::make('valutatore_id'),
            'stabi' => TextEntry::make('stabi'),
            'repar' => TextEntry::make('repar'),
            'nome_stabi' => TextEntry::make('nome_stabi'),
            'ente' => TextEntry::make('ente'),
            'matr' => TextEntry::make('matr'),
            'nome_diri' => TextEntry::make('nome_diri'),
            'nome_diri_plus' => TextEntry::make('nome_diri_plus'),
            'email' => TextEntry::make('email'),
            'anno' => TextEntry::make('anno'),
        ];
    }
}
