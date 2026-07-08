<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OrganizzativaAssenzeInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'tipo' => TextEntry::make('tipo')
                ->dateTime(),
            'codice' => TextEntry::make('codice')
                ->dateTime(),
            'descr' => TextEntry::make('descr')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
