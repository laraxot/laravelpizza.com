<?php

declare(strict_types=1);

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use Modules\Cms\Models\Page;
use Monolog\Handler\TestHandler;
use Monolog\Level;
use Monolog\Logger as Monolog;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/*
 * DCP-283 (C-03): PageSlugMiddleware deve essere fail-closed. Una pagina la cui protezione non si riesce a determinare
 * non va servita (503), e dal campo `middleware` del JSON si eseguono solo i middleware in allowlist.
 */

/** Middleware con effetto osservabile: se la allowlist non lo ferma, `$calls` sale. */
final class Dcp283ProbeMiddleware
{
    public static int $calls = 0;

    /** @param  Closure(Request): Response  $next */
    public function handle(Request $request, Closure $next): Response
    {
        self::$calls++;

        return $next($request);
    }
}

/** Middleware che non restituisce una Response: la richiesta non deve proseguire. */
final class Dcp283ReturnsNothingMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        return null;
    }
}

/** Classe esistente senza `handle`: la richiesta non deve proseguire. */
final class Dcp283NoHandleMiddleware {}

/**
 * Middleware con slug e middleware dichiarati decisi dal test (le due cuciture sono i metodi protetti).
 *
 * @param  Closure(string): list<string>  $declared
 */
function dcp283Middleware(Closure $declared, ?string $slug = 'dcp283.page'): PageSlugMiddleware
{
    return new class($declared, $slug) extends PageSlugMiddleware
    {
        /** @param Closure(string): list<string> $declared */
        public function __construct(private readonly Closure $declared, private readonly ?string $slug) {}

        protected function resolveCmsPageSlug(Request $request): ?string
        {
            return $this->slug;
        }

        protected function declaredMiddlewares(string $slug): array
        {
            return ($this->declared)($slug);
        }
    };
}

/** Stato HTTP della risposta o dell'eccezione HTTP lanciata (abort). `null` se la richiesta ha lanciato altro. */
function dcp283Status(Closure $run): int
{
    try {
        $response = $run();
        Assert::assertInstanceOf(Response::class, $response);

        return $response->getStatusCode();
    } catch (HttpException $exception) {
        return $exception->getStatusCode();
    }
}

/**
 * Contesti dei record `error` emessi durante `$run`, raccolti da un logger di prova (indipendente dalla configurazione).
 *
 * @param  Closure(): mixed  $run
 * @return list<array<mixed>>
 */
function dcp283LoggedErrors(Closure $run): array
{
    $handler = new TestHandler;
    Log::swap(new Logger(new Monolog('dcp283', [$handler])));
    $run();

    $contexts = [];
    foreach ($handler->getRecords() as $record) {
        if ($record->level === Level::Error) {
            $contexts[] = $record->context;
        }
    }

    return $contexts;
}

function dcp283Reached(): Closure
{
    return static fn (Request $request): Response => new Response('reached', 200);
}

test('una lettura dei middleware che fallisce rende la pagina 503, non pubblica', function (): void {
    $next = false;
    $middleware = dcp283Middleware(static fn (string $slug): array => throw new RuntimeException('lettura JSON fallita'));

    $status = dcp283Status(function () use ($middleware, &$next): Response {
        return $middleware->handle(Request::create('/it/x'), function (Request $request) use (&$next): Response {
            $next = true;

            return new Response('reached', 200);
        });
    });

    Assert::assertSame(503, $status);
    Assert::assertFalse($next, 'la pagina non deve essere servita');
});

test('il 503 registra il contesto della pagina senza dati personali', function (): void {
    $middleware = dcp283Middleware(static fn (string $slug): array => throw new RuntimeException('lettura JSON fallita'));

    $errors = dcp283LoggedErrors(fn (): int => dcp283Status(fn (): Response => $middleware->handle(Request::create('/it/profile/a-user-identifier?token=secret'), dcp283Reached())));

    Assert::assertCount(1, $errors);
    $context = $errors[0];
    $encoded = json_encode($context, JSON_THROW_ON_ERROR);
    Assert::assertSame('dcp283.page', $context['slug'] ?? null);
    Assert::assertStringNotContainsString('a-user-identifier', $encoded);
    Assert::assertStringNotContainsString('secret', $encoded);
    foreach (['ip', 'user', 'user_id', 'path', 'url'] as $forbidden) {
        Assert::assertArrayNotHasKey($forbidden, $context);
    }
});

