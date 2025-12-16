<?php

declare(strict_types=1);

namespace Modules\Notify\Datas\SMS;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

class GammuData extends Data
{
    public null|string $path;
    public null|string $config;
    public int $timeout = 30;

    private static null|self $instance = null;

    public static function make(): self
    {
        if (!(self::$instance instanceof GammuData)) {
            /*
             * $data = TenantService::getConfig('sms');
             * $data = Arr::get($data, 'drivers.gammu', []);
             */
            $data = Config::array('sms.drivers.gammu');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function getPath(): string
    {
        return $this->path ?? '/usr/bin/gammu';
    }

    public function getConfig(): string
    {
        return $this->config ?? '/etc/gammurc';
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }
}
