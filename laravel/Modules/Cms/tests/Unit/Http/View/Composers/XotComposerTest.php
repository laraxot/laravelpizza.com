<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Modules\Cms\Http\View\Composers\XotComposer;
use Modules\Cms\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('compose returns early when no authenticated user', function (): void {
    Auth::shouldReceive('user')->once()->andReturn(null);

    $view = cmsCreateMock(View::class);

    $composer = new XotComposer;
    $composer->compose($view);
});

test('compose returns early when authenticated user is not user contract', function (): void {
    $authUser = cmsCreateMock(Authenticatable::class);
    Auth::shouldReceive('user')->once()->andReturn($authUser);

    $view = cmsCreateMock(View::class);

    $composer = new XotComposer;
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
            if ($calls === 1) {
                Assert::assertSame('params', $key);
                Assert::assertSame(['slug' => 'about'], $value);
            } elseif ($calls === 2) {
                Assert::assertSame('lang', $key);
                Assert::assertSame('it', $value);
            } else {
                Assert::assertSame('profile', $key);
                Assert::assertSame($profile, $value);
            }

            return $view;
        }
    );

    $composer = new XotComposer;
    $composer->compose($view);
});
