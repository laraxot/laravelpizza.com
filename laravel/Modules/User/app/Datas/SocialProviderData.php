<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Data;

/**
 * Undocumented class.
 */
class SocialProviderData extends Data
{
    public string $name; // ' => 'Facebook',

    public ?array $scopes = null;

    public ?array $parameters = null;

    public bool $stateless = true;

    public bool $active = true;

    public bool $socialite = true;

    public ?string $svg = null;

    // 'svg' => '<svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none"><path fill="#0866FF" d="M48 24C48 10.745 37.255 0 24 0S0 10.745 0 24c0 11.255 7.75 20.7 18.203 23.293V31.334h-4.95V24h4.95v-3.16c0-8.169 3.697-11.955 11.716-11.955 1.521 0 4.145.298 5.218.596v6.648c-.566-.06-1.55-.09-2.773-.09-3.935 0-5.455 1.492-5.455 5.367V24h7.84L33.4 31.334H26.91v16.49C38.793 46.39 48 36.271 48 24H48Z"/><path fill="#fff" d="M33.4 31.334 34.747 24h-7.84v-2.594c0-3.875 1.521-5.366 5.457-5.366 1.222 0 2.206.03 2.772.089V9.481c-1.073-.299-3.697-.596-5.218-.596-8.02 0-11.716 3.786-11.716 11.955V24h-4.95v7.334h4.95v15.96a24.042 24.042 0 0 0 8.705.53v-16.49H33.4Z"/></svg>',
    public ?string $client_id = null; // => env('FACEBOOK_CLIENT_ID'),

    public ?string $client_secret = null; // => env('FACEBOOK_CLIENT_SECRET'),

    private static ?self $instance = null;

    public static function make(): self
    {
        if (! self::$instance) {
            $data = TenantService::getConfig('social-providers');
            dddx($data);
            self::$instance = self::from($data);
        }

        return self::$instance;
    }
}
