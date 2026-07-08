<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class AssenzaInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'tipo' => TextEntry::make('tipo'),
            'codice' => TextEntry::make('codice'),
            'descr' => TextEntry::make('descr'),
            'anno' => TextEntry::make('anno'),
            'umi' => TextEntry::make('umi'),
            'dur' => TextEntry::make('dur'),
        ];
    }
}
