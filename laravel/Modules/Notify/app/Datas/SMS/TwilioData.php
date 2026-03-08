<?php

declare(strict_types=1);

namespace Modules\Notify\Datas\SMS;

use Illuminate\Support\Facades\Config;
use Spatie\LaravelData\Data;

class TwilioData extends Data
{
    public ?string $account_sid;

    public ?string $auth_token;

    public ?string $base_url;

    public string $auth_type = 'basic';

    public int $timeout = 30;

    private static ?self $instance = null;

    public static function make(): self
    {
        if (! (self::$instance instanceof TwilioData)) {
            /*
             * $data = TenantService::getConfig('sms');
             * $data = Arr::get($data, 'drivers.twilio', []);
             */
            $data = Config::array('sms.drivers.twilio');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function getAuthHeaders(): array
    {
        switch (// @var mixed auth_type
            case 'basic':
            default:
                return [
                    'Authorization' => 'Basic '.base64_encode(// @var mixed account_sid.':'.$this->auth_token
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ];
        }
    }

    public function getBaseUrl(): string
    {
        return // @var mixed base_url ?? 'https://api.twilio.com';
    }

    public function getTimeout(): int
    {
        return // @var mixed timeout;
    }
}
