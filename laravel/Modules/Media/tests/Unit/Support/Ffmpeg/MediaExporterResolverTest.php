<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions\Ffmpeg;

use Modules\Media\Actions\Ffmpeg\ResolveMediaExporterAction;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ProtoneMedia\LaravelFFMpeg\Exporters\MediaExporter;
use RuntimeException;

uses(TestCase::class)->group('no-media-db');

describe('MediaExporterResolver', function (): void {
    it('returns the value unchanged when it is already a MediaExporter', function (): void {
        $exporter = \Mockery::mock(MediaExporter::class);

        Assert::assertSame($exporter, app(ResolveMediaExporterAction::class)->execute($exporter));
    });

    it('rejects a value that is not a MediaExporter', function (): void {
        try {
            app(ResolveMediaExporterAction::class)->execute('non-un-exporter');
            Assert::fail('Expected RuntimeException was not thrown.');
        } catch (RuntimeException $exception) {
            Assert::assertStringContainsString('MediaExporter', $exception->getMessage());
        }
    });

    it('names the received type in the error message for an object', function (): void {
        try {
            app(ResolveMediaExporterAction::class)->execute(new \stdClass);
            Assert::fail('Expected RuntimeException was not thrown.');
        } catch (RuntimeException $exception) {
            Assert::assertStringContainsString('stdClass', $exception->getMessage());
        }
    });

    it('names the received type in the error message for a scalar', function (): void {
        try {
            app(ResolveMediaExporterAction::class)->execute(42);
            Assert::fail('Expected RuntimeException was not thrown.');
        } catch (RuntimeException $exception) {
            Assert::assertStringContainsString('int', $exception->getMessage());
        }
    });

    it('rejects null', function (): void {
        try {
            app(ResolveMediaExporterAction::class)->execute(null);
            Assert::fail('Expected RuntimeException was not thrown.');
        } catch (RuntimeException $exception) {
            Assert::assertStringContainsString('null', $exception->getMessage());
        }
    });
});
