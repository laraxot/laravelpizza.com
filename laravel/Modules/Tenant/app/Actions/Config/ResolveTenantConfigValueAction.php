<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Xot\Services\RouteService;
use Nwidart\Modules\Facades\Module;
use Spatie\QueueableAction\QueueableAction;

class ResolveTenantConfigValueAction
{
    use QueueableAction;

    /**
     * @param  string|int|array<mixed>|null  $_default
     * @return float|int|string|array<mixed>|null
     */
    public function execute(string $key, string|int|array|null $_default = null): float|int|string|array|null
    {
        if (app()->runningInConsole()) {
            $default = $_default;
            $res = config($key, $default);
            if (is_numeric($res) || \is_string($res) || \is_array($res) || $res === null) {
                /** @var float|int|string|array<mixed>|null $res */
                return $res;
            }

            throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
        }

       
        $group = collect(explode('.', $key))->first();

        $originalConf = config((string) $group);
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
        if ($group === null) {
            throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
        }

        Config::set((string) $group, $mergeConf);

        $res = config($key);

        if ($res === null && isset($_default)) {
            $index = Str::after($key, $group.'.');
            Arr::set($extraConf, $index, $_default);

            throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
        }

        if (is_numeric($res) || \is_string($res) || \is_array($res) || $res === null) {
            return $res;
        }

        throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
    }
}


