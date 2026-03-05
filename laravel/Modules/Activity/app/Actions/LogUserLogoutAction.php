<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log User Logout Action.
 * Optimized for Laraxot architecture.
 */
class LogUserLogoutAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(?User $user = null): Activity
    {
        $user = $user ?? Auth::user();
        
        return app(LogActivityAction::class)->execute(
            type: 'logout',
            user: $user,
            description: sprintf('User %s logged out', $user?->name ?? 'unknown'),
            properties: [
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]
        );
    }
}
