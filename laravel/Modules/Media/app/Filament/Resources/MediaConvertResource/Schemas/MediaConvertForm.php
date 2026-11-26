<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaConvertResource\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MediaConvertForm extends XotBaseResourceForm
{
    /**
     * Campi del form di conversione con etichette italiane da lang/it/media_convert_form.php.
     *
     * @see Modules/Media/docs/manuals/manuale-utente.md
     *
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'format' => Radio::make('format')
                ->label(__('media::media_convert_form.fields.format.label'))
                ->options([
                    'webm' => 'webm',
                    // 'webm02' => 'webm02',
                ])
                ->inline()
                ->inlineLabel(false),
            // -----------------------------------
            'codec_video' => Radio::make('codec_video')
                ->label(__('media::media_convert_form.fields.codec_video.label'))
                ->options([
                    'libvpx-vp9' => 'libvpx-vp9',
                    'libvpx-vp8' => 'libvpx-vp8',
                ])
                ->inline()
                ->inlineLabel(false),
            'codec_audio' => Radio::make('codec_audio')
                ->label(__('media::media_convert_form.fields.codec_audio.label'))
                ->options([
                    'copy' => 'copy',
                    'libvorbis' => 'libvorbis',
                ])
                ->inline()
                ->inlineLabel(false),
            'preset' => Radio::make('preset')
                ->label(__('media::media_convert_form.fields.preset.label'))
                ->options([
                    'fast' => 'fast',
                    'ultrafast' => 'ultrafast',
                ])
                ->inline()
                ->inlineLabel(false),
            'bitrate' => TextInput::make('bitrate')->label(__('media::media_convert_form.fields.bitrate.label')),
            'width' => TextInput::make('width')->numeric()->label(__('media::media_convert_form.fields.width.label')),
            'height' => TextInput::make('height')->numeric()->label(__('media::media_convert_form.fields.height.label')),
            'threads' => TextInput::make('threads')->label(__('media::media_convert_form.fields.threads.label')),
            'speed' => TextInput::make('speed')->label(__('media::media_convert_form.fields.speed.label')),
        ];
    }
}
