<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\SettlementResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class SettlementInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'Informazioni' => TextEntry::make('Informazioni'),
            'denominazione' => TextEntry::make('denominazione')
                ->dateTime(),
            'importo' => TextEntry::make('importo'),
            'project.nome' => TextEntry::make('project.nome')
                ->dateTime(),
            'tipologia' => TextEntry::make('tipologia')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
