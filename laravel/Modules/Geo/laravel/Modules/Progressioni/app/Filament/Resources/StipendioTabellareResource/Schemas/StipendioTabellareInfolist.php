<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\StipendioTabellareResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class StipendioTabellareInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'ente' => TextEntry::make('ente'),
            'matr' => TextEntry::make('matr'),
            'cognome' => TextEntry::make('cognome'),
            'nome' => TextEntry::make('nome'),
            'stabi' => TextEntry::make('stabi'),
            'stabi_txt' => TextEntry::make('stabi_txt'),
            'repar' => TextEntry::make('repar'),
            'repar_txt' => TextEntry::make('repar_txt'),
            'qua2kd' => TextEntry::make('qua2kd'),
            'qua2ka' => TextEntry::make('qua2ka'),
            'propro' => TextEntry::make('propro'),
            'posfun' => TextEntry::make('posfun')
                ->dateTime(),
            'categoria_eco' => TextEntry::make('categoria_eco'),
            'posiz' => TextEntry::make('posiz'),
            'posiz_txt' => TextEntry::make('posiz_txt'),
            'disci1' => TextEntry::make('disci1'),
            'disci1_txt' => TextEntry::make('disci1_txt'),
            'dal' => TextEntry::make('dal'),
            'al' => TextEntry::make('al'),
            'gg_no_asz' => TextEntry::make('gg_no_asz'),
            'gg_cateco_posfun_no_asz' => TextEntry::make('gg_cateco_posfun_no_asz'),
            'gg_cateco_no_posfun_no_asz' => TextEntry::make('gg_cateco_no_posfun_no_asz'),
            'gg_in_sede' => TextEntry::make('gg_in_sede'),
            'gg_fuori_sede' => TextEntry::make('gg_fuori_sede'),
            'gg_cateco_in_sede' => TextEntry::make('gg_cateco_in_sede'),
            'gg_cateco_fuori_sede' => TextEntry::make('gg_cateco_fuori_sede'),
            'gg_cateco_posfun_in_sede' => TextEntry::make('gg_cateco_posfun_in_sede'),
            'gg_cateco_posfun_fuori_sede' => TextEntry::make('gg_cateco_posfun_fuori_sede'),
            'gg_asz_in_sede' => TextEntry::make('gg_asz_in_sede'),
            'gg_asz_fuori_sede' => TextEntry::make('gg_asz_fuori_sede'),
            'gg_asz_cateco_in_sede' => TextEntry::make('gg_asz_cateco_in_sede'),
            'gg_asz_cateco_fuori_sede' => TextEntry::make('gg_asz_cateco_fuori_sede'),
            'gg_asz_cateco_posfun_in_sede' => TextEntry::make('gg_asz_cateco_posfun_in_sede'),
            'gg_asz_cateco_posfun_fuori_sede' => TextEntry::make('gg_asz_cateco_posfun_fuori_sede'),
            'cateco' => TextEntry::make('cateco')
                ->dateTime(),
            'importo' => TextEntry::make('importo')
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
