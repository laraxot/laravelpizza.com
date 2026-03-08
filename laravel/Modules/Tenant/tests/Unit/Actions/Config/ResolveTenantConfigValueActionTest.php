<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Illuminate\Support\Facades\Config;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

it('resolves tenant config value by merging with tenant overrides', function (): void {
    $this->mock(GetTenantNameAction::class
        ->shouldReceive('execute')
        ->andReturn('test-tenant');

    // Set up base config
    Config::set('app.name', 'Base App');
    Config::set('app.timezone', 'UTC');

    // Set up tenant override config
    Config::set('test-tenant.app', [
        'name' => 'Tenant App',
    ]);

    $action = app(ResolveTenantConfigValueAction::class);

    // Test resolving a key that is overridden
    $result = $action->execute('app.name');
    expect($result)->toBe('Tenant App');

    // Test resolving a key that is NOT overridden but exists in base
    $result = $action->execute('app.timezone');
    expect($result)->toBe('UTC');
});

it('throws exception for empty config key', function (): void {
    $action = app(ResolveTenantConfigValueAction::class);
    $action->execute('');
})->throws(\Exception::class);

it('returns default value if config not found', function (): void {
    $this->mock(GetTenantNameAction::class
        ->shouldReceive('execute')
        ->andReturn('test-tenant');

    $action = app(ResolveTenantConfigValueAction::class);
    $result = $action->execute('nonexistent.key', 'default');

    expect($result)->toBe('default');
});
