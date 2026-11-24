<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Modules\Tenant\Actions\GetTenantNameAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-tenant-config-path-action.md
 * @contract docs/contracts/get-tenant-config-path-action.md
 */
class GetTenantConfigPathAction
{
    use QueueableAction;

    public function execute(string $key): string
    {
        $name = app(GetTenantNameAction::class)->execute();

        return str_replace('/', '.', $name).'.'.$key;
    }
}
