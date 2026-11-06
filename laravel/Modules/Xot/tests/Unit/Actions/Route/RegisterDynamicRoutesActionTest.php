<?php

declare(strict_types=1);

use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Facades\Route;
use Modules\Xot\Actions\Route\RegisterDynamicRoutesAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/**
 * @param  array<int, array<string, mixed>>  $definitions
 */
function xotRegisterDynamicRoutes(array $definitions, ?string $namespace = null): void
{
    app(RegisterDynamicRoutesAction::class)->execute($definitions, $namespace, 'Modules\Foo\Http\Controllers');
    Route::getRoutes()->refreshNameLookups();
}

function xotDynamicRoute(string $name): IlluminateRoute
{
    $route = Route::getRoutes()->getByName($name);
    if (! $route instanceof IlluminateRoute) {
        throw new RuntimeException("Route {$name} was not registered.");
    }

    return $route;
}

/**
 * Sostituisce le asserzioni di RouteDynService/RouteDynAction (metodi statici che ora sono passi privati
 * dell'Action): prefix, namespace, as, controller, uses e method si leggono dalle route registrate.
 */
it('registers the resource and the acts of a simple definition', function (): void {
    xotRegisterDynamicRoutes([[
        'name' => 'xotposts',
        'param_name' => '',
        'acts' => [
            ['name' => 'xotposts'],
            ['name' => 'feed', 'method' => 'get'],
            ['name' => 'draft', 'act' => 'index-act', 'method' => ['get', 'head']],
        ],
    ]]);

    $index = xotDynamicRoute('xotposts.index');
    $default = xotDynamicRoute('xotposts.xotposts');

    expect($index->uri())->toBe('xotposts')
        ->and($index->getAction('uses'))->toBe('XotpostsController@index')
        ->and($default->uri())->toBe('xotposts/xotposts')
        ->and($default->getAction('namespace'))->toBe('Xotposts')
        ->and($default->getAction('uses'))->toBe('\Modules\Foo\Http\Controllers\XotpostsController@xotposts')
        // senza `method` l'act risponde a get e post (Route::match aggiunge HEAD)
        ->and($default->methods())->toEqualCanonicalizing(['GET', 'POST', 'HEAD'])
        ->and(xotDynamicRoute('xotposts.feed')->methods())->toEqualCanonicalizing(['GET', 'HEAD'])
        ->and(xotDynamicRoute('xotposts.draft')->getAction('uses'))
        ->toBe('\Modules\Foo\Http\Controllers\XotpostsController@index-act');
});

it('derives names, controller and namespace from a parametrized definition with an explicit prefix', function (): void {
    xotRegisterDynamicRoutes([[
        'name' => 'Xotarticles/{id}',
        'prefix' => 'xotarticles',
        'acts' => [['name' => 'archive']],
    ]], 'Api');

    foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $resourceAction) {
        expect(xotDynamicRoute('xotarticles.id.'.$resourceAction)->getAction('uses'))
            ->toBe('XotarticlesIdController@'.$resourceAction);
    }

    $archive = xotDynamicRoute('xotarticles.id.archive');

    expect($archive->uri())->toBe('xotarticles/archive')
        ->and($archive->getAction('namespace'))->toBe('Xotarticles/id')
        ->and($archive->getAction('uses'))->toBe('\Modules\Foo\Http\Controllers\XotarticlesIdController@archive');
});


it('refuses an empty definition list', function (): void {
    expect(fn () => app(RegisterDynamicRoutesAction::class)->execute([]))->toThrow(InvalidArgumentException::class);
});
