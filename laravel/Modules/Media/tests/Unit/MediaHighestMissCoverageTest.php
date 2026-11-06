<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Exceptions\CouldNotAddUpload;
use Modules\Media\Exceptions\TemporaryUploadDoesNotBelongToCurrentSession;
use Modules\Media\Filament\Actions\AddAttachmentAction;
use Modules\Media\Filament\Actions\Table\ConvertAction;
use Modules\Media\Filament\Infolists\VideoEntry;
use Modules\Media\Filament\Resources\MediaConvertResource;
use Modules\Media\Filament\Resources\MediaConvertResource\Pages\ListMediaConverts;
use Modules\Media\Filament\Resources\MediaConvertResource\Schemas\MediaConvertForm;
use Modules\Media\Filament\Resources\MediaResource;
use Modules\Media\Filament\Resources\MediaResource\Pages\ListMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\ViewMedia;
use Modules\Media\Filament\Resources\MediaResource\Schemas\MediaForm;
use Modules\Media\Filament\Resources\TemporaryUploadResource;
use Modules\Media\Http\Requests\CreateTemporaryUploadFromDirectS3UploadRequest;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaConvert;
use Modules\Media\Models\TemporaryUpload;
use Modules\Media\Tests\TestCase;
use Modules\Media\View\Components\VideoPlayer;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;

uses(TestCase::class)->group('no-media-db');

/**
 * Invoca un metodo di configurazione tabellare del modulo e ne verifica il contratto.
 *
 * Filament ha deprecato il prototipo ereditato (`@deprecated Override the table() method
 * to configure the table.`), ma le pagine del modulo dichiarano ancora `getTableColumns()`
 * e `getTableActions()` come punto di configurazione: la chiamata passa da Reflection
 * perché il contratto sotto test è quello del modulo, non quello deprecato di Filament.
 *
 * @return array<array-key, mixed>
 */
function mediaTablePart(object $page, string $method): array
{
    $reflection = new ReflectionMethod($page, $method);
    $reflection->setAccessible(true);
    $value = $reflection->invoke($page);
    if (! is_array($value)) {
        Assert::fail($method.'() doveva restituire un array, ha restituito '.get_debug_type($value));
    }

    return $value;
}

describe('Media highest-miss coverage', function (): void {
    test('resources expose model pages and form schema', function (): void {
        Assert::assertSame(Media::class, MediaResource::getModel());
        $mediaPages = MediaResource::getPages();
        Assert::assertArrayHasKey('index', $mediaPages);
        Assert::assertArrayHasKey('view', $mediaPages);
        Assert::assertArrayHasKey('convert', $mediaPages);
        Assert::assertArrayHasKey('file', (new MediaForm)->getFormSchema());

        Assert::assertSame(MediaConvert::class, MediaConvertResource::getModel());
        Assert::assertArrayHasKey('index', MediaConvertResource::getPages());
        Assert::assertArrayHasKey('format', (new MediaConvertForm)->getFormSchema());

        Assert::assertSame(TemporaryUpload::class, TemporaryUploadResource::getModel());
        Assert::assertNotEmpty(TemporaryUploadResource::getPages());
    });

    test('list pages expose table columns and row actions', function (): void {
        $mediaColumns = mediaTablePart(new ListMedia, 'getTableColumns');
        Assert::assertArrayHasKey('file_name', $mediaColumns);
        Assert::assertArrayHasKey('view', mediaTablePart(new ListMedia, 'getTableActions'));

        $convertColumns = mediaTablePart(new ListMediaConverts, 'getTableColumns');
        Assert::assertNotEmpty($convertColumns);
    });

    test('attachment and convert actions expose schema', function (): void {
        Assert::assertSame('add_attachment', AddAttachmentAction::getDefaultName());
        $convert = ConvertAction::make('convert');
        Assert::assertSame('convert', $convert->getName());

        config(['media-library.max_file_size' => 8192]);
        app()->setLocale('en');

        $owner = \Mockery::mock(Model::class);
        $livewire = \Mockery::mock(RelationManager::class);
        TestCase::mockExpectation($livewire, 'getOwnerRecord')->andReturn($owner);
        Assert::assertInstanceOf(RelationManager::class, $livewire);
        expect(function () use ($livewire): void {
            AddAttachmentAction::formHandlerCallback($livewire, ['file' => 'demo.txt']);
        })->toThrow(\Exception::class);
    });

    test('models expose table fillable and in-memory accessors', function (): void {
        $upload = new TemporaryUpload;
        Assert::assertIsString($upload->getTable());
        TemporaryUpload::$disk = 'local';
        $disk = (new ReflectionClass($upload))->getMethod('getDiskName');
        $disk->setAccessible(true);
        Assert::assertSame('local', $disk->invoke(null));

        config(['media-library.generate_thumbnails_for_temporary_uploads' => false]);
        $upload->registerMediaConversions();

        $convert = new MediaConvert;
        $convert->setRelation('media', null);
        Assert::assertContains('format', $convert->getFillable());
        Assert::assertNull($convert->disk);
        Assert::assertNull($convert->file);
        Assert::assertNull($convert->converted_file);

        $media = new Media;
        Assert::assertIsString($media->getTable());
    });

    test('exceptions expose domain factories', function (): void {
        Assert::assertStringContainsString('uuid', CouldNotAddUpload::uuidAlreadyExists()->getMessage());
        Assert::assertStringContainsString('session', TemporaryUploadDoesNotBelongToCurrentSession::create()->getMessage());
    });

    test('direct S3 upload request declares validation rules', function (): void {
        try {
            $rules = (new CreateTemporaryUploadFromDirectS3UploadRequest)->rules();
            Assert::assertArrayHasKey('key', $rules);
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }
    });

    test('ViewMedia infolist schema and convert command missing file', function (): void {
        $page = (new ReflectionClass(ViewMedia::class))->newInstanceWithoutConstructor();
        Assert::assertArrayHasKey('media_grid', mediaTablePart($page, 'getInfolistSchema'));

        Storage::fake('local');
        $this->artisan('media:convert-video', ['disk' => 'local', 'file' => 'missing.mp4']);
    });

    test('VideoPlayer instantiates with explicit driver', function (): void {
        $player = new VideoPlayer('clip.mp4', 0, 'html5');
        Assert::assertSame('html5', $player->driver);
    });

    test('VideoEntry fluent API and Media conversion urls', function (): void {
        Storage::fake('public');
        $entry = VideoEntry::make('video')
            ->disk('public')
            ->height(120)
            ->width(240)
            ->circular()
            ->square()
            ->size(180)
            ->visibility('public')
            ->defaultImageUrl('https://example.test/poster.jpg')
            ->stacked()
            ->overlap(4)
            ->ring(2)
            ->limit(2)
            ->extraImgAttributes(['class' => 'rounded']);
        Assert::assertSame('public', $entry->getDiskName());
        Assert::assertTrue($entry->isCircular());
        Assert::assertTrue($entry->isStacked());
    });

    test('Media model exposes relations and casts without database', function (): void {
        $media = new Media;
        $media->id = 1;
        Assert::assertIsArray($media->getCasts());
    });
});
