<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Providers;

use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('activity service provider exposes expected metadata', function (): void {
    $provider = new ActivityServiceProvider(app());

    $reflection = new \ReflectionClass($provider);

    $name = $reflection->getProperty('name');
    $name->setAccessible(true);

    $moduleDir = $reflection->getProperty('moduleDir');
    $moduleDir->setAccessible(true);

    $moduleNs = $reflection->getProperty('moduleNs');
    $moduleNs->setAccessible(true);

    expect($name->getValue($provider))->toBe('Activity')
        ->and((string) $moduleDir->getValue($provider))->toContain('Modules/Activity')
        ->and($moduleNs->getValue($provider))->toBe('Modules\\Activity\\Providers');
});

test('activity service provider registerConfig publishes and merges config', function (): void {
    $provider = new ActivityServiceProvider(app());

    $method = new \ReflectionMethod($provider, 'registerConfig');
    $method->setAccessible(true);
    $method->invoke($provider);

    expect(config('activity'))->toBeArray()
        ->and(config('activity.name'))->toBe('Activity');
});

