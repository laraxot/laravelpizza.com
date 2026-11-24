<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-route-parameters-action.md
 * @contract docs/contracts/get-route-parameters-action.md
 */
class GetRouteParametersAction
{
    use QueueableAction;

    /**
     * Parametri della route corrente (es. anno, stabi, repar nei moduli PTV).
     *
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        if (app()->runningInConsole()) {
            return [];
        }

        $route = RouteFacade::current();
        if (! $route instanceof Route) {
            return [];
        }

        $parameters = [];
        foreach ($route->parameters() as $key => $value) {
            $parameters[(string) $key] = $value;
        }

        return $parameters;
    }
}
