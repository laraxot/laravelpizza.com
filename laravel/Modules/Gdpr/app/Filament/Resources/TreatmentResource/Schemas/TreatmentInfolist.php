<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class TreatmentInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'active' => IconEntry::make('active')->boolean(),
            'required' => IconEntry::make('required')->boolean(),
            'name' => TextEntry::make('name'),
            'description' => TextEntry::make('description')->columnSpanFull(),
            'documentVersion' => TextEntry::make('documentVersion'),
            'documentUrl' => TextEntry::make('documentUrl'),
            'weight' => TextEntry::make('weight')->numeric(),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
