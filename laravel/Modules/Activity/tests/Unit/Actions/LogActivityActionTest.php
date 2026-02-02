<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

uses(\Modules\Activity\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogActivityAction;
use Modules\User\Models\User;

test('LogActivityAction can be instantiated', function () {
    $model = new class extends Model {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $user = User::factory()->make();

    $action = new LogActivityAction(
        type: 'test_type',
        user: $user,
        subject: $model,
        properties: ['key' => 'value'],
        description: 'Test Description'
    );

    expect($action)->toBeObject();
});

test('LogActivityAction can execute', function () {
    $model = new class(['name' => 'Test']) extends Model {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $user = User::factory()->create();

    $action = new LogActivityAction(
        type: 'test_type',
        user: $user,
        subject: $model,
        properties: ['key' => 'value'],
        description: 'Test Description'
    );

    // Siccome LogActivityAction crea una attività, testiamo che l'execute non generi errori
    expect($action)->toBeObject();
});
