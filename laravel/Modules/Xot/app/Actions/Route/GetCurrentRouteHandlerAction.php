<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Routing\Route;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;

/**
 * Handler controller della route corrente (`Modules\Foo\Http\Controllers\BarController@index`).
 *
 * E' il punto unico da cui ricavano modulo, controller, azione e vista le altre
 * `GetCurrentRoute*Action`. Una route a closure non ha un handler `controller`: da li'
 * non si puo' ricavare nulla, quindi si lancia invece di restituire `Closure`.
 */
class GetCurrentRouteHandlerAction
{
    use QueueableAction;

    public function execute(): string
    {
        $route = request()->route();
        $handler = $route instanceof Route ? $route->getAction('controller') : null;
        if (! is_string($handler)) {
            throw new RuntimeException('The current route has no controller action.');
        }

        return $handler;
    }
}
