<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Xot\Actions\Route\GetCurrentRouteActionNameAction;
use Modules\Xot\Actions\Route\GetCurrentRouteControllerNameAction;
use Modules\Xot\Actions\Route\GetCurrentRouteHandlerAction;
use Modules\Xot\Actions\Route\GetCurrentRouteModuleNameAction;
use Modules\Xot\Actions\Route\GetCurrentRouteViewAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/**
 * Registra una route che risponde con una closure ma dichiara il handler `controller` come una route a controller:
 * si puo' dispatchare davvero senza che la classe del controller esista.
 */
function xotRouteWithHandler(string $uri, string $handler): void
{
    $route = Route::get($uri, static fn (): string => 'ok');
    $action = $route->getAction();
    if (! is_array($action)) {
        throw new RuntimeException('A route action must be an array.');
    }

    $action['controller'] = $handler;
    $route->setAction($action);
}

it('derives module, controller, action and view from the current controller route', function (): void {
    xotRouteWithHandler('/xot-route-actions/profile', 'Modules\Foo\Http\Controllers\ProfileController@editProfile');

    $this->get('/xot-route-actions/profile')->assertOk();

    expect(app(GetCurrentRouteHandlerAction::class)->execute())
        ->toBe('Modules\Foo\Http\Controllers\ProfileController@editProfile')
        ->and(app(GetCurrentRouteModuleNameAction::class)->execute())->toBe('Foo')
        ->and(app(GetCurrentRouteControllerNameAction::class)->execute())->toBe('Profile')
        ->and(app(GetCurrentRouteActionNameAction::class)->execute())->toBe('edit_profile')
        ->and(app(GetCurrentRouteViewAction::class)->execute())->toBe('profile');
});

it('drops the Module and Item namespaces from the view name', function (): void {
    xotRouteWithHandler('/xot-route-actions/posts', 'Modules\Foo\Http\Controllers\Module\Item\PostsController@index');

    $this->get('/xot-route-actions/posts')->assertOk();

    expect(app(GetCurrentRouteControllerNameAction::class)->execute())->toBe('Module\Item\Posts')
        ->and(app(GetCurrentRouteViewAction::class)->execute())->toBe('posts');
});

it('replaces the containers part of the view with the container route parameters', function (): void {
    xotRouteWithHandler(
        '/xot-route-actions/c/{container0}/{item0}/{container1}',
        'Modules\Foo\Http\Controllers\ContainersController@index',
    );

    $this->get('/xot-route-actions/c/posts/12/comments')->assertOk();

    expect(app(GetCurrentRouteViewAction::class)->execute())->toBe('posts.comments');
});

it('refuses a closure route because it has no controller action to read', function (): void {
    Route::get('/xot-route-actions/closure', static fn (): string => 'ok');

    $this->get('/xot-route-actions/closure')->assertOk();

    foreach ([
        GetCurrentRouteHandlerAction::class,
        GetCurrentRouteModuleNameAction::class,
        GetCurrentRouteControllerNameAction::class,
        GetCurrentRouteActionNameAction::class,
        GetCurrentRouteViewAction::class,
    ] as $action) {
        expect(fn (): string => app($action)->execute())->toThrow(RuntimeException::class);
    }
});
