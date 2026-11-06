<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Datas;

use FFMpeg\Format\Video\WebM;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Datas\CloudFrontData;
use Modules\Media\Datas\ConvertData;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;
use RuntimeException;

use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\unlink;

/*
 * Data object del modulo. `ConvertData` interroga uno Storage, mai il database:
 * qui il disco e' finto. `CloudFrontData` legge la config e, per la chiave privata,
 * un file su storage_path.
 */

uses(TestCase::class)->group('no-media-db');

test('convert data reports whether the source file is on the disk', function (): void {
    Storage::fake('video');
    Storage::disk('video')->put('clip.mp4', 'contenuto');

    $present = ConvertData::from([
        'disk' => 'video',
        'file' => 'clip.mp4',
        'format' => 'webm',
        'codec_video' => 'libvpx-vp9',
        'codec_audio' => 'libvorbis',
        'preset' => 'ultrafast',
        'bitrate' => '1000',
    ]);

    Assert::assertTrue($present->exists());

    $missing = ConvertData::from([
        'disk' => 'video',
        'file' => 'assente.mp4',
        'format' => 'webm',
        'codec_video' => 'libvpx-vp9',
        'codec_audio' => 'libvorbis',
        'preset' => 'ultrafast',
        'bitrate' => '1000',
    ]);

    Assert::assertFalse($missing->exists());
});

test('the ffmpeg format is a webm carrying the declared codecs and bitrate', function (): void {
    $data = ConvertData::from([
        'disk' => 'video',
        'file' => 'clip.mp4',
        'format' => 'webm',
        'codec_video' => 'libvpx-vp9',
        'codec_audio' => 'libvorbis',
        'preset' => 'ultrafast',
        'bitrate' => '1500',
    ]);

    $format = $data->getFFMpegFormat();

    Assert::assertInstanceOf(WebM::class, $format);
    Assert::assertSame(1500, $format->getKiloBitrate());
    Assert::assertSame('libvpx-vp9', $format->getVideoCodec());
    Assert::assertSame('libvorbis', $format->getAudioCodec());
});

test('the converted filename swaps only the trailing mp4 extension', function (): void {
    $data = ConvertData::from([
        'disk' => 'video',
        'file' => 'cartella/clip.mp4.backup/clip.mp4',
        'format' => 'webm',
        'codec_video' => 'libvpx-vp9',
        'codec_audio' => 'libvorbis',
        'preset' => 'ultrafast',
        'bitrate' => '1000',
    ]);

    Assert::assertSame('cartella/clip.mp4.backup/clip.webm', $data->getConvertedFilename());
});

test('optional geometry and threading fields default to null', function (): void {
    $data = ConvertData::from([
        'disk' => 'video',
        'file' => 'clip.mp4',
        'format' => 'webm',
        'codec_video' => 'libvpx-vp9',
        'codec_audio' => 'libvorbis',
        'preset' => 'ultrafast',
        'bitrate' => '1000',
    ]);

    Assert::assertNull($data->width);
    Assert::assertNull($data->height);
    Assert::assertNull($data->threads);
    Assert::assertNull($data->speed);
});

test('cloudfront data returns the inline private key when present', function (): void {
    $data = CloudFrontData::from([
        'region' => 'eu-west-1',
        'base_url' => 'https://cdn.example.test',
        'private_key' => '-----BEGIN PRIVATE KEY-----inline-----END PRIVATE KEY-----',
        'private_key_path' => null,
        'key_pair_id' => 'KP123',
    ]);

    Assert::assertStringContainsString('inline', $data->getPrivateKey());
});

test('cloudfront data reads the key from storage when only a path is configured', function (): void {
    $relative = 'app/cloudfront-test.pem';
    $absolute = storage_path($relative);

    if (! is_dir(dirname($absolute))) {
        mkdir(dirname($absolute), 0o775, true);
    }
    file_put_contents($absolute, 'chiave-da-file');

    try {
        $data = CloudFrontData::from([
            'region' => 'eu-west-1',
            'base_url' => 'https://cdn.example.test',
            'private_key' => null,
            'private_key_path' => $relative,
            'key_pair_id' => 'KP123',
        ]);

        Assert::assertSame('chiave-da-file', $data->getPrivateKey());
    } finally {
        unlink($absolute);
    }
});

test('cloudfront data refuses to guess when no key is configured', function (): void {
    $data = CloudFrontData::from([
        'region' => 'eu-west-1',
        'base_url' => 'https://cdn.example.test',
        'private_key' => null,
        'private_key_path' => null,
        'key_pair_id' => 'KP123',
    ]);

    try {
        $data->getPrivateKey();
        Assert::fail('era attesa una RuntimeException');
    } catch (RuntimeException $e) {
        Assert::assertStringContainsString('CLOUDFRONT_PRIVATE_KEY', $e->getMessage());
    }
});
