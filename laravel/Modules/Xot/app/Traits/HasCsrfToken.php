<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

trait HasCsrfToken
{
    /**
     * CSRF token for the current request.
     */
    public string $_token;

    /**
     * Mount the component and set the CSRF token.
     */
    public function mount(): void
    {
        $_token = App::make('session');
    }

    /**
     * Get the CSRF token.
     */
    public function getCsrfToken(): string
    {
        return $_token;
    }

    /**
     * Verify if the CSRF token is valid.
     */
    public function verifyCsrfToken(): bool
    {
        return Session::token() === $_token;
    }
}
