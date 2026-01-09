<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Modules\Tenant\Actions\GetTenantNameAction;
use Spatie\QueueableAction\QueueableAction;

class ResolveTenantConfigValueAction
{
    use QueueableAction;

    /**
     * Resolve tenant-specific configuration value.
     *
     * Merges base Laravel config with tenant-specific overrides.
     * Works consistently in web, console, queue, and scheduler contexts.
     *
     * @param  string  $key  Config key (e.g., 'app.name', 'mail.driver')
     * @param  string|int|array<mixed>|null  $_default  Default value if config not found
     *
     * @return float|int|string|array<mixed>|null Resolved configuration value
     *
     * @throws Exception If config key is invalid or value type is unexpected
     *
     * @see docs/resolve-tenant-config-console-debate.md
     */
    public function execute(string $key, string|int|array|null $_default = null): float|int|string|array|null
    {
        $group = Arr::first(explode('.', $key));
        if ($group === null || $group === '') {
            throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
        }

        $originalConf = config($group);
        $tenantName = app(GetTenantNameAction::class)->execute();

        $configName = str_replace('/', '.', $tenantName).'.'.$group;
        $extraConf = config($configName);

        if (! \is_array($originalConf)) {
            $originalConf = [];
        }

        if (! \is_array($extraConf)) {
            $extraConf = [];
        }

        $mergeConf = collect($originalConf)->merge($extraConf)->all();

        Config::set($group, $mergeConf);

        $res = config($key, $_default);

        if (is_numeric($res) || \is_string($res) || \is_array($res) || $res === null) {
            return $res;
        }

        throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
    }
}
