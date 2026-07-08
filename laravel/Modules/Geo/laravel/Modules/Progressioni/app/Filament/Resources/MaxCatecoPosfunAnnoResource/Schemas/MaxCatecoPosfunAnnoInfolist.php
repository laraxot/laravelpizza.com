<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MaxCatecoPosfunAnnoResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MaxCatecoPosfunAnnoInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'cateco' => TextEntry::make('cateco')
                ->dateTime(),
            'posfun' => TextEntry::make('posfun')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'max_gg_tot_pond' => TextEntry::make('max_gg_tot_pond')
                ->dateTime(),
            'aventi_diritto' => TextEntry::make('aventi_diritto')
                ->dateTime(),
            'aventi_diritto_perc' => TextEntry::make('aventi_diritto_perc')
                ->dateTime(),
            'aventi_diritto_eff' => TextEntry::make('aventi_diritto_eff')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
