<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaConvertResource\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MediaConvertForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'format' => Radio::make('format')
                ->options([
                    'webm' => 'webm',
                    // 'webm02' => 'webm02',
                ])
                ->inline()
                ->inlineLabel(false),
            // -----------------------------------
            'codec_video' => Radio::make('codec_video')
                ->options([
                    'libvpx-vp9' => 'libvpx-vp9',
                    'libvpx-vp8' => 'libvpx-vp8',
                ])
                ->inline()
                ->inlineLabel(false),
            'codec_audio' => Radio::make('codec_audio')
                ->options([
                    'copy' => 'copy',
                    'libvorbis' => 'libvorbis',
                ])
                ->inline()
                ->inlineLabel(false),
            'preset' => Radio::make('preset')
                ->options([
                    'fast' => 'fast',
                    'ultrafast' => 'ultrafast',
                ])
                ->inline()
                ->inlineLabel(false),
            'bitrate' => TextInput::make('bitrate'),
            'width' => TextInput::make('width')->numeric(),
            'height' => TextInput::make('height')->numeric(),
            'threads' => TextInput::make('threads'),
            'speed' => TextInput::make('speed'),
        ];

    }
}
