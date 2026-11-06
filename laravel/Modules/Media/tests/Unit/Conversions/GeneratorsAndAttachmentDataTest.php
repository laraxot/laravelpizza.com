<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Conversions;

use Modules\Media\Conversions\ImageGenerators\PowerPoint;
use Modules\Media\Conversions\VideoGenerators\Webm;
use Modules\Media\Datas\AttachmentToSaveData;
use Modules\Media\Datas\SaveAttachmentsData;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Capability dei generatori di conversione (quali estensioni e mime dichiarano di
 * saper trattare) e data object degli allegati. Tutto in memoria.
 *
 * `PowerPoint::convert()` resta fuori da questo file. `Webm::convert()` e' uno
 * stub dichiarato: lancia `LogicException` invece di restituire un percorso finto.
 */

uses(TestCase::class)->group('no-media-db');

test('the webm generator declares itself installable and handles mp4 sources', function (): void {
    $generator = new Webm;

    Assert::assertTrue($generator->requirementsAreInstalled());

    $extensions = $generator->supportedExtensions();
    Assert::assertSame(['mp4'], $extensions->all());

    Assert::assertSame(['video/mpeg', 'video/mp4'], $generator->supportedMimeTypes()->all());
});

test('the webm generator refuses to convert instead of returning a bogus path', function (): void {
    $thrown = null;

    try {
        (new Webm)->convert('/tmp/clip.mp4');
    } catch (\LogicException $exception) {
        $thrown = $exception;
    }

    Assert::assertInstanceOf(\LogicException::class, $thrown);
    Assert::assertStringContainsString('non implementato', $thrown->getMessage());
});

test('the powerpoint generator advertises extensions and mime types consistently', function (): void {
    $generator = new PowerPoint;

    $extensions = $generator->supportedExtensions();
    $mimeTypes = $generator->supportedMimeTypes();

    Assert::assertNotSame([], $extensions->all());
    Assert::assertNotSame([], $mimeTypes->all());

    foreach ($extensions->all() as $extension) {
        Assert::assertIsString($extension);
        Assert::assertSame(mb_strtolower($extension), $extension);
    }
});

test('an attachment entry keeps its name and tolerates a missing path', function (): void {
    $withPath = new AttachmentToSaveData(name: 'fattura', path: 'tmp/fattura.pdf');
    $withoutPath = new AttachmentToSaveData(name: 'contratto');

    Assert::assertSame('fattura', $withPath->name);
    Assert::assertSame('tmp/fattura.pdf', $withPath->path);
    Assert::assertSame('contratto', $withoutPath->name);
    Assert::assertNull($withoutPath->path);
});

test('the legacy parallel arrays collapse into one typed pair per attachment', function (): void {
    $data = SaveAttachmentsData::fromNamesAndPaths(
        ['fattura', 'contratto', 'allegato_c'],
        ['fattura' => 'tmp/fattura.pdf', 'contratto' => null],
    );

    Assert::assertCount(3, $data->attachments);
    Assert::assertSame('attachments', $data->disk);

    Assert::assertSame('fattura', $data->attachments[0]->name);
    Assert::assertSame('tmp/fattura.pdf', $data->attachments[0]->path);

    // path esplicitamente null
    Assert::assertNull($data->attachments[1]->path);

    // nome senza alcuna voce nella mappa dei path: stesso esito, non un errore
    Assert::assertSame('allegato_c', $data->attachments[2]->name);
    Assert::assertNull($data->attachments[2]->path);
});

test('the disk can be overridden and no attachment is invented', function (): void {
    $data = SaveAttachmentsData::fromNamesAndPaths([], [], 'documenti');

    Assert::assertSame([], $data->attachments);
    Assert::assertSame('documenti', $data->disk);
});
