<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\User\Models\User;
use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Contracts\ModelContract;
use Tests\TestCase;

uses(TestCase::class);

test('model type actions work', function () {
    config(['morph_map' => [
        'test_user' => User::class,
    ]]);

    $classAction = app(GetModelClassByModelTypeAction::class);
    expect($classAction->execute('test_user'))->toBe(User::class);

    // We cannot test GetModelByModelTypeAction easily with User because it's not a ModelContract
    // and we don't want to change User model now.

    $typeAction = app(GetModelTypeByModelAction::class);
    $mock = \Mockery::mock(ModelContract::class);
    // class_basename of mock will be Mockery_...
    $result = $typeAction->execute($mock);
    expect($result)->toContain('mockery');
});
