<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IndividualeDecurtazioneAssenzeInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'min_perc' => TextEntry::make('min_perc')
                ->dateTime(),
            'max_perc' => TextEntry::make('max_perc')
                ->dateTime(),
            'min_gg_365' => TextEntry::make('min_gg_365')
                ->dateTime(),
            'max_gg_365' => TextEntry::make('max_gg_365')
                ->dateTime(),
            'decurtazione_perc' => TextEntry::make('decurtazione_perc')
                ->dateTime(),
            'id' => TextEntry::make('id')
                ->dateTime(),
            'individuale.nome' => TextEntry::make('individuale.nome')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
