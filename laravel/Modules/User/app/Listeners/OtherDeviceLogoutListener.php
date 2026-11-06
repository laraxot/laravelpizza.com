<?php

declare(strict_types=1);

namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\User\Actions\Authentication\GetAuthenticationLogQueryForAuthenticatableAction;
use Modules\User\Contracts\HasAuthentications;
use Modules\User\Contracts\UserContract;
use Modules\User\Models\AuthenticationLog;

// use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class OtherDeviceLogoutListener
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(OtherDeviceLogout $event): void
    {
        // Identità = UserContract; capability log = HasAuthentications (+ Model per Eloquent).
        if ($event->user instanceof UserContract
            && $event->user instanceof Model
            && $event->user instanceof HasAuthentications) {
            $user = $event->user;
            $ip = $this->request->ip();
            $userAgent = $this->request->userAgent();

            $logQuery = app(GetAuthenticationLogQueryForAuthenticatableAction::class)->execute($user);

            $authenticationLog = $logQuery
                ->where('ip_address', $ip)
                ->where('user_agent', $userAgent)
                ->first();

            if (! $authenticationLog instanceof AuthenticationLog) {
                $authenticationLog = new AuthenticationLog([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                ]);
            }

            $logQuery
                ->where('login_successful', true)
                ->whereNull('logout_at')
                ->where('id', '!=', $authenticationLog->getKey())
                ->update([
                    'cleared_by_user' => true,
                    'logout_at' => now(),
                ]);
        }
    }

    /**
     * Handle the event.
     */
    public function handleLogin(Login $event): void
    {
        if (! config('authentication-log.notify_other_devices', false)) {
            return;
        }

        $newIP = $this->request->ip();
        $newUserAgent = $this->request->userAgent();

        $user = $event->user;
        if (! $user instanceof UserContract
            || ! $user instanceof Model
            || ! $user instanceof HasAuthentications) {
            return;
        }

        $loginQuery = app(GetAuthenticationLogQueryForAuthenticatableAction::class)->execute($user);

        $loginQuery
            ->orderByDesc('login_at')
            ->where(function (Builder $query) use ($newIP, $newUserAgent): void {
                $query->where('ip_address', '!=', $newIP)->orWhere('user_agent', '!=', $newUserAgent);
            })
            ->where('login_successful', true)
            ->get();
    }
}
