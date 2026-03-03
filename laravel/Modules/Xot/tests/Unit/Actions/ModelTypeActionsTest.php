<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\User\Models\User;
use Tests\TestCase;

uses(TestCase::class);

test('model type actions work', function () {
    config(['morph_map' => [
        'test_user' => User::class,
    ]]);
    
    $classAction = app(GetModelClassByModelTypeAction::class);
    expect($classAction->execute('test_user'))->toBe(User::class);
    
    $modelAction = app(GetModelByModelTypeAction::class);
    $model = $modelAction->execute('test_user', null);
    expect($model)->toBeInstanceOf(User::class);
    
    $typeAction = app(GetModelTypeByModelAction::class);
    // User should become user
    expect($typeAction->execute($model))->toBe('user');
});
