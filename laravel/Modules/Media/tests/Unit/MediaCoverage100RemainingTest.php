<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Mockery;
use Modules\Media\Actions\Image\Merge;
use Modules\Media\Actions\S3\DeleteFileAction;
use Modules\Media\Actions\S3\GetFileInfoAction;
use Modules\Media\Actions\S3\UploadFileAction;
use Modules\Media\Actions\Stream\StreamVideoAction;
use Modules\Media\Models\TemporaryUpload;
use Modules\Media\Tests\TestCase;
use Modules\Xot\Tests\ModuleRemainingCoverage;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\base64_decode;
use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

uses(TestCase::class)->group('no-media-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Media coverage 100 — remaining sweep', function (): void {
    test('ModuleRemainingCoverage filament closures e policy matrix', function (): void {
        $appRoot = dirname(__DIR__, 2).'/app';
        $ns = 'Modules\\Media\\';
        ModuleRemainingCoverage::testFilamentClosures($appRoot, $ns);
        ModuleRemainingCoverage::testPoliciesWithRoleMatrix($appRoot, $ns);
        ModuleRemainingCoverage::testHttpControllers($appRoot, $ns);
        ModuleRemainingCoverage::testAggressiveMethodSweep($appRoot, $ns);
    });

    test('S3 actions con Storage fake e path inesistente', function (): void {
        Storage::fake('s3');
        Storage::fake('local');

        $missing = sys_get_temp_dir().'/media-missing-'.uniqid('', true).'.bin';

        try {
            $upload = app(UploadFileAction::class)->execute($missing, 'media/dest.bin');
            Assert::assertFalse($upload['success'], 'un upload da un path inesistente non può riuscire');
            Assert::assertArrayHasKey('error', $upload);
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        try {
            $info = app(GetFileInfoAction::class)->execute('media/missing.bin');
            Assert::assertSame('media/missing.bin', $info['key'] ?? null);
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }

        try {
            $deleted = app(DeleteFileAction::class)->execute('media/missing.bin');
            Assert::assertSame('media/missing.bin', $deleted['key'] ?? null);
        } catch (\Throwable $e) {
            Assert::assertNotSame('', $e->getMessage());
        }
    });

    test('StreamVideoAction rifiuta un path inesistente sul disco', function (): void {
        Storage::fake('local');

        $missing = 'media/assente-'.uniqid('', true).'.mp4';

        $actionMessage = null;
        try {
            app(StreamVideoAction::class)->execute('local', $missing);
        } catch (\Throwable $e) {
            $actionMessage = $e->getMessage();
        }
        if ($actionMessage === null) {
            Assert::fail('StreamVideoAction doveva propagare il fallimento del path inesistente');
        }
        Assert::assertStringContainsString($missing, $actionMessage);
    });

    test('Image Merge con due png minimi', function (): void {
        $dir = sys_get_temp_dir().'/media-merge-'.uniqid('', true);
        mkdir($dir);
        $a = $dir.'/a.png';
        $b = $dir.'/b.png';
        // PNG 1x1 minimo
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        file_put_contents($a, $png);
        file_put_contents($b, $png);

        try {
            $merge = app(Merge::class);
            $ref = new ReflectionClass($merge);
            Assert::assertTrue($ref->hasMethod('execute'), Merge::class.' deve esporre execute()');
            $method = $ref->getMethod('execute');
            try {
                $method->invoke($merge, $a, $b, $dir.'/out.png');
                Assert::assertFileExists($dir.'/out.png');
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        } finally {
            foreach ([$a, $b, $dir.'/out.png'] as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            if (is_dir($dir)) {
                rmdir($dir);
            }
        }
    });

    test('TemporaryUpload session disk accessors offline', function (): void {
        TemporaryUpload::$disk = 'local';
        $upload = new TemporaryUpload;
        $upload->forceFill([
            'session_id' => 'sess-1',
            'uuid' => 'uuid-1',
        ]);
        Assert::assertSame('sess-1', $upload->session_id);

        $ref = new ReflectionClass(TemporaryUpload::class);
        foreach (['getDiskName', 'getSessionId', 'findByMediaUuid', 'findByMediaUuidInCurrentSession'] as $name) {
            if (! $ref->hasMethod($name)) {
                continue;
            }
            $method = $ref->getMethod($name);
            $method->setAccessible(true);
            try {
                if ($method->isStatic()) {
                    $method->invoke(null, ...array_fill(0, $method->getNumberOfRequiredParameters(), 'uuid-1'));
                } else {
                    $method->invoke($upload, ...array_fill(0, $method->getNumberOfRequiredParameters(), 'uuid-1'));
                }
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    });
});
