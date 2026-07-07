<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Providers;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('activity service provider exposes expected metadata', function (): void {
    $provider = new ActivityServiceProvider(app());

    $reflection = new \ReflectionClass($provider);

    $name = $reflection->getProperty('name');
    $name->setAccessible(true);

    $moduleDir = $reflection->getProperty('moduleDir');
    $moduleDir->setAccessible(true);

    $moduleNs = $reflection->getProperty('moduleNs');
    $moduleNs->setAccessible(true);

    Assert::assertSame('Activity', $name->getValue($provider));
    $moduleDirValue = $moduleDir->getValue($provider);
    $moduleDirString = is_string($moduleDirValue) ? $moduleDirValue : (string) $moduleDirValue;
    Assert::assertStringContainsString('Modules/Activity', $moduleDirString);
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
