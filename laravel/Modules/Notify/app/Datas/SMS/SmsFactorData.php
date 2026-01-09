<?php

declare(strict_types=1);

namespace Modules\Notify\Datas\SMS;

use Illuminate\Support\Facades\Config;
use Spatie\LaravelData\Data;

class SmsFactorData extends Data
{
    public ?string $token;

    public ?string $base_url;

    public string $auth_type = 'bearer';

    public int $timeout = 30;

    private static ?self $instance = null;

    public static function make(): self
    {
        if (! (self::$instance instanceof SmsFactorData)) {
            /*
             * $data = TenantService::getConfig('sms');
             * $data = Arr::get($data, 'drivers.smsfactor', []);
             */
            $data = Config::array('sms.drivers.smsfactor');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function getAuthHeaders(): array
    {
        switch ($this->auth_type) {
            case 'bearer':
            default:
                return [
                    'Authorization' => 'Bearer '.$this->token,
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                ];
        }
    }

    public function getBaseUrl(): string
    {
        return $this->base_url ?? 'https://api.smsfactor.com';
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }
}
