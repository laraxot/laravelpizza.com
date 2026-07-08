<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IndividualeCatCoeffInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'lista_propro' => TextEntry::make('lista_propro')
                ->dateTime(),
            'coeff' => TextEntry::make('coeff')
                ->dateTime(),
            'descr' => TextEntry::make('descr')
                ->dateTime(),
            'tot_giorni' => TextEntry::make('tot_giorni')
                ->dateTime(),
            'tot_giorni_pt' => TextEntry::make('tot_giorni_pt')
                ->dateTime(),
            'tot_giorni_pt_coeff' => TextEntry::make('tot_giorni_pt_coeff')
                ->dateTime(),
            'quota_teorica' => TextEntry::make('quota_teorica')
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
