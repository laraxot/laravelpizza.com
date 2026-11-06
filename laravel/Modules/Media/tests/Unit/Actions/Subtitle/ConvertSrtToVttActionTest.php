<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions\Subtitle;

use Illuminate\Support\Facades\File;
use Modules\Media\Actions\Subtitle\ConvertSrtToVttAction;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Conversione SRT -> WebVTT: il percorso e' relativo a public_path().
 * Solo le righe dei tempi cambiano la virgola in punto; il testo resta com'e'.
 */

uses(TestCase::class)->group('no-media-db');

test('timing lines get a dot, cue text keeps its commas', function (): void {
    $dir = 'media-srt-test-'.uniqid('', true);
    File::ensureDirectoryExists(public_path($dir));

    try {
        File::put(
            public_path($dir.'/in.srt'),
            "1\n00:00:01,500 --> 00:00:02,250\nCiao, mondo\n\n2\n00:00:03,000 --> 00:00:04,000\nA presto\n",
        );

        (new ConvertSrtToVttAction)->execute($dir.'/in.srt', $dir.'/out.vtt');

        Assert::assertSame(
            "WEBVTT\n\n1\n00:00:01.500 --> 00:00:02.250\nCiao, mondo\n\n2\n00:00:03.000 --> 00:00:04.000\nA presto\n",
            File::get(public_path($dir.'/out.vtt')),
        );
    } finally {
        File::deleteDirectory(public_path($dir));
    }
});
