<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Middleware;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Actions\ValidatePageMiddlewareAction;
use Modules\Cms\Models\Page;
use Symfony\Component\HttpFoundation\Response;

class PageSlugMiddleware
{
    /**
     * Gruppi gia' applicati dallo stack Folio: una voce `web` nel JSON non ha effetto.
     * Prima faceva `Target class [web] does not exist` (500 per tutti): D17, 2026-10-13.
     */
    private const array GROUPS_ALREADY_APPLIED = ValidatePageMiddlewareAction::FOLIO_APPLIED_GROUPS;

    protected Kernel $kernel;

    public function handle(Request $request, \Closure $next): Response
    {
        $middlewares = $this->middlewaresOrRefuse($request);

        // Execute middlewares manually in a chain (con lista vuota la catena chiama solo `$next`).
        return $this->executeMiddlewareChain($request, $middlewares, $next);
    }

    /**
     * Middleware dichiarati dalla pagina CMS della richiesta, gia' validati (allowlist e risolvibilita').
     *
     * Fail-closed (DCP-283, C-03): se non si riesce a determinare la protezione di una pagina (ricerca dello slug,
     * lettura o validazione dei middleware) la pagina non viene servita: 503. Prima l'eccezione era inghiottita e la
     * pagina diventava pubblica. Il log porta slug, nomi dei middleware e tipo di errore; mai IP, utente, percorso o
     * query string (il percorso puo' contenere identificativi).
     *
     * @return list<string>
     */
    protected function middlewaresOrRefuse(Request $request): array
    {
        $slug = null;
        $declared = [];

        try {
            $slug = $this->resolveCmsPageSlug($request);
            if ($slug === null) {
                return [];
            }

            // Should return ["auth", "throttle:10,1"]
            $declared = $this->declaredMiddlewares($slug);
            if ($declared === []) {
                return [];
            }

            $this->kernel = app(Kernel::class);
            $middlewares = app(ValidatePageMiddlewareAction::class)->execute($declared);
            foreach ($middlewares as $middleware) {
                $name = $this->parseMiddleware($middleware)[0];
                if (! \in_array($name, self::GROUPS_ALREADY_APPLIED, true)) {
                    $this->assertResolvable($this->resolveMiddlewareClass($name), $middleware);
                }
            }

            return $middlewares;
        } catch (\Throwable $exception) {
            Log::error('Pagina CMS non servita: la sua protezione non e determinabile.', [
                'slug' => $slug,
                'middleware' => $declared,
                'exception' => $exception::class,
                // Il messaggio solo se scritto da noi: quelli del database possono contenere il valore cercato (parte dell'URL).
                'reason' => $exception instanceof \InvalidArgumentException || $exception instanceof \UnexpectedValueException
                    ? $exception->getMessage()
                    : basename($exception->getFile()).':'.$exception->getLine(),
            ]);

            abort(503);
        }
    }

    /**
     * Middleware dichiarati dal JSON della pagina `$slug`. Lancia se il campo e' illeggibile.
     *
     * @return list<string>
     */
    protected function declaredMiddlewares(string $slug): array
    {
        return Page::getMiddlewareBySlug($slug);
    }

    protected function findPageBySlug(string $slug): ?Page
    {
        return Page::findUniqueBySlug($slug);
    }

    /**
     * Un nome non risolvibile (refuso, gruppo) non si ignora mai: ignorarlo renderebbe pubblica una pagina protetta.
     */
    protected function assertResolvable(string $middlewareClass, string $declared): void
    {
        if (! class_exists($middlewareClass) && ! app()->bound($middlewareClass)) {
            throw new \InvalidArgumentException(sprintf("Middleware CMS '%s' non risolvibile: usare un alias (es. 'auth') o una classe esistente; 'web' e' gia' applicato dallo stack Folio.", $declared));
        }
    }

    /**
     * Resolve CMS page slug from Folio route (name, container+segment, or single slug).
     */
    protected function resolveCmsPageSlug(Request $request): ?string
    {
        $route = $request->route();
        if ($route === null) {
            return null;
        }

        /** @var list<string> $candidates */
        $candidates = [];

        $name = $route->getName();
        if (\is_string($name) && $name !== '') {
            $candidates[] = $name;
        }

        $container0 = $route->parameter('container0');
        $slug0 = $route->parameter('slug0');
        if (\is_string($container0) && $container0 !== '' && \is_string($slug0) && $slug0 !== '') {
            $candidates[] = $container0.'.'.$slug0;
        }

        $container = $route->parameter('container');
        $slug = $route->parameter('slug');
        if (\is_string($container) && $container !== '' && \is_string($slug) && $slug !== '') {
            $candidates[] = $container.'.'.$slug;
        }
        if (\is_string($container0) && $container0 !== '' && \is_string($slug) && $slug !== '') {
            $candidates[] = $container0.'.'.$slug;
        }

        foreach (['slug0', 'slug'] as $param) {
            $value = $route->parameter($param);
            if (\is_string($value) && $value !== '') {
                $candidates[] = $value;
            }
        }

        // Un errore nella ricerca (slug duplicato, JSON illeggibile) non salta il candidato: la pagina potrebbe essere proprio
        // quella protetta. Propaga e `handle()` risponde 503 (DCP-283, C-03).
        foreach (array_unique($candidates) as $candidate) {
            if ($this->findPageBySlug($candidate) !== null) {
                return $candidate;
            }
        }

        return null;
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
    /**
     * @param  array<int, string>  $middlewares
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

        if (\in_array($middlewareClass, self::GROUPS_ALREADY_APPLIED, true)) {
            return $this->executeMiddlewareChain($request, $middlewares, $finalNext);
        }

        // Resolve middleware class name if it's an alias
        $middlewareClass = $this->resolveMiddlewareClass($middlewareClass);

        $this->assertResolvable($middlewareClass, $middleware);

        // Create middleware instance
        /** @var object $middlewareInstance */
        $middlewareInstance = app($middlewareClass);

        // Create next closure for remaining middlewares
        $next = fn (Request $req): Response => $this->executeMiddlewareChain($req, $middlewares, $finalNext);

        // Execute current middleware. Una risposta che non e' una Response o un handle assente non lasciano proseguire:
        // far passare la richiesta renderebbe pubblica una pagina protetta (DCP-283, C-03).
        if (! method_exists($middlewareInstance, 'handle')) {
            throw new \LogicException(sprintf("Middleware CMS '%s' non ha il metodo handle: la pagina non viene servita.", $middleware));
        }

        $response = $parameters === []
            ? $middlewareInstance->handle($request, $next)
            : $middlewareInstance->handle($request, $next, ...$parameters);

        if (! $response instanceof Response) {
            throw new \LogicException(sprintf("Middleware CMS '%s' non ha restituito una risposta: la pagina non viene servita.", $middleware));
        }

        return $response;
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
        // `getRouteMiddleware()` e' deprecato e delega a `getMiddlewareAliases()`.
        $routeMiddleware = $this->kernel->getMiddlewareAliases();
        if (isset($routeMiddleware[$middleware])) {
            /* @var class-string */
            return $routeMiddleware[$middleware];
        }

        // If not an alias, return as-is (assuming it's a full class name)
        return $middleware;
    }
}
