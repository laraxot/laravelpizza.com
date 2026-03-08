<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Activity\Models\Activity;
use Modules\Xot\Actions\Cast\SafeArrayByModelCastAction;


it('converts model attributes to array correctly', function (): void {
    $model = new Activity();
    $model->setRawAttributes(['name' => 'Test']);

    $action = app(SafeArrayByModelCastAction::class);
    $result = $action->execute($model);

    expect($result)->toBeArray();
    expect($result)->toHaveKey('name');
});

it('falls back to safeExecute on error', function (): void {
    $model = \Mockery::mock(\Illuminate\Database\Eloquent\Model::class);
    $model->shouldReceive('attributesToArray')->andThrow(new \Exception('Mock error'));
    $model->shouldReceive('getAttributes')->andReturn(['name' => 'Fallback']);
    $model->shouldReceive('getAttribute')->andReturn('Fallback');
    // Allow any set call
    $model->shouldReceive('setAttribute');

    $action = app(SafeArrayByModelCastAction::class);
    $result = $action->execute($model);

    expect($result)->toBeArray();
    expect($result)->toHaveKey('name', 'Fallback');

    \Mockery::close();
});