test('uno slug duplicato nella ricerca della pagina rende la pagina 503, non pubblica', function (): void {
    $middleware = new class extends PageSlugMiddleware
    {
        protected function findPageBySlug(string $slug): ?Page
        {
            throw new RuntimeException("Page slug duplication detected for slug='{$slug}'");
        }
    };
    $request = Request::create('/it/dcp283/page');
    $request->setRouteResolver(static fn (): Route => (new Route(['GET'], '/it/dcp283/page', static fn (): string => 'ok'))->name('dcp283.page')->bind($request));

    Assert::assertSame(503, dcp283Status(fn (): Response => $middleware->handle($request, dcp283Reached())));
});

test('un middleware fuori allowlist non viene istanziato ne eseguito', function (): void {
    Dcp283ProbeMiddleware::$calls = 0;
    $middleware = dcp283Middleware(static fn (string $slug): array => [Dcp283ProbeMiddleware::class]);

    $status = dcp283Status(fn (): Response => $middleware->handle(Request::create('/it/x'), dcp283Reached()));

    Assert::assertSame(503, $status);
    Assert::assertSame(0, Dcp283ProbeMiddleware::$calls, 'una classe qualunque dal JSON non deve girare');
});

test('un refuso nel nome del middleware non rende pubblica la pagina', function (): void {
    $middleware = dcp283Middleware(static fn (string $slug): array => ['auht']);

    Assert::assertSame(503, dcp283Status(fn (): Response => $middleware->handle(Request::create('/it/x'), dcp283Reached())));
});

test('auth in allowlist esegue ancora la catena: un ospite non passa', function (): void {
    $middleware = dcp283Middleware(static fn (string $slug): array => ['auth']);

    expect(fn () => $middleware->handle(Request::create('/it/x'), dcp283Reached()))->toThrow(AuthenticationException::class);
});

test('throttle:10,1 in allowlist risponde come prima, con le intestazioni del limite', function (): void {
    $middleware = dcp283Middleware(static fn (string $slug): array => ['throttle:10,1']);
    $request = Request::create('/it/tickets/track', 'GET', [], [], [], ['REMOTE_ADDR' => '203.0.113.7']);
    $request->setRouteResolver(static fn (): Route => (new Route(['GET'], '/it/tickets/track', static fn (): string => 'ok'))->bind($request));

    $response = $middleware->handle($request, dcp283Reached());

    Assert::assertSame(200, $response->getStatusCode());
    Assert::assertSame('10', $response->headers->get('X-RateLimit-Limit'));
});

test('web resta un no-op: la pagina arriva a destinazione', function (): void {
    $middleware = dcp283Middleware(static fn (string $slug): array => ['web']);

    Assert::assertSame(200, dcp283Status(fn (): Response => $middleware->handle(Request::create('/it/x'), dcp283Reached())));
});

test('senza middleware dichiarati la pagina e pubblica come prima', function (): void {
    $middleware = dcp283Middleware(static fn (string $slug): array => []);

    Assert::assertSame(200, dcp283Status(fn (): Response => $middleware->handle(Request::create('/it/x'), dcp283Reached())));
});

test('un middleware che non restituisce una Response non lascia proseguire la richiesta', function (): void {
    $middleware = new PageSlugMiddleware;
    $kernel = (new ReflectionClass($middleware))->getProperty('kernel');
    $kernel->setValue($middleware, app(Kernel::class));
    $chain = (new ReflectionClass($middleware))->getMethod('executeMiddlewareChain');

    expect(fn () => $chain->invoke($middleware, Request::create('/it/x'), [Dcp283ReturnsNothingMiddleware::class], dcp283Reached()))
        ->toThrow(LogicException::class);
});

test('una classe senza handle non lascia proseguire la richiesta', function (): void {
    $middleware = new PageSlugMiddleware;
    $kernel = (new ReflectionClass($middleware))->getProperty('kernel');
    $kernel->setValue($middleware, app(Kernel::class));
    $chain = (new ReflectionClass($middleware))->getMethod('executeMiddlewareChain');

    expect(fn () => $chain->invoke($middleware, Request::create('/it/x'), [Dcp283NoHandleMiddleware::class], dcp283Reached()))
        ->toThrow(LogicException::class);
});
