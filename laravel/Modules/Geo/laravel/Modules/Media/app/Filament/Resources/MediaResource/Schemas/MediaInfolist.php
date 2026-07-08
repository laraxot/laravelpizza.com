<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MediaInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'model_type' => TextEntry::make('model_type'),
            'model_id' => TextEntry::make('model_id'),
            'uuid' => TextEntry::make('uuid'),
            'collection_name' => TextEntry::make('collection_name'),
            'name' => TextEntry::make('name'),
            'file_name' => TextEntry::make('file_name'),
            'mime_type' => TextEntry::make('mime_type'),
            'disk' => TextEntry::make('disk'),
            'size' => TextEntry::make('size'),
        ];
    }
}
