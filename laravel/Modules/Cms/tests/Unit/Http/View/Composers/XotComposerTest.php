<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Modules\Cms\Http\View\Composers\XotComposer;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

test('compose returns early when no authenticated user', function (): void {
    Auth::shouldReceive('user')->once()->andReturn(null);

    $view = cmsCreateMock(View::class);

    $composer = new XotComposer();
    $composer->compose($view);
});

test('compose returns early when authenticated user is not user contract', function (): void {
    $authUser = cmsCreateMock(Authenticatable::class);
    Auth::shouldReceive('user')->once()->andReturn($authUser);

    $view = cmsCreateMock(View::class);

    $composer = new XotComposer();
    $composer->compose($view);
});

test('compose shares params lang and profile when user contract is authenticated', function (): void {
    app()->setLocale('it');

    $profile = (object) ['id' => 123];
    $testCase = cmsTest();

    $profileRelation = $testCase->createPHPUnitMock(HasOne::class);
    $profileRelation->method('first')->willReturn($profile);

    $user = $testCase->createPHPUnitMock(UserContract::class);
    $user->method('profile')->willReturn($profileRelation);

    Auth::shouldReceive('user')->once()->andReturn($user);

    $route = $testCase->createPHPUnitMock(IlluminateRoute::class);
    $route->method('parameters')->willReturn(['slug' => 'about']);
    Route::shouldReceive('current')->once()->andReturn($route);

    $view = $testCase->createPHPUnitMock(View::class);
    $calls = 0;
    $view->method('with')->willReturnCallback(
        static function (string $key, mixed $value) use ($view, $profile, &$calls): View {
            $calls = (int) $calls + 1;
            if (1 === $calls) {
                Assert::assertSame('params', $key);
                Assert::assertSame(['slug' => 'about'], $value);
            } elseif (2 === $calls) {
                Assert::assertSame('lang', $key);
                Assert::assertSame('it', $value);
            } else {
                Assert::assertSame('profile', $key);
                Assert::assertSame($profile, $value);
            }

            return $view;
        }
    );

    $composer = new XotComposer();
    $composer->compose($view);
});
