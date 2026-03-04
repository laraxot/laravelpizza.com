<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Mockery;
use Modules\Activity\Models\Activity;
use Modules\Xot\Actions\Cast\SafeAttributeCastAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('manages eloquent attributes safely', function (): void {
    $model = Mockery::mock(Activity::class);
    $model->shouldReceive('getAttribute')->with('name')->andReturn('Test User');
    $model->shouldReceive('getAttribute')->with('email')->andReturn('');
    $model->shouldReceive('getAttribute')->with('id')->andReturn(123);
    $model->shouldReceive('getAttribute')->with('active')->andReturn(1);
    $model->shouldReceive('getAttribute')->with('missing')->andReturn(null);

    $action = app(SafeAttributeCastAction::class);

    // hasAttribute
    expect($action->hasAttribute($model, 'name'))->toBeTrue();
    expect($action->hasAttribute($model, 'missing'))->toBeFalse();

    // hasNonEmptyAttribute
    expect($action->hasNonEmptyAttribute($model, 'name'))->toBeTrue();
    expect($action->hasNonEmptyAttribute($model, 'email'))->toBeFalse();

    // getStringAttribute
    expect($action->getStringAttribute($model, 'name'))->toBe('Test User');

    // getIntAttribute
    expect($action->getIntAttribute($model, 'id'))->toBe(123);

    // getBooleanAttribute
    expect($action->getBooleanAttribute($model, 'active'))->toBeTrue();

    // hasAttributeValue
    expect($action->hasAttributeValue($model, 'id', 123))->toBeTrue();

    Mockery::close();
});
