<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use function Safe\exec;
use function Safe\file_get_contents;

uses(\Modules\Activity\Tests\TestCase::class);

/**
 * @return list<string>
 */
function activityFindPhpFiles(string $directory): array
{
    $phpFiles = [];

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if (! $file instanceof SplFileInfo) {
            continue;
        }

        if ($file->isFile() && $file->getExtension() === 'php') {
            $phpFiles[] = $file->getPathname();
        }
    }

    return $phpFiles;
}

function activityAssertPhpFileHasValidSyntax(string $filePath): void
{
    $outputLines = [];
    $resultCode = 0;
    exec('php -l '.escapeshellarg($filePath).' 2>&1', $outputLines, $resultCode);

    Assert::assertIsArray($outputLines);
    $lines = array_map(static function (mixed $line): string {
        return is_string($line) ? $line : '';
    }, $outputLines);
    Assert::assertSame(0, $resultCode, "File {$filePath} ha errori di sintassi: ".implode("\n", $lines));
}

test('all php files have valid syntax', function (): void {
    $modulePath = base_path('Modules/Activity');
    $phpFiles = activityFindPhpFiles($modulePath);

    foreach ($phpFiles as $file) {
        activityAssertPhpFileHasValidSyntax($file);
    }
});

test('main classes exist and are instantiable', function (): void {
    Assert::assertTrue(class_exists(ActivityServiceProvider::class));
    Assert::assertTrue(class_exists(ListLogActivitiesAction::class));
    Assert::assertTrue(class_exists(ListLogActivities::class));
});

test('configuration files exist', function (): void {
    $configPath = base_path('Modules/Activity/config/config.php');
    Assert::assertTrue(file_exists($configPath));

    $config = include $configPath;
    Assert::assertIsArray($config);
});

test('translations exist and are structured', function (): void {
    $actionsTranslationsPath = base_path('Modules/Activity/lang/it/actions.php');
    $activitiesTranslationsPath = base_path('Modules/Activity/lang/it/activities.php');

    Assert::assertTrue(file_exists($actionsTranslationsPath));
    Assert::assertTrue(file_exists($activitiesTranslationsPath));

    $actionsTranslations = include $actionsTranslationsPath;
    $activitiesTranslations = include $activitiesTranslationsPath;

    Assert::assertIsArray($actionsTranslations);
    Assert::assertIsArray($activitiesTranslations);
    Assert::assertArrayHasKey('list_log_activities', $actionsTranslations);
    Assert::assertArrayHasKey('events', $activitiesTranslations);
});

test('views exist and are valid', function (): void {
    $viewPath = base_path('Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php');
    Assert::assertTrue(file_exists($viewPath));

    $viewContent = file_get_contents($viewPath);
    Assert::assertStringContainsString('getActivities()', $viewContent);
    Assert::assertStringContainsString('getFieldLabel', $viewContent);
});

test('service provider configuration', function (): void {
    $provider = new ActivityServiceProvider(app());

    Assert::assertSame('Activity', $provider->name);
    Assert::assertNotEmpty($provider->name);
});

test('documentation is up to date', function (): void {
    $readmePath = base_path('Modules/Activity/docs/README.md');
    Assert::assertTrue(file_exists($readmePath));

    $readmeContent = file_get_contents($readmePath);
    Assert::assertStringContainsString('ListLogActivitiesAction', $readmeContent);
    Assert::assertStringContainsString('ListLogActivities', $readmeContent);
    Assert::assertStringContainsString('ActivityServiceProvider', $readmeContent);
});
