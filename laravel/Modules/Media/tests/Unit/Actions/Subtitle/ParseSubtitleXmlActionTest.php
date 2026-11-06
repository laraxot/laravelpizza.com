<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions\Subtitle;

use Modules\Media\Actions\Subtitle\ParseSubtitleXmlAction;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Parsing dei sottotitoli XML: legge un file di fixture dal disco, nessun database.
 * I tempi nel sorgente sono in millisecondi e vengono normalizzati in secondi e in
 * timecode `HH:MM:SS,mmm`.
 */

uses(TestCase::class)->group('no-media-db');

test('a non xml extension yields no rows', function (): void {
    $rows = (new ParseSubtitleXmlAction)->execute(__DIR__.'/sottotitoli.srt');

    Assert::assertSame([], $rows);
});

test('a path without extension yields no rows', function (): void {
    $rows = (new ParseSubtitleXmlAction)->execute('/tmp/senza-estensione');

    Assert::assertSame([], $rows);
});

test('every item becomes a row with normalised timings', function (): void {
    $rows = (new ParseSubtitleXmlAction)->execute(
        dirname(__DIR__, 3).'/Fixtures/subtitle.xml',
    );

    Assert::assertCount(3, $rows);

    Assert::assertSame(0, $rows[0]['sentence_i']);
    Assert::assertSame(0, $rows[0]['item_i']);
    Assert::assertSame(1.5, $rows[0]['start']);
    Assert::assertSame(2.25, $rows[0]['end']);
    Assert::assertSame('00:00:01,500,00:00:02,250', $rows[0]['time']);
    Assert::assertSame('Buongiorno', $rows[0]['text']);

    // secondo item della stessa sentence: item_i avanza, sentence_i no
    Assert::assertSame(0, $rows[1]['sentence_i']);
    Assert::assertSame(1, $rows[1]['item_i']);

    // sentence successiva: sentence_i avanza, item_i riparte da zero
    Assert::assertSame(1, $rows[2]['sentence_i']);
    Assert::assertSame(0, $rows[2]['item_i']);
});

test('timecodes carry hours, minutes and milliseconds', function (): void {
    $rows = (new ParseSubtitleXmlAction)->execute(
        dirname(__DIR__, 3).'/Fixtures/subtitle.xml',
    );

    // 3_723_456 ms = 1h 02m 03s 456ms
    Assert::assertSame('01:02:03,456,01:02:04,000', $rows[2]['time']);
});
