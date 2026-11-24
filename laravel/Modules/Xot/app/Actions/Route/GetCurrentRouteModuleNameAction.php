<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-current-route-module-name-action.md
 * @contract docs/contracts/get-current-route-module-name-action.md
 */
class GetCurrentRouteModuleNameAction
{
    use QueueableAction;

    public function execute(): string
    {
        $routeAction = app(GetCurrentRouteHandlerAction::class)->execute();

        return Str::between($routeAction, 'Modules\\', '\\Http');
    }
}
