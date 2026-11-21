<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Tests\Fixtures\LogModelDeletedActionTestModel;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

<<<<<<< .merge_file_pvdv4M
test('LogModelDeletedAction can be instantiated', function () {
    $model = new class extends Model
    {
        protected $table = 'test_models';
=======
test('LogModelDeletedAction execute persiste deleted con subject e causer', function (): void {
    $model = new LogModelDeletedActionTestModel;
    $model->forceFill(['id' => 'deleted-1', 'name' => 'Deleted']);
    $model->exists = true;
>>>>>>> .merge_file_Am0xmI

    $user = new User;
    $user->forceFill([
        'id' => 'causer-deleted-1',
        'name' => 'Causer',
        'email' => 'causer-deleted-1@example.test',
    ]);
    $user->exists = true;

    $activity = (new LogModelDeletedAction($model, $user))->execute();

    Assert::assertSame('deleted', $activity->event);
    Assert::assertSame($model::class, $activity->subject_type);

    $subjectKey = $model->getKey();
    Assert::assertIsString($subjectKey);
    Assert::assertIsString($activity->subject_id);
    Assert::assertSame($subjectKey, $activity->subject_id);
    Assert::assertSame($user->id, $activity->causer_id);
});
