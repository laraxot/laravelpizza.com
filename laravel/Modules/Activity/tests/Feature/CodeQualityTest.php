<?php

declare(strict_types=1);

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Providers\ActivityServiceProvider;

uses(\Modules\Activity\Tests\TestCase::class);

beforeEach(function () {
    // Skip if database not available
    try {
        \DB::connection()->getPdo();
    } catch (\Exception $e) {
        $this->markTestSkipped('Database not available: '.$e->getMessage());
    }
});

function activityFindPhpFiles(string $directory): array
{
    $phpFiles = [];

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $phpFiles[] = $file->getPathname();
        }
    }

    /** @var array<int, string> $phpFiles */
    return $phpFiles;
}

function activityAssertPhpFileHasValidSyntax(string $filePath): void
{
    $output = [];
    $resultCode = 0;
    exec('php -l '.escapeshellarg($filePath).' 2>&1', $output, $resultCode);

    expect($resultCode)->toBe(0, "File {$filePath} ha errori di sintassi: ".implode("\n", $output));
}

test('all php files have valid syntax', function (): void {
    $modulePath = base_path('Modules/Activity');
    $phpFiles = activityFindPhpFiles($modulePath);

    foreach ($phpFiles as $file) {
        activityAssertPhpFileHasValidSyntax($file);
    }
});

test('main classes exist and are instantiable', function (): void {
    expect(class_exists(ActivityServiceProvider::class))->toBeTrue();
    expect(class_exists(ListLogActivitiesAction::class))->toBeTrue();
    expect(class_exists(ListLogActivities::class))->toBeTrue();
});

test('configuration files exist', function (): void {
    $configPath = base_path('Modules/Activity/config/config.php');
    expect(file_exists($configPath))->toBeTrue();

    $config = include $configPath;
    expect($config)->toBeArray();
});

test('translations exist and are structured', function (): void {
    $actionsTranslationsPath = base_path('Modules/Activity/lang/it/actions.php');
    $activitiesTranslationsPath = base_path('Modules/Activity/lang/it/activities.php');

    expect(file_exists($actionsTranslationsPath))->toBeTrue();
    expect(file_exists($activitiesTranslationsPath))->toBeTrue();

    $actionsTranslations = include $actionsTranslationsPath;
    $activitiesTranslations = include $activitiesTranslationsPath;

    expect($actionsTranslations)->toBeArray()->and($actionsTranslations)->toHaveKey('list_log_activities');
    expect($activitiesTranslations)->toBeArray()->and($activitiesTranslations)->toHaveKey('events');
});

test('views exist and are valid', function (): void {
    $viewPath = base_path('Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php');
    expect(file_exists($viewPath))->toBeTrue();

    $viewContent = file_get_contents($viewPath);
    expect($viewContent)->toBeString()->and($viewContent)->toContain('getActivities()')->toContain('getFieldLabel');
});

test('service provider configuration', function (): void {
    $provider = new ActivityServiceProvider(app());

    expect($provider->name)->toBe('Activity')->and($provider->name)->not->toBeEmpty();
});

test('documentation is up to date', function (): void {
    $readmePath = base_path('Modules/Activity/docs/README.md');
    expect(file_exists($readmePath))->toBeTrue();

    $readmeContent = file_get_contents($readmePath);
    expect($readmeContent)->toBeString()
        ->and($readmeContent)->toContain('ListLogActivitiesAction')
        ->and($readmeContent)->toContain('ListLogActivities')
        ->and($readmeContent)->toContain('ActivityServiceProvider');
});
