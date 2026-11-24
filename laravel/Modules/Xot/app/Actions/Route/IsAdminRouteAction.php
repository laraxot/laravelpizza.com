<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/is-admin-route-action.md
 * @contract docs/contracts/is-admin-route-action.md
 */
class IsAdminRouteAction
{
    use QueueableAction;

    /** @param array<string, mixed> $params */
    public function execute(array $params = []): bool
    {
        if (isset($params['in_admin'])) {
            return (bool) $params['in_admin'];
        }

        if (request()->segment(1) === 'admin') {
            return true;
        }

        $segments = request()->segments();

        return $segments !== [] && $segments[0] === 'livewire' && session('in_admin', false) === true;
    }
}
