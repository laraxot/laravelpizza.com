<?php

declare(strict_types=1);

// https://phpstan.org/user-guide/discovering-symbols

define('LARAVEL_DIR', __DIR__);

if (! function_exists('getRouteParameters')) {
    /** @return array<string, mixed> */
    function getRouteParameters(): array
    {
        return request()->route()?->parameters() ?? [];
    }
}
