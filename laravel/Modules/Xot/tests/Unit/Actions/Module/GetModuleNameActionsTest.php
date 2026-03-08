<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Module\GetModuleNameByClassAction;
use Modules\Xot\Actions\Module\GetModuleNameByModelAction;
use Modules\Xot\Actions\Module\GetModuleNameByModelClassAction;

it('extracts module name from class and model class', function (): void {
    $byClass = app(GetModuleNameByClassAction::class)->execute('Modules\\Cms\\Models\\Page');
    $byModelClass = app(GetModuleNameByModelClassAction::class)->execute('Modules\\Xot\\Models\\Module');

    expect($byClass)->toBe('Cms')
        ->and($byModelClass)->toBe('Xot');
});

it('returns extracted fragment for non-module class signatures', function (): void {
    $byClass = app(GetModuleNameByClassAction::class)->execute('App\\Models\\User');
    $byModelClass = app(GetModuleNameByModelClassAction::class)->execute('App\\Models\\User');

    expect($byClass)->toBe('App')
        ->and($byModelClass)->toBe('App');
});

it('delegates model instance class to model class action', function (): void {
    $model = Mockery::mock(Model::class);
    $delegate = Mockery::mock(GetModuleNameByModelClassAction::class);
    $delegate->shouldReceive('execute')
        ->once()
        ->with($model::class)
        ->andReturn('Delegated');
    app()->instance(GetModuleNameByModelClassAction::class, $delegate);

    $result = app(GetModuleNameByModelAction::class)->execute($model);

    expect($result)->toBe('Delegated');
});
