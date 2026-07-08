<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\Artisan;
use Modules\Xot\Database\Factories\ModuleFactory;
use Modules\Xot\Models\Module;
use PHPUnit\Framework\Assert;

it('can create a test module', function () {
    $module = ModuleFactory::new()->createOne([
        'name' => 'TestModule',
        'enabled' => true,
    ]);

    Assert::assertInstanceOf(Module::class, $module);
    Assert::assertSame('TestModule', $module->name);
    Assert::assertTrue((bool) $module->enabled);
});

it('can run migrations', function () {
    Artisan::call('migrate', ['--env' => 'testing', '--force' => true]);
});
