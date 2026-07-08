<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ProgressioniInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'diritto' => TextEntry::make('diritto'),
            'refresh' => TextEntry::make('refresh'),
            'ha_diritto' => TextEntry::make('ha_diritto'),
            'motivo' => TextEntry::make('motivo'),
            'lavoratore' => TextEntry::make('lavoratore'),
            'matr' => TextEntry::make('matr'),
            'cognome' => TextEntry::make('cognome'),
            'nome' => TextEntry::make('nome'),
            'email' => TextEntry::make('email'),
            'qua' => TextEntry::make('qua'),
            'propro' => TextEntry::make('propro'),
            'posfun' => TextEntry::make('posfun'),
            'posiz' => TextEntry::make('posiz'),
            'posiz_txt' => TextEntry::make('posiz_txt'),
            'categoria_eco' => TextEntry::make('categoria_eco'),
            'categoria_ecoval' => TextEntry::make('categoria_ecoval'),
            'posfunval' => TextEntry::make('posfunval'),
            'disci1' => TextEntry::make('disci1'),
            'disci1_txt' => TextEntry::make('disci1_txt'),
            'rep' => TextEntry::make('rep'),
            'stabi' => TextEntry::make('stabi'),
            'stabi_txt' => TextEntry::make('stabi_txt'),
            'repar' => TextEntry::make('repar'),
            'repar_txt' => TextEntry::make('repar_txt'),
            'periodo' => TextEntry::make('periodo'),
            'dal' => TextEntry::make('dal'),
            'al' => TextEntry::make('al'),
            'anno' => TextEntry::make('anno'),
            'valutatore_id' => TextEntry::make('valutatore_id'),
            'excellences' => TextEntry::make('excellences'),
            'excellences_count_last_3_years' => TextEntry::make('excellences_count_last_3_years'),
            'performance' => TextEntry::make('performance'),
            'perf_ind_media' => TextEntry::make('perf_ind_media'),
            '_gg' => TextEntry::make('_gg'),
            'gg_cateco_in_sede' => TextEntry::make('gg_cateco_in_sede'),
            'gg_cateco_fuori_sede' => TextEntry::make('gg_cateco_fuori_sede'),
            'gg_cateco' => TextEntry::make('gg_cateco'),
            'gg_cateco_posfun_in_sede' => TextEntry::make('gg_cateco_posfun_in_sede'),
            'gg_cateco_posfun_fuori_sede' => TextEntry::make('gg_cateco_posfun_fuori_sede'),
            'gg_cateco_posfun' => TextEntry::make('gg_cateco_posfun'),
            'gg_cateco_posfun_no_asz_in_sede' => TextEntry::make('gg_cateco_posfun_no_asz_in_sede'),
            'gg_cateco_posfun_no_asz_fuori_sede' => TextEntry::make('gg_cateco_posfun_no_asz_fuori_sede'),
            'gg_asz_cateco_posfun_in_sede' => TextEntry::make('gg_asz_cateco_posfun_in_sede'),
            'gg_asz_cateco_posfun_fuori_sede' => TextEntry::make('gg_asz_cateco_posfun_fuori_sede'),
            'gg_cateco_posfun_no_asz' => TextEntry::make('gg_cateco_posfun_no_asz'),
            'gg_integ_params' => TextEntry::make('gg_integ_params'),
            'mail_sended_at' => TextEntry::make('mail_sended_at')
                ->dateTime(),
            'criteri' => TextEntry::make('criteri'),
            'gg' => TextEntry::make('gg'),
            'gg_no_asz' => TextEntry::make('gg_no_asz'),
            'gg_asz' => TextEntry::make('gg_asz'),
            'gg_cateco_no_posfun_no_asz' => TextEntry::make('gg_cateco_no_posfun_no_asz'),
            'eta' => TextEntry::make('eta'),
            'qualifica' => TextEntry::make('qualifica'),
            'reparto' => TextEntry::make('reparto'),
            'send-mail' => TextEntry::make('send-mail'),
            'zip-schede' => TextEntry::make('zip-schede'),
        ];
    }
}
