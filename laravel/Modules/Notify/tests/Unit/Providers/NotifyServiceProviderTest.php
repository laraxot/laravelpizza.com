<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Providers;

use Illuminate\Support\Facades\Mail;
use Modules\Notify\Providers\NotifyServiceProvider;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('notify service provider boot sets fallback recipient when configured', function () {
    app()->instance(ResolveTenantConfigValueAction::class, new class
    {
        public function execute(string $key, string|int|array|null $default = null): array
        {
            return ['fallback_to' => 'fallback@example.test'];
        }
    });

    Mail::shouldReceive('alwaysTo')->once()->with('fallback@example.test');

    $provider = new NotifyServiceProvider(app());
    $provider->boot();
});

test('notify service provider boot skips alwaysTo when fallback is missing', function () {
    app()->instance(ResolveTenantConfigValueAction::class, new class
    {
        public function execute(string $key, string|int|array|null $default = null): array
        {
            return [];
        }
    });

    Mail::shouldReceive('alwaysTo')->never();

    $provider = new NotifyServiceProvider(app());
    $provider->boot();
});
