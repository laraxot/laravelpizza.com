<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeArrayByModelCastAction;
use Modules\Xot\Tests\TestCase;
use Modules\User\Models\User;
use Mockery;

uses(TestCase::class);

it('converts model attributes to array correctly', function (): void {
    $user = new User();
    $user->name = 'Test User';
    
    $action = app(SafeArrayByModelCastAction::class);
    $result = $action->execute($user);
    
    expect($result)->toBeArray();
    expect($result)->toHaveKey('name', 'Test User');
});

it('falls back to safeExecute on error', function (): void {
    $model = Mockery::mock(\Illuminate\Database\Eloquent\Model::class);
    $model->shouldReceive('attributesToArray')->andThrow(new \Exception('Mock error'));
    $model->shouldReceive('getAttributes')->andReturn(['name' => 'Fallback']);
    
    // Simulating $model->name access
    $model->name = 'Fallback';

    $action = app(SafeArrayByModelCastAction::class);
    $result = $action->execute($model);
    
    expect($result)->toBeArray();
    expect($result)->toHaveKey('name', 'Fallback');
    
    Mockery::close();
});
