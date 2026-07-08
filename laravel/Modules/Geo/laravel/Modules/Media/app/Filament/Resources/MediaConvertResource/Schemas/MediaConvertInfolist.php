<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaConvertResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MediaConvertInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'media_id' => TextEntry::make('media_id'),
            'format' => TextEntry::make('format'),
            'codec_video' => TextEntry::make('codec_video'),
            'codec_audio' => TextEntry::make('codec_audio'),
            'preset' => TextEntry::make('preset'),
            'bitrate' => TextEntry::make('bitrate'),
            'width' => TextEntry::make('width'),
            'height' => TextEntry::make('height'),
            'threads' => TextEntry::make('threads'),
            'speed' => TextEntry::make('speed'),
        ];
    }
}
