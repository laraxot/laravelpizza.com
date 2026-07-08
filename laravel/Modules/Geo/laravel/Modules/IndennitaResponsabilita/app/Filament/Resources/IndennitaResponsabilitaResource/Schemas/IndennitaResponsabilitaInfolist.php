<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IndennitaResponsabilitaInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'lavoratore' => TextEntry::make('lavoratore'),
            'rep' => TextEntry::make('rep'),
            'anno' => TextEntry::make('anno'),
            'periodo' => TextEntry::make('periodo'),
            'sent_email_list' => TextEntry::make('sent_email_list'),
            'anno_valutatore' => TextEntry::make('anno_valutatore'),
            'is_compiled' => TextEntry::make('is_compiled'),
            'record-pdf1' => TextEntry::make('record-pdf1'),
            'record-pdf' => TextEntry::make('record-pdf'),
            'activities' => TextEntry::make('activities'),
            'zip-schede' => TextEntry::make('zip-schede'),
            'send-mail' => TextEntry::make('send-mail'),
            'downloadXls' => TextEntry::make('downloadXls'),
        ];
    }
}
