<?php

declare(strict_types=1);

/**
 * Le due Action di conversione devono applicare il formato descritto da ConvertData
 * (codec, bitrate, preset) con `inFormat()` e salvare solo il percorso.
 *
 * Senza ffmpeg sul server di sviluppo la catena FFMpeg e' simulata: il test controlla quale
 * formato arriva all'esportatore, non l'encoding.
 *
 * @see Modules/Media/docs/contracts/convert-video-by-convert-data-action.md
 * @see Modules/Media/docs/contracts/convert-video-by-media-convert-action.md
 */

use FFMpeg\Format\Video\DefaultVideo;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Actions\Video\ConvertVideoByConvertDataAction;
use Modules\Media\Actions\Video\ConvertVideoByMediaConvertAction;
use Modules\Media\Datas\ConvertData;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaConvert;
use Modules\Media\Tests\TestCase;
use ProtoneMedia\LaravelFFMpeg\Exporters\MediaExporter;
use ProtoneMedia\LaravelFFMpeg\MediaOpener;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

uses(TestCase::class);

if (! function_exists('mediaConvertFixtureData')) {
    function mediaConvertFixtureData(): ConvertData
    {
        Storage::fake('video');
        Storage::disk('video')->put('in.mp4', 'x');

        return ConvertData::from([
            'disk' => 'video',
            'file' => 'in.mp4',
            'format' => 'webm',
            'codec_video' => 'libvpx-vp9',
            'codec_audio' => 'libvorbis',
            'preset' => 'veryfast',
            'bitrate' => '1000',
        ]);
    }
}

/**
 * Simula FFMpeg::fromDisk()->open()->export() e cattura il formato passato a inFormat().
 *
 * @param  list<string>  $extraCalls  metodi dell'esportatore ammessi oltre a inFormat/save
 */
if (! function_exists('mediaConvertFakeFfmpeg')) {
    function mediaConvertFakeFfmpeg(object $capture, string $savedPath, array $extraCalls = []): void
    {
        $exporter = Mockery::mock(MediaExporter::class);
        $exporter->shouldReceive('inFormat')->once()
            ->with(Mockery::on(static function (DefaultVideo $format) use ($capture): bool {
                $capture->format = $format;

                return true;
            }))
            ->andReturnSelf();
        $exporter->shouldReceive('save')->once()->with($savedPath)->andReturnNull();
        foreach ($extraCalls as $method) {
            $exporter->shouldReceive($method)->andReturnSelf();
        }

        $opener = Mockery::mock(MediaOpener::class);
        $opener->shouldReceive('open')->once()->with('in.mp4')->andReturnSelf();
        $opener->shouldReceive('export')->once()->andReturn($exporter);

        FFMpeg::shouldReceive('fromDisk')->once()->with('video')->andReturn($opener);
    }
}

describe('ConvertVideoByConvertDataAction applica il formato di ConvertData', function (): void {
    it('passa a inFormat() il formato con codec, bitrate e preset scelti', function (): void {
        $capture = new stdClass;
        mediaConvertFakeFfmpeg($capture, 'in.webm');

        $result = (new ConvertVideoByConvertDataAction)->execute(mediaConvertFixtureData());

        expect($result)->toBe('in.webm');
        expect($capture->format)->toBeInstanceOf(DefaultVideo::class);
        expect($capture->format->getVideoCodec())->toBe('libvpx-vp9');
        expect($capture->format->getAudioCodec())->toBe('libvorbis');
        expect($capture->format->getKiloBitrate())->toBe(1000);
        expect($capture->format->getAdditionalParameters())->toBe(['-preset', 'veryfast']);
    });
});

describe('ConvertVideoByMediaConvertAction applica il formato di ConvertData', function (): void {
    it('passa a inFormat() il formato con codec, bitrate e preset scelti', function (): void {
        $capture = new stdClass;
        mediaConvertFakeFfmpeg($capture, 'm/conversions/in_7.webm', ['onProgress']);

        // `converted_file` e' un accessor calcolato dal Media collegato (MediaConvertMutator).
        $media = (new Media)->forceFill(['disk' => 'video', 'path' => 'm', 'file_name' => 'in.mp4']);
        $record = Mockery::mock(MediaConvert::class)->makePartial();
        $record->forceFill(['id' => 7, 'format' => 'webm'])->setRelation('media', $media);
        // La fine si registra in `percentage`: `onProgress` non scatta a 100 e `status` non e' una colonna.
        $record->shouldReceive('update')->once()->with(['percentage' => 100])->andReturnTrue();

        $result = (new ConvertVideoByMediaConvertAction)->execute(mediaConvertFixtureData(), $record);

        expect($result)->toBe('m/conversions/in_7.webm');
        expect($capture->format)->toBeInstanceOf(DefaultVideo::class);
        expect($capture->format->getKiloBitrate())->toBe(1000);
        expect($capture->format->getAdditionalParameters())->toBe(['-preset', 'veryfast']);
    });
});
