<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('LogModelCreatedAction can be instantiated', function () {
    $model = new class() extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(Model::class, $user);

    $action = new LogModelCreatedAction($model, $user);

<<<<<<< .merge_file_Y8fYWw
    Assert::assertSame($user, $action->user);
=======
    Assert::assertSame('created', $activity->event);
    Assert::assertSame($model->getKey(), $activity->subject_id);
>>>>>>> .merge_file_XvmB2L
});

test('LogModelCreatedAction can execute', function () {
    $modelClass = get_class(new class() extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    });
    $model = new $modelClass(['name' => 'Test']);
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(Model::class, $user);

    $action = new LogModelCreatedAction($model, $user);

<<<<<<< .merge_file_Y8fYWw
    Assert::assertInstanceOf(LogModelCreatedAction::class, $action);
=======
    Assert::assertSame($model::class, $activity->subject_type);

    $user = UserFactory::new()->createOne();
    $action = new LogModelCreatedAction($model, $user);

    Assert::assertSame($user, $action->user);
});

test('LogModelCreatedAction can execute', function () {
    $modelClass = get_class(new class extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    });
    $model = new $modelClass(['name' => 'Test']);
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(Model::class, $user);

    $action = new LogModelCreatedAction($model, $user);

    Assert::assertSame($model, $action->model);
>>>>>>> .merge_file_XvmB2L
});
