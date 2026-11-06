<?php

declare(strict_types=1);

namespace Modules\User\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PasswordExpiryMiddleware
{
    /**
     * @param  \Closure(Request):((Response|RedirectResponse))  $next
     */
    public function handle(Request $request, \Closure $next): Response|RedirectResponse
    {
        if ($request->routeIs('password.change') || $request->routeIs('password.update')) {
            return $next($request);
        }

        if ($request->routeIs($this->getPasswordExpiryRoute()) || $request->routeIs('*.auth.*')) {
            return $next($request);
        }

        if ($this->passwordHasExpired()) {
            return redirect(route($this->getPasswordExpiryRoute()));
        }

        return $next($request);
    }

    public function getPasswordExpiryRoute(): string
    {
        return 'errors.password-expired';

        /*
         * $route = Filament::getCurrentPanel()->generateRouteName(
         * // config('password-expiry.password_expiry_route')
         * // 'password-expiry.reset-password'
         * // 'password.expired'
         * 'pages.password-expired'
         * ) ?? '#';
         *
         * return $route;
         * // */
        // return 'filament.admin.auth.password-reset.request';
    }

    protected function passwordHasExpired(): bool
    {
        $user = Auth::user();
        if (! $user) {
            return false;
        }

        if ($user->is_otp) {
            return true;
        }
        if (blank($user->password)) {
            return false;
        }

        if (blank($user->password_expires_at)) {
            return false;
        }

        if (now()->isAfter($user->password_expires_at)) {
            return true;
        }

        return false;
    }
}
