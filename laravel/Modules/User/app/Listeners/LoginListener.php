<?php

declare(strict_types=1);

namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\User\Actions\Auth\RecordAuthenticationLogAction;
use Modules\User\Actions\GetCurrentDeviceAction;
use Modules\User\Contracts\HasAuthentications;
use Modules\User\Contracts\UserContract;
use Modules\User\Models\DeviceUser;

class LoginListener
{
    public Request $request;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // Session::flash('login-success', 'Hello ' . $event->user->name . ', welcome back!');
        $user = $event->user;

        // Device tracking is audit metadata, never a prerequisite for auth.
        // A restored/partially migrated user database may not have these
        // tables yet; do not turn a valid login into a 500 in that case.
        $userSchema = Schema::connection('user');
        if ($userSchema->hasTable('devices') && $userSchema->hasTable('device_user')) {
            $device = app(GetCurrentDeviceAction::class)->execute();
            $pivot = DeviceUser::firstOrCreate(['user_id' => $user->getAuthIdentifier(), 'device_id' => $device->id]);

            $updates = [];
            if ($userSchema->hasColumn($pivot->getTable(), 'login_at')) {
                $updates['login_at'] = now();
            }
            if ($userSchema->hasColumn($pivot->getTable(), 'logout_at')) {
                $updates['logout_at'] = null;
            }

            if ($updates !== []) {
                $pivot->update($updates);
            }
        } else {
            Log::warning('device tracking tables missing on user connection; login continues', [
                'connection' => 'user',
                'user_id' => $user->getAuthIdentifier(),
            ]);
        }

        // Identità = UserContract; capability log = HasAuthentications (non l'astratta interna).
        if (! $user instanceof UserContract || ! $user instanceof HasAuthentications) {
            return;
        }

        app(RecordAuthenticationLogAction::class)->execute($user, [
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'login_at' => now(),
            'login_successful' => true,
            'location' => [],
        ]);
    }
}
