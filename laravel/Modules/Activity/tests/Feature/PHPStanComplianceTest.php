<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Modules\Xot\Providers\XotBaseServiceProvider;
use PHPUnit\Framework\Assert;
use function Safe\file_get_contents;

uses(\Modules\Activity\Tests\TestCase::class);

test('classes extend correct base classes', function (): void {
    $actionReflection = new \ReflectionClass(ListLogActivitiesAction::class);
    Assert::assertTrue(
        $actionReflection->isSubclassOf(XotBaseAction::class),
        'ListLogActivitiesAction deve estendere XotBaseAction'
    );

    $pageReflection = new \ReflectionClass(ListLogActivities::class);
    Assert::assertTrue(
        $pageReflection->isSubclassOf(XotBasePage::class),
        'ListLogActivities deve estendere XotBasePage'
    );
});

test('translations are properly structured', function (): void {
    $actionsPath = base_path('Modules/Activity/lang/it/actions.php');
    $activitiesPath = base_path('Modules/Activity/lang/it/activities.php');

    Assert::assertTrue(file_exists($actionsPath));
    Assert::assertTrue(file_exists($activitiesPath));

    $actionsTranslations = include $actionsPath;
    $activitiesTranslations = include $activitiesPath;

    Assert::assertIsArray($actionsTranslations);
    Assert::assertIsArray($activitiesTranslations);
    Assert::assertArrayHasKey('list_log_activities', $actionsTranslations);
    Assert::assertArrayHasKey('events', $activitiesTranslations);
});

test('service provider configuration', function (): void {
    $providerReflection = new \ReflectionClass(ActivityServiceProvider::class);
    Assert::assertTrue(
        $providerReflection->isSubclassOf(XotBaseServiceProvider::class),
        'ActivityServiceProvider deve estendere XotBaseServiceProvider'
    );

    $provider = new ActivityServiceProvider(app());
    Assert::assertSame('Activity', $provider->name);
});

test('views exist and are structured', function (): void {
    $viewPath = base_path('Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php');
    Assert::assertTrue(file_exists($viewPath));

    $viewContent = file_get_contents($viewPath);
    Assert::assertStringContainsString('getActivities()', $viewContent);
    Assert::assertStringContainsString('getFieldLabel', $viewContent);
});
