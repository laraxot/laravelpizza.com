<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\WorkgroupResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class WorkgroupInfolist extends XotBaseResourceInfolist
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
            'employees.cognome' => TextEntry::make('employees.cognome')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
