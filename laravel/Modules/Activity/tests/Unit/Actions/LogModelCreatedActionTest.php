<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Tests\Fixtures\LogModelCreatedActionTestModel;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

<<<<<<< .merge_file_KyuU8I
test('LogModelCreatedAction can be instantiated', function () {
    $model = new class extends Model
    {
        protected $table = 'test_models';
=======
test('LogModelCreatedAction execute persiste created con subject e causer', function (): void {
    $model = new LogModelCreatedActionTestModel;
    $model->forceFill(['id' => 'created-1', 'name' => 'Created']);
    $model->exists = true;
>>>>>>> .merge_file_SNZzRz

    $user = new User;
    $user->forceFill([
        'id' => 'causer-created-1',
        'name' => 'Causer',
        'email' => 'causer-created-1@example.test',
    ]);
    $user->exists = true;

    $activity = (new LogModelCreatedAction($model, $user))->execute();

    Assert::assertSame('created', $activity->event);
    Assert::assertSame($model::class, $activity->subject_type);
    Assert::assertSame($model->getKey(), $activity->subject_id);
<<<<<<< .merge_file_KyuU8I
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
=======
    Assert::assertSame($user->id, $activity->causer_id);
});

test('LogModelCreatedAction execute accetta model passato a execute', function (): void {
    $model = new LogModelCreatedActionTestModel;
    $model->forceFill(['id' => 'created-2', 'name' => 'ViaExecute']);
    $model->exists = true;
>>>>>>> .merge_file_SNZzRz

    $activity = (new LogModelCreatedAction)->execute($model);

<<<<<<< .merge_file_KyuU8I
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
=======
    Assert::assertSame('created', $activity->event);
    Assert::assertSame($model::class, $activity->subject_type);
>>>>>>> .merge_file_SNZzRz
});
