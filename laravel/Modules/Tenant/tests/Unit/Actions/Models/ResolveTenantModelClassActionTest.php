<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Models;

use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Modules\Xot\Tests\XotBasePest;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('resolves tenant model class from config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'Modules\Test\Models\TestModel']);
    });

    $result = app(ResolveTenantModelClassAction::class)->execute('test_model');

    Assert::assertSame('Modules\Test\Models\TestModel', $result);
});

it('resolves tenant model class by scanning modules if not in config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => null]);
    });

    $module = Mockery::mock(LaravelModule::class);
    TestCase::expectMockery($module, 'getName')->andReturn('Meetup');

    Module::shouldReceive('allEnabled')->andReturn([$module]);

    $this->mockService(GetAllModelsByModuleNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => ['tenant' => Tenant::class]]);
    });

    $this->mockService(SaveTenantConfigAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => true]);
    });

    $result = app(ResolveTenantModelClassAction::class)->execute('tenant');

    Assert::assertSame(Tenant::class, $result);
});

it('throws exception for unknown model', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => null]);
    });

    Module::shouldReceive('allEnabled')->andReturn([]);

    XotBasePest::assertThrows(
        fn (): string => app(ResolveTenantModelClassAction::class)->execute('unknown_model'),
        \Exception::class,
    );
});
