<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Ptv\Filament\Resources\SchedaResource\Schemas\BaseSchedaInfolist;

class SchedaInfolist extends BaseSchedaInfolist
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
            'matr' => TextEntry::make('matr')
                ->dateTime(),
            'cognome' => TextEntry::make('cognome')
                ->dateTime(),
            'nome' => TextEntry::make('nome')
                ->dateTime(),
            'stabi' => TextEntry::make('stabi')
                ->dateTime(),
            'stabi_txt' => TextEntry::make('stabi_txt')
                ->dateTime(),
            'repar' => TextEntry::make('repar')
                ->dateTime(),
            'repar_txt' => TextEntry::make('repar_txt')
                ->dateTime(),
            'qua2kd' => TextEntry::make('qua2kd'),
            'qua2ka' => TextEntry::make('qua2ka'),
            'propro' => TextEntry::make('propro')
                ->dateTime(),
            'posfun' => TextEntry::make('posfun')
                ->dateTime(),
            'categoria_eco' => TextEntry::make('categoria_eco')
                ->dateTime(),
            'posiz' => TextEntry::make('posiz')
                ->dateTime(),
            'posiz_txt' => TextEntry::make('posiz_txt')
                ->dateTime(),
            'disci1' => TextEntry::make('disci1')
                ->dateTime(),
            'disci1_txt' => TextEntry::make('disci1_txt')
                ->dateTime(),
            'dal' => TextEntry::make('dal')
                ->dateTime(),
            'al' => TextEntry::make('al')
                ->dateTime(),
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
            'lavoratore' => TextEntry::make('lavoratore')
                ->dateTime(),
            'email' => TextEntry::make('email')
                ->dateTime(),
            'ha_diritto' => TextEntry::make('ha_diritto')
                ->dateTime(),
            'motivo' => TextEntry::make('motivo')
                ->dateTime(),
            'qua' => TextEntry::make('qua')
                ->dateTime(),
            'categoria_ecoval' => TextEntry::make('categoria_ecoval')
                ->dateTime(),
            'posfunval' => TextEntry::make('posfunval')
                ->dateTime(),
            'rep' => TextEntry::make('rep')
                ->dateTime(),
            'periodo' => TextEntry::make('periodo')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
            'pdf' => TextEntry::make('pdf'),
        ];
    }
}
