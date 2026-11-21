<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Activity\Actions\ActivityMaintenanceAction;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ActivityMaintenanceAction rifiuta giorni non positivi', function (): void {
    expect(fn (): int => (new ActivityMaintenanceAction)->execute(0))
        ->toThrow(InvalidArgumentException::class, 'Days must be positive');

    expect(fn (): int => (new ActivityMaintenanceAction)->execute(-5))
        ->toThrow(InvalidArgumentException::class);
});

test('LogModelCreatedAction accetta model e user opzionale', function (): void {
    $model = new class extends Model
    {
        protected $table = 'stub_models';
    };

    $action = new LogModelCreatedAction(model: $model);
    Assert::assertSame($model, $action->model);
    Assert::assertNull($action->user);

    $user = new class extends Model
    {
        protected $table = 'users';
    };
    $withUser = new LogModelCreatedAction(model: $model, user: $user);
    Assert::assertSame($user, $withUser->user);
});

test('LogModelUpdatedAction e LogModelDeletedAction accettano model', function (): void {
    $model = new class extends Model
    {
        protected $table = 'stub_models';

        /** @var array<string, mixed> */
        protected $attributes = ['name' => 'test'];
    };

    $updated = new LogModelUpdatedAction(model: $model);
    Assert::assertSame($model, $updated->model);

    $deleted = new LogModelDeletedAction(model: $model);
    Assert::assertSame($model, $deleted->model);
});

test('LogUserLoginAction e LogUserLogoutAction accettano User', function (): void {
    $user = new User;

    $login = new LogUserLoginAction(user: $user);
    Assert::assertSame($user, $login->user);

    $logout = new LogUserLogoutAction(user: $user);
    Assert::assertSame($user, $logout->user);
});
