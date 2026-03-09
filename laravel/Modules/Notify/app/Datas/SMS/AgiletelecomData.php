<?php

declare(strict_types=1);

namespace Modules\Notify\Datas\SMS;

use Illuminate\Support\Facades\Config;
use Spatie\LaravelData\Data;

class AgiletelecomData extends Data
{
    public ?string $username;

    public ?string $password;

    public ?string $sender;

    public ?string $endpoint;

    public ?string $enable_delivery;

    public ?string $simulation;

    public string $auth_type = 'basic';

    public ?string $api_key;

    public ?string $oauth_token;

    public int $timeout = 30;

    private static ?self $instance = null;

    public static function make(): self
    {
        if (! (self::$instance instanceof AgiletelecomData)) {
            /*
             * $data = TenantService::getConfig('sms');
             * $data = Arr::get($data, 'drivers.agiletelecom', []);
             */
            $data = Config::array('sms.drivers.agiletelecom');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function getAuthHeaders(): array
    {
        switch ($this->auth_type) {
            case 'api_key':
                return [
                    'Authorization' => 'Api-Key '.$this->api_key,
                    'Content-Type' => 'application/json',
                ];

            case 'oauth':
                return [
                    'Authorization' => 'OAuth '.$this->oauth_token,
                    'Content-Type' => 'application/json',
                ];

            case 'basic':
            default:
                return [
                    'Authorization' => 'Basic '.base64_encode($this->username.':'.$this->password),
                    'Content-Type' => 'application/json',
                ];
        }
    }
}
