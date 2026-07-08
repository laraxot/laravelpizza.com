<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\DefaultActivityResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class DefaultActivityInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'nome' => TextEntry::make('nome'),
            'tipo' => TextEntry::make('tipo'),
            'appartiene_a_liquidazione_a_fasi' => TextEntry::make('appartiene_a_liquidazione_a_fasi'),
            'liquidazione_fasi' => TextEntry::make('liquidazione_fasi'),
            'quota_percentuale' => TextEntry::make('quota_percentuale'),
            'importo' => TextEntry::make('importo'),
            'anno_competenza' => TextEntry::make('anno_competenza'),
        ];
    }
}
