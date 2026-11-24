<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Providers;

<<<<<<< .merge_file_L2HspA
<<<<<<< .merge_file_aHsUUq
<<<<<<< .merge_file_ZUBNB4
<<<<<<< .merge_file_2vSA2e
=======
use function Safe\json_encode;
>>>>>>> .merge_file_6RwPWS
=======
use function Safe\json_encode;
>>>>>>> .merge_file_aVReNO
=======
use function Safe\json_encode;
>>>>>>> .merge_file_tGmHWw
=======
use function Safe\json_encode;
>>>>>>> .merge_file_11frJ3
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('activity service provider exposes expected metadata', function (): void {
    $provider = new ActivityServiceProvider(app());

    $reflection = new \ReflectionClass($provider);

    $name = $reflection->getProperty('name');
    $name->setAccessible(true);

    // Proprietà reali: snake_case ($module_dir / $module_ns) su ActivityServiceProvider.
    $moduleDir = $reflection->getProperty('module_dir');
    $moduleDir->setAccessible(true);

    $moduleNs = $reflection->getProperty('module_ns');
    $moduleNs->setAccessible(true);

    Assert::assertSame('Activity', $name->getValue($provider));
    $moduleDirValue = $moduleDir->getValue($provider);
    Assert::assertIsString($moduleDirValue);
    Assert::assertStringContainsString('Modules/Activity', $moduleDirValue);
    Assert::assertSame('Modules\\Activity\\Providers', $moduleNs->getValue($provider));
});

test('activity service provider registerConfig publishes and merges config', function (): void {
    $provider = new ActivityServiceProvider(app());

    $method = new \ReflectionMethod($provider, 'registerConfig');
    $method->setAccessible(true);
    $method->invoke($provider);

    $config = config('activity');
    Assert::assertIsArray($config);
    Assert::assertSame('Activity', $config['name'] ?? null);
});
