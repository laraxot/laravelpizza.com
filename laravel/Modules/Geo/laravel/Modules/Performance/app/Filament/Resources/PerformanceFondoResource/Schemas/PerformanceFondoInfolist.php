<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class PerformanceFondoInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'quota_individuale' => TextEntry::make('quota_individuale')
                ->dateTime(),
            'quota_organizzativa' => TextEntry::make('quota_organizzativa')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'note' => TextEntry::make('note')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
            'created_by' => TextEntry::make('created_by'),
            'updated_by' => TextEntry::make('updated_by'),
        ];
    }
}
