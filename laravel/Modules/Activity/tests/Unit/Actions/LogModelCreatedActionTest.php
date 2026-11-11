<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogModelCreatedAction can execute for a model', function (): void {
    $model = UserFactory::new()->createOne();
    $action = new LogModelCreatedAction;
    $activity = $action->execute($model);

    Assert::assertSame('created', $activity->event);
    Assert::assertSame($model->getKey(), $activity->subject_id);
});

test('LogModelCreatedAction accepts any Eloquent model', function (): void {
    $model = new class extends Model
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $action = new LogModelCreatedAction;
    $activity = $action->execute($model);

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
});
