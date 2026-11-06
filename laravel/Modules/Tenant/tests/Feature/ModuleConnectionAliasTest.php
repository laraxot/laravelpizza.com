<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Tenant\Tests\TestCase;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('resolves a module connection cloned from the default on the same Connection instance', function (): void {
    $module = Module::find('Tenant');
    Assert::assertNotNull($module);

    $default = Config::string('database.default');
    $name = $module->getSnakeName();
    $connections = Config::array('database.connections');
    unset($connections[$name]);
    Config::set('database.connections', $connections);

    $provider = app()->getProvider(TenantServiceProvider::class);
    Assert::assertInstanceOf(TenantServiceProvider::class, $provider);
    $provider->registerDB();

    Assert::assertSame(DB::connection($default), DB::connection($name));
});

it('keeps a module connection declared explicitly in the tenant config separate', function (): void {
    Config::set('database.connections.tenant_explicit_test', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);

    Assert::assertNotSame(DB::connection(Config::string('database.default')), DB::connection('tenant_explicit_test'));
});
