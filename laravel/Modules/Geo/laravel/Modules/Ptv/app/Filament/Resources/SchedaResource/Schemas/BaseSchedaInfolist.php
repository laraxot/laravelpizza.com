<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * Infolist scheda condiviso tra moduli che estendono BaseSchedaResource.
 *
 * Le classi concrete nel modulo figlio estendono questa base e sovrascrivono
 * getInfolistSchema() quando l'UI differisce (es. Progressioni).
 */
abstract class BaseSchedaInfolist extends XotBaseResourceInfolist
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
            'assenze' => TextEntry::make('assenze'),
            'gg_presenza_dalal' => TextEntry::make('gg_presenza_dalal'),
            'gg_assenza_dalal' => TextEntry::make('gg_assenza_dalal'),
            'hh_assenza_dalal' => TextEntry::make('hh_assenza_dalal'),
            'criteri' => TextEntry::make('criteri'),
            'type' => TextEntry::make('type'),
            'motivo/invio_email' => TextEntry::make('motivo/invio_email'),
            'mail_sended_at' => TextEntry::make('mail_sended_at')
                ->dateTime(),
            'totale_punteggio' => TextEntry::make('totale_punteggio'),
            'qualifica' => TextEntry::make('qualifica'),
            'reparto' => TextEntry::make('reparto'),
            'valutatore_id' => TextEntry::make('valutatore_id'),
            'anno_valutatore' => TextEntry::make('anno_valutatore'),
            'pdf' => TextEntry::make('pdf'),
            'send_mail' => TextEntry::make('send_mail'),
            'zip_schede' => TextEntry::make('zip_schede'),
        ];
    }
}
