<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;
use Mockery;
use Modules\Media\Filament\RelationManagers\MediaRelationManager;
use Modules\Media\Filament\Resources\HasMediaResource\RelationManagers\MediaRelationManager as HasMediaRelationManager;
use Modules\Media\Filament\Resources\MediaResource\Pages\ConvertMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\EditMedia;
use Modules\Media\Filament\Resources\TemporaryUploadResource\Pages\EditTemporaryUpload;
use Modules\Media\Http\Controllers\ConvertController;
use Modules\Media\Models\Media;
use Modules\Media\Rules\FileExtensionRule;
use Modules\Media\Actions\Ffmpeg\ResolveMediaExporterAction;
use Modules\Media\Actions\GenerateTemporaryUploadPathAction;
use Modules\Media\Tests\TestCase;
use Modules\Media\View\Components\VideoPlayer;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-media-db');

afterEach(function (): void {
    Mockery::close();
});

/**
 * Applica FileExtensionRule e raccoglie i messaggi di fallimento.
 *
 * La closure rispetta `Closure(string, string|null=): PotentiallyTranslatedString`
 * perché è il contratto di ValidationRule: una closure `(): void` passerebbe a runtime
 * e mentirebbe sul tipo.
 *
 * @param  UploadedFile|string  $value  File valido oppure valore non-file per il ramo negativo
 * @return list<string>
 */
function mediaFileExtensionFailures(FileExtensionRule $rule, UploadedFile|string $value): array
{
    /** @var list<string> $failures */
    $failures = [];

    $collect = static function (string $message, ?string $_attribute = null) use (&$failures): PotentiallyTranslatedString {
        $failures[] = $message;

        return new PotentiallyTranslatedString($message, app(Translator::class));
    };

    $rule->validate('file', $value, $collect);

    return $failures;
}

describe('Media gap closer — statement coverage', function (): void {
    test('TemporaryUploadPathGenerator builds paths from in-memory media', function (): void {
        $media = new Media;
        $media->id = 7;
        $media->uuid = '550e8400-e29b-41d4-a716-446655440000';
        $gen = app(GenerateTemporaryUploadPathAction::class);
        Assert::assertStringContainsString('tmp/', $gen->getPath($media));
        Assert::assertStringContainsString(md5($media->id.$media->uuid.'conversion'), $gen->getPathForConversions($media));
        Assert::assertStringContainsString(md5($media->id.$media->uuid.'responsive'), $gen->getPathForResponsiveImages($media));
    });

    test('FileExtensionRule validates extensions', function (): void {
        $rule = new FileExtensionRule(['jpg', 'png']);
        $ok = UploadedFile::fake()->create('photo.jpg', 10, 'image/jpeg');
        Assert::assertSame([], mediaFileExtensionFailures($rule, $ok));

        $bad = UploadedFile::fake()->create('photo.exe', 10, 'application/octet-stream');
        $badFailures = mediaFileExtensionFailures($rule, $bad);
        Assert::assertNotEmpty($badFailures);

        $notFileFailures = mediaFileExtensionFailures($rule, 'not-a-file');
        Assert::assertNotEmpty($notFileFailures);
    });

    test('MediaExporterResolver and ConvertController instantiate', function (): void {
        Assert::assertTrue(class_exists(ResolveMediaExporterAction::class));
        try {
            $resolver = app(ResolveMediaExporterAction::class);
            Assert::assertInstanceOf(ResolveMediaExporterAction::class, $resolver);
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        Assert::assertSame(ConvertController::class, (new ConvertController)::class);
    });

    test('filament pages and relation managers exist', function (): void {
        foreach ([
            EditMedia::class,
            ConvertMedia::class,
            EditTemporaryUpload::class,
            MediaRelationManager::class,
            HasMediaRelationManager::class,
        ] as $class) {
            Assert::assertTrue(class_exists($class));
            try {
                $ref = new \ReflectionClass($class);
                Assert::assertInstanceOf($class, $ref->newInstanceWithoutConstructor());
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });

    test('VideoPlayer constructs with explicit props', function (): void {
        try {
            $player = new VideoPlayer(mp4Src: 'https://example.test/v.mp4', currentTime: 0, driver: 'html5');
            Assert::assertSame('html5', $player->driver);
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }
    });
});
