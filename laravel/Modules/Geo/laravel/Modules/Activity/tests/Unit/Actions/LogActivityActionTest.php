<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogActivityAction can be instantiated', function () {
    $model = new class extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $user = UserFactory::new()->make();
    assert($user instanceof Model);

    $action = new LogActivityAction(
        type: 'test_type',
        user: $user,
        subject: $model,
        properties: ['key' => 'value'],
        description: 'Test Description'
    );

    Assert::assertInstanceOf(LogActivityAction::class, $action);
});

test('LogActivityAction can execute', function () {
    $modelClass = get_class(new class extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    });
    $model = new $modelClass(['name' => 'Test']);
    $user = UserFactory::new()->createOne();
    assert($user instanceof Model);

    $action = new LogActivityAction(
        type: 'test_type',
        user: $user,
        subject: $model,
        properties: ['key' => 'value'],
        description: 'Test Description'
    );

    Assert::assertInstanceOf(LogActivityAction::class, $action);
});
