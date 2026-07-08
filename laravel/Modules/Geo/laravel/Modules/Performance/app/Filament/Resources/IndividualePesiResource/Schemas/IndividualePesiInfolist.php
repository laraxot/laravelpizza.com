<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePesiResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IndividualePesiInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'type' => TextEntry::make('type')
                ->dateTime(),
            'lista_propro' => TextEntry::make('lista_propro')
                ->dateTime(),
            'descr' => TextEntry::make('descr')
                ->dateTime(),
            'peso_esperienza_acquisita' => TextEntry::make('peso_esperienza_acquisita')
                ->dateTime(),
            'peso_risultati_ottenuti' => TextEntry::make('peso_risultati_ottenuti')
                ->dateTime(),
            'peso_arricchimento_professionale' => TextEntry::make('peso_arricchimento_professionale')
                ->dateTime(),
            'peso_impegno' => TextEntry::make('peso_impegno')
                ->dateTime(),
            'peso_qualita_prestazione' => TextEntry::make('peso_qualita_prestazione')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
            'created_by' => TextEntry::make('created_by'),
            'updated_by' => TextEntry::make('updated_by'),
            'pesi_non_zero' => TextEntry::make('pesi_non_zero'),
            'value' => TextEntry::make('value'),
        ];
    }
}
