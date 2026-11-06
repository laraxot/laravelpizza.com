<?php

declare(strict_types=1);

use Modules\Job\Actions\BuildQueueWorkerCommandAction;
use Modules\Job\Console\Commands\WorkerCheck;
use Modules\Job\Datas\JobConfigData;
use Modules\Job\Filament\Pages\SettingPage;
use Modules\Job\Tests\Support\FakeTenantJobConfig;
use Modules\Job\Tests\TestCase;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;

uses(TestCase::class)->group('no-job-db');

test('setting page resolves config name and data class by convention', function (): void {
    expect(SettingPage::getConfigName())->toBe('job')
        ->and(SettingPage::getConfigDataClass())->toBe(JobConfigData::class)
        ->and(JobConfigData::tenantConfigName())->toBe('job');
});

test('without a saved value the worker flags are the ones worker:check always used', function (): void {
    $data = JobConfigData::from([]);

    expect($data->max_attempts)->toBe(3)
        ->and($data->timeout_seconds)->toBe(60)
        ->and($data->sleep_seconds)->toBe(5);
});

test('values from the tenant file override the defaults', function (): void {
    FakeTenantJobConfig::bind([
        'max_attempts' => 5,
        'timeout_seconds' => 80,
        'sleep_seconds' => 2,
    ]);

    $data = JobConfigData::make();

    expect($data->max_attempts)->toBe(5)
        ->and($data->timeout_seconds)->toBe(80)
        ->and($data->sleep_seconds)->toBe(2);
});

test('the worker command is byte for byte the old one until someone saves', function (): void {
    FakeTenantJobConfig::bind([]);

    expect(app(BuildQueueWorkerCommandAction::class)->execute())
        ->toBe(' /usr/local/bin/php '.base_path().'/artisan queue:work --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!');
});

test('the worker command carries the saved flags', function (): void {
    FakeTenantJobConfig::bind([
        'max_attempts' => 5,
        'timeout_seconds' => 80,
        'sleep_seconds' => 2,
    ]);

    expect(app(BuildQueueWorkerCommandAction::class)->execute())
        ->toContain('queue:work --timeout=80 --sleep=2 --tries=5 ');
});

test('worker:check starts the worker with the command built from the settings', function (): void {
    $source = file_get_contents((string) (new ReflectionClass(WorkerCheck::class))->getFileName());

    expect($source)->toContain('app(BuildQueueWorkerCommandAction::class)->execute()');
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $properties = array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(JobConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );

    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing($properties);
});
