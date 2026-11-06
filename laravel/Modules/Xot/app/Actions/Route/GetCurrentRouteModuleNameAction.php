<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class GetCurrentRouteModuleNameAction
{
    use QueueableAction;

    public function execute(): string
    {
        $routeAction = app(GetCurrentRouteHandlerAction::class)->execute();

        return Str::between($routeAction, 'Modules\\', '\\Http');
    }
}
