<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\View\Composers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Modules\Cms\Http\View\Composers\XotComposer;
use Modules\Xot\Contracts\UserContract;

test('compose returns early when no authenticated user', function (): void {
    Auth::shouldReceive('user')->once()->andReturn(null);

    $view = \Mockery::mock(View::class);
    $view->shouldNotReceive('with');

    $composer = new XotComposer();
    $composer->compose($view);

    expect(true)->toBeTrue();
});

test('compose returns early when authenticated user is not user contract', function (): void {
    $authUser = \Mockery::mock(Authenticatable::class);
    Auth::shouldReceive('user')->once()->andReturn($authUser);

    $view = \Mockery::mock(View::class);
    $view->shouldNotReceive('with');

    $composer = new XotComposer();
    $composer->compose($view);

    expect(true)->toBeTrue();
});

test('compose shares params lang and profile when user contract is authenticated', function (): void {
    app()->setLocale('it');

    $profile = (object) ['id' => 123];

    $profileRelation = \Mockery::mock(HasOne::class);
    $profileRelation->shouldReceive('first')->once()->andReturn($profile);

    $user = \Mockery::mock(UserContract::class);
    $user->shouldReceive('profile')->once()->andReturn($profileRelation);

    Auth::shouldReceive('user')->once()->andReturn($user);

    $route = \Mockery::mock(IlluminateRoute::class);
    $route->shouldReceive('parameters')->once()->andReturn(['slug' => 'about']);
    Route::shouldReceive('current')->once()->andReturn($route);

    $view = \Mockery::mock(View::class);
    $view->shouldReceive('with')->once()->with('params', ['slug' => 'about']);
    $view->shouldReceive('with')->once()->with('lang', 'it');
    $view->shouldReceive('with')->once()->with('profile', $profile);

    $composer = new XotComposer();
    $composer->compose($view);

    expect(true)->toBeTrue();
});
