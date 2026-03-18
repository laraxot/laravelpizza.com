<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Middleware;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use Symfony\Component\HttpFoundation\Response;

function invokeProtected(object $object, string $method, array $args = []): mixed
{
    $reflection = new \ReflectionClass($object);
    $target = $reflection->getMethod($method);
    $target->setAccessible(true);

    return $target->invokeArgs($object, $args);
}

function setProtected(object $object, string $property, mixed $value): void
{
    $reflection = new \ReflectionClass($object);
    $target = $reflection->getProperty($property);
    $target->setAccessible(true);
    $target->setValue($object, $value);
}

test('handle returns next response when slug is not a string', function (): void {
    $request = Request::create('/test', 'GET');
    $middleware = new PageSlugMiddleware();

    $response = $middleware->handle($request, fn (Request $req): Response => new Response('ok', 200));

    expect($response->getStatusCode())->toBe(200)
        ->and($response->getContent())->toBe('ok');
});

test('handle wraps non-response next value into 500 response when slug is not a string', function (): void {
    $request = Request::create('/test', 'GET');
    $middleware = new PageSlugMiddleware();

    $response = $middleware->handle($request, fn (Request $req) => 'not-a-response');

    expect($response->getStatusCode())->toBe(500)
        ->and($response->getContent())->toBe('Internal Server Error');
});

test('parseMiddleware splits name and parameters', function (): void {
    $middleware = new PageSlugMiddleware();

    /** @var array{0:string,1:array<string>} $parsed */
    $parsed = invokeProtected($middleware, 'parseMiddleware', ['throttle:60,1']);

    expect($parsed[0])->toBe('throttle')
        ->and($parsed[1])->toBe(['60', '1']);
});

test('resolveMiddlewareClass returns mapped class for alias', function (): void {
    $middleware = new PageSlugMiddleware();
    $kernel = \Mockery::mock(Kernel::class);
    $kernel->shouldReceive('getRouteMiddleware')
        ->once()
        ->andReturn(['auth' => \Illuminate\Auth\Middleware\Authenticate::class]);

    setProtected($middleware, 'kernel', $kernel);

    $resolved = invokeProtected($middleware, 'resolveMiddlewareClass', ['auth']);

    expect($resolved)->toBe(\Illuminate\Auth\Middleware\Authenticate::class);
});

test('executeMiddlewareChain returns 500 when final closure does not return response', function (): void {
    $middleware = new PageSlugMiddleware();
    $request = Request::create('/test', 'GET');

    /** @var Response $response */
    $response = invokeProtected($middleware, 'executeMiddlewareChain', [
        $request,
        [],
        fn (Request $req) => 'not-a-response',
    ]);

    expect($response->getStatusCode())->toBe(500)
        ->and($response->getContent())->toBe('Internal Server Error');
});
