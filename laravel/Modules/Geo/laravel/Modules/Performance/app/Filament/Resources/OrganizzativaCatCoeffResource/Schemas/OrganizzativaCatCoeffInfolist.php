<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OrganizzativaCatCoeffInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'lista_propro' => TextEntry::make('lista_propro'),
            'coeff' => TextEntry::make('coeff'),
            'descr' => TextEntry::make('descr'),
            'tot_giorni' => TextEntry::make('tot_giorni'),
            'tot_giorni_pt' => TextEntry::make('tot_giorni_pt'),
            'tot_giorni_pt_coeff' => TextEntry::make('tot_giorni_pt_coeff'),
            'quota_teorica' => TextEntry::make('quota_teorica'),
            'anno' => TextEntry::make('anno'),
            'tot' => TextEntry::make('tot'),
        ];
    }
}
