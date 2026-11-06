<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class GetCurrentRouteViewAction
{
    use QueueableAction;

    public function execute(): string
    {
        $routeAction = app(GetCurrentRouteHandlerAction::class)->execute();
        $controller = Str::between($routeAction, 'Http\\Controllers\\', 'Controller');
        /** @var array<string, mixed> $params */
        $params = [];
        $route = request()->route();
        foreach ($route instanceof Route ? $route->parameters() : [] as $key => $value) {
            if (is_string($key)) {
                $params[$key] = $value;
            }
        }

        $params['containers'] = implode('.', array_map(
            static fn (mixed $value): string => is_scalar($value) ? (string) $value : '',
            array_values(array_filter(
                $params,
                static fn (string $key): bool => str_starts_with($key, 'container'),
                ARRAY_FILTER_USE_KEY,
            )),
        ));

        return collect(explode('\\', $controller))
            ->reject(static fn (string $part): bool => in_array($part, ['Module', 'Item'], true))
            ->map(static function (string $part) use ($params): string {
                $part = Str::snake($part);
                $value = $params[$part] ?? $part;

                return is_scalar($value) || $value instanceof \Stringable ? (string) $value : $part;
            })
            ->implode('.');
    }
}
