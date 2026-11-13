<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

/** Nome della connessione di un modulo attivo, alias registrato da TenantServiceProvider al boot. */
function aliasedModuleConnection(): string
{
    $module = Module::find('Tenant');
    Assert::assertNotNull($module);

    return $module->getSnakeName();
}

it('resolves a module connection with the default config on the same Connection instance', function (): void {
    $default = Config::string('database.default');
    $name = aliasedModuleConnection();

    Config::set('database.connections.'.$name, DB::connection($default)->getConfig());
    DB::purge($name);

    Assert::assertSame(DB::connection($default), DB::connection($name));
});

it('opens a separate connection when the module config points to another database', function (): void {
    $default = Config::string('database.default');
    $name = aliasedModuleConnection();

    Config::set('database.connections.'.$name, [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
    DB::purge($name);

    Assert::assertNotSame(DB::connection($default), DB::connection($name));
});
