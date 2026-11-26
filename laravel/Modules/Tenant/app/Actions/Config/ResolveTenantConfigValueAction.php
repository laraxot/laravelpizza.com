<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Exception;
use Spatie\QueueableAction\QueueableAction;

/**
 * Alias stabile di {@see GetTenantConfigValueAction}: stesso overlay config tenant.
 *
 * @see Modules/Tenant/docs/wiki/topics/resolve-tenant.md
 * @see Modules/Tenant/docs/wiki/topics/tenant-config.md
 */
class ResolveTenantConfigValueAction
{
    use QueueableAction;

    /**
     * Delega a GetTenantConfigValueAction (unica implementazione).
     *
     * @param  string  $key  Config key (e.g., 'app.name', 'mail.driver')
     * @param  string|int|array<mixed>|null  $_default  Default value if config not found
     * @return float|int|string|array<mixed>|null Resolved configuration value
     *
     * @throws Exception If config key is invalid or value type is unexpected
     *
     * @see Modules/Tenant/docs/wiki/topics/resolve-tenant.md
     */
    public function execute(string $key, string|int|array|null $_default = null): float|int|string|array|null
    {
        return app(GetTenantConfigValueAction::class)->execute($key, $_default);
    }
}
