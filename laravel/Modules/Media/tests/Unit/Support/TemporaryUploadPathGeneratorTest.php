<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions;

use Modules\Media\Actions\GenerateTemporaryUploadPathAction;
use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-media-db');

/**
 * Media non persistito: il generator legge solo `id` e `uuid`, non tocca il database.
 *
 * `id` è `int` sul modello — è esattamente il caso su cui `getBasePath()` sollevava,
 * finché l'assert interno pretendeva una stringa.
 */
function temporaryUploadPathGeneratorMedia(int $id = 7, string $uuid = 'e2b1f0a4'): Media
{
    $media = new Media;
    $media->id = $id;
    $media->uuid = $uuid;

    return $media;
}

describe('TemporaryUploadPathGenerator', function (): void {
    it('accepts the integer primary key the model actually declares', function (): void {
        $path = app(GenerateTemporaryUploadPathAction::class)->getPath(temporaryUploadPathGeneratorMedia());

        Assert::assertStringStartsWith('tmp/'.md5('e2b1f0a4'.'7').'/', $path);
    });

    it('closes the original path with a slash', function (): void {
        $path = app(GenerateTemporaryUploadPathAction::class)->getPath(temporaryUploadPathGeneratorMedia());

        Assert::assertStringEndsWith('/', $path);
        Assert::assertStringContainsString(md5('7'.'e2b1f0a4'.'original'), $path);
    });

    it('uses a distinct segment for conversions', function (): void {
        $path = app(GenerateTemporaryUploadPathAction::class)->getPathForConversions(temporaryUploadPathGeneratorMedia());

        Assert::assertStringContainsString(md5('7'.'e2b1f0a4'.'conversion'), $path);
    });

    it('uses a distinct segment for responsive images', function (): void {
        $path = app(GenerateTemporaryUploadPathAction::class)->getPathForResponsiveImages(temporaryUploadPathGeneratorMedia());

        Assert::assertStringContainsString(md5('7'.'e2b1f0a4'.'responsive'), $path);
    });

    it('keeps the three paths distinct for the same media', function (): void {
        $generator = app(GenerateTemporaryUploadPathAction::class);
        $media = temporaryUploadPathGeneratorMedia();

        $paths = [
            $generator->getPath($media),
            $generator->getPathForConversions($media),
            $generator->getPathForResponsiveImages($media),
        ];

        Assert::assertCount(3, array_unique($paths));
    });

    it('separates two media that share the uuid but not the key', function (): void {
        $generator = app(GenerateTemporaryUploadPathAction::class);

        $first = $generator->getPath(temporaryUploadPathGeneratorMedia(7, 'aaaa'));
        $second = $generator->getPath(temporaryUploadPathGeneratorMedia(8, 'aaaa'));

        Assert::assertNotSame($first, $second);
    });

    it('shares the base path across the three variants of the same media', function (): void {
        $generator = app(GenerateTemporaryUploadPathAction::class);
        $media = temporaryUploadPathGeneratorMedia();
        $base = 'tmp/'.md5('e2b1f0a4'.'7');

        Assert::assertStringStartsWith($base, $generator->getPath($media));
        Assert::assertStringStartsWith($base, $generator->getPathForConversions($media));
        Assert::assertStringStartsWith($base, $generator->getPathForResponsiveImages($media));
    });
});
