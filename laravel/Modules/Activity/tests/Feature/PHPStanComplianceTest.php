<?php

declare(strict_types=1);

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Modules\Xot\Providers\XotBaseServiceProvider;

uses(\Modules\Activity\Tests\TestCase::class);

test('phpstan placeholder', function (): void {
    expect(true)->toBeTrue();
});

test('classes extend correct base classes', function (): void {
    $actionReflection = new ReflectionClass(ListLogActivitiesAction::class);
    expect($actionReflection->isSubclassOf(XotBaseAction::class))
        ->toBeTrue('ListLogActivitiesAction deve estendere XotBaseAction');

    $pageReflection = new ReflectionClass(ListLogActivities::class);
    expect($pageReflection->isSubclassOf(XotBasePage::class))
        ->toBeTrue('ListLogActivities deve estendere XotBasePage');
});

test('translations are properly structured', function (): void {
    $actionsPath = base_path('Modules/Activity/lang/it/actions.php');
    $activitiesPath = base_path('Modules/Activity/lang/it/activities.php');

    expect(file_exists($actionsPath))->toBeTrue();
    expect(file_exists($activitiesPath))->toBeTrue();

    $actionsTranslations = include $actionsPath;
    $activitiesTranslations = include $activitiesPath;

    expect($actionsTranslations)->toBeArray()->and($actionsTranslations)->toHaveKey('list_log_activities');
    expect($activitiesTranslations)->toBeArray()->and($activitiesTranslations)->toHaveKey('events');
});

test('service provider configuration', function (): void {
    $providerReflection = new ReflectionClass(ActivityServiceProvider::class);
    expect($providerReflection->isSubclassOf(XotBaseServiceProvider::class))
        ->toBeTrue('ActivityServiceProvider deve estendere XotBaseServiceProvider');

    $provider = new ActivityServiceProvider(app());
    expect($provider->name)->toBe('Activity');
});

test('views exist and are structured', function (): void {
    $viewPath = base_path('Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php');
    expect(file_exists($viewPath))->toBeTrue();

    $viewContent = file_get_contents($viewPath);
    expect($viewContent)->toBeString()->and($viewContent)->toContain('getActivities()')->toContain('getFieldLabel');
});
