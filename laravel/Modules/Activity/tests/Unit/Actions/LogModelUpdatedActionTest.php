<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

uses(\Modules\Activity\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\User\Models\User;

test('LogModelUpdatedAction can be instantiated', function () {
    $model = new class extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $user = User::factory()->make();

    $action = new LogModelUpdatedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});
