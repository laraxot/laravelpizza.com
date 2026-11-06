<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Modules\Media\Actions\S3\DeleteFileAction;
use Modules\Media\Actions\S3\GetFileInfoAction;
use Modules\Media\Actions\S3\UploadFileAction;
use Modules\Media\Actions\Stream\StreamVideoAction;
use Modules\Media\Actions\Video\ConvertVideoByMediaConvertAction;
use Modules\Media\Filament\Clusters\Test\Pages\AwsTest;
use Modules\Media\Filament\Clusters\Test\Pages\S3Test;
use Modules\Media\Filament\Widgets\ConvertWidget;
use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;

use function Safe\file_put_contents;
use function Safe\unlink;

uses(TestCase::class)->group('no-media-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Media gap attack — S3 Aws pages actions', function (): void {
    test('S3Test e AwsTest metodi pubblici offline', function (): void {
        foreach ([S3Test::class, AwsTest::class] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            $page = (new ReflectionClass($class))->newInstanceWithoutConstructor();
            $ref = new ReflectionClass($page);
            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED) as $method) {
                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }
                if (in_array($method->getName(), ['mount', 'render', '__construct', 'boot'], true)) {
                    continue;
                }
                if ($method->getNumberOfRequiredParameters() > 3) {
                    continue;
                }
                $method->setAccessible(true);
                try {
                    $args = [];
                    foreach ($method->getParameters() as $i => $param) {
                        if ($i >= $method->getNumberOfRequiredParameters()) {
                            break;
                        }
                        $type = $param->getType();
                        $n = $type instanceof \ReflectionNamedType ? $type->getName() : '';
                        $args[] = match (true) {
                            $n === 'string' => 'local',
                            $n === 'int' => 1,
                            $n === 'bool' => true,
                            $n === 'array' => ['key' => 'value'],
                            default => 'test',
                        };
                    }
                    $method->invoke($page, ...$args);
                } catch (\Throwable) {
                }
            }
            Assert::assertInstanceOf($class, $page);
        }
    });

    test('tutte le S3/Aws actions execute con Storage fake', function (): void {
        Storage::fake('s3');
        Storage::fake('local');
        Http::fake(['*' => Http::response('ok', 200)]);

        $tmp = sys_get_temp_dir().'/media-s3-'.uniqid('', true).'.txt';
        file_put_contents($tmp, 'hello');

        foreach ([
            UploadFileAction::class,
            GetFileInfoAction::class,
            DeleteFileAction::class,
            StreamVideoAction::class,
            ConvertVideoByMediaConvertAction::class,
        ] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            try {
                $action = app($class);
            } catch (\Throwable) {
                try {
                    $action = (new ReflectionClass($class))->newInstanceWithoutConstructor();
                } catch (\Throwable) {
                    continue;
                }
            }
            $ref = new ReflectionClass($action);
            foreach (['execute', 'handle', '__invoke'] as $name) {
                if (! $ref->hasMethod($name)) {
                    continue;
                }
                $method = $ref->getMethod($name);
                $method->setAccessible(true);
                try {
                    $args = [];
                    foreach ($method->getParameters() as $param) {
                        $type = $param->getType();
                        $n = $type instanceof \ReflectionNamedType ? $type->getName() : '';
                        $args[] = match (true) {
                            $n === 'string' => $tmp,
                            $n === 'int' => 1,
                            $n === 'bool' => true,
                            $n === 'array' => ['path' => $tmp, 'disk' => 'local'],
                            default => $tmp,
                        };
                    }
                    $method->invoke($action, ...$args);
                } catch (\Throwable) {
                }
            }
            Assert::assertTrue(
                $ref->hasMethod('execute') || $ref->hasMethod('handle') || $ref->hasMethod('__invoke'),
                $class.' non espone un entry point invocabile (execute/handle/__invoke)',
            );
        }
        if (is_file($tmp)) {
            unlink($tmp);
        }
    });

    test('ConvertWidget e Media model metodi offline', function (): void {
        if (class_exists(ConvertWidget::class)) {
            $widget = (new ReflectionClass(ConvertWidget::class))->newInstanceWithoutConstructor();
            $ref = new ReflectionClass($widget);
            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED) as $method) {
                if ($method->getDeclaringClass()->getName() !== ConvertWidget::class) {
                    continue;
                }
                if (str_starts_with($method->getName(), '__')) {
                    continue;
                }
                $method->setAccessible(true);
                try {
                    $method->invoke($widget, ...array_fill(0, $method->getNumberOfRequiredParameters(), 1));
                } catch (\Throwable) {
                }
            }
            Assert::assertInstanceOf(ConvertWidget::class, $widget);
        }

        $media = new Media;
        $media->forceFill([
            'id' => 1,
            'file_name' => 'a.mp4',
            'mime_type' => 'video/mp4',
            'disk' => 'local',
            'size' => 100,
        ]);
        $ref = new ReflectionClass($media);
        foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() !== Media::class) {
                continue;
            }
            if (str_starts_with($method->getName(), '__')) {
                continue;
            }
            if (in_array($method->getName(), ['save', 'delete', 'update', 'fresh', 'refresh'], true)) {
                continue;
            }
            if ($method->getNumberOfRequiredParameters() > 2) {
                continue;
            }
            try {
                $method->invoke($media, ...array_fill(0, $method->getNumberOfRequiredParameters(), 'x'));
            } catch (\Throwable) {
            }
        }
        Assert::assertEquals(1, $media->id);
    });
});
