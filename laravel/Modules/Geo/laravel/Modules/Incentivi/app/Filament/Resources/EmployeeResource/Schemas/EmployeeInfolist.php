<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\EmployeeResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class EmployeeInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'matricola' => TextEntry::make('matricola'),
            'cognome' => TextEntry::make('cognome'),
            'nome' => TextEntry::make('nome'),
            'sesso' => TextEntry::make('sesso'),
            'codice_fiscale' => TextEntry::make('codice_fiscale'),
            'posizione_inail' => TextEntry::make('posizione_inail'),
            'tipologia' => TextEntry::make('tipologia'),
            'full_name' => TextEntry::make('full_name'),
            'tqu00f_desc1' => TextEntry::make('tqu00f_desc1'),
            'tqu00f_desc2' => TextEntry::make('tqu00f_desc2'),
            'tqu00f' => TextEntry::make('tqu00f'),
        ];
    }
}
