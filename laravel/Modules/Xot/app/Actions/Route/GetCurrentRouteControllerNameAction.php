<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-current-route-controller-name-action.md
<<<<<<< .merge_file_rCP7bW
 *
=======
>>>>>>> .merge_file_QSh3SN
 * @contract docs/contracts/get-current-route-controller-name-action.md
 */
class GetCurrentRouteControllerNameAction
{
    use QueueableAction;

    public function execute(): string
    {
        $routeAction = app(GetCurrentRouteHandlerAction::class)->execute();

        return Str::between($routeAction, 'Http\\Controllers\\', 'Controller');
    }
}
