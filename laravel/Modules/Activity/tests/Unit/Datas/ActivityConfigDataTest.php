<?php

declare(strict_types=1);

use Modules\Activity\Actions\Config\ApplyActivityConfigAction;
use Modules\Activity\Datas\ActivityConfigData;
use Modules\Activity\Filament\Pages\SettingPage;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Tests\Support\FakeTenantActivityConfig;
use Modules\Activity\Tests\TestCase;
use Spatie\Activitylog\Support\ActivityLogStatus;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;

uses(TestCase::class)->group('no-activity-db');

/**
 * @return list<string>
 */
function activityConfigProperties(): array
{
    return array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(ActivityConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );
}

test('activity settings live in the activitylog tenant file because the package reads the same keys', function (): void {
    expect(ActivityConfigData::tenantConfigName())->toBe('activitylog')
        ->and(SettingPage::getConfigName())->toBe('activitylog')
        ->and(SettingPage::getConfigDataClass())->toBe(ActivityConfigData::class);
});

test('without a saved value every default equals what the package does today', function (): void {
    $packageDefaults = require base_path('vendor/spatie/laravel-activitylog/config/activitylog.php');
    Assert::isArray($packageDefaults);

    $data = ActivityConfigData::from([]);

    expect($data->enabled)->toBeTrue()
        ->and($data->clean_after_days)->toBe($packageDefaults['clean_after_days'])
        ->and($data->default_log_name)->toBe($packageDefaults['default_log_name'])
        ->and($data->include_soft_deleted_subjects)->toBe($packageDefaults['include_soft_deleted_subjects']);
});

test('values from the tenant file override the defaults', function (): void {
    FakeTenantActivityConfig::bind([
        'enabled' => false,
        'clean_after_days' => 90,
        'default_log_name' => 'audit',
        'include_soft_deleted_subjects' => true,
    ]);

    $data = ActivityConfigData::make();

    expect($data->enabled)->toBeFalse()
        ->and($data->clean_after_days)->toBe(90)
        ->and($data->default_log_name)->toBe('audit')
        ->and($data->include_soft_deleted_subjects)->toBeTrue();
});

test('every setting is a key the installed package really reads', function (): void {
    $source = '';
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(base_path('vendor/spatie/laravel-activitylog/src'), FilesystemIterator::SKIP_DOTS),
    );
    foreach ($files as $file) {
        Assert::isInstanceOf($file, SplFileInfo::class);
        if ($file->getExtension() === 'php') {
            $source .= file_get_contents($file->getPathname());
        }
    }

    foreach (activityConfigProperties() as $key) {
        expect($source)->toContain('activitylog.'.$key);
    }
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing(activityConfigProperties());
});

test('saved values reach the config the package reads', function (): void {
    config([
        'activitylog.enabled' => true,
        'activitylog.clean_after_days' => 365,
        'activitylog.default_log_name' => 'default',
        'activitylog.include_soft_deleted_subjects' => false,
    ]);
    FakeTenantActivityConfig::bind([
        'enabled' => false,
        'clean_after_days' => 30,
        'default_log_name' => 'audit',
        'include_soft_deleted_subjects' => true,
    ]);

    app(ApplyActivityConfigAction::class)->execute();

    expect(config('activitylog.enabled'))->toBeFalse()
        ->and(config('activitylog.clean_after_days'))->toBe(30)
        ->and(config('activitylog.default_log_name'))->toBe('audit')
        ->and(config('activitylog.include_soft_deleted_subjects'))->toBeTrue()
        ->and((new ActivityLogStatus(app('config')))->disabled())->toBeTrue();
});

test('keys the tenant file does not define keep the value the application already had', function (): void {
    config([
        'activitylog.enabled' => false,
        'activitylog.clean_after_days' => 111,
    ]);
    FakeTenantActivityConfig::bind([
        'default_log_name' => 'audit',
    ]);

    app(ApplyActivityConfigAction::class)->execute();

    expect(config('activitylog.enabled'))->toBeFalse()
        ->and(config('activitylog.clean_after_days'))->toBe(111)
        ->and(config('activitylog.default_log_name'))->toBe('audit');
});

test('without a tenant file the application config is left alone', function (): void {
    config(['activitylog.clean_after_days' => 111]);
    FakeTenantActivityConfig::bind([]);

    app(ApplyActivityConfigAction::class)->execute();

    expect(config('activitylog.clean_after_days'))->toBe(111);
});

test('the service provider applies the saved settings at boot', function (): void {
    config(['activitylog.clean_after_days' => 365]);
    FakeTenantActivityConfig::bind(['clean_after_days' => 45]);

    (new ActivityServiceProvider(app()))->boot();

    expect(config('activitylog.clean_after_days'))->toBe(45);
});
