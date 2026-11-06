<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Spatie\QueueableAction\QueueableAction;

class BuildNestedRouteNameAction
{
    use QueueableAction;

    /** @param array<string, mixed> $params */
    public function execute(array $params): string
    {
        $depth = is_numeric($params['n'] ?? null) ? (int) $params['n'] : 0;
        $action = is_string($params['act'] ?? null) ? $params['act'] : 'show';
        $parts = inAdmin($params) ? ['admin'] : [];

        for ($i = 0; $i <= $depth; $i++) {
            $parts[] = 'container'.$i;
        }

        $parts[] = $action;

        return implode('.', $parts);
    }
}
