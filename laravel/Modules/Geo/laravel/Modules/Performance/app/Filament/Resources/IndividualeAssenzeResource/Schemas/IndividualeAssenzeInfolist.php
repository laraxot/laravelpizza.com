<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IndividualeAssenzeInfolist extends XotBaseResourceInfolist
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
            'created_by' => TextEntry::make('created_by'),
            'updated_by' => TextEntry::make('updated_by'),
            'deleted_by' => TextEntry::make('deleted_by'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
