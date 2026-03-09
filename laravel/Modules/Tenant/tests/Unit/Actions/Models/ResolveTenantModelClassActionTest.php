<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Models;

use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;

uses(TestCase::class);

it('resolves tenant model class from config', function (): void {)
    $this->mock(ResolveTenantConfigValueAction::class)
        ->shouldReceive('execute')
        ->with('morph_map.test_model')
        ->andReturn('Modules\Test\Models\TestModel');

    $action = app(ResolveTenantModelClassAction::class);
    $result = $action->execute('test_model');

    expect($result)->toBe('Modules\Test\Models\TestModel');
});

it('resolves tenant model class by scanning modules if not in config', function (): void {)
    $this->mock(ResolveTenantConfigValueAction::class)
        ->shouldReceive('execute')
        ->with('morph_map.event')
        ->andReturn(null);

    // Mock Module::allEnabled() with a lightweight module stub
    $module = new class
    {
        public function getName(): string
        {
            return 'Meetup';
        }
    };

    Module::shouldReceive('allEnabled')->andReturn([$module]);

    $this->mock(GetAllModelsByModuleNameAction::class)
        ->shouldReceive('execute')
        ->with('Meetup')
        ->andReturn(['event' => 'Modules\Meetup\Models\Event']);

    $this->mock(SaveTenantConfigAction::class)
        ->shouldReceive('execute')
        ->with('morph_map', ['event' => 'Modules\Meetup\Models\Event'])
        ->once();

    $action = app(ResolveTenantModelClassAction::class);
    $result = $action->execute('event');

    expect($result)->toBe('Modules\Meetup\Models\Event');
});

it('throws exception for unknown model', function (): void {)
    $this->mock(ResolveTenantConfigValueAction::class)
        ->shouldReceive('execute')
        ->andReturn(null);

    Module::shouldReceive('allEnabled')->andReturn([]);

    $action = app(ResolveTenantModelClassAction::class);
    $action->execute('unknown_model');
})->throws(\Exception::class);
