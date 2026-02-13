<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\User\Models\User;

test('LogModelDeletedAction can be instantiated', function () {
    $model = new class() extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $user = User::factory()->make();

    $action = new LogModelDeletedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});
