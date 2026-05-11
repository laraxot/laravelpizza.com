<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class TemporaryUploadInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'session_id' => TextEntry::make('session_id'),
            'user_id' => TextEntry::make('user_id'),
            'file_name' => TextEntry::make('file_name'),
            'file_size' => TextEntry::make('file_size'),
            'mime_type' => TextEntry::make('mime_type'),
            'status' => TextEntry::make('status'),
        ];
    }
}
