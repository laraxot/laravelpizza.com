<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Middleware;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Modules\Cms\Models\Page;
use Symfony\Component\HttpFoundation\Response;

class PageSlugMiddleware
{
    protected Kernel $kernel;

    public function handle(Request $request, \Closure $next): Response
    {
        $slug = $request->route('slug');

        // Handle case where slug might be null or not a string
        if (! \is_string($slug)) {
            $response = $next($request);
            if (! $response instanceof Response) {
                // Middleware chain should always return Response, but if not, wrap it
                return new Response('Internal Server Error', 500);
            }

            return $response;
        }

        $middlewares = Page::getMiddlewareBySlug($slug);
        // Should return ["auth", "Modules\User\Http\Middleware\EnsureUserHasType:doctor"]

        if (empty($middlewares)) {
            $response = $next($request);
            if (! $response instanceof Response) {
                // Middleware chain should always return Response, but if not, wrap it
                return new Response('Internal Server Error', 500);
            }

            return $response;
        }
        $this->kernel = app(Kernel::class);

        // Execute middlewares manually in a chain
        return $this->executeMiddlewareChain($request, $middlewares, $next);
    }

    /**
     * Parse a middleware string to get the name and parameters.
     *
     * @return array{0: string, 1: array<string>}
     */
    protected function parseMiddleware(string $middleware): array
    {
        $parts = array_pad(explode(':', $middleware, 2), 2, '');
        $name = $parts[0];
        $parameters = $parts[1];

        if (\is_string($parameters)) {
            $parameters = explode(',', $parameters);
        } else {
            $parameters = [];
        }

        /* @var array<string> $parameters */
        return [$name, $parameters];
    }

    /**
     * Execute middleware chain manually.
     */
    protected function executeMiddlewareChain(Request $request, array $middlewares, \Closure $finalNext): Response
    {
        if (empty($middlewares)) {
            $response = $finalNext($request);
            if (! $response instanceof Response) {
                return new Response('Internal Server Error', 500);
            }

            return $response;
        }

        $middleware = array_shift($middlewares);
        if (! \is_string($middleware)) {
            $response = $finalNext($request);
            if (! $response instanceof Response) {
                return new Response('Internal Server Error', 500);
            }

            return $response;
        }

        [$middlewareClass, $parameters] = $this->parseMiddleware($middleware);

        // Resolve middleware class name if it's an alias
        $middlewareClass = $this->resolveMiddlewareClass($middlewareClass);
        // Create middleware instance
        /** @var object $middlewareInstance */
        $middlewareInstance = app($middlewareClass);

        // Create next closure for remaining middlewares
        $next = fn (Request $req): Response => $this->executeMiddlewareChain($req, $middlewares, $finalNext);

        // Execute current middleware
        if (\is_object($middlewareInstance) && method_exists($middlewareInstance, 'handle')) {
            if (empty($parameters)) {
                $response = $middlewareInstance->handle($request, $next);
                if (! $response instanceof Response) {
                    return $next($request); // Use next if current middleware didn't return Response
                }

                return $response;
            }

            $response = $middlewareInstance->handle($request, $next, ...$parameters);
            if (! $response instanceof Response) {
                return $next($request); // Use next if current middleware didn't return Response
            }

            return $response;
        }

        // If middleware doesn't exist or doesn't have handle method, continue with next
        return $next($request);
    }

    /**
     * Resolve middleware class name from alias.
     */
    protected function resolveMiddlewareClass(string $middleware): string
    {
        // Get middleware aliases from HTTP kernel
        // $kernel = app(\Illuminate\Contracts\Http\Kernel::class);

        // Try to get from route middleware (custom middleware)
        // method_exists will always be true for Http\Kernel, so we can remove the check
        /** @var array<string, class-string> $routeMiddleware */
        $routeMiddleware = $this->kernel->getRouteMiddleware();
        if (isset($routeMiddleware[$middleware])) {
            /* @var class-string */
            return $routeMiddleware[$middleware];
        }

        // If not an alias, return as-is (assuming it's a full class name)
        return $middleware;
    }
}
