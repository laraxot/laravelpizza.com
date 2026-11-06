<?php

declare(strict_types=1);

use Filament\Resources\Resource;
use Modules\Xot\Tests\Fixtures\Filament\Resources\NavigationProbeResource;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match;

uses(TestCase::class);

test('xot base resource extends filament resource', function (): void {
    Assert::assertTrue((new ReflectionClass(NavigationProbeResource::class))->isSubclassOf(Resource::class));
});

test('application filament resources do not extend filament resource directly', function (): void {
    $resources = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(base_path('Modules'), FilesystemIterator::SKIP_DOTS),
    );

    $directExtensions = [];
    foreach ($resources as $file) {
        if (! $file instanceof SplFileInfo || $file->getExtension() !== 'php') {
            continue;
        }

        $path = $file->getPathname();
        if (! str_contains($path, DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Filament'.DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR)) {
            continue;
        }

        $contents = file_get_contents($path);
        if (preg_match('/\bextends\s+(?:Resource|FilamentResource|\\?Filament\\Resources\\Resource)\b/', $contents) !== 1) {
            continue;
        }

        if (str_ends_with($path, DIRECTORY_SEPARATOR.'XotBaseResource.php')) {
            continue;
        }

        $directExtensions[] = $path;
    }

    Assert::assertSame([], $directExtensions);
});

test('xot base resource reads navigation icon from translations', function (): void {
    Assert::assertSame('heroicon-o-beaker', NavigationProbeResource::getNavigationIcon());
});

test('xot base resource reads navigation group from translations', function (): void {
    Assert::assertSame('Sistema', NavigationProbeResource::getNavigationGroup());
});

test('xot base resource reads navigation sort from translations', function (): void {
    Assert::assertSame(59, NavigationProbeResource::getNavigationSort());
});

test('xot base resource can be instantiated', function (): void {
    Assert::assertSame('Xot', NavigationProbeResource::getModuleName());
});
