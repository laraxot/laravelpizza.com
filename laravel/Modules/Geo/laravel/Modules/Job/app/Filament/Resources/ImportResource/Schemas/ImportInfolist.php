<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ImportResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ImportInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'completed_at' => TextEntry::make('completed_at')
                ->dateTime(),
            'file_name' => TextEntry::make('file_name'),
            'file_path' => TextEntry::make('file_path'),
            'importer' => TextEntry::make('importer'),
            'processed_rows' => TextEntry::make('processed_rows'),
            'total_rows' => TextEntry::make('total_rows'),
            'successful_rows' => TextEntry::make('successful_rows'),
            'user_id' => TextEntry::make('user_id'),
        ];
    }
}
