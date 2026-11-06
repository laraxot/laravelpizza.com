<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit;

use Filament\Forms\Components\Field;
use Filament\Tables\Columns\Column;
use Mockery;
use Modules\Media\Actions\Ffmpeg\ResolveMediaExporterAction;
use Modules\Media\Actions\GenerateTemporaryUploadPathAction;
use Modules\Media\Filament\Resources\HasMediaResource\Schemas\HasMediaForm;
use Modules\Media\Filament\Resources\HasMediaResource\Tables\HasMediasTable;
use Modules\Media\Filament\Resources\MediaResource\Schemas\MediaForm;
use Modules\Media\Filament\Resources\MediaResource\Tables\MediasTable;
use Modules\Media\Filament\Resources\TemporaryUploadResource\Schemas\TemporaryUploadForm;
use Modules\Media\Filament\Resources\TemporaryUploadResource\Tables\TemporaryUploadsTable;
use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ProtoneMedia\LaravelFFMpeg\Exporters\MediaExporter;
use RuntimeException;

uses(TestCase::class)->group('no-media-db');

test('MediaForm espone i campi anagrafici del media', function (): void {
    $schema = (new MediaForm)->getFormSchema();

    Assert::assertSame(
        ['name', 'file_name', 'mime_type', 'disk', 'size', 'collection_name'],
        array_keys($schema),
    );
    Assert::assertContainsOnlyInstancesOf(Field::class, $schema);
});

test('TemporaryUploadForm espone file folder e expires_at', function (): void {
    Assert::assertSame(
        ['file', 'folder', 'expires_at'],
        array_keys((new TemporaryUploadForm)->getFormSchema()),
    );
});

test('HasMediaForm espone una section con name', function (): void {
    $schema = (new HasMediaForm)->getFormSchema();

    Assert::assertNotSame([], $schema);
});

test('MediasTable e TemporaryUploadsTable espongono colonne indicizzate', function (): void {
    foreach ([new MediasTable, new TemporaryUploadsTable, new HasMediasTable] as $tabella) {
        $colonne = $tabella->getTableColumns();
        Assert::assertNotEmpty($colonne);
        Assert::assertContainsOnlyInstancesOf(Column::class, $colonne);
        foreach (array_keys($colonne) as $chiave) {
            Assert::assertIsString($chiave);
        }
    }
});

test('GenerateTemporaryUploadPathAction costruisce path distinti per purpose', function (): void {
    $action = new GenerateTemporaryUploadPathAction;
    $media = new Media([
        'id' => '42',
        'uuid' => '550e8400-e29b-41d4-a716-446655440000',
    ]);

    $original = $action->execute($media, 'original');
    $conversion = $action->execute($media, 'conversion');
    $responsive = $action->execute($media, 'responsive');

    Assert::assertStringStartsWith('tmp/', $original);
    Assert::assertStringStartsWith('tmp/', $conversion);
    Assert::assertStringStartsWith('tmp/', $responsive);
    Assert::assertNotSame($original, $conversion);
    Assert::assertNotSame($original, $responsive);
});

test('ResolveMediaExporterAction accetta MediaExporter e rifiuta altri tipi', function (): void {
    $action = new ResolveMediaExporterAction;
    $exporter = Mockery::mock(MediaExporter::class);

    Assert::assertSame($exporter, $action->execute($exporter));

    try {
        $action->execute('not-an-exporter');
        Assert::fail('attesa RuntimeException');
    } catch (RuntimeException $e) {
        Assert::assertStringContainsString('MediaExporter', $e->getMessage());
    }
});
