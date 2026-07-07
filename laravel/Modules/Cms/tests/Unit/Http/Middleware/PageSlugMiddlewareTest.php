<?php

declare(strict_types=1);

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

uses(Modules\Cms\Tests\TestCase::class);
/**
 * @param array<int, mixed> $args
 */
function invokeProtected(object $object, string $method, array $args = []): mixed
{
    $reflection = new ReflectionClass($object);
    $target = $reflection->getMethod($method);
    $target->setAccessible(true);

    return $target->invokeArgs($object, $args);
}

function setProtected(object $object, string $property, mixed $value): void
{
    $reflection = new ReflectionClass($object);
    $target = $reflection->getProperty($property);
    $target->setAccessible(true);
    $target->setValue($object, $value);
}

test('handle returns next response when cms page slug cannot be resolved', function (): void {
    $request = Request::create('/test', 'GET');
    $middleware = new PageSlugMiddleware();

    $response = $middleware->handle($request, fn (Request $req): Response => new Response('ok', 200));

    Assert::assertSame(200, $response->getStatusCode());

    Assert::assertSame('ok', $response->getContent());
});

test('resolveCmsPageSlug prefers folio route name when it matches a cms page', function (): void {
    $middleware = new PageSlugMiddleware();
    $request = Request::create('/it/tickets/create', 'GET');
    $request->setRouteResolver(static function () use ($request) {
        return new Illuminate\Routing\Route(['GET'], '/it/tickets/create', static fn (): string => 'ok')
            ->name('tickets.create')
            ->bind($request);
    });

    $resolved = invokeProtected($middleware, 'resolveCmsPageSlug', [$request]);

    Assert::assertSame('tickets.create', $resolved);
});

test('resolveCmsPageSlug builds container0.slug0 for nested folio pages', function (): void {
    $middleware = new PageSlugMiddleware();
    $request = Request::create('/it/tickets/foo', 'GET');
    $request->setRouteResolver(static function () use ($request) {
        $route = new Illuminate\Routing\Route(['GET'], '/it/{container0}/{slug0}', static fn (): string => 'ok');
        $route->name('container0.view');
        $route->bind($request);
        $route->setParameter('container0', 'tickets');
        $route->setParameter('slug0', 'view');

        return $route;
    });

    $resolved = invokeProtected($middleware, 'resolveCmsPageSlug', [$request]);

    Assert::assertSame('tickets.view', $resolved);
});

test('handle wraps non-response next value into 500 response when slug is not a string', function (): void {
    $request = Request::create('/test', 'GET');
    $middleware = new PageSlugMiddleware();

    $response = $middleware->handle($request, fn (Request $req) => 'not-a-response');

    Assert::assertSame(500, $response->getStatusCode());

    Assert::assertSame('Internal Server Error', $response->getContent());
});

test('parseMiddleware splits name and parameters', function (): void {
    $middleware = new PageSlugMiddleware();

    /** @var array{0:string,1:array<string>} $parsed */
    $parsed = invokeProtected($middleware, 'parseMiddleware', ['throttle:60,1']);

    Assert::assertSame('throttle', $parsed[0]);

    Assert::assertSame(['60', '1'], $parsed[1]);
});

test('resolveMiddlewareClass returns mapped class for alias', function (): void {
    $middleware = new PageSlugMiddleware();
    /** @var Kernel&Mockery\MockInterface $kernel */
    $kernel = Mockery::mock(Kernel::class);
    $kernel->allows([
        'getRouteMiddleware' => ['auth' => Authenticate::class],
    ]);

    setProtected($middleware, 'kernel', $kernel);

    $resolved = invokeProtected($middleware, 'resolveMiddlewareClass', ['auth']);

    Assert::assertSame(Authenticate::class, $resolved);
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

    Assert::assertSame(500, $response->getStatusCode());

    Assert::assertSame('Internal Server Error', $response->getContent());
});
